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

class iDModule extends iDMEACoRMediator {

    private $_module;
    private $_module_path;
    private $_event;
    private $_action;

    public function __construct($module) {
        $this->_module = $module;
    }

    public function loadModule() {
        return $this->_module;
    }

    public function loadEvent() {
        return NULL;
    }

    public function loadAction() {
        return NULL;
    }

    public function getMEA() {
        if($this->_module != NULL ) {
            return $this->_module;
        } else {
            throw new Exception (" No module to load found.");
        }
    }
}

?>
