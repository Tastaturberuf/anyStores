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


/**
 * Back end modules
 */
$GLOBALS['TL_LANG']['MOD']['anystores_locations'] = array('Standorte', 'Standortlisten verwalten und geographische Suche ermöglichen.');
$GLOBALS['TL_LANG']['MOD']['anystores_settings']  = array('Einstellungen', 'Einstellungen für anyStores.');


/**
 * Front end modules
 */
array_insert($GLOBALS['TL_LANG']['FMD'], 0, array
(
    'anystores'         => 'AnyStores',
    'anystores_search'  => array('anyStores Suche',   'Suchformular für Standorte.'),
    'anystores_list'    => array('anyStores Liste',   'Suchergebnisliste oder einfache Liste der Standorte.'),
    'anystores_details' => array('anyStores Details', 'Zeigt Details zum Standort an. Das Listenmodul muss auf dieses Modul weiterleiten.'),
    'anystores_map'     => array('anyStores Karte',   'Übersicht der Standorte auf einer Karte.')
));


array_insert($GLOBALS['TL_LANG']['tl_module'], 0, array
(
    'anystores_defaultCountry'       => array('Standardland', 'In welchem Land sollen die Ergebnisse gesucht werden (falls der Benutzer kein anderes ausgewählt hat)?'),
    'anystores_categories'           => array('Kategorie auswählen', 'Aus welcher Kategorie sollen Standorte angezeigt werden?'),
    'anystores_listLimit'            => array('Anzahl der Standorte', 'Wieviele Standorte sollen maximal angezeigt werden?'),
    'anystores_allowEmptySearch'     => array('Leersuche erlauben?', 'Soll der Benutzer eine leere Suchanfrage abschicken können um alle Standorte angezeigt zu bekommen?'),
    'anystores_limitDistance'        => array('Entfernung begrenzen', 'Standorte ab einer maximalen Entfernung nicht anzeigen.'),
    'anystores_maxDistance'          => array('Maximale Entfernung', 'Die maximale Entfernung in km.'),
    'anystores_sortingOrder'         => array('Sortierreihenfolge', 'Legen Sie hier die individuelle Sortierung der Liste fest. Standard: postal'),
    'anystores_detailTpl'            => array('Standort-Template', 'Hier kann das Template für die einzelnen Standorte überschrieben werden. Sie können damit die Einträge des Listen- und Detail-Moduls ihren wünschen anpassen.'),
    'anystores_mapTpl'               => array('Karten-Template', 'Hier kann das Template für die Standortkarte überschrieben werden.')
));
