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
class TCPDF_AMBIANCEBUREAU extends TCPDF {

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
        $this->SetAutoPageBreak(false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
		$this->SetMargins($left=0, $top=0, $right=0, $bottom=0);
		$this->SetFont($default_font,'R',8);
		$this->SetTextColor(128); 
		$this->SetMargins(0,0,0,0);
		$this->SetAutoPageBreak(false, 0);
        $template = get_stylesheet_directory_uri()."/images/template_PDF_produit_ambiance.jpg"; 
		$this->Image($template, 0, 0, 210);
		// set style for barcode
		$styleQR = array(
		    'border' => 0,
		    'vpadding' => '0',
		    'hpadding' => '0',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255)
		    'module_width' => 1, // width of a single module in points
		    'module_height' => 1 // height of a single module in points
		);
		$link=get_permalink($_GET['id_produit']);
		$this->write2DBarcode($link, 'QRCODE,M', 183, 12, 15, 15, $styleQR, 'N');
		$linktext='<a href="'.$link.'" style="text-decoration:none; color:rgb(128,128,128);">Retrouvez la page produit</a>';
		//$this->writeHTML( $html=$linktext, $ln = true, $fill = false, $reseth = true, $cell = false, $align = 'R' );
		$this->writeHTMLCell( $w=52, $h=6, 	$x=146, $y=28, 	$html = $linktext, 	$border = 0, $ln = 0, $fill = false, $reseth = true, $align = 'R', $autopadding = true ); 
		$this->SetXY(12, 41);
		$this->Cell($w=186,	$h=6, $txt="Nom du produit :", $border = 0, $ln = 0, $align = 'L', $fill = false );			
		$this->Line ($x1=12, $y1=47, $x2=198, $y2=47, $style = array( 'width'=>0.25, 'color'=>array(128,128,128) ) ); 
    }
	 
    
	
    // Page footer
    public function Footer() {	
		$this->SetTextColor(128); 
		$this->Line ($x1=12, $y1=262, $x2=198, $y2=262, $style = array( 'width'=>0.25, 'color'=>array(128,128,128) ) ); 
		$this->SetFont($default_font,'R',9);
		$this->SetXY(12,264);
		$this->MultiCell(186,4,"Parc des Tuileries - 9, rue des Nonettes BP 20
			77500 CHELLES Cedex
			Tél : 01 60 08 71 92 - Fax : 01 60 08 19 20
			Mail : contact@ambiance-bureau.com",0,'L');
		$this->SetFont($default_font,'R',6);
		$this->SetXY(12,282);
		$this->Cell($w=186,	$h=6, $txt="SIRET : 790 905 343 000 22 - TVA Intraco : FR11 790 905 343", $border = 0, $ln = 0, $align = 'L', $fill = false );	
		$this->SetXY(126, 282);
		$this->SetFont($default_font,'B',9);
		$linktext='<a href="http://www.ambiance-bureau.fr" style="text-decoration:none; color:rgb(205,23,25);">www.ambiance-bureau.fr</a>';
		//$this->writeHTML( $html=$linktext, $ln = true, $fill = false, $reseth = true, $cell = false, $align = 'R' );
		$this->writeHTMLCell( $w=60, $h=6, 	$x=138, $y=282, 	$html = $linktext, 	$border = 0, $ln = 0, $fill = false, $reseth = true, $align = 'R', $autopadding = true ); 	
    }

} // END OF CLASS

//============================================================+
// END OF FILE
//============================================================+
