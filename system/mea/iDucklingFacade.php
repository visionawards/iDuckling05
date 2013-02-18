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

class iDucklingFacade  {

    public function __construct() {
        $this->setModuleObjectData();
        $this->setEventObjectData();
        $this->setActionObjectData();
    }

    public function setModuleObjectData() {
        $objModule = new iDModuleLocal();
        
        $moduleData = $objModule->buildModule();
        $this->objModuleName = $moduleData['name'];

        $objModule->setObject();
        //$this->$m = new iDModuleLocal();
        $this->{$this->objModuleName} = new iDModuleLocal();

        $this->{$this->objModuleName}->name = $moduleData['name'];
        $this->{$this->objModuleName}->path = $moduleData['path'];
        $this->{$this->objModuleName}->skin = $moduleData['skin'];
    }

    public function setEventObjectData() {
        $objEvent = new iDEventLocal();

        $eventData = $objEvent->buildEvent();
        $this->objEventName = $eventData['name'];

        $objEvent->setObject();

        $this->{$this->objModuleName}->{$this->objEventName} = new iDEventLocal();
        
        $this->{$this->objModuleName}->{$this->objEventName}->name = $eventData['name'];
    }

     public function setActionObjectData() {
        $objAction = new iDActionLocal();

        $actionData = $objAction->buildAction();
        $this->objActionName = $actionData['name'];

        $objAction->setObject();

        $this->{$this->objModuleName}->{$this->objEventName}->{$this->objActionName} = new iDEventLocal();

        $this->{$this->objModuleName}->{$this->objEventName}->{$this->objActionName}->name = $actionData['name'];
        $this->{$this->objModuleName}->{$this->objEventName}->{$this->objActionName}->param = $actionData['param'];
    }

}

?>
