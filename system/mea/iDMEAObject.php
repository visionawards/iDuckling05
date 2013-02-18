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

class iDMEAObject {

    private $__iDModuleLocalClass;
    private $__iDEventLocalClass;
    private $__iDActionLocalClass;

    public function __construct($iDModuleLocalClass,$iDEventLocalClass,$iDActionLocalClass) {

        $this->__iDModuleLocalClass = $iDModuleLocalClass;
        $this->__iDEventLocalClass = $iDEventLocalClass;
        $this->__iDActionLocalClass = $iDActionLocalClass;

        $this->getModuleLocalClass();
    }

    public function getModuleLocalClass() {
        return $this->__iDModuleLocalClass;
    }

    public function getEventLocalClass() {
        return $this->__iDEventLocalClass;
    }

    public function getActionLocalClass() {
        return $this->__iDActionLocalClass;
    }

}

?>
