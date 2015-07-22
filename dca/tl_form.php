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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'anystores_emailNearestStore';

$GLOBALS['TL_DCA']['tl_form']['palettes']['default'] .= ';{anystores_legend},anystores_emailNearestStore';


/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['anystores_emailNearestStore'] = 'anystores_categories';

$GLOBALS['TL_DCA']['tl_form']['subpalettes']['sendViaEmail'] .= ',anystores_sendEmail';


/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_form']['fields'], 0, array
(
    'anystores_sendEmail' => array
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
    ),
    'anystores_emailNearestStore' => array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_form']['anystores_emailNearestStore'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => array
        (
            'submitOnChange' => true
        ),
        'sql' => "char(1) NOT NULL default ''"
    ),
    'anystores_categories' => array
    (
        'label'            => &$GLOBALS['TL_LANG']['tl_form']['anystores_categories'],
        'exclude'          => true,
        'inputType'        => 'checkbox',
        'options_callback' => function()
        {
            if ( ($objCategories = AnyStoresCategoryModel::findAll(array('order'=>'title'))) !== null )
            {
                return $objCategories->fetchEach('title');
            }
        },
        'eval' => array
        (
            'mandatory' => true,
            'multiple'  => true
        ),
        'sql' => "text NULL"
    )
));


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