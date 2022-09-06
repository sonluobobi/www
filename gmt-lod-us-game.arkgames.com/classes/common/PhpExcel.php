<?php
/**
 * @filesource PhpExcel.php
 * @desc 提供公用的EXCEL处理方法
 * @author Juezhong Long
 * @date 2010-07-05
 */

namespace common;

class PhpExcel {
	
	/**
	 * 构造函数
	 */
	function __construct() 
	{
	
	}

	/**
	 * 读取EXCEL文件
	 * @param $xls 文件地址
	 * @return Array
	 */
	public static function readExcel($xls)
	{
		require_once "../lib/PHPExcel/PHPExcelReader.php";
 		$excelReader = new \Spreadsheet_Excel_Reader();
 		$excelReader->setOutputEncoding('UTF-8');
 		$excelReader->setUTFEncoder('mb');
 		$excelReader->read($xls);
 		return $excelReader->sheets;
	}
	
	/**
	 * 生成EXCEL下载文件 
	 * @param $filename 文件名称
	 * @param $title 文件标题
	 * @param $data 写入EXCEL数据，格式为二位数组
	 * @param $format 文件格式，EXCEL:xls
	 */
	public static function downloadExcel($filename,$title,$data,$format)
	{
		require_once '../lib/PHPExcel/PHPExcelDownload.php';
		$download = new \PHPExcelDownload($filename,$title,$format);
		$download->getDownLoad($data);
	}
}

?>