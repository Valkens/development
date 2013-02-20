<?php
class Core_Upload
{
	public $maxSize				= 0;
	public $maxWidth			= 0;
	public $maxHeight			= 0;
	public $maxFilename			= 0;
	public $allowedTypes		= "";
	public $fileTemp			= "";
	public $fileName			= "";
	public $origName			= "";
	public $fileType			= "";
	public $fileSize			= "";
	public $fileExt				= "";
	public $uploadPath			= "";
	public $overwrite			= FALSE;
	public $encryptName			= FALSE;
	public $isImage				= FALSE;
	public $imageWidth			= '';
	public $imageHeight			= '';
	public $imageType			= '';
	public $imageSizeStr		= '';
	public $errorMsg			= array();
	public $removeSpaces		= TRUE;
	public $xssClean			= FALSE;
	public $tempPrefix			= "temp_file_";
	public $clientName			= '';

	protected $_errorMsg 		= array();
	protected $_fileNameOverride = '';

	/**
	 * Initialize preferences
	 *
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$defaults = array(
			'maxSize'			=> 0,
			'maxWidth'			=> 0,
			'maxHeight'		=> 0,
			'maxFilename'		=> 0,
			'allowedTypes'		=> "",
			'fileTemp'			=> "",
			'fileName'			=> "",
			'origname'			=> "",
			'fileType'			=> "",
			'fileSize'			=> "",
			'fileExt'			=> "",
			'uploadPath'		=> "",
			'overwrite'			=> FALSE,
			'encryptName'		=> FALSE,
			'isImage'			=> FALSE,
			'imageWidth'		=> '',
			'imageHeight'		=> '',
			'imageType'		=> '',
			'imageSizeStr'	=> '',
			'errorMsg'			=> array(),
			'mimes'				=> array(),
			'removeSpaces'		=> TRUE,
			'xssClean'			=> FALSE,
			'tempPrefix'		=> "temp_file_",
			'clientName'		=> ''
		);


		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key])) {
				$method = 'set' . ucfirst($key);
				if (method_exists($this, $method)) {
					$this->$method($config[$key]);
				} else {
					$this->$key = $config[$key];
				}
			} else {
				$this->$key = $val;
			}
		}

		// if a fileName was provided in the config, use it instead of the user input
		// supplied file name for all uploads until initialized again
		$this->_fileNameOverride = $this->fileName;
	}

	/**
	 * Perform the file upload
	 *
	 * @return	bool
	 */
	public function doUpload($field = 'userfile')
	{

		// Is $_FILES[$field] set? If not, no reason to continue.
		if (!isset($_FILES[$field])) {
			return;
		}

		// Was the file able to be uploaded? If not, determine the reason why.
		if (!is_uploaded_file($_FILES[$field]['tmp_name'])) {
			$error = (!isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];
			
			switch($error)
			{
				case 1:	// UPLOAD_ERR_INI_SIZE
					$maxUpload = (int) (ini_get('upload_max_filesize'));
					$maxPost = (int) (ini_get('post_max_size'));
					$memoryLimit = (int) (ini_get('memory_limit'));

					$this->setError('Upload file exceeds limit ' . min($maxUpload, $maxPost, $memoryLimit) . ' MB');
					break;
				
				case 2: // UPLOAD_ERR_FORM_SIZE
					$this->setError('Upload file exceeds form limit');
					break;
				
				case 3: // UPLOAD_ERR_PARTIAL
					$this->setError('Upload file partial');
					break;
				
				case 4: // UPLOAD_ERR_NO_FILE
					$this->setError('No Upload file is selected');
					break;
				
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$this->setError('Upload no temp directory');
					break;
				
				case 7: // UPLOAD_ERR_CANT_WRITE
					$this->setError('Upload unable to write file');
					break;
				
				case 8: // UPLOAD_ERR_EXTENSION
					$this->setError('Upload stop by extension');
					break;
				
				default :
					$this->setError('No Upload file is selected');
					break;
			}

			return FALSE;
		}


		// Set the uploaded data as class variables
		$this->fileTemp = $_FILES[$field]['tmp_name'];
		$this->fileSize = $_FILES[$field]['size'];
		$this->_fileMimeType($_FILES[$field]);
		$this->fileType = preg_replace("/^(.+?);.*$/", "\\1", $this->fileType);
		$this->fileType = strtolower(trim(stripslashes($this->fileType), '"'));
		$this->fileName = $this->_prepFileName($_FILES[$field]['name']);
		$this->fileExt	= $this->getExtension($this->fileName);
		$this->clieName = $this->fileName;

		// Is the file type allowed to be uploaded?
		if (!$this->isAllowedFileType()) {
			$this->setError('Only accept ' . implode(',', $this->allowedTypes) . ' file');
			return FALSE;
		}

		// if we're overriding, let's now make sure the new name and type is allowed
		if ($this->_fileNameOverride != '') {
			$this->fileName = $this->_prepFileName($this->_fileNameOverride);

			// If no extension was provided in the fileName config item, use the uploaded one
			if (strpos($this->_fileNameOverride, '.') === FALSE) {
				$this->fileName .= $this->fileExt;
			} else {
				$this->fileExt	 = $this->getExtension($this->_fileNameOverride);
			}

			if (!$this->isAllowedFileType(TRUE)) {
				$this->setError('Only accept ' . implode(',', $this->allowedTypes) . ' file');
				return FALSE;
			}
		}

		// Convert the file size to kilobytes
		if ($this->fileSize > 0) {
			$this->fileSize = round($this->fileSize / 1024, 2);
		}

		// Is the file size within the allowed maximum?
		if (!$this->isAllowedFileSize()) {
			$this->setError("File upload must be less than {$this->maxSize}MB");
			return FALSE;
		}

		// Sanitize the file name for security
		$this->fileName = $this->cleanFileName($this->fileName);

		// Remove white spaces in the name
		if ($this->removeSpaces == TRUE) {
			$this->fileName = preg_replace("/\s+/", "_", $this->fileName);
		}

		/*
		 * Validate the file name
		 * This function appends an number onto the end of
		 * the file if one with the same name already exists.
		 * If it returns false there was a problem.
		 */
		$this->origName = $this->fileName;

		if ($this->overwrite == FALSE) {
			$this->fileName = $this->setFileName($this->uploadPath, $this->fileName);

			if ($this->fileName === FALSE) {
				return FALSE;
			}
		}

		/*
		 * Run the file through the XSS hacking filter
		 * This helps prevent malicious code from being
		 * embedded within a file.  Scripts can easily
		 * be disguised as images or other file types.
		 */
		if ($this->xssClean) {
			if ($this->doXssClean() === FALSE) {
				$this->setError('Upload unable to write file');
				return FALSE;
			}
		}

		/*
		 * Move the file to the final destination
		 * To deal with different server configurations
		 * we'll attempt to use copy() first.  If that fails
		 * we'll use move_uploaded_file().  One of the two should
		 * reliably work in most environments
		 */
		if (!copy($this->fileTemp, $this->uploadPath . $this->fileName)) {
			if (!move_uploaded_file($this->fileTemp, $this->uploadPath . $this->fileName)) {
				$this->setError('Upload destination error');
				return FALSE;
			}
		}

		/*
		 * Set the finalized image dimensions
		 * This sets the image width/height (assuming the
		 * file was an image).  We use this information
		 * in the "data" function.
		 */
		$this->setImageProperties($this->uploadPath . $this->fileName);

		return TRUE;
	}

