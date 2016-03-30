<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 * @since       1.8.0
 */


namespace Tastaturberuf;

define('TL_MODE', 'FE');

require '../../../initialize.php';

FrontendAjax::run(\Input::get('module'), \Input::get('token'));
