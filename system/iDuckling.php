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
 * @package			
 * @subpackage		
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

class iDuckling extends iDMEAFacade {

    //protected $_moduleData;
    private $__siteViewData;

    public function __construct() {
        parent::__construct();//this initiate MEA process
        $this->getSiteLayout();
        //$this->initModel();
    }

    public function getSiteLayout() {
        $iDSL = new iDSiteLayoutLocal();
        $iDSL->buildSiteSkin();        
        $iDSL->setSiteLayout($this->moduleData);
        $this->__siteViewData = $iDSL->getSiteViewData();
        iDVIEW::setSiteView($this->__siteViewData);
        
        return $this->__siteViewData;
    }

    public function initModel() {
        new iDModelLocal();
    }

}

?>