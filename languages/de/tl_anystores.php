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


$GLOBALS['TL_LANG']['tl_anystores'] = array
(
    // Fields
    'name'           => array('Name', 'Name des Händlers'),
    'email'          => array('E-Mail', 'E-Mail-Adresse zur Kontaktaufnahme'),
    'url'            => array('Webseite', 'Geben Sie die URL zur Webseite des Händlers an'),
    'phone'          => array('Telefon', 'Telefonnummer'),
    'fax'            => array('Fax', 'Faxnummer'),
    'street'         => array('Strasse', 'Name der Strasse und Hausnummer'),
    'postal'         => array('Postleitzahl', 'Postleitzahl'),
    'city'           => array('Stadt', 'Name der Stadt'),
    'country'        => array('Land', 'Bitte wähle ein Land aus.'),
    'logo'           => array('Händlerlogo', 'Wählen Sie ein Händlerlogo aus.'),
    'opening_times'  => array('Öffnungszeiten', ''),
    'times_weekday'  => array('Wochentag', ''),
    'times_from'     => array('von', ''),
    'times_to'       => array('bis', ''),
    'times_isClosed' => array('geschlossen', 'Markieren wenn an diesem Tag geschlossen ist'),
    'longitude'      => array('Längengrad', 'Wird automatisch ausgefüllt...'),
    'latitude'       => array('Breitengrad', 'Wird automatisch ausgefüllt...'),
    'map'            => array('Kartenansicht'),
    'geo_explain'    => array('Die geographischen Koordinaten werden benötigt damit der Besucher später nach einem Händler in seiner Nähe suchen kann. Diese beiden Felder werden automatisch beim Speichern ausgefüllt, können aber bei Bedarf manuell korrigiert werden.'),
    'description'    => array('Beschreibung', 'Beschreibung des Händlers'),

    // Legends
    'common_legend'  => 'Allgemein',
    'adress_legend'  => 'Adressdaten',
    'geo_legend' 	 => 'Koordinaten',
    'times_legend' 	 => 'Öffnungszeiten',

    // Buttons
    'new'            => array('Neuer Händler', 'Neuen Händler anlegen'),
    'coords'   		 => array('Noch keine Geo-Koordinaten vorhanden!', 'Geo-Koordinaten vorhanden'),
    'edit'   		 => array('Händler bearbeiten', 'Händler mit der ID %s bearbeiten'),
    'copy'   		 => array('Händler kopieren', 'Händler mit der ID %s kopieren'),
    'delete' 		 => array('Händler löschen', 'Händler mit der ID %s löschen'),
    'importStores' 	 => array('CSV-Import', 'Händler aus CSV-Datei importieren')
);
