<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
*            
*           
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class implements an abstract controller for all yag controllers
 * 
 * @package Controller
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 * 
 * TODO: Move the general stuff to pt_extbase ...
 * 
 */
abstract class Tx_Yag_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController {
	
	/**
	 * Holds extension manager settings of yag extension
	 *
	 * @var array
	 */
	protected $emSettings = array();
	
	
	
	/**
	 * Holds an instance of yag configuration builder
	 *
	 * @var Tx_Yag_Domain_Configuration_ConfigurationBuilder
	 */
	protected $configurationBuilder;
	
	
	
	/**
     * Prepares a view for the current action and stores it in $this->view.
     * By default, this method tries to locate a view with a name matching
     * the current action.
     *
     * Configuration for view in TS:
     * 
     * controller.<ControllerName>.<controllerActionName>.view = <viewClassName>
     * 
     * @return void
     */
    protected function resolveView() {
    	$view = $this->resolveViewObject();
        
        $controllerContext = $this->buildControllerContext();
        $view->setControllerContext($controllerContext);

		// Setting the controllerContext for the FLUID template renderer         
        Tx_PtExtlist_Utility_RenderValue::setControllerContext($controllerContext);
        
        // Template Path Override
        $extbaseFrameworkConfiguration = Tx_Extbase_Dispatcher::getExtbaseFrameworkConfiguration();
        if (isset($extbaseFrameworkConfiguration['view']['templateRootPath']) && strlen($extbaseFrameworkConfiguration['view']['templateRootPath']) > 0) {
            $view->setTemplateRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']));
        }
        if (isset($extbaseFrameworkConfiguration['view']['layoutRootPath']) && strlen($extbaseFrameworkConfiguration['view']['layoutRootPath']) > 0) {
            $view->setLayoutRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']));
        }
        if (isset($extbaseFrameworkConfiguration['view']['partialRootPath']) && strlen($extbaseFrameworkConfiguration['view']['partialRootPath']) > 0) {
            $view->setPartialRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']));
        }

        if ($view->hasTemplate() === FALSE) {
            $viewObjectName = $this->resolveViewObjectName();
            if (class_exists($viewObjectName) === FALSE) $viewObjectName = 'Tx_Extbase_MVC_View_EmptyView';
            $view = $this->objectManager->getObject($viewObjectName);
            $view->setControllerContext($controllerContext);
        }
        if (method_exists($view, 'injectConfigurationBuilder')) {
            $view->injectConfigurationBuilder($this->configurationBuilder);
        }
        $view->initializeView(); // In FLOW3, solved through Object Lifecycle methods, we need to call it explicitely
        $view->assign('settings', $this->settings); // same with settings injection.
        
        return $view;
    }
    
    
    
    /**
     * These lines have been added by Michael Knoll to make view configurable via TS
     * Added TS-Key redirect by Daniel Lienert. If the tsPath points to a TS Configuration with child key viewClassName, it uses this as view class
     * 
     * @throws Exception
     */
    protected function resolveViewObject() {
   
        $viewClassName = $this->settings['controller'][$this->request->getControllerName()][$this->request->getControllerActionName()]['view'];

        if ($viewClassName != '') {

        	if (class_exists($viewClassName)) {
        		return $this->objectManager->getObject($viewClassName);
        	} 

        	$viewClassName .= '.viewClassName';
        	$tsRedirectPath = explode('.', $viewClassName);
        	$viewClassName = Tx_Extbase_Utility_Arrays::getValueByPath($this->settings, $tsRedirectPath);
        	
        	if (class_exists($viewClassName)) {
        		return $this->objectManager->getObject($viewClassName);
        	}
        	
        	throw new Exception('View class does not exist! ' . $viewClassName . ' 1281369758');
        } else {
        	
        	// We replace Tx_Fluid_View_TemplateView by Tx_PtExtlist_View_BaseView here to use our own view base class
        	return $this->objectManager->getObject('Tx_PtExtlist_View_BaseView');	
        }
    }
	
	
	
	
    /**
     * Redirects on a access denied page, if fe user has no admin rights
     *
     * @param Tx_Yag_Domain_Model_Album $album
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     * @return bool     True, if user is in admin group or BE-Mode
     */
    protected function checkForAdminRights() {
        if (TYPO3_MODE === 'BE') {
            return TRUE;
        }
        if (!Tx_Yag_Div_YagDiv::isLoggedInUserInGroups(explode(',', $this->settings[adminGroups]))) {
            $this->accessDeniedAction();  
        } else {
            return true;
        }
    }
    
    
    
    /**
     * Initializes all controllers 
     *
     */
    protected function initializeAction() {
    	// TODO implement me!
    	#parent::initializeAction();
    	#$this->checkConfiguration();
    }
    
    
    
    /**
     * Check for correct configuration
     *
     */
    protected function checkConfiguration() {
    	if (!$this->settings['storagePid'] >= 0) {
    		throw new Exception('No storage PID has been set!');
    	}
    }
    
    
    
    /**
     * Injects the settings of the extension.
     *
     * @param array $settings Settings container of the current extension
     * @return void
     */
    public function injectSettings(array $settings) {
        parent::injectSettings($settings);

        $this->emSettings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['yag']);
        $this->configurationBuilder = Tx_Yag_Domain_Configuration_ConfigurationBuilderFactory::getInstance($this->settings);
    }
    
    
    
    /**
     * Redirects to gallery start page after access for another action has been denied
     *
     * @param Tx_Yag_Domain_Model_Album $album      
     * @param Tx_Yag_Domain_Model_Gallery $gallery
     */
    protected function accessDeniedAction(
        Tx_Yag_Domain_Model_Album $album = NULL,
        Tx_Yag_Domain_Model_Gallery $gallery = NULL
    ) {
        $this->flashMessages->add('Access denied!');
        $this->redirect('index', 'Gallery', NULL, array('album' => $album, 'gallery' => $gallery));
    }
    
    
    
    /**
     * Returns a request parameter, if it's available.
     * Returns NULL if it's not available
     *
     * @param string $parameterName
     * @return string
     */
    protected function getParameterSafely($parameterName) {
        if ($this->request->hasArgument($parameterName)) {
            return $this->request->getArgument($parameterName);
        }
        return NULL;
    }
    
    
    
    /**
     * Initializes the view before invoking an action method.
     *
     * Override this method to solve assign variables common for all actions
     * or prepare the view in another way before the action is called.
     *
     * @param Tx_Extbase_MVC_View_ViewInterface $view The view to be initialized
     * @return void
     * @api
     */
    protected function initializeView(Tx_Extbase_MVC_View_ViewInterface $view) {
    	#$view->assign('userIsAdmin', Tx_Yag_Div_YagDiv::isLoggedInUserInGroups(explode(',',$this->settings['adminGroups'])));
    	$this->view->assign('config', $this->configurationBuilder);
    }
    
    	
}

?>