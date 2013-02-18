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

class iDActionTemplate {

    protected $_actionData = array();
    
    public function __construct() {}
    
    public function setAction() {
        $this->_actionName = $this->setActionName();
        $this->_actionPath = $this->setActionPath();
        $this->_actionParam = $this->setActionParam();
    
        $_actionData = array("name" => $this->_actionName,
                            "path" => $this->_actionPath,
                            "param" => $this->_actionParam);

        $this->_actionData = $_actionData;
    }

    //none of these are abstract, which means these methods
    //are optional in its sub-class. that's why this is in Template
    //pattern. the developer-user can have the module stuff in her
    //own way through the iDModuleLocal object.
    protected function setActionName() {
        return NULL;
    }

    protected function setActionPath() {
        return NULL;
    }

    protected function setActionParam() {
        return NULL;
    }

    //This part is for Builder.
    //The methods here are public, but in case any object
    //that instantiate this class directly and call the methods
    //here will get NULL.
    //Only when going through the Builder, it'll get
    //the corresponding value if any.
    public function getAction() {
        return $this->_actionData;
    }
    
}
?>
