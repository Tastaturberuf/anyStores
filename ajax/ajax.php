<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 - 2025 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 * @since       1.8.0
 */


namespace Tastaturberuf;

define('TL_MODE', 'FE');
define('TL_SCRIPT', __FILE__);

$file = str_replace('vendor/tastaturberuf/anystores', 'system/initialize.php', dirname(__DIR__));

if (!file_exists($file)) {
    http_response_code(404);
    die('404 Not Found');
}

require $file;

FrontendAjax::run(\Input::get('module'), \Input::get('token'));
