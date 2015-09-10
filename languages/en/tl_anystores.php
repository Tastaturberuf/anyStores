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
    'pid'            => array('Category', 'Choose the locations category.'),
    'name'           => array('Name', ''),
    'alias'          => array('Alias', ''),
    'email'          => array('E-Mail', ''),
    'url'            => array('Website', ''),
    'phone'          => array('Phone', ''),
    'fax'            => array('Fax', ''),
    'street'         => array('Street', ''),
    'postal'         => array('ZIP', ''),
    'city'           => array('City', ''),
    'country'        => array('Country', ''),
    'logo'           => array('Logo', ''),
    'opening_times'  => array('Opening times', ''),
    'times_weekday'  => array('Weekday', ''),
    'times_from'     => array('from', ''),
    'times_to'       => array('to', ''),
    'times_isClosed' => array('closed', 'Mark if location is closed on this day.'),
    'longitude'      => array('Longitude', 'Automaticly filled if empty.'),
    'latitude'       => array('Latitude', 'Automaticly filled if empty.'),
    'map'            => array('Mapview'),
    'geo_explain'    => array('The geographic coordinates are needed for the search to be working correctly. Later on the user will be able to search for stores near his given location. Both of these fields will be filled in automatically but also can be fixed manually.'),
    'description'    => array('Description', ''),
    'published'      => array('Publish location', 'Publish the location for the user.'),
    'start'          => array('Publish from', ''),
    'stop'           => array('Publish to', ''),

    // Legends
    'common_legend'  => 'Common',
    'adress_legend'  => 'Address',
    'geo_legend'     => 'Coordinates',
    'times_legend'   => 'Opening times',
    'publish_legend' => 'Publishing',

    // Global buttons
    'importStores' => array('CSV-Import', ''),
    'new'          => array('New location', ''),

    // Buttons
    'edit'             => array('Edit location', 'Edit location with ID %s'),
    'edit_description' => array('Edit location description', 'Edit location description with ID %s'),
    'copy'             => array('Copy location', 'Copy location with ID %s'),
    'delete'           => array('Delete location', 'Delete location with ID %s'),
    'coords'           => array('No Coordinates available!', 'Coordinates available'),
    'show'             => array('Show details', 'Show details from location with ID %s'),
    'toggle'           => array('Publish location', 'Publish or unpublish location with ID %s')
);
