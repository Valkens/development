<?php
class Core_Helper_File
{
	/**
	 * Get sub-directori(es) of a directory, not including the directory which
	 * its name is one of ".", ".." or ".svn"
	 *  
	 * @param string $dir Path to the directory
	 * @return array
	 */
	public static function getSubDir($dir) 
	{
		if (!file_exists($dir)) {
			return array();
		}
		
		$subDirs 	 = array();
		$dirIterator = new DirectoryIterator($dir);
		foreach ($dirIterator as $dir) {
            if ($dir->isDot() || !$dir->isDir()) {
                continue;
            }
            $dir = $dir->getFilename();
            if ($dir == '.svn') {
            	continue;
            }
            $subDirs[] = $dir;
		}
		return $subDirs;
	}
	
	/**
	 * @param string $dir
	 * @return boolean
	 */
	public static function deleteRescursiveDir($dir) 
	{
		if (is_dir($dir)) {	        	
            $dir 	 = (substr($dir, -1) != DS) ? $dir.DS : $dir;
            $openDir = opendir($dir);
            while ($file = readdir($openDir)) {
                if (!in_array($file, array(".", ".."))) {
                    if (!is_dir($dir.$file)) {
                        @unlink($dir.$file);
                    } else {
                        self::deleteRescursiveDir($dir.$file);
                    }
                }
            }
            closedir($openDir);
            @rmdir($dir);
        }
        
        return true;
	}
	
	/**
	 * @param string $source
	 * @param string $dest
	 * @return boolean
	 */
	public static function copyRescursiveDir($source, $dest) 
	{
		$openDir = opendir($source);
		if (!file_exists($dest)) {
	    	@mkdir($dest);
		}
		while ($file = readdir($openDir)) {
			if (!in_array($file, array(".", ".."))) {
	        	if (is_dir($source . DS . $file)) { 
	                self::copyRescursiveDir($source . DS . $file, $dest . DS . $file); 
	            } else { 
	                copy($source . DS . $file, $dest . DS . $file); 
				} 
	        }
	    }
	    closedir($openDir);
		
		return true;
	}
	
	/**
	 * Create sub-directories of given directory
	 * 
	 * @param string $root Path to root directory
	 * @param string $path Relative path to new created directory in format a/b/c (on Linux) 
	 * or a\b\c (on Windows)
	 */
	public static function createDirs($root, $path) 
	{
		$root 	 = rtrim($root, DS);
		$subDirs = explode(DS, $path);
		if ($subDirs == null) {
			return;
		}
		$currDir = $root;
		foreach ($subDirs as $dir) {
			$currDir = $currDir . DS . $dir;
			if (!file_exists($currDir)) {
				mkdir($currDir);
			}
		}	 
	}
	
	/**
	 * Get max file size allowed to upload
	 *
	 */
	 public static function getMaxFileSizeUpload()
	 {
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
		return $upload_mb;
	 }
	 
