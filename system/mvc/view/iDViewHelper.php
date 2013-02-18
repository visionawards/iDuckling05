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
 * @subpackage      system.mvc.view
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

class iDViewHelper {

    protected $_pageView;
    private $__siteView;
    private $__siteModView;
    private $__hasArrayVar;
    private $__hasArrayVar1;
    private $__hasArrayVar2;
    private $__hasForeach;
    
    public function __construct() {
    }

    public function header($hasHeader) {
        define(HEADER, $hasHeader);
    }

    public function neck($hasNeck) {
        define(NECK, $hasNeck);
    }

    public function bodytop($hasBodyTop) {
        define(BODYTOP, $hasBodyTop);
    }

    public function bodyleft($hasBodyLeft) {
        define(BODYLEFT, $hasBodyLeft);
    }

    public function bodyright($hasBodyRight) {
        define(BODYRIGHT, $hasBodyRight);
    }

    public function bodybottom($hasBodyBottom) {
        define(BODYBOTTOM, $hasBodyBottom);
    }

    public function body($hasBody) {
        define(BODY, $hasBody);
    }

    public function footer($hasFooter) {
        define(FOOTER, $hasFooter);
    }

    public function sole($hasSole) {
        define(SOLE, $hasSole);
    }    
    
    public function tail($hasTail) {
        define(TAIL, $hasTail);
    }

    public function onload($onload) { //see iDControllerHelper
        define(ONLOAD, $onload);
    }

    public function raw($raw) { //this is for getting, e.g. JSON data
        define(RAW, $raw);
    }

    public function json($data){}
    
    public function render($_pageView,$_action = NULL) {

        if($_action) {
            if($_action == CURACTION) {
                define(iDVIEW, $_pageView);
            } else {
                define(iDAction, $_action);
            }
        } else {
            define(iDVIEW, $_pageView);
        }
    }

    public function renderOnly($_pageView,$_action = NULL) {
        if($_action) {
            if($_action == CURACTION) {
                define(iDVIEW, $_pageView);
            } else {
                define(iDAction, $_action);
            }
        } else {
            define(iDVIEW, $_pageView);
        }
    }

    public function renderOnlywTail($_pageView,$_action = NULL) {
        if($_action) {
            if($_action == CURACTION) {
                define(iDVIEW, $_pageView);
            } else {
                define(iDAction, $_action);
            }
        } else {
            define(iDVIEW, $_pageView);
        }
    }    
    
    public function setPageTitle($title) {
        define(PAGE_TITLE,$title);
    }

    public function setSiteView($siteViewData) {

        $siteViewData = self::setSiteView1($siteViewData);

        $cacheFile = SITE_ID . "." . CURMODULE . "." . CUREVENT . "." . CURVIEW . "." . CACHE_FILE_EXT;

        if(!file_exists(CACHE_PATH . SITE_ID)) {
              mkdir(CACHE_PATH . SITE_ID , 0777);
        }

        $fh = fopen( CACHE_PATH . SITE_ID . DS . $cacheFile , "w");
        fwrite($fh, $siteViewData);
        fclose($fh);

        include(CACHE_PATH . SITE_ID . DS . $cacheFile);

    }

    public function setSiteView1($siteViewData) {

        if(preg_match('/(\{:\s*)(inc)\((.*?\w+.*?)\)\;(\:})/', $siteViewData) > 0) {
            $siteViewData = self::scanViewDataInc($siteViewData);
        }

        if(preg_match('/(\{\:\s*)(.*)\@(foreach)(.*)(\s*\:\})/', $siteViewData) > 0) {
            $siteViewData = preg_replace("/(\{\:\s*)(.*)\@(foreach)\s.*\(\#([\w+.*]+)(.*)(\s*\:\})/", "$1$2if(count(\$_SESSION['$4'])>0){ $3(#$4$5$6" ,$siteViewData);
            $siteViewData = self::setSiteView1($siteViewData);
        }

        $siteViewData =  preg_replace("/(\{\:=\s*)(.*)\#([\w+.*]+)(.*)(\s*\:\})/", "$1$2\$_SESSION['$3']$4$5", $siteViewData);
        
        if(preg_match('/(\{\:\s*)(.*)\#([\w+.*]+)(.*)(\s*\:\})/', $siteViewData) > 0) {
            $siteViewData =  preg_replace("/(\{\:\s*)(.*)\#([\w+.*]+)(.*)(\s*\:\})/", "$1$2\$_SESSION['$3']$4$5", $siteViewData);
            $siteViewData = self::setSiteView1($siteViewData);
        }
        
        $siteViewData = preg_replace('/({:=)((?:[^{:=]+|(?!:}).)*)(:})/is', "<?php echo($2);?>", $siteViewData);
        $siteViewData = preg_replace('/({:)((?:[^{:]+|(?!:}).)*)(:})/is', "<?php $2 ?>", $siteViewData);

       if(eregi("<%",$siteViewData)) {
            $siteViewData = self::setSiteViewJS($siteViewData);
       }

       if(eregi("<:",$siteViewData)) {
            $siteViewData = self::setSiteView2($siteViewData);
       }

       return $siteViewData;
    }

