<?php
require '../vendor/autoload.php';
require_once('MediaWiki/Config.php');
require_once('MediaWiki/Page.php');
require_once('MediaWiki/Functions.php');
require_once('MediaWiki/Images.php');
require_once('Logging.php');
use \Helper\Config;

/**
 * Init file for easy set up of scripts
 * This file needs to be included or must be copied into the script
 * @author DFelten
 */
$config = new Config();
$wiki = $config->getWiki();
?>
