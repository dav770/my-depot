<?php
require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');

class PDF extends FPDI
{
	
	public $isoref;
	public $typedoc;
	public $nopageinfo;

	function Header()
	{
	}

	function Footer()
	{
		if ($this->nopageinfo != '') {
			$this->SetFont('times', '', 10);
			$this->setXY(175, -22);
			$this->setFillColor(255,255,255);
			$this->Cell(10,15,$this->nopageinfo,0,0,'C', true);		
		}
	}

}