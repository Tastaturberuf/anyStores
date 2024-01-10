<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_LANG']['tl_form'] = array_replace($GLOBALS['TL_LANG']['tl_form'] ?? [], array
(
    'anystores_legend'    => 'AnyStores settings',
    'anystores_sendEmail' => array
    (
        'anyStores: Send an email from following field',
        'Send an copy from the choice of this field.'
    ),
    'anystores_emailNearestStore' => array
    (
        'Mail to the nearest location.',
        'Determined from the fields street, postal, city and country the next location and send a copy ftom the message. Compatible with EFG.'
    ),
    'anystores_categories' => array('Categories', 'Choose categories for the determination to the nearest location.')
));
