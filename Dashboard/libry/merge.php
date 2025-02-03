<?php
//import fpdi and fpdf files
use setasign\Fpdi\Fpdi;
require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

//create your class to merge pdfs
class MergePdf extends Fpdi
{
    public $pdffiles = array();

    public function setFiles($pdffiles)
    {
        $this->pdffiles = $pdffiles;
    }
    //function to merge pdf files using fpdf and fpdi.
    public function merge()
    {
        foreach($this->pdffiles AS $file) {
            $pdfCount = $this->setSourceFile($file);
            for ($pdfNo = 1; $pdfNo <= $pdfCount; $pdfNo++) {
                $pdfId = $this->ImportPage($pdfNo);
                $temp = $this->getTemplatesize($pdfId);
                $this->AddPage($temp['orientation'], $temp);
                $this->useImportedPage($pdfId);
            }
        }
    }
}

$Outputpdf = new MergePdf();
//we gave absolute path because sometimes the libraries can't detect the path. Please use your path here.
$files= array();
			$files[] = __DIR__.'/../Dashboard/uploads/84WR6AX77002/DEVIS_SIGNED_7002.pdf';
			$files[] = __DIR__.'/../Dashboard/uploads/84WR6AX77002/CONTRAT_7002_SIGNED_ARCHIVED.pdf';
            $Outputpdf->setFiles($files);
// $Outputpdf->setFiles(array('C:\Apache24\htdocs\samplepdfs\one.pdf', 'C:\Apache24\htdocs\samplepdfs\two.pdf', 'C:\Apache24\htdocs\samplepdfs\three.pdf'));
$Outputpdf->merge();

//I: The output pdf will run on the browser
//D: The output will download a merged pdf file
//F: The output will save the file to a particular path.
//We select the default I to run the output on the browser.
$Outputpdf->Output('I', 'Merged PDF.pdf');
?>
