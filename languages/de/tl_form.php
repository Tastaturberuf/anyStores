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
    'anystores_legend'    => 'AnyStores-Einstellungen',
    'anystores_sendEmail' => array
    (
        'anyStores: E-Mail an Auswahl von folgendem Feld senden',
        'Sendet eine Kopie an an die Auswahl des Benutzers von diesem Feld.'
    ),
    'anystores_emailNearestStore' => array
    (
        'E-Mail an nächsten Standort senden.',
        'Ermittelt anhand der Felder street, postal, city und country den nächsten Standort und schickt eine Kopie der Nachricht. Kompatibel mit EFG.'
    ),
    'anystores_categories' => array('Kategorien für die E-Mail wählen.', '')
));
