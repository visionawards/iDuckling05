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
 * @subpackage      system.mvc
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

class iDControllerModelSubject implements IiDControllerModelSubject {
    
    private $__observers;
    private $__moduleName;
    private $__className;
    private $__params;
    
    public function __construct() {
        $this->__observers = array();
    }

    public function registerObserver($o ) {
        $this->__observers[] = $o;
    }
    //Modified use of removeObserver
    //since all Controller/Model objects are observers
    //this should remove all of those to release them from memory
    //we can put __destruct into each class, but
    //1)PHP itself does this well.
    //2) we can unset them for it as well
    //think about this more ...
    public function removeObserver() {
        //$this->__observers = array();
        foreach($this->__observers as $obj) {
            unset($obj);
        }
    }

    public function notifyObservers() {
        foreach($this->__observers as $myObserver) {
            $myObserver->update($this->__params);
        }
    }

    public function setParams() {
        $this->getParams();
        return $this->__params;
    }

    public function getParams() {
        $this->notifyObservers();
    }
    
}

?>
