<?php
/**
 * Plugin Name: Crypto plugin by WebStudio.Solutions
 * Plugin URI:  https://webstudio.solutions/
 * Description: Utilizes Coingecko API to manage different operations related to cryptocurrencies.
 * Version:     1.0
 * Author:      WebStudio.Solutions
 * License:     GPL-2.0
 * Text Domain: cws
 */

namespace Cryptows;

use Cryptows\Classes\Shortcodes;
use Cryptows\Classes\Backend;
use Cryptows\Classes\Api;

define('CWSROOT', __DIR__);
define('CWSSCRIPTPATH', plugin_dir_url( __FILE__ ));

require_once dirname(__FILE__) . '/vendor/autoload.php';

global $plugin;

$plugin = new Shortcodes();
new Backend();
?>