	/**
	 * Finalized Data Array
	 *
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @return	array
	 */
	public function data()
	{
		return array (
			'fileName'			=> $this->fileName,
			'fileType'			=> $this->fileType,
			'filePath'			=> $this->uploadPath,
			'fullPath'			=> $this->uploadPath . $this->fileName,
			'rawName'			=> str_replace($this->fileExt, '', $this->fileName),
			'origName'			=> $this->origName,
			'clientName'		=> $this->clientName,
			'fileExt'			=> $this->fileExt,
			'fileSize'			=> $this->fileSize,
			'isImage'			=> $this->isImage(),
			'imageWidth'		=> $this->imageWidth,
			'imageHeight'		=> $this->imageHeight,
			'imageType'		=> $this->imageType,
			'imageSizeStr'	=> $this->imageSizeStr
		);
	}

	/**
	 * Validate the image
	 *
	 * @return	bool
	 */
	public function isImage()
	{
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.

		$pngMimes  = array('image/x-png');
		$jpegMimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');

		if (in_array($this->fileType, $pngMimes)) {
			$this->fileType = 'image/png';
		}

		if (in_array($this->fileType, $jpegMimes)) {
			$this->fileType = 'image/jpeg';
		}

		$imgMimes = array(
			'image/gif',
			'image/jpeg',
			'image/png',
		);

		return (in_array($this->fileType, $imgMimes, TRUE)) ? TRUE : FALSE;
	}

