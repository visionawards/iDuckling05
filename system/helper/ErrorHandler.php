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
 * @subpackage      system.helper
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

class ErrorHandler {

    function __construct() {
        set_error_handler("myErrorHandler");
    }

    function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
        case E_USER_ERROR:
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }

    // function to test the error handling
    function scale_by_log($vect, $scale)
    {
        if (!is_numeric($scale) || $scale <= 0) {
            trigger_error("log(x) for x <= 0 is undefined, you used: scale = $scale", E_USER_ERROR);
        }

        if (!is_array($vect)) {
            trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
            return null;
        }

        $temp = array();
        foreach($vect as $pos => $value) {
            if (!is_numeric($value)) {
                trigger_error("Value at position $pos is not a number, using 0 (zero)", E_USER_NOTICE);
                $value = 0;
            }
            $temp[$pos] = log($scale) * $value;
        }

        return $temp;
    }

    // set to the user defined error handler
    }
?>
