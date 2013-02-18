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

//using interface can be unusual, but, each DBMS uses a differenct
//methodology to, for example, connect etc., so, using interface can
//be more reasonalble than using inheritance with parent class
class iDMySQL implements IiDDatabase {

    protected $con = NULL;
    private $_dbhost;
    private $_dbname;
    private $_dbuser;
    private $_dbpass;

    public function __construct() {
    }

    public function connect($_dbhost=null, $_dbname=null, $_dbuser=null, $_dbpass=null) {
        
        $this->_dbhost = $_dbhost;
        $this->_dbname = $_dbname;
        $this->_dbuser = $_dbuser;
        $this->_dbpass = $_dbpass;
        
        if (is_null($this->_dbname))
            die("MySQL database not selected");
        if (is_null($this->_dbhost))
            die("MySQL hostname not set");

        $con = @mysql_connect($this->_dbhost, $this->_dbuser, $this->_dbpass);
        $this->con = $con;
        
        if ( FALSE === $this->connected() )
            die("Could not connect to database. Check your username and password then try again.\n");
        if ( TRUE === mysql_select_db($this->_dbname, $this->con) ) {
				$this->query('SET NAMES ' . $this->quote('utf8') . ';');
				$this->query('SET CHARACTER SET ' . $this->quote('utf8') . ';');
        } else {
            die("Could not select database");
        }
    }

	public function __destruct()
	{
		if (TRUE === $this->connected())
		{
            mysql_close($this->con);
            $this->con = null;
		}
	}

    public function connected() {
        if (is_resource($this->con)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function disconnect() {
		if (TRUE === $this->connected())
		{
            mysql_close($this->con);
            $this->con = null;
		}
    }

    public function query($sql,$opt = NULL) {
        if ( FALSE === $this->connected()) {
            die('No Database Connection Found.');
        }

        $result = @mysql_query($sql,$this->con);

        if ( FALSE === $result ) {
            die(mysql_error());
        } else {

            if( TRUE === is_resource($result) ) {

                if($opt==null || $opt=='0') {
                    while($row = mysql_fetch_array($result)) {
                        $sqlResult []= $row;
                    }
                }
                elseif($opt=='1') {
                        while($row = mysql_fetch_object($result)) {
                            $sqlResult []= $row;
                        }
                }
            }
            elseif ( TRUE === $result ) {
				switch (strtoupper(substr($sql, 0, strpos($sql, ' '))))
				{
					case 'INSERT':
						return $this->insertId();
					break;
					case 'UPDATE':
					case 'DELETE':
						return $this->affectedRows();
					break;
				}

				return TRUE;
            }
        }
        mysql_free_result($result);

        return $sqlResult;
    }

    public function fetchArray($result) {
        if ($this->con === false) {
            die('No Database Connection Found.');
        }

        $data = @$data = @mysql_fetch_array($result);
        if (!is_array($data)) {
            die(mysql_error());
        }
        
        return $data1;
    }

    public function fetchObject($result) {
        if ($this->con === false) {
            die('No Database Connection Found.');
        }

        $data = @mysql_fetch_object($result);
        if (!is_object($data)) {
            die(mysql_error());
        }
        return $data;
    }

    public function affectedRows() {
        return mysql_affected_rows($this->con);
    }

    public function insertId() {
        return mysql_insert_id($this->con);
    }

	public function quote($string)
	{
		if( TRUE === get_magic_quotes_gpc() )
		{
			$string = stripslashes($string);
		}

		return '\'' . mysql_real_escape_string(trim($string), $this->con) . '\'';
	}

}

?>