	/**
	 * Extract the file extension
	 *
	 * @param	string
	 * @return	string
	 */
	public function getExtension($filename)
	{
		$x = explode('.', $filename);
		return '.' . end($x);
	}

	/**
	 * Verify that the filetype is allowed
	 *
	 * @return	bool
	 */
	public function isAllowedFileType($ignoreMime = FALSE)
	{
		if ($this->allowedTypes == '*') {
			return TRUE;
		}

		$ext = strtolower(ltrim($this->fileExt, '.'));
		if (!in_array($ext, $this->allowedTypes)) {
			return FALSE;
		}

		// Images get some additional checks
		$imageTypes = array('gif', 'jpg', 'jpeg', 'png');

		if (in_array($ext, $imageTypes)) {
			if (getimagesize($this->fileTemp) === FALSE) {
				return FALSE;
			}
		}

		if ($ignoreMime === TRUE) {
			return TRUE;
		}

		$mime = $this->mimesTypes($ext);

		if (is_array($mime)) {
			if (in_array($this->fileType, $mime, TRUE)) {
				return TRUE;
			}
		}
		elseif ($mime == $this->fileType) {
				return TRUE;
		}

		return FALSE;
	}

	/**
	 * Verify that the file is within the allowed size
	 *
	 * @return	bool
	 */
	public function isAllowedFileSize()
	{
		if ($this->maxSize != 0  AND  $this->fileSize > $this->maxSize) {
			return FALSE;
		}
		
		return true;
	}

	/**
	 * Clean the file name for security
	 *
	 * @param	string
	 * @return	string
	 */
	public function cleanFileName($filename)
	{
		$bad = array(
			"<!--",
			"-->",
			"'",
			"<",
			">",
			'"',
			'&',
			'$',
			'=',
			';',
			'?',
			'/',
			"%20",
			"%22",
			"%3c",		// <
			"%253c",	// <
			"%3e",		// >
			"%0e",		// >
			"%28",		// (
			"%29",		// )
			"%2528",	// (
			"%26",		// &
			"%24",		// $
			"%3f",		// ?
			"%3b",		// ;
			"%3d"		// =
		);

		$filename = str_replace($bad, '', $filename);

		return stripslashes($filename);
	}

	/**
	 * List of Mime Types
	 *
	 * This is a list of mime types.  We use it to validate
	 * the "allowed types" set by the developer
	 *
	 * @param	string
	 * @return	string
	 */
	public function mimesTypes($mime)
	{
		$mimes = Core_Helper_File::getMimeTypes();
		return $mimes[$mime];
	}

	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function setFileName($path, $filename)
	{
		if ($this->encryptName == TRUE) {
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$this->fileExt;
		}

		if (!file_exists($path . $filename)) {
			return $filename;
		}

		$filename = str_replace($this->fileExt, '', $filename);

		$newFilename = '';
		for ($i = 1; $i < 100; $i++) {
			if (!file_exists($path . $filename . $i . $this->fileExt)) {
				$newFilename = $filename . $i . $this->fileExt;
				break;
			}
		}

		if ($newFilename == '') {
			$this->setError('Upload bad file name');
			return FALSE;
		} else {
			return $newFilename;
		}
	}

	/**
	 * Set Allowed File Types
	 *
	 * @param	string
	 * @return	void
	 */
	public function setAllowedTypes($types)
	{
		if (!is_array($types) && $types == '*') {
			$this->allowedTypes = '*';
			return;
		}

		$this->allowedTypes = explode('|', $types);
	}

	/**
	 * Set Image Properties
	 *
	 * Uses GD to determine the width/height/type of image
	 *
	 * @param	string
	 * @return	void
	 */
	public function setImageProperties($path = '')
	{
		if (!$this->isImage()) {
			return;
		}

		if (function_exists('getimagesize')) {
			if (FALSE !== ($D = @getimagesize($path))) {
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$this->imageWidth	= $D['0'];
				$this->imageHeight	= $D['1'];
				$this->imageType	= ( ! isset($types[$D['2']])) ? 'unknown' : $types[$D['2']];
				$this->imageSizeStr	= $D['3'];  // string containing height and width
			}
		}
	}

