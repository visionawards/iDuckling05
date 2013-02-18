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

class iDMEAFacade {

    private $__iDModuleLocalClass;
    private $__iDEventLocalClass;
    private $__iDActionLocalClass;

    protected $_moduleData;
    protected $_eventData;
    protected $_actionData;

    public function __construct() {
        //$this->__iDModuleLocalClass = parent::getModuleLocalClass();
        //$this->__iDEventLocalClass = parent::getEventLocalClass();
        //$this->__iDActionLocalClass = parent::getActionLocalClass();
        //parent::__construct($iDModuleLocalClass, $iDEventLocalClass, $iDActionLocalClass)
        $this->setModuleObjectData();
        $this->setEventObjectData();
        $this->setActionObjectData();
    }

    public function setModuleObjectData() {
        //$__iDModuleLocalClass = parent::getModuleLocalClass();

        //$objModule = new $__iDModuleLocalClass();
        $objModule = new iDModuleLocal();

        $this->moduleData = $objModule->buildModule();

        $this->module = $this->moduleData['name'];
        define(CURMODULE, $this->module);

        $objModule->setObject();

        $this->{$this->module} = new iDModule($this->module);
        
        $this->{$this->module}->name = $this->moduleData['name'];
        $this->{$this->module}->path = $this->moduleData['path'];
        $this->{$this->module}->skin = $this->moduleData['skin'];
        define(CURMODULE_SKIN, $this->moduleData['skin']);

        $this->moduleObject = $this->{$this->module};
        
        return  $this->moduleObject;
    }

    public function setEventObjectData() {
        $objEvent = new iDEventLocal();

        $this->eventData = $objEvent->buildEvent();
        $event = $this->eventData['name'];

        $model = $this->eventData['modelname'];
            $this->moduleData['event'] = $event;
            define(CUREVENT, $event);
            define(CURMODEL, $model);
        $this->eventPath = $this->eventData['path'];
        $this->modelEventPath = $this->eventData['modelpath'];

        $objEvent->setObject();

        require_once($this->eventPath);
        require_once($this->modelEventPath);

        $this->event = $event;
        $this->model = $model;

        //this is not for returning the module-class object
        //this is for instantiating it
        $this->{$this->module}->{$this->event} = new $event();
        $this->{$this->module}->{$this->model} = new $model(); 
        
        $this->{$this->module}->{$this->event}->path = $this->eventPath;

        $this->_event = new iDEvent($this->event,$this->moduleObject);

        return $this->_event;
    }

     public function setActionObjectData() {
        $objAction = new iDActionLocal();

        $this->actionData = $objAction->buildAction();
        $this->action = $this->actionData['name'];
            $this->moduleData['action'] = $this->action;
            define(CURACTION, $this->action);
        $this->actionParam = $this->actionData['param'];
        $numParam = count($this->actionParam);

        $this->{$this->module}->{$this->event}->{$this->action}->param = $this->actionParam;

         //this enables the Controller or Model to call a method with its parameters
         if(method_exists($this->{$this->module}->{$this->event},$this->action)) {
            if(method_exists($this->{$this->module}->{$this->event},'parent::__construct')) {
                call_user_func_array(array($this->{$this->module}->{$this->event},'parent::__construct'),$this->actionParam);
                //call_user_func_array(array($this->{$this->module}->{$this->event},'__construct'),$this->actionParam);
            }
            if(method_exists($this->{$this->module}->{$this->event},'_construct')) {
                call_user_func_array(array($this->{$this->module}->{$this->event},'_construct'),$this->actionParam);
            }
            if(method_exists($this->{$this->module}->{$this->event},'_'.$this->event)) {
                call_user_func_array(array($this->{$this->module}->{$this->event},'_'.$this->event),$this->actionParam);
            }

            if(method_exists($this->{$this->module}->{$this->model},'_construct')) {
                call_user_func_array(array($this->{$this->module}->{$this->model},'_construct'),$this->actionParam);
            }
            if(method_exists($this->{$this->module}->{$this->model},'_'.$this->model)) {
                call_user_func_array(array($this->{$this->module}->{$this->model},'_'.$this->model),$this->actionparam);
            }
                call_user_func_array(array($this->{$this->module}->{$this->event},$this->action),$this->actionParam);
         }

        $this->moduleData['view'] =  (defined('iDVIEW')) ? iDVIEW : ( ($this->moduleData['action'] == '_'.$this->event) ? $this->event : $this->moduleData['action'] );
        $this->moduleData['header'] = (defined('HEADER')) ? HEADER : TRUE;//defalut option is to show this part
                                                                          //each page can set this option up, see iDViewHelper
        $this->moduleData['neck'] = (defined('NECK')) ? NECK : TRUE;
        $this->moduleData['body'] = (defined('BODY')) ? BODY : TRUE;
        $this->moduleData['bodytop'] = (defined('BODYTOP')) ? BODYTOP : TRUE;
        $this->moduleData['bodyleft'] = (defined('BODYLEFT')) ? BODYLEFT : TRUE;
        $this->moduleData['bodyright'] = (defined('BODYRIGHT')) ? BODYRIGHT : TRUE;
        $this->moduleData['bodybottom'] = (defined('BODYBOTTOM')) ? BODYBOTTOM : TRUE;
        $this->moduleData['footer'] = (defined('FOOTER')) ? FOOTER : TRUE;
        $this->moduleData['sole'] = (defined('SOLE')) ? SOLE : TRUE;
        $this->moduleData['tail'] = (defined('TAIL')) ? TAIL : TRUE;

        define(CURVIEW, $this->moduleData['view']);

        $objAction->setObject();

        $this->_action = new iDAction($this->actionName,$this->_event);

        return $this->_action;
    }
}

?>
