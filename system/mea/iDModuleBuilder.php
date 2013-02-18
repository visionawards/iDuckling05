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
 
//Why we need a builder between iDModuleTemplate
//and iDModelLocal?
//Because we want to get more values from
//the values accuired from Template, like,
//module object, etc...{think about this more}
//And also, this Builder inherits the abstract template class,
//but it's in a Builder pattern, meaning that this builds
//the module stuff by receiving the module data from the
//iDModuleLocal that technically extends the abstract iDModuleTemplete
//class, and has the module data in it.
//Accordingly, we can have a different logic by putting a different logic
//into iDModalLocal, or we can create another local template-sub-class that
//extends the abstract iDModuleTemplate class.
//In case we put a new iDModalLocal with a different class name,
//iDMEAFacade needs to be modified accordingly with the new name...
//{think about this more, how to make this process local too
//Myabe Adapter?}
class iDModuleBuilder extends iDModuleTemplate {

    protected $_moduleData;

    public function __construct() {
    }

    public function buildModule() {
 
        parent::setModule();
        $_moduleData = parent::getModule();

        $this->_moduleData = $_moduleData;
        
       return $this->_moduleData;
    }
    
    public function setObject() {
        /*
        $moduleObjName = $this->_moduleData['name'];

        $objType = 'Module';
        $muduleObj = "iDModuleDelegate";
        $this->$moduleObjName = new $moduleObj;

        $this->$moduleObjName->name = $this->_moduleData['name'];
        $this->$moduleObjName->path = $this->_moduleData['path'];
        $this->$moduleObjName->skin = $this->_moduleData['skin'];

        $this->$moduleObjName->loadObject($objType);
         *
         */

    }

}

?>
