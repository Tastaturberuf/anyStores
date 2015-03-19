<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Dynamically add the permission check and parent table
 */
if ( Input::get('do') == 'anystores' )
{
    $GLOBALS['TL_DCA']['tl_content']['config']['ptable'] = 'tl_anystores';
}
