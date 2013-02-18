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
 * @subpackage      system.mea
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

class iDModuleTemplate {

    protected $_moduleData = array();
    
    public function __construct() {}
    
    public final function setModule() {
        $this->_moduleName = $this->setModuleName();
        $this->_modulePath = $this->setModulePath();
        $this->_moduleSkin = $this->setModuleSkin();
        
        $moduleData = array("name" => $this->_moduleName,
                                "path" => $this->_modulePath,
                                "skin" => $this->_moduleSkin);
        $this->_moduleData = $moduleData;
    }

    protected function setModuleName() {
        return NULL;
    }

    protected function setModulePath() {
        return NULL;
    }

    protected function setModuleSkin() {
        return NULL;
    }

    public function getModule() {
        return $this->_moduleData;
    }

    protected function getModuleConf() {
        
    }
/*
    public function getModulePath() {
        return $this->setModuleName();
    }

    public function getModuleSkin() {
        return $this->setModuleSkin();
    }
*/
    
}
?>
