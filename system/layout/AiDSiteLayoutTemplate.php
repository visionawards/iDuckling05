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

abstract class AiDSiteLayoutTemplate {

    private $_siteSkin;
    private $_siteSkinCreator = NULL;
    private $_siteSkinCreatorMail = NULL;
    private $_siteSkinCreatorHome = NULL;
    private $_siteSkinDescription = NULL;
    private $__siteSkinDefaultPageTitle = NULL;
    private $__siteViewData = NULL;
    private $_siteSkinData = array();
    //the template method
    //  sets up a general algorithm for the whole class 
    public final function setSiteSkin() {
        $this->_siteSkin = $this->getSiteSkin();
        $this->_siteSkinCreator = $this->getSiteSkinCreator();
        $this->_siteSkinCreatorMail = $this->getSiteSkinCreatorMail();
        $this->_siteSkinCreatorHome = $this->getSiteSkinCreatorHome();
        $this->_siteSkinDescription = $this->getSiteSkinDescription();
        $this->__siteSkinDefaultPageTitle = $this->getSiteSkinDefaultPageTitle();

        $siteSkinData = array("name"        => $this->_siteSkin,
                              "creator"     => $this->_siteSkinCreator,
                              "mail"        => $this->_siteSkinCreatorMail,
                              "home"        => $this->_siteSkinCreatorHome,
                              "description" => $this->_siteSkinDescription,
                              "pagetitle" => $this->__siteSkinDefaultPageTitle);

        $this->_siteSkinData = $siteSkinData;

        $this->layout->{$this->_siteSkin}->name = $this->_siteSkin;
        $this->layout->{$this->_siteSkin}->creator = $this->_siteSkinCreator;
        $this->layout->{$this->_siteSkin}->mail = $this->_siteSkinMail;
        $this->layout->{$this->_siteSkin}->home = $this->_siteSkinHome;
        $this->layout->{$this->_siteSkin}->desc = $this->_siteSkinDescription;
        $this->layout->{$this->_siteSkin}->ptitle = $this->__siteSkinDefaultPageTitle;
        

    }
    
    //the primitive operation
    //  this function must be overridded
    abstract protected function getSiteSkin();
    
    abstract protected function setSiteLayout($module);

    //the hook operation
    //  this function may be overridden,
    //  but does nothing if it is not
    protected function getSiteSkinCreator() {
        return NULL;
    }

    protected function getSiteSkinCreatorMail() {
        return NULL;
    }

    protected function getSiteSkinCreatorHome() {
        return NULL;
    }

    protected function getSiteSkinDescription() {
        return NULL;
    }

    protected function getSiteSkinDefaultPageTitle() {
        return NULL;
    }

    protected function getSiteSkinData() {
        return $this->_siteSkinData;
    }

    protected function getSiteViewData() {
        return $this->__siteViewData;
    }
}

?>