	/**
	 * Prep Filename
	 *
	 * Prevents possible script execution from Apache's handling of files multiple extensions
	 * http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	 *
	 * @param	string
	 * @return	string
	 */
	protected function _prepFilename($filename)
	{
		if (strpos($filename, '.') === FALSE OR $this->allowedTypes == '*') {
			return $filename;
		}

		$parts		= explode('.', $filename);
		$ext		= array_pop($parts);
		$filename	= array_shift($parts);

		foreach ($parts as $part)
		{
			if ( ! in_array(strtolower($part), $this->allowedTypes) OR $this->mimesTypes(strtolower($part)) === FALSE) {
				$filename .= '.'.$part.'_';
			} else {
				$filename .= '.'.$part;
			}
		}

		$filename .= '.'.$ext;

		return $filename;
	}

	/**
	 * File MIME type
	 *
	 * Detects the (actual) MIME type of the uploaded file, if possible.
	 * The input array is expected to be $_FILES[$field]
	 *
	 * @param	array
	 * @return	void
	 */
	protected function _fileMimeType($file)
	{
		// We'll need this to validate the MIME info string (e.g. text/plain; charset=us-ascii)
		$regexp = '/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/';

		/* Fileinfo extension - most reliable method
		 *
		 * Unfortunately, prior to PHP 5.3 - it's only available as a PECL extension and the
		 * more convenient FILEINFO_MIME_TYPE flag doesn't exist.
		 */
		if (function_exists('finfo_file')) {
			$finfo = finfo_open(FILEINFO_MIME);
			if (is_resource($finfo)) { // It is possible that a FALSE value is returned, if there is no magic MIME database file found on the system{
				$mime = @finfo_file($finfo, $file['tmp_name']);
				finfo_close($finfo);

				/* According to the comments section of the PHP manual page,
				 * it is possible that this function returns an empty string
				 * for some files (e.g. if they don't exist in the magic MIME database)
				 */
				if (is_string($mime) && preg_match($regexp, $mime, $matches)) {
					$this->fileType = $matches[1];
					return;
				}
			}
		}

		/* This is an ugly hack, but UNIX-type systems provide a "native" way to detect the file type,
		 * which is still more secure than depending on the value of $_FILES[$field]['type'], and as it
		 * was reported in issue #750 (https://github.com/EllisLab/CodeIgniter/issues/750) - it's better
		 * than mime_content_type() as well, hence the attempts to try calling the command line with
		 * three different functions.
		 *
		 * Notes:
		 *	- the DIRECTORY_SEPARATOR comparison ensures that we're not on a Windows system
		 *	- many system admins would disable the exec(), shell_exec(), popen() and similar functions
		 *	  due to security concerns, hence the function_exists() checks
		 */
		if (DIRECTORY_SEPARATOR !== '\\') {
			$cmd = 'file --brief --mime ' . escapeshellarg($file['tmp_name']) . ' 2>&1';

			if (function_exists('exec'))
			{
				/* This might look confusing, as $mime is being populated with all of the output when set in the second parameter.
				 * However, we only neeed the last line, which is the actual return value of exec(), and as such - it overwrites
				 * anything that could already be set for $mime previously. This effectively makes the second parameter a dummy
				 * value, which is only put to allow us to get the return status code.
				 */
				$mime = @exec($cmd, $mime, $returnStatus);
				if ($returnStatus === 0 && is_string($mime) && preg_match($regexp, $mime, $matches)) {
					$this->fileType = $matches[1];
					return;
				}
			}

			if ( (bool) @ini_get('safe_mode') === FALSE && function_exists('shell_exec')) {
				$mime = @shell_exec($cmd);
				if (strlen($mime) > 0) {
					$mime = explode("\n", trim($mime));
					if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
						$this->fileType = $matches[1];
						return;
					}
				}
			}

			if (function_exists('popen')) {
				$proc = @popen($cmd, 'r');
				if (is_resource($proc)) {
					$mime = @fread($proc, 512);
					@pclose($proc);
					if ($mime !== FALSE) {
						$mime = explode("\n", trim($mime));
						if (preg_match($regexp, $mime[(count($mime) - 1)], $matches)) {
							$this->fileType = $matches[1];
							return;
						}
					}
				}
			}
		}

		// Fall back to the deprecated mime_content_type(), if available (still better than $_FILES[$field]['type'])
		if (function_exists('mime_content_type')) {
			$this->fileType = @mime_content_type($file['tmp_name']);
			if (strlen($this->fileType) > 0) {// It's possible that mime_content_type() returns FALSE or an empty string
				return;
			}
		}

		$this->fileType = $file['type'];
	}

	/**
	 * Set an error message
	 *
	 * @param	string
	 * @return	void
	 */
	public function setError($msg)
	{
		$this->_errorMsg[] = $msg;
	}

	public function getErrors()
	{
		return $this->_errorMsg;
	}

}