	 /**
	 * Check is foler empty
	 * @param  string $dirPath Path of folder
	 * return boolean
	 */
	public static function isEmptyDir($dirPath)
	{
		if (($files = @scandir($dirPath)) && (count($files) > 2)) {
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Count all file in directory
	 * @param string $dirPath Path of directory
	 * return int Number of files
	 */
	public static function countFiles($dirPath)
	{
		if (glob($dirPath . "/*.*") != false) {
		 	$filecount = count(glob($dirPath . "/*.*"));
		 	return $filecount;
		} else {
		 	return 0;
		}
	}
	
	/**
	 * Get all file in directory
	 * @param string $dirPath Path of directory
	 * @param string $rootPath Path of URL
	 *
	 * return array Array of files
	 */
	 public static function getAllFiles($dirPath, $rootPath = '')
	 {
		 $files = array();
		 if (!self::isEmptyDir($dirPath)) {
			 $files = glob($dirPath . '/*.*');
			 foreach ($files as $key => $file) {
				$file = str_replace($dirPath . '/', '', $file);
				$file = $rootPath . '/' . $file;
			 	$files[$key] = ltrim($file, '/');
			 }
		 }
		 return $files;
	 }
	 
	 /**
	  * Get name of directory base on date
	  *
	  * @return string
	  */
	 public static function getDirBaseOnDate()
	 {
		 $date = date('Y');  /**A full numeric representation of a year, 4 digits */
		 $date .= '/' . date('m'); /** Numeric representation of a month, with leading zeros */
		 
		 return $date;
	 }

    /**
     * Delete all file
     * @param string $dir Path of directory
     * @param string $ext File extension
     */
    public static function deleteAllFile($dir, $ext = '')
    {
        if (!self::isEmptyDir($dir)) {
            $ext  = $ext ? ".$ext" : '';
            $files = glob($dir . '/*' . $ext);

            foreach ($files as $key => $file) {
                @unlink($file);
            }
        }
    }

    public static function getMimeTypes()
    {
    	return array(
			'hqx'	=>	'application/mac-binhex40',
			'cpt'	=>	'application/mac-compactpro',
			'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'),
			'bin'	=>	'application/macbinary',
			'dms'	=>	'application/octet-stream',
			'lha'	=>	'application/octet-stream',
			'lzh'	=>	'application/octet-stream',
			'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
			'class'	=>	'application/octet-stream',
			'psd'	=>	'application/x-photoshop',
			'so'	=>	'application/octet-stream',
			'sea'	=>	'application/octet-stream',
			'dll'	=>	'application/x-dosexec',
			'oda'	=>	'application/oda',
			'pdf'	=>	array('application/pdf', 'application/x-download'),
			'ai'	=>	'application/postscript',
			'eps'	=>	'application/postscript',
			'ps'	=>	'application/postscript',
			'smi'	=>	'application/smil',
			'smil'	=>	'application/smil',
			'mif'	=>	'application/vnd.mif',
			'xls'	=>	array('application/excel', 'application/vnd.ms-excel', 'application/msexcel'),
			'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint'),
			'wbxml'	=>	'application/wbxml',
			'wmlc'	=>	'application/wmlc',
			'dcr'	=>	'application/x-director',
			'dir'	=>	'application/x-director',
			'dxr'	=>	'application/x-director',
			'dvi'	=>	'application/x-dvi',
			'gtar'	=>	'application/x-gtar',
			'gz'	=>	'application/x-gzip',
			'php'	=>	'application/x-httpd-php',
			'php4'	=>	'application/x-httpd-php',
			'php3'	=>	'application/x-httpd-php',
			'phtml'	=>	'application/x-httpd-php',
			'phps'	=>	'application/x-httpd-php-source',
			'js'	=>	'application/x-javascript',
			'swf'	=>	'application/x-shockwave-flash',
			'sit'	=>	'application/x-stuffit',
			'tar'	=>	'application/x-tar',
			'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
			'xhtml'	=>	'application/xhtml+xml',
			'xht'	=>	'application/xhtml+xml',
			'zip'	=>  array('application/x-zip', 'application/zip', 'application/x-zip-compressed'),
			'mid'	=>	'audio/midi',
			'midi'	=>	'audio/midi',
			'mpga'	=>	'audio/mpeg',
			'mp2'	=>	'audio/mpeg',
			'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
			'aif'	=>	'audio/x-aiff',
			'aiff'	=>	'audio/x-aiff',
			'aifc'	=>	'audio/x-aiff',
			'ram'	=>	'audio/x-pn-realaudio',
			'rm'	=>	'audio/x-pn-realaudio',
			'rpm'	=>	'audio/x-pn-realaudio-plugin',
			'ra'	=>	'audio/x-realaudio',
			'rv'	=>	'video/vnd.rn-realvideo',
			'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
			'bmp'	=>	array('image/bmp', 'image/x-windows-bmp'),
			'gif'	=>	'image/gif',
			'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
			'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
			'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
			'png'	=>	array('image/png',  'image/x-png'),
			'tiff'	=>	'image/tiff',
			'tif'	=>	'image/tiff',
			'css'	=>	'text/css',
			'html'	=>	'text/html',
			'htm'	=>	'text/html',
			'shtml'	=>	'text/html',
			'txt'	=>	'text/plain',
			'text'	=>	'text/plain',
			'log'	=>	array('text/plain', 'text/x-log'),
			'rtx'	=>	'text/richtext',
			'rtf'	=>	'text/rtf',
			'xml'	=>	'text/xml',
			'xsl'	=>	'text/xml',
			'mpeg'	=>	'video/mpeg',
			'mpg'	=>	'video/mpeg',
			'mpe'	=>	'video/mpeg',
			'qt'	=>	'video/quicktime',
			'mov'	=>	'video/quicktime',
			'avi'	=>	'video/x-msvideo',
			'movie'	=>	'video/x-sgi-movie',
			'doc'	=>	'application/msword',
			'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'),
			'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip'),
			'word'	=>	array('application/msword', 'application/octet-stream'),
			'xl'	=>	'application/excel',
			'eml'	=>	'message/rfc822',
			'json' => array('application/json', 'text/json')
		);
    }

}
