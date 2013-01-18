<?php
global $connector;

/**
 * Protect against sending content before all HTTP headers are sent (#186).
 */
ob_start();

/**
 * define required constants
 */
require_once dirname(__FILE__) . "/constants.php";

// @ob_end_clean();
// header("Content-Encoding: none");

/**
 * we need this class in each call
 */
require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/CommandHandlerBase.php";
/**
 * singleton factory
 */
require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/Factory.php";
/**
 * utils class
 */
require_once CKFINDER_CONNECTOR_LIB_DIR . "/Utils/Misc.php";
/**
 * hooks class
 */
require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/Hooks.php";
/**
 * Simple function required by config.php - discover the server side path
 * to the directory relative to the "$baseUrl" attribute
 *
 * @package CKFinder
 * @subpackage Connector
 * @param string $baseUrl
 * @return string
 */
function resolveUrl($baseUrl) {
    $fileSystem =& CKFinder_Connector_Core_Factory::getInstance("Utils_FileSystem");
    return $fileSystem->getDocumentRootPath() . $baseUrl;
}

$utilsSecurity =& CKFinder_Connector_Core_Factory::getInstance("Utils_Security");
$utilsSecurity->getRidOfMagicQuotes();

/**
 * $config must be initialised
 */
$config = array();
$config['Hooks'] = array();
$config['Plugins'] = array();

/**
 * read config file
 */
require_once CKFINDER_CONNECTOR_CONFIG_FILE_PATH;

CKFinder_Connector_Core_Factory::initFactory();
$connector = CKFinder_Connector_Core_Factory::getInstance("Core_Connector");
$GLOBALS['connecter'] = $connector;

if(isset($_GET['command'])) {
    $connector->executeCommand($_GET['command']);
}
else {
    $connector->handleInvalidCommand();
}
