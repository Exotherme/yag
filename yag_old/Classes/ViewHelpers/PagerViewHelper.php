<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>, MKLV GbR
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
 * Class definitionfile for pager viewhelper
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */



/**
 * Class implements a viewhelper rendering a pager 
 *
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @since 2010-01-01
 * @package Typo3
 * @subpackage yag
 */
class Tx_Yag_ViewHelpers_PagerViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
    /**
     * Initialize arguments.
     *
     * @return void
     * @author Michael Knoll <mimi@kaktusteam.de>
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('pager','Tx_Yag_Lib_PagerIntercae', 'Pager object to render', TRUE);
    }
	
	

	/**
	 * Renders this viewhelper
	 *
	 * @return string  The rendered pager
	 * @author Michael Knoll <mimi@kaktusteam.de>
	 */
	public function render() {
        #$output = print_r($this->arguments['pager'],true);
        $output = '';
        return $output;
	}
	
}

?>