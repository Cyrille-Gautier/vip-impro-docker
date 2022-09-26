<?php
//============================================================+
// File name   : tcpdf_import.php
// Version     : 1.0.001
// Begin       : 2011-05-23
// Last Update : 2013-09-17
// Author      : Nicola Asuni - Tecnick.com LTD - www.tecnick.com - info@tecnick.com
// License     : GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2011-2013 Nicola Asuni - Tecnick.com LTD
//
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the License
// along with TCPDF. If not, see
// <http://www.tecnick.com/pagefiles/tcpdf/LICENSE.TXT>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description : This is a PHP class extension of the TCPDF library to
//               import existing PDF documents.
//
//============================================================+

/**
 * @file
 * !!! THIS CLASS IS UNDER DEVELOPMENT !!!
 * This is a PHP class extension of the TCPDF (http://www.tcpdf.org) library to import existing PDF documents.<br>
 * @package com.tecnick.tcpdf
 * @author Nicola Asuni
 * @version 1.0.001
 */

// include the TCPDF class
require_once(dirname(__FILE__) . '/tcpdf.php');
// include PDF parser class
require_once(dirname(__FILE__) . '/tcpdf_parser.php');

/**
 * @class TCPDF_IMPORT
 * !!! THIS CLASS IS UNDER DEVELOPMENT !!!
 * PHP class extension of the TCPDF (http://www.tcpdf.org) library to import existing PDF documents.<br>
 * @package com.tecnick.tcpdf
 * @brief PHP class extension of the TCPDF library to import existing PDF documents.
 * @version 1.0.001
 * @author Nicola Asuni - info@tecnick.com
 */
class TCPDF_VIP extends TCPDF {

	protected $default_font='dejavusans';
	//$titilliumweb = TCPDF_FONTS::addTTFfont(get_stylesheet_directory_uri()."/tcpdf/fonts/titillium/TitilliumWeb-Regular.ttf",'TrueTypeUnicode', '', 32);
	
	//$this->SetFont($titilliumweb, '', 14, '', false);
    //Page header
    public function Header() {
		// get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        //$this->SetAutoPageBreak(false, 0);
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
		$this->SetMargins($left=0, $top=0, $right=0, $bottom=0);
		$this->SetFont($default_font,'R',8);
		$this->SetTextColor(128); 
		$this->SetMargins(0,0,0,0);
		$this->SetAutoPageBreak(false, 0);
    }
	 
    
	
    // Page footer
    public function Footer() {	
    }

} // END OF CLASS

//============================================================+
// END OF FILE
//============================================================+
