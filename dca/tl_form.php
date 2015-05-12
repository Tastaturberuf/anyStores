<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['sendViaEmail'] .= ',anystores_sendEmail';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form']['fields']['anystores_sendEmail'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_form']['anystores_sendEmail'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_form_anystores', 'getFormFields'),
    'eval'             => array
    (
        'includeBlankOption' => true,
        'tl_class'           => 'w50'
    ),
    'sql' => "varchar(64) NOT NULL default ''"
);


class tl_form_anystores
{

    public function getFormFields(DataContainer $dc)
    {
        $arrOptions = array
        (
            'column' => array("type='stores'")
        );

        $objFields = FormFieldModel::findPublishedByPid($dc->id, $arrOptions);

        if ( $objFields )
        {
            while($objFields->next())
            {
                $arrFields[$objFields->name] = $objFields->label;
            }

            return $arrFields;
        }
    }

}