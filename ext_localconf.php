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
 * Configuration file for YAG gallery
 * 
 * @author Michael Knoll <mimi@kaktusteam.de>
 * @author Daniel Lienert <daniel@lienert.cc>
 */

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Album' => 'index, show, new, create, edit, update, delete',
		'Gallery' => 'index, show, new, create, edit, update, delete',
		'ItemType' => 'index, show, new, create, edit, update, delete',
		'Item' => 'index, show, new, create, edit, update, delete',
		'ResolutionPreset' => 'index, show, new, create, edit, update, delete',
		'Resolution' => 'index, show, new, create, edit, update, delete',
		'ItemFile' => 'index, show, new, create, edit, update, delete',
		'ItemSourceType' => 'index, show, new, create, edit, update, delete',
		'ItemSource' => 'index, show, new, create, edit, update, delete',
		'ResolutionItemFileRelation' => 'index, show, new, create, edit, update, delete',
		'DirectoryImport' => 'showImportForm, importFromDirectory',
		'Development' => 'createSampleData, deleteAll',
	    'Remote' => 'addItemToAlbum'
	),
	array(
		'Album' => 'create, update, delete',
		'Gallery' => 'create, update, delete',
		'ItemType' => 'create, update, delete',
		'Item' => 'create, update, delete',
		'ResolutionPreset' => 'create, update, delete',
		'Resolution' => 'create, update, delete',
		'ItemFile' => 'create, update, delete',
		'ItemSourceType' => 'create, update, delete',
		'ItemSource' => 'create, update, delete',
		'ResolutionItemFileRelation' => 'create, update, delete',
        'DirectoryImport' => 'showImportForm, importFromDirectory',
        'Development' => 'createSampleData, deleteAll',
        'Remote' => 'addItemToAlbum'
	)
);

require_once t3lib_extMgm::extPath('yag').'Classes/Utility/FlexformDataProvider.php';

?>