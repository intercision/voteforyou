<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('FPDF_FONTPATH','font/');
require('fpdf.php');
require('fpdi/fpdi.php');
class Pdf extends FPDI
{
	// Extend FPDF using this class
	// More at fpdf.org -> Tutorials

	function __construct($orientation='P', $unit='mm', $size='A4')
	{
		// Call parent constructor
		parent::__construct($orientation,$unit,$size);
	}
}
?>