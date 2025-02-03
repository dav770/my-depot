<?php
include 'PDFMerger.php'; 
use PDFMerger\PDFMerger; 
$pdf = new PDFMerger;

$pdf->addPDF('pdf1.pdf', '1')      //  1 is page1 ,'1,2,3'  are pdf pagenumbers that you want to include in merge
	->addPDF('pdf2.pdf', 'all')
	
	->merge('download', 'TEST.pdf');
	
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
