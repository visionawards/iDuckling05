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
 * @subpackage      system.mvc.controiller
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

class iDControllerHelper extends iDControllerModelObserver {

    protected $_view;
    private $__modClassObj;

    public function __construct() {
        self::setControllerModelSO();
        self::setCurModelObject();
        self::setGetPost();

        $this->iDLib = new iDLib();
    }

    protected function header($hasHeader) {
        //if( FALSE == $hasHeader ) {
            iDView::header($hasHeader);
        //}
    }

    protected function neck($hasNeck) {
        //if( FALSE == $hasHeader ) {
            iDView::neck($hasNeck);
        //}
    }

    protected function bodytop($hasBodyTop) {
        //if( FALSE == $hasBodyTop ) {
            iDView::bodytop($hasBodyTop);
        //}
    }

    protected function bodyleft($hasBodyLeft) {
            iDView::bodyleft($hasBodyLeft);
    }

    protected function bodyright($hasBodyRight) {
            iDView::bodyright($hasBodyRight);
    }

    protected function bodybottom($hasBodyBottom) {
            iDView::bodybottom($hasBodyBottom);
    }

    protected function body($hasBody) {
        //if( FALSE == $hasBodyTop ) {
            iDView::body($hasBody);
        //}
    }

    protected function footer($hasFooter) {
        //if( FALSE == $hasFooter ) {
            iDView::footer($hasFooter);
        //}
    }

    protected function sole($hasSole) {
        //if( FALSE == $hasFooter ) {
            iDView::sole($hasSole);
        //}
    }    
    
    protected function tail($hasTail) {
        //if( FALSE == $hasFooter ) {
            iDView::tail($hasTail);
        //}
    }

    protected function render($_view,$_action = NULL) {
        iDView::render($_view,$_action);
    }

    protected function renderOnly($_view,$_action = NULL) {
        iDVIEW::header(0);
        iDVIEW::neck(0);
        iDVIEW::bodytop(0);
        iDVIEW::bodyleft(0);
        iDVIEW::bodyright(0);
        iDVIEW::bodybottom(0);
        iDVIEW::footer(0);
        iDVIEW::sole(0);
        iDVIEW::tail(0);
        iDView::render($_view,$_action);
    }

    protected function renderOnlywTail($_view,$_action = NULL) {
        iDVIEW::header(0);
        iDVIEW::neck(0);
        iDVIEW::bodytop(0);
        iDVIEW::bodyleft(0);
        iDVIEW::bodyright(0);
        iDVIEW::bodybottom(0);
        iDVIEW::footer(0);
        iDVIEW::sole(0);
        iDView::render($_view,$_action);
    }    
    
    public function setControllerModelSO() {
        $iDCtrlSubj = new iDControllerModelSubject();

        //by using SITE_ID for this,
        //we may be able to call functions from other sites on iDuckling? ^^
        //if the site is running in the same sever on the same iDuckling,
        //it might be possible?^^
        $this->CMO = new iDControllerModelObserver($iDCtrlSubj);
        $iDCtrlSubj ->removeObserver();
    }

    public function setCurModelObject() {
        //this needs to be updated to the working one below
        //'cause when the Controller is called by another Controller
        //and thus the Model in the local Controller is also called remotely
        //by that remote Controller
        //$curModel = CURMODEL;
        //$this->model = new $curModel();

        $model = $this->CMO->model_prefix.get_class($this);
        $this->model = new $model();
        //Models' pseudo constructor cannot pass Parameters
        if(method_exists($this->model,'_construct')) {
            call_user_func_array(array($this->model,'_construct'),array());//this invokes the pseudo constructor of Model class
        }
        if(method_exists($this->model,'_'.$model)) {
            call_user_func_array(array($this->model,'_'.$model),array());//this invokes the pseudo constructor of Model class
        }
    }

    public function setGetPost() {
        $this->post = $_POST;
        $this->get = $_GET;
    }

    public function title($title) {
        iDVIEW::setPageTitle($title);
    }

    public function onload($onload) {
        iDVIEW::onload($onload);
    }

    public function raw($raw) {
        if($raw) :
            iDVIEW::header(0);
            iDVIEW::neck(0);
            iDVIEW::bodytop(0);
            iDVIEW::bodyleft(0);
            iDVIEW::bodyright(0);
            iDVIEW::bodybottom(0);
            iDVIEW::render(0);
            iDVIEW::footer(0);
            iDVIEW::sole(0);
            iDVIEW::tail(0);
            iDVIEW::raw($raw);
        endif;
    }

    public function json($data) {        
        print json_encode($data);
    }
    
    public function view() {
        //print DKIM;
    }
    
    public function set($var, $val) {
        
        if(is_array($val)) {
            //define($var, 'return ' . var_export($val, 1) . ';');
            $_SESSION[$var] = $val;
        } else {
            define($var,$val);
        }
    }

    public function un_set($var) {
        session_unregister($var);
        define($var,'');
    }

    public function reset($var) {
        session_unregister($var);
        define($var,'');
    }

    public function get($val) {
        return $_SESSION[$val];
    }

    public function setCMObject($method,$args) {
        
        foreach($this->CMO->modClassObjects as $modClassObj) {
            $mod = $modClassObj['mod'];
            $evt = $modClassObj['cls'];
            $model = MODEL_PREFIX.$evt;

            if(method_exists($evt,$method)) {
                //$args = (is_array($args)) ? $args : array();
                $this->evt = new $evt();
                if(method_exists($this->evt,'_construct')) {
                    call_user_func_array(array($this->evt,'_construct'),$args);
                }
                if(method_exists($this->evt,'_'.$evt)) {
                    call_user_func_array(array($this->evt,'_'.$evt),$args);
                }
                if(method_exists($this->model,'_construct')) {
                    call_user_func_array(array($this->model,'_construct'),$args);
                }
                if(method_exists($this->model,'_'.$model)) {
                    call_user_func_array(array($this->model,'_'.$model),$args);
                }
                $result = call_user_func_array(array($this->evt,$method),$args);
               
                return $result;
            } else {
                //return NULL;//this breaks the loop, so, commentize it for now
            }
        }
    }

    public function selectAll($table,$cond='1=1',$opt='1') {
         $result = $this->query(
            "SELECT * FROM $table WHERE $cond ", $opt);

        return $result;
    }

    public function insertAll($table,$param = 0, $fields = 0) {
        if($this->post['insertAll'] == 1) {

            $myFields = '';
            $myValues = '';
            
            $i = 0;
            foreach($_POST as $key => $val) {

                $sep = ($i > 0) ? "," : '';
                
                if(is_array($param)) {
                    foreach($param as $k => $v) {
                        if($key == $k) {
                            $nV = preg_replace('/('.$k.')/', "\$_POST[$1]", $v);
                            eval("\$val = ". $nV . ";");
                        }
                    }
                }

                if($key != 'insertAll') {
                    $myFields .= $sep . $key;
                    $myValues .= $sep . "'" . $val ."'";

                    $i++;
                }
            }

            if(is_array($fields)) {
                foreach($fields as $fk => $fv) {
                    $myFields .= $sep . $fk;
                    $myValues .= $sep . "'" . $fv ."'";
                }
            }

            $result = $this->query("INSERT INTO $table ( $myFields ) VALUES ( $myValues )");
                
        } else {
            return false;
        }
    }

    public function __call($method,$args) {

        if( 'model' == $method ) {
            
            if(method_exists($this->model,CURACTION)) {
                $result = call_user_func_array(array($this->model,CURACTION),$args);
            }
        } else { 
            $result = self::setCMObject($method,$args);
        }

        return $result;
    }
}

?>
