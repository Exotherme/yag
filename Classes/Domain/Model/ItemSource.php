<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Michael Knoll <mimi@kaktusteam.de>
*  			Daniel Lienert <daniel@lienert.cc>
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
 * ItemSource
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Yag_Domain_Model_ItemSource extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * uri
	 * @var string
	 * @validate NotEmpty
	 */
	protected $uri;
	
	/**
	 * itemSourceType
	 * @var Tx_Yag_Domain_Model_ItemSourceType
	 */
	protected $itemSourceType;
	
	
	
	/**
	 * Setter for uri
	 *
	 * @param string $uri uri
	 * @return void
	 */
	public function setUri($uri) {
		$this->uri = $uri;
	}

	/**
	 * Getter for uri
	 *
	 * @return string uri
	 */
	public function getUri() {
		return $this->uri;
	}
	
	/**
	 * Setter for itemSourceType
	 *
	 * @param Tx_Yag_Domain_Model_ItemSourceType $itemSourceType itemSourceType
	 * @return void
	 */
	public function setItemSourceType(Tx_Yag_Domain_Model_ItemSourceType $itemSourceType) {
		$this->itemSourceType = $itemSourceType;
	}

	/**
	 * Getter for itemSourceType
	 *
	 * @return Tx_Yag_Domain_Model_ItemSourceType itemSourceType
	 */
	public function getItemSourceType() {
		return $this->itemSourceType;
	}
	
}
?>