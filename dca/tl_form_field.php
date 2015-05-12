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
    {options_legend},anystores_categories;
    {expert_legend:hide},class,accesskey,tabindex;
    {template_legend:hide},customTpl;
    {submit_legend},addSubmit
';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['anystores_categories'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['anystores_categories'],
    'exclude'          => true,
    'inputType'        => 'checkbox',
    'options_callback' => function()
    {
        $objCategories = AnyStoresCategoryModel::findAll(array('order' => 'title'));

        if ( $objCategories === null )
        {
            return;
        }

        return $objCategories->fetchEach('title');
    },
    'eval' => array
    (
        'mandatory' => true,
        'multiple'  => true
    ),
    'sql' => "text NULL"
);
