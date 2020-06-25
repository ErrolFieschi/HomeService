<?php

// define constants
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_LOCALE', 'fr_FR');

require_once('lib/gettext/gettext.inc');

$supported_locales = array('fr_FR', 'en_US');
$encoding = 'UTF-8';

$locale = (isset($_SESSION['language']))? $_SESSION['language'] : DEFAULT_LOCALE;

// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'en_US';
bindtextdomain($domain, LOCALE_DIR);
// bind_textdomain_codeset is supported only in PHP 4.2.0+
if (function_exists('bind_textdomain_codeset'))
    bind_textdomain_codeset($domain, $encoding);
textdomain($domain);

//header("Content-type: text/html; charset=$encoding");