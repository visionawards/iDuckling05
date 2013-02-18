<?php
/**
 * iDuckling :  Simple Framework for PHP coders
 * Copyright (c)	2010, David Kim
 *
 * Licensed under The GPL License
 * Redistributions of files must retain the above copyright notice.
 * For more in detail, please see the LICENSE file in the root directory.
 *
 * @category
 * @package         system
 * @subpackage      system.layout
 * @author      	David Kim <david.qwk@gmail.com>
 * @link
 * @copyright		Copyright (c) 2010, David Kim
 * @link
 * @since			iDuckling v 0.1
 * @version			$Revision:  $
 * @modifiedby		$LastChangedBy: david k $
 * @lastmodified	$Date: 2010-04-14 19:30:33 -0000 (Wed, 14 April 2010) $
 * @license			http://www.opensource.org/licenses/gpl-license.php The GPL License
 */

class iDSiteLayoutBuilder extends AiDSiteLayoutTemplate {

    private $_siteSkinData = array();
    private $__siteViewData = NULL;

    public function buildSiteSkin() {
        parent::setSiteSkin();

        $siteSkinData = parent::getSiteSkinData();
        $this->_siteSkinData = $siteSkinData;
        
        self:: setSiteDefaultPageTitle();

        return $this->_siteSkinData;
    }

    public function getSiteSkin() {
        return $this->_siteSkinData['name'];
    }

    public function getSiteViweData() {
        $siteViewData = parent::getSiteViewData();
        $this->__siteViewData = $siteViewData;
        //print $this->__siteViewData;
        return $this->__siteViewData;
    }

    public function setSiteDefaultPageTitle() {
        define(PAGE_TITLE,$this->_siteSkinData['pagetitle']);
    }

    public function setSiteLayout($module) {}

}

?>
