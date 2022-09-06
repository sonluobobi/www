<?php
/**
 * @author juezhong.long
 */
require_once 'Classes/PHPExcel.php';

class PHPExcelDownload 
{
	private $filename;
	private $title;
	private $format;
	private $objPHPExcel;
	
	/**
	 * 
	 * @param $filename
	 * @param $title
	 * @param $format
	 * @return unknown_type
	 */
	function __construct($filename='test',$title='test',$format='xls')
	{
		$this->title = $title;
		$this->filename = $filename;
		$this->format = strtolower($format);
		$this->objPHPExcel = new PHPExcel();
		$this->setProperties();
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	private function setProperties()
	{
		$this->objPHPExcel->getProperties()->setCreator("Juezhong Long")
							 ->setLastModifiedBy("Juezhong Long")
							 ->setTitle("Kunlun GMT Document")
							 ->setSubject("Kunlun GMT Document")
							 ->setDescription("Kunlun GMT Document, generated using PHP classes.")
							 ->setKeywords("Provide Download")
							 ->setCategory("Download file");
	}
	
	/**
	 * 
	 * @param $data
	 * @return unknown_type
	 */
	private function setSheetData($data)
	{
		$num = 1;
		foreach($data as $tmp)
		{
			$startChar = 65; //65为字母A的ASCII码
			foreach($tmp as $k => $v)
			{
				$col = chr($startChar).$num;
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue("$col", "$v");
				$startChar = $startChar + 1;
			}
			$num += 1;
		}
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	private function downloadExcel()
	{
		// Rename sheet
		$this->objPHPExcel->getActiveSheet()->setTitle($this->title);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$this->objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		$fileInfo = $this->getFileProperties();
		
		header('Content-Type: '.$fileInfo['app'].'\'');
		header('Content-Disposition: attachment;filename="'.$this->filename.'.'.$this->format.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $fileInfo['write']);
		$objWriter->save('php://output');
		exit;
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	private function getFileProperties()
	{
		$filePro = array();
		switch($this->format)
		{
			case 'xls':
				$filePro['app'] = 'application/vnd.ms-excel';
				$filePro['write'] = 'Excel5';
				break;
			case 'pdf':
				$filePro['app'] = 'application/'.$this->format;
				$filePro['write'] = strtoupper($this->format);
				break;
			default :
				$filePro['app'] = 'vnd.ms-excel';
				$filePro['write'] = 'Excel5';
		}
		return $filePro;
	}
	
	/**
	 * 
	 * @param $data
	 * @return unknown_type
	 */
	public function getDownLoad($data)
	{
		$this->setSheetData($data);
		$this->downloadExcel();	
	}
}

?>