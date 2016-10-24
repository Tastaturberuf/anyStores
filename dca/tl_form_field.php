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
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['stores'] =
'
    {type_legend},type,name,label;
    {fconfig_legend},mandatory,multiple;
    {options_legend},anystores_idField,anystores_categories;
    {expert_legend:hide},class,accesskey,tabindex;
    {template_legend:hide},customTpl;
    {submit_legend},addSubmit
';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['anystores_categories'] = array
(
    'label'      => &$GLOBALS['TL_LANG']['tl_form_field']['anystores_categories'],
    'exclude'    => true,
    'inputType'  => 'checkbox',
    'foreignKey' => 'tl_anystores_category.title',
    'eval'       => array
    (
        'mandatory' => true,
        'multiple'  => true
    ),
    'sql' => "text NULL"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['anystores_idField'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['anystores_idField'],
    'exclude'          => true,
    'default'          => 'id',
    'inputType'        => 'select',
    'options_callback' => function(\DataContainer $dc)
    {
        $arrFields = [];

        System::loadLanguageFile('tl_anystores');

        foreach ( $dc->Database->listFields('tl_anystores') as $arrField )
        {
            if ( $arrField['type'] !== 'index' )
            {
                $arrFields[$arrField['name']] = $GLOBALS['TL_LANG']['tl_anystores'][$arrField['name']][0] ?: $arrField['name'];
            }
        }

        return $arrFields;
    },
    'eval' => array
    (
        'mandatory' => true
    ),
    'sql' => "varchar(255) NOT NULL default 'id'"
);