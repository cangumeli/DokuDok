<?php

class PDFtoIMG
{
	private $image;
	private $pdfName;
	private $totalNumber;

	public function __construct($pdfName)
	{
		$this->image = new imagick();
		$this->pdfName = $pdfName;
		$this->totalNumber = $this->totalNumber();
	}

	//Will Change
	public function makeIMG($i)
	{
		$imgName = "thumbs/";
		$imgName .= md5("ThUmB.".rand(rand(0,1000), rand(1001, 1000000)));
		$imgName .= ".png";

		$this->image->setResolution(200,200);
		$this->image->readImage($this->pdfName."[".$i."]");
		$this->image->scaleImage(800,0);
		$this->image->setImageColorspace(255); 
		$this->image->setCompressionQuality(95); 
		$this->image = $this->image->flattenImages();
		$this->image->setImageFormat("png");
		$this->image->writeImage($imgName);
		
		return $imgName;
	}

	private function totalNumber()
	{
		$pdftext = file_get_contents($this->pdfName);
  		$num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
  		return $num;
	}

	public function getPageCount() { return $this->totalNumber; }

	public function __destruct()
	{
		$this->image->clear();
		$this->image->destroy();
	}	
}
//$class = new PDFtoIMG();
//$class->makeIMG("x.pdf", 0);
?>