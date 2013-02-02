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
}
