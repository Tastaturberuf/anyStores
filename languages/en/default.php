<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              (c) 2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


$GLOBALS['TL_LANG']['anystores'] = array
(

    // url params
    'url_params' => array
    (
        'search'  => 'search',
        'country' => 'country',
        //@todo rename key to 'details'
        'store'   => 'details'
    ),

    // days
    'days' => array
    (
        'mon' => $GLOBALS['TL_LANG']['DAYS'][1],
        'tue' => $GLOBALS['TL_LANG']['DAYS'][2],
        'wed' => $GLOBALS['TL_LANG']['DAYS'][3],
        'thu' => $GLOBALS['TL_LANG']['DAYS'][4],
        'fri' => $GLOBALS['TL_LANG']['DAYS'][5],
        'sat' => $GLOBALS['TL_LANG']['DAYS'][6],
        'sun' => $GLOBALS['TL_LANG']['DAYS'][0]
    ),

    // default
    'postal'      => 'ZIP / City',
    'distance'    => 'Distance approx.',
    'phone'       => 'Phone',
    'fax'         => 'Fax',
    'email'       => 'E-Mail',
    'www'         => 'Internet',
    'more'        => 'more information',
    'country'     => 'Country',
    'search'      => 'Search',
    'description' => 'Description',
    'closed'      => 'closed',
    'timePostfix' => '',

    // messages
    'noResults' => 'No results found.',
    'noCoods'   => 'No coodinates found.',

    // import
    'head'  => 'Location import',
    'start' => 'start import',
    'file'  => array('Choose file','The file must be saved using the UTF8-charset and may contain the following structure: name, email, url, phone, fax, street, postal, city, country (2-letters).')

);
