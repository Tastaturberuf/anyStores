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


$GLOBALS['TL_LANG']['tl_anystores'] = array
(
    // Fields
    'pid'             => array('Kategorie', 'Kategorie des Standorts.'),
    'name'            => array('Name', 'Name des Standorts.'),
    'alias'           => array('Alias', 'Der Alias ist eine eindeutige Referenz, die anstelle der numerischen Artikel-ID aufgerufen werden kann.'),
    'email'           => array('E-Mail', 'E-Mail-Adresse des Standorts.'),
    'url'             => array('Webseite', 'Webseite des Standorts.'),
    'phone'           => array('Telefon', 'Telefonnummer des Standorts.'),
    'fax'             => array('Fax', 'Faxnummer des Standorts.'),
    'street'          => array('Straße', 'Straße und Hausnummer des Standorts.'),
    'street2'         => array('Straße Zusatz', 'Zusatzinformation der Straße.'),
    'postal'          => array('Postleitzahl', 'Postleitzahl des Standorts.'),
    'city'            => array('Ort', 'Ort des Standorts.'),
    'country'         => array('Land', 'Land des Standorts.'),
    'logo'            => array('Standort-Logo', 'Wählen Sie ein Logo aus.'),
    'opening_times'   => array('Öffnungszeiten', ''),
    'times_weekday'   => array('Wochentag', ''),
    'times_from'      => array('von', ''),
    'times_to'        => array('bis', ''),
    'times_isClosed'  => array('geschlossen', 'Markieren wenn an diesem Tag geschlossen ist'),
    'longitude'       => array('Längengrad', 'Wird automatisch ausgefüllt wenn leer.'),
    'latitude'        => array('Breitengrad', 'Wird automatisch ausgefüllt wenn leer.'),
    'map'             => array('Kartenansicht'),
    'geo_explain'     => array('Die geographischen Koordinaten werden benötigt damit der Besucher später nach einem Standort in seiner Nähe suchen kann. Diese beiden Felder werden automatisch beim Speichern ausgefüllt, können aber bei Bedarf manuell korrigiert werden.'),
    'description'     => array('Beschreibung', 'Beschreibung des Standorts.'),
    'published'       => array('Standort veröffentlichen.', 'Den Standort veröffentlichen damit dieser dem Besucher angezeigt wird.'),
    'start'           => array('Anzeigen ab', 'Ein Datum ab dem der Standort angezeigt wird.'),
    'stop'            => array('Anzeigen bis', 'Ein Datum bis wann der Standort angezeigt.'),
    'metatitle'       => array('Meta-Titel', htmlentities('Geben Sie den Inhalt für das <title>-Tag ein.')),
    'metadescription' => array('Meta-Beschreibung', htmlentities('Geben Sie den Inhalt für <meta content"description"> ein.')),
    'marker'          => array('Marker', 'Setzt den Marker für diesen Standort. Überschreibt alle anderen Marker.'),
    'freeField1'      => array('Freifeld 1', 'Kann im Template mit <code style="font-size: 10px"> $this->freeField1</code> ausgegeben werden.'),
    'freeField2'      => array('Freifeld 2', 'Kann im Template mit <code style="font-size: 10px">$this->freeField2</code> ausgegeben werden.'),
    'freeField3'      => array('Freifeld 3', 'Kann im Template mit <code style="font-size: 10px">$this->freeField3</code> ausgegeben werden.'),
    'freeField4'      => array('Freifeld 4', 'Kann im Template mit <code style="font-size: 10px">$this->freeField4</code> ausgegeben werden.'),
    'freeField5'      => array('Freifeld 5', 'Kann im Template mit <code style="font-size: 10px">$this->freeField5</code> ausgegeben werden.'),
    'freeField6'      => array('Freifeld 6', 'Kann im Template mit <code style="font-size: 10px">$this->freeField6</code> ausgegeben werden.'),

    // Legends
    'common_legend'      => 'Allgemein',
    'adress_legend'      => 'Adressdaten',
    'geo_legend'         => 'Koordinaten',
    'contact_legend'     => 'Kontaktdaten',
    'description_legend' => 'Beschreibung',
    'seo_legend'         => 'SEO-Einstellungen',
    'times_legend'       => 'Öffnungszeiten',
    'publish_legend'     => 'Veröffentlichen',
    'freeform_legend'    => 'Freitextfelder',

    // Global buttons
    'importStores' => array('CSV-Import', 'Standorte aus CSV-Datei importieren'),
    'new'          => array('Neuer Standort', 'Neuen Standort anlegen'),

    // Buttons
    'edit'    => array('Standort bearbeiten', 'Standort mit der ID %s bearbeiten'),
    'content' => array('Standortbeschreibung bearbeiten', 'Standortbeschreibung von der ID %s bearbeiten'),
    'copy'    => array('Standort kopieren', 'Standort mit der ID %s kopieren'),
    'delete'  => array('Standort löschen', 'Standort mit der ID %s löschen'),
    'coords'  => array('Noch keine Geo-Koordinaten vorhanden!', 'Geo-Koordinaten vorhanden'),
    'show'    => array('Details ansehen', 'Details des Standorts ID %s anzeigen'),
    'toggle'  => array('Standort veröffentlichen', 'Standort ID %s veröffentlichen/unveröffentlichen')
);
