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
 
class iDEvent extends iDMEACoRMediator {

    public $module;
    private $_module;
    private $_event;
    private $_action;

    public function __construct($event, iDModule $module) {
        $this->_event = $event;
        $this->module = $module;
    }

    public function loadModule() {
        $this->_module = $this->module->loadModule();
        
        return $this->_module;
    }

    public function loadEvent() {
        return $this->_event;
    }

    public function loadAction() {
        return NULL;
    }

    public function getMEA() {
        if( $this->_event != NULL ) {
            if( $this->_module != NULL ) {
                return $this->_event;
            } else {
                throw new Exception (" No module to load found.");
            }
        } else {
            throw new Exception (" No event to load found.");
        }
    }
}

?>
