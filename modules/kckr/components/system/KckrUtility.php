<?php
/**
 * KckrUtility class file
 * version: 0.0.1
 *
 * Contains many function that most used :
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @created date 4 October 2016, 18:58 WIB
 * @copyright Copyright (c) 2016 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/mod-kckr
 * @contact (+62)856-299-4114
 *
 */

class KckrUtility
{
	
	/**
	 * Create pdf, save to disk and return the name with path
	 */
	public function getPdf($model, $preview=false, $template, $path=null, $documentName, $page=null, $returnIsPath=true)
	{
		ini_set('max_execution_time', 0);
		ob_start();
		
		Yii::import('application.modules.kckr.components.extensions.html2pdf.HTML2PDF');
		Yii::import('application.modules.kckr.components.extensions.html2pdf._mypdf.MyPDF');	// classe mypdf
		Yii::import('application.modules.kckr.components.extensions.html2pdf.parsingHTML');		// classe de parsing HTML
		Yii::import('application.modules.kckr.components.extensions.html2pdf.styleHTML');		// classe de gestion des styles
		
		include(YiiBase::getPathOfAlias('application.modules.kckr.components.templates').'/'.$template.'.php');	
		
		$content  = ob_get_clean();
		$fileName = '';
		
		try {
			// initialisation de HTML2PDF
			if($page == null)
				$page = 'P';
			$html2pdf = new HTML2PDF($page,'Legal','en', false, 'ISO-8859-15', array(0, 0, 0, 0));

			// affichage de la page en entier
			$html2pdf->pdf->SetDisplayMode('fullpage');

			// conversion
			$html2pdf->writeHTML($content);
			
			if($path == null)
				$path = YiiBase::getPathOfAlias('webroot.public.kckr.document_pdf');
			
			// Generate path directory
			if(!file_exists($path)) {
				@mkdir($path, 0755, true);

				// Add file in directory (index.php)
				$newFile = $path.'/index.php';
				$FileHandle = fopen($newFile, 'w');
			} else
				@chmod($path, 0755, true);
			
			$fileName = time().'_'.$documentName.'.pdf';
			$filePath = $path.'/'.$fileName;
			
			if($preview == false)
				$html2pdf->Output($filePath, 'F');
			else
				$html2pdf->Output($filePath);
			@chmod($filePath, 0777);
			
		} catch(HTML2PDF_exception $e) {
			echo $e;
		}
		
		if($returnIsPath == true)
			return $filePath;
		else
			return $fileName;
		
		ob_end_flush();
	}
	
}
