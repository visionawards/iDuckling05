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

class iDEventTemplate {

    protected $_eventData = array();
    
    public function __construct() {}
    
    public function setEvent() {
        $this->_eventName = $this->setEventName();
        $this->_eventPath = $this->setEventPath();
        $this->_modelEventName = $this->setModelEventName();
        $this->_modelEventPath = $this->setModelEventPath();
        
        $_eventData = array("name" => $this->_eventName,
                            "path" => $this->_eventPath,
                            "modelname" => $this->_modelEventName,
                            "modelpath" => $this->_modelEventPath);

        $this->_eventData = $_eventData;
    }

    //none of these are abstract, which means these methods
    //are optional in its sub-class. that's why this is in Template
    //pattern. the developer-user can have the module stuff in her
    //own way through the iDModuleLocal object.
    protected function setEventName() {
        return NULL;
    }

    protected function setEventPath() {
        return NULL;
    }

    protected function setModelEventName() {
        return NULL;
    }

    protected function setModelEventPath() {
        return NULL;
    }

    public function getEvent() {
        return $this->_eventData;
    }
    
}
?>
