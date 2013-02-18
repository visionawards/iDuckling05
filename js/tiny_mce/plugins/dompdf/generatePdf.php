<?php

require("../../../../../config.php");

$before = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="stylesheet" type="text/css" href="format.css">
</head>
<body>

<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("verdana");;
  $size = 10;
  $color = array(0,0,0);
  $text_height = Font_Metrics::get_font_height($font, $size);

  $foot = $pdf->open_object();
  
  $w = $pdf->get_width();
  $h = $pdf->get_height();

  // Draw a line along the bottom
  $y = $h - $text_height - 24;
  $pdf->line(16, $y, $w - 16, $y, $color, 0.5);

  $pdf->close_object();
  $pdf->add_object($foot, "all");

  $text = "Seite {PAGE_NUM} von {PAGE_COUNT}";  

  // Center the text
  $width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
  
}
</script>
<div id="wrapper">
';

$html = optional_param('dompdf_html', NULL, PARAM_CLEANHTML);

$after = '</div></body></html>';

// Alle Grafiken liegen im pdf_res-Ordner --> Die src-Pfade in $html müssen koorigiert werden!
// Setzt voraus, dass das src-Attribut die folgende Struktur hat: 
//
//					src=".../irgend/ein/pfad/bild.png"
//
// Das ist insb. dann gewährleistet, wenn die Grafik mit Hilfe des TinyMCE-Editors eingefügt wurde.
do {
	$i = strpos($html, '<img', $j);
	
	if ($i) {
		$j = strpos($html, 'src', $i);
		$k = strpos($html,   '"', $j);
		$l = strpos($html,   '"', $k+1);
	
		$long_path = substr($html, $k, $l-$k+1);
		
		if (!strpos($long_path, '/')) {  // Der Pfad ist bereits OK
			continue;
		}

		$parts = explode('/', $long_path);
		
		$short_path = '"'.$parts[sizeof($parts)-1];

		$html = str_replace($long_path, $short_path, $html);	
	}
} while ($i);

$tmpfile = tempnam("/tmp", "dompdf_");

file_put_contents($tmpfile, $before.$html.$after); 

$url = $CFG->wwwroot."/lib/editor/tinymce3/plugins/dompdf/dompdf-0.5.1/dompdf.php?input_file=" . rawurlencode($tmpfile) .
       "&base_path=../pdf_res&paper=a4&output_file=" . rawurlencode("output.pdf");

header("Location: " . "$url");
?>