    private function scanViewDataInc($siteViewData) {
 
        preg_match_all('/(\{:\s*)(inc)\((.*?\w+.*?)\)\;(\:})/', $siteViewData, $inc_val);

        foreach($inc_val[3] as $key => $val) {
            $viewVal = $val;
        }
        ob_start();
        include_once(MODULE_ROOT. DS. CURMODULE. DS . MODULE_VIEW_ROOT . DS . $viewVal . VEXT);
        $siteViewDataInc = ob_get_contents();
        ob_end_clean();

        $siteViewDataInc = self::setSiteView1($siteViewDataInc);

        $incViewCacheFile = SITE_ID . "." . CURMODULE . "." . CUREVENT . "." . $viewVal . "." . CACHE_INC_FILE_EXT;

        if(!file_exists(CACHE_INC_PATH)) {
              mkdir(CACHE_INC_PATH , 0777);
        }

        $fh = fopen( CACHE_INC_PATH . $incViewCacheFile , "w");
        fwrite($fh, $$siteViewDataInc);
        fclose($fh);

        $incPath = "include_once(\"" . CACHE_INC_PATH . "$incViewCacheFile\")";

        $siteViewData = preg_replace("/(\{:\s*)(inc)\((.*?\w+.*?)\)\;(\:})/", "$1 $incPath;$4" ,$siteViewData);
                   
        return $siteViewData;
    }

    public function setSiteView2($siteViewData) {

        preg_match_all('/(<:)(\s?)(\w.*)(\s?)(:>)/', $siteViewData, $inc_mod);

        foreach($inc_mod[3] as $key => $val) {
            if(eregi("\,",$val)) {
                $arrMod = split(",", $val);
                $modVal = $arrMod[0];
                $evtVal = ($arrMod[1]!='') ? $arrMod[1] : $arrMod[0];
                $actVal = ($arrMod[2]!='') ? $arrMod[2] : $evtVal;
                $viewVal = ($arrMod[3]!='') ? $arrMod[3] : $actVal;
            } else {
                $modVal = $val;
                $evtVal = $val;
                $actVal = $val;
                $viewVal = $val;
            }
                $meaVal = $arrMod[0] . "," . $arrMod[1] . "," . $arrMod[2];
                
                $viewVal = preg_replace("/(\<\?php)\s?(echo)\((\w.*)\)\s?(;\?\>)/", "$3" , $viewVal);

                eval("\$viewVal = $viewVal;");

                $modParam = array();
                if(count($arrMod) > 4) {
                    for($i=4;$i<count($arrMod);$i++) {

                        //if(eregi("\<\?php",$arrMod[$i])) {
                        if(eregi("echo",$arrMod[$i])) {
                            $modPar = preg_replace("/(\<\?php)\s*(echo)\((\w.*)\)(;\?\>)/", "$3" , $arrMod[$i]);
                            eval("\$myPar = ". $modPar . ";");
                        } else {
                            $myPar = $arrMod[$i];
                        }
                        $modParam[] .= $myPar;
                    }
                }

                require_once(MODULE_ROOT . DS . $modVal . DS . 'controller' . DS . $evtVal . EXT);

                $objMod = new $evtVal();
                call_user_func_array(array($objMod,"$actVal"), $modParam );

                ob_start();
                include_once( MODULE_ROOT . DS . $modVal . DS . 'view' . DS . $viewVal . VEXT);
                $incSiteViewData = ob_get_contents();
                ob_end_clean();

                $incSiteViewData = self::setSiteView1($incSiteViewData);

                $modViewCacheFile = SITE_ID . "." . $modVal . "." . $evtVal . "." . $viewVal . "." . CACHE_INC_FILE_EXT;

                if(!file_exists(CACHE_INC_PATH)) {
                      mkdir(CACHE_INC_PATH , 0777);
                }

                $fh = fopen( CACHE_INC_PATH . $modViewCacheFile , "w");
                fwrite($fh, $incSiteViewData);
                fclose($fh);

                $incPath = "include_once(\"" . CACHE_INC_PATH . "$modViewCacheFile\")";

                $siteViewData = preg_replace("/(<:)(" . $meaVal . "[a-zA-Z0-9_'\s*\,\<\?\;\>\(\)]+)(:>)/", "<?php $incPath;?>" , $siteViewData);
        }

        return $siteViewData;
    }

    public function setSiteViewJS($siteViewData) {

       $siteViewData = preg_replace('/(<%)(.*)\$\.iDJS\.([a-zA-Z0-9]+)(.*)(%>)/is', "$1$2iDJS.$3$4$5$6$7", $siteViewData);

       if(preg_match('/(<%)(.*)\$\.iDJS\.([a-zA-Z0-9]+)(.*)(%>)/is',$siteViewData) > 0) {
            $siteViewData = self::setSiteViewJS($siteViewData);
       } else {
            $siteViewData = preg_replace('/(<%)((?:[^<%]+|(?!%>).)*)(%>)/is', "<script type='application/x-javascript'>$2</script>", $siteViewData);
       }

       return $siteViewData;
    }

}

?>
