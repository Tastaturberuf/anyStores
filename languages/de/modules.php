<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['slmap_legend'] = 'Google Maps';


/**
 * Back end modules
 */
$GLOBALS['TL_LANG']['MOD']['anystores'] = array('anyStores', 'Händler-Listen verwalten und geographische Suche ermöglichen.');


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_LANG']['FMD'], 0, array
(
    'anystores'         => 'AnyStores',
    'anystores_search'  => array('anyStores Suche', 'fügt eine Suchmaske ein.'),
    'anystores_list'    => array('anyStores Liste', 'fügt eine Liste aller Händler zur Seite hinzu.'),
    'anystores_details' => array('anyStores Details', 'zeigt Details zum ausgewählten Händler an.')
));


array_insert($GLOBALS['TL_LANG']['tl_module'], 0, array
(
    'anystores_defaultCountry'       => array('Standardland', 'In welchem Land sollen die Ergebnisse gesucht werden (falls der Benutzer kein anderes ausgewählt hat)?'),
    'anystores_showFullCountryNames' => array('Ländernamen ausgeschrieben?', 'Sollen die Ländernamen in kompletter Länge und nicht als Kürzel angezeigt werden?'),

    'anystores_categories'           => array('Händlerkategorien', 'Aus welchen Händlerlisten sollen Einträge angezeigt werden?'),
    'anystores_listLimit'            => array('Anzahl der Ergebnisse', 'Wieviele Ergebnisse sollen maximal angezeigt werden?'),
    'anystores_allowEmptySearch'     => array('Leersuche erlauben?', 'Soll der Benutzer eine leere Suchanfrage abschicken können um alle Ergebnisse angezeigt zu bekommen?'),

    'anystores_limitDistance'        => array('Entfernung begrenzen', 'Einträge ab einer maximalen Entfernung nicht anzeigen.'),
    'anystores_maxDistance'          => array('Maximale Entfernung', 'Die maximale Entfernung in km.'),

    'anystores_detailsMaptype'       => array('Typ', 'Welche Art von Google Map soll angezeigt werden?'),
    'anystores_detailsMaptypes'      => array('statisch', 'dynamisch')
));
