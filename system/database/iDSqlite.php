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
 * @subpackage      system.database
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
 
require_once('IiDDatabase.php');

class Sqlite implements IiDDatabase {

    protected $con;
    private $_error;
    private $_dbperms;
    private $_dbname;

    public function __construct() {
      $this->_dbname = $_dbName;
      $this->_dbperms = $_dbperms;
    }

    public function connect() {
      if(is_null($this->_dbname)) {
        die("Sqlite database not selected");
      }
      if (is_null($this->_dbperms)) {
        die("Sqlite permissions not set");
      }
      if(file_exists($this->_dbname)) {
        $this->con = sqlite_open($this->_dbname, $this->_dbperms, $this->_error);
      } else {
        //$this->conn = sqlite_open($this->_dbname, $this->_dbperms, $this->_error);
      }

      if ($this->con === false) {
        die($this->_error);
      }
    }

    public function connected() {
        if (is_resource($this->con)) {
            return true;
        } else {
            return false;
        }
    }

    public function disconnect() {
      sqlite_close($this->con);
      $this->con = null;
    }

    public function query($sql) {
      if ($this->con === false) {
        die('No Database Connection Found.');
      }
      $result = sqlite_query($this->con, $sql);
      if ($result === false) {
        die($sql);
      }
      return $result;
    }

    public function fetchArray($result) {
      if ($this->con === false) {
        die('No Database Connection Found.');
      }

      $data = @sqlite_fetch_array($result);
      if (!is_array($data)) {
        return false;
      }
      return $data;
    }

    public function fetchAll($result) {
      if ($this->con === false) {
        die('No Database Connection Found.');
      }

      $data = @sqlite_fetch_all($result);
      if (!is_array($data)) {
        $this->_error = 'Fetch All Failed.';
        return null;
      }
      return $data;
    }

    public function table_exists($table) {
        return sqlite_fetch_single($rez) > 0;
    }
}

?>
