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
        'search'  => 'suche',
        'country' => 'land',
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
    'postal'      => 'PLZ / Ort',
    'distance'    => 'Entfernung ca.',
    'phone'       => 'Telefon',
    'fax'         => 'Fax',
    'email'       => 'E-Mail',
    'www'         => 'Internet',
    'more'        => 'mehr Informationen',
    'country'     => 'Land',
    'search'      => 'Suchen',
    'description' => 'Beschreibung',
    'closed'      => 'geschlossen',
    'timePostfix' => ' Uhr',

    // messages
    'noResults' => 'Zu Ihrer Suchanfrage wurden leider keine Ergebnisse gefunden.',
    'noCoods'   => 'Der Ort ihrer Suchanfrage konnte nicht gefunden werden.',

    // import
    'head'  => 'Standorte importieren',
    'start' => 'Import starten',
    'file'  => array('Datei auswählen','Die CSV-Datei muss mit dem UTF8-Zeichensatz kodiert und wie folgt aufgebaut sein: name, email, url, telefon, fax, strasse, plz, ort, ländercode (2-stellig)')

);
