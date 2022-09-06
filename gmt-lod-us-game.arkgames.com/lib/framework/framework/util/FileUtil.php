<?php // -*-coding:utf-8; mode:php-mode;-*-
namespace framework\util;

/**
 * 文件操作工具类
 * @author xodger@gmail.com
 * @package framework\util
 */
class FileUtil {
	/**
	 * 取得目录下及所有子孙目录的文件路径，并且以$dir参数为根目录名
	 * @param String $dir 路径名 
	 * @param String $filter 正则表达式，过滤掉文件名不匹配该表达式的文件
	 * @return array
	 */
	public static function treeDirectory($dir, $filter = null) {
		$dirpath = realpath($dir);
		
		$files = array();
		$filenames = scandir($dir);

		for ($i = 0, $count = count($filenames); $i < $count; $i ++) {
			$filename = $filenames[$i];

			if ($filename=='.' || $filename=='..' || (!empty($filter) && !preg_match($filter, $filename)))
			{
				continue;
			}

			$file = $dirpath . DIRECTORY_SEPARATOR . $filename;
			if(is_dir($file))
			{
				$files = array_merge($files, self::treeDirectory($file));
			}
			else
			{
				$files[] = $file;
			}
		}

		return $files;
	}
}
