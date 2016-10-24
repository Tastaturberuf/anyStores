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
    'anystores'           => 'AnyStores',
    'anystores_search'    => array('anyStores Suche',   'Suchformular für Standorte.'),
    'anystores_list'      => array('anyStores Liste',   'Suchergebnisliste oder einfache Liste der Standorte.'),
    'anystores_details'   => array('anyStores Details', 'Zeigt Details zum Standort an. Das Listenmodul muss auf dieses Modul weiterleiten.'),
    'anystores_map'       => array('anyStores Karte',   'Übersicht der Standorte auf einer Karte.'),
    'anystores_searchmap' => array('anyStores Suchergebnis-Karte',   'Zeigt die Suchergebnisse auf der Karte an.')
));


array_insert($GLOBALS['TL_LANG']['tl_module'], 0, array
(
    'map_legend'     => 'Karteneinstellungen',
    'map_api_legend' => 'API-Einstellungen',

    'anystores_defaultCountry'   => array('Standardland', 'In welchem Land sollen die Ergebnisse gesucht werden (falls der Benutzer kein anderes ausgewählt hat)?'),
    'anystores_categories'       => array('Kategorie auswählen', 'Aus welcher Kategorie sollen Standorte angezeigt werden?'),
    'anystores_listLimit'        => array('Anzahl der Standorte', 'Wieviele Standorte sollen maximal angezeigt werden?'),
    'anystores_allowEmptySearch' => array('Leersuche erlauben?', 'Soll der Benutzer eine leere Suchanfrage abschicken können um alle Standorte angezeigt zu bekommen?'),
    'anystores_limitDistance'    => array('Entfernung begrenzen', 'Standorte ab einer maximalen Entfernung nicht anzeigen.'),
    'anystores_maxDistance'      => array('Maximale Entfernung', 'Die maximale Entfernung in km.'),
    'anystores_sortingOrder'     => array('Sortierreihenfolge', 'Legen Sie hier die individuelle Sortierung der Liste fest. Standard: postal'),
    'anystores_detailTpl'        => array('Standort-Template', 'Hier kann das Template für die einzelnen Standorte überschrieben werden. Sie können damit die Einträge des Listen- und Detail-Moduls ihren wünschen anpassen.'),
    'anystores_mapTpl'           => array('Karten-Template', 'Hier kann das Template für die Standortkarte überschrieben werden.'),
    'anystores_latitude'         => array('Breitengrad', 'Breitengrad für die Ausgangsansicht.'),
    'anystores_longitude'        => array('Längengrad', 'Längengrad für die Ausgangsansicht.'),
    'anystores_zoom'             => array('Zoom-Level', 'Zoom-Level für die Ausgangsansicht.'),
    'anystores_maptype'          => array('Kartentyp', 'Standard-Kartentyp.'),
    'anystores_streetview'       => array('Streetview aktivieren', 'Streetview an/abschalten.'),
    'anystores_mapheight'        => array('Kartenhöhe', 'Angabe in Pixel. Fügt dem Template das Style-Attribut hinzu.'),
    'anystores_defaultMarker'    => array('Standard-Marker für dieses Modul', 'Kann in der Kategorie oder im Standort überschrieben werden. Überschreibt den globalen Marker aus den Einstellungen.'),
    'anystores_signedIn'         => array('Login möglich', 'Man kann sich in die Google-Karte einloggen um sie zu personalisieren.'),
    'anystores_mapsApi'          => array('Karten API wählen', '')
));
