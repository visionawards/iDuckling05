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

class iDControllerModelObserver implements IiDControllerModelObserver {

    private $__iDControllerModelSubject;

    public function  __construct(iDControllerModelSubject $__iDControllerModelSubject) {

        $this->modClassObjects = $this->getModuleClasses( MODULE_ROOT );
        $this->__iDControllerModelSubject = $__iDControllerModelSubject;

        foreach($this->modClassObjects as $modClassObj) {
            $mod = $modClassObj['mod'];
            $evt = $modClassObj['cls'];

            $this->$evt = $modClassObj['obj'];
            $this->$mod->$evt = $modClassObj['obj'];
            $this->__iDControllerModelSubject->registerObserver($modClassObj['obj']);
        }
        $this->model_prefix = MODEL_PREFIX;
    }

    public function update($params) {
       //$this->getModuleClasses( MODULE_ROOT );
       //foreach($this->modClassObjects as $modClassObj) {
       //     $this->{$modClassOb['mod']}->{$modClassObj['cls']} = $modClassObj['obj'];
       //}
    }

    private function getDirFiles($dir) {

        $files = array();

        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
               if($file != '.' && $file != '..' && strpos( $file, '.') !== 0) {                   
                $file = preg_replace( '/\.[a-z0-9]+$/i' , '' , $file );
                $files[] = $file;                   
               }
            }
            closedir($handle);
        }

        return $files;
    }

    private function getModuleClasses($dir) {

        $this->modules = $this->getDirFiles($dir);

        foreach($this->modules as $modDir) {
            $this->controllerClasses []= $this->getDirFiles($dir . DS . $modDir. DS . CONTROLLER_ROOT );
            $this->modelClasses []= $this->getDirFiles($dir . DS . $modDir. DS . MODEL_ROOT );
        }

        for($i=0;$i<count($this->modules);$i++) {
            $mod = $this->modules[$i];
            for($j=0;$j<count($this->controllerClasses[$i]);$j++) {
                $controllerClass = $this->controllerClasses[$i][$j];
                $modelClass = $this->modelClasses[$i][$j];
                require_once( MODULE_ROOT . DS . $mod . DS . CONTROLLER_ROOT . DS . $controllerClass .'.php');
                require_once( MODULE_ROOT . DS . $mod . DS . MODEL_ROOT . DS . $modelClass .'.php');

                //$objC = new $controllerClass(1);
                //$objM = new $modelClass();
                $obj []= array("mod"=>$mod,"cls"=>$controllerClass,"obj"=>$objC,"mvc"=>"c");
                $obj []= array("mod"=>$mod,"cls"=>$modelClass,"obj"=>$objM,"mvc"=>"m");
            }
        }
        return $obj;
    }

    private function setClassObject($moduleName, $className) {

        $this->$$moduleName->$$className = new $className();
        return $this->$$moduleName->$$className;
    }

    public function __call($method,$args) {

            foreach($this->modClassObjects as $mCO) {
                $mod = $mCO['mod'];
                $evt = $mCO['cls'];

                if(method_exists($evt,$method)) {
                    //call_user_func_array(array($evt,$method), $args);
                    call_user_func_array(array($evt,'parent::__construct'),$args);

                    $result = call_user_func_array(array($evt,$method),$args);
                }
                //$this//->$evt = $modClassObj['obj'];
               // $this->$mod->$evt = $modClassObj['obj'];
            }

        //elseif(method_exhist($this->{CURMODULE}))

        return $result;
    }

}
?>
