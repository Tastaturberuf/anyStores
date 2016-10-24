<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014 - 2016 Tastaturberuf <mail@tastaturberuf.de>
 *              (c) 2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


/**
 * Table tl_anystores
 */
$GLOBALS['TL_DCA']['tl_anystores'] = array
(
    'config' => array
    (
        'dataContainer'     => 'Table',
        'ptable'            => 'tl_anystores_category',
        'ctable'            => array('tl_content'),
        'enableVersioning'  => true,
        'onload_callback'   => array
        (
            array('tl_anystores', 'checkPermission')
        ),
        'onsubmit_callback' => array
        (
            array('tl_anystores', 'fillCoordinates'),
            array('tl_anystores', 'clearOpeningTimes')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' => 'index',
                'pid,name,street,postal,city,country' => 'unique'
            )
        )
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'        => 2,
            'fields'      => array('name'),
            'flag'        => 1,
            'panelLayout' => 'filter;sort,search,limit'
        ),
        'label' => array
        (
            'fields'      => deserialize(\Config::get('anystores_tableHeaders'), true),
            'showColumns' => true
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            ),
            /* @todo rewrite
            'importStores' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_anystores']['importStores'],
                'href'       => 'key=importStores',
                'class'      => 'header_anystores_import',
                'attributes' => 'onclick="Backend.getScrollOffset()"'
            )
            */
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores']['edit'],
                'href'            => 'act=edit',
                'icon'            => 'edit.gif',
                'button_callback' => array('tl_anystores', 'generateEditButton')
            ),
            'content' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores']['content'],
                'href'            => 'table=tl_content',
                'icon'            => 'system/modules/anyStores/assets/images/description.png',
                'button_callback' => array('tl_anystores', 'generateContentButton')
            ),
            'copy' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores']['copy'],
                'href'            => 'act=copy',
                'icon'            => 'copy.gif',
                'button_callback' => array('tl_anystores', 'generateCopyButton')
            ),
            'delete' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores']['delete'],
                'href'            => 'act=delete',
                'icon'            => 'delete.gif',
                'attributes'      => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"',
                'button_callback' => array('tl_anystores', 'generateDeleteButton')
            ),
            'coords' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_anystores']['coords'],
                'href'  => 'act=show',
                'icon'  => array
                (
                    'system/modules/anyStores/assets/images/coords0.png',
                    'system/modules/anyStores/assets/images/coords1.png'
                ),
                'button_callback' => array('tl_anystores', 'generateCoordsButton')
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_anystores']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ),
            'toggle' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('tl_anystores', 'generatePublishButton')
            ),
        )
    ),
    'palettes' => array
    (
        '__selector__' => array('published'),
        'default' =>
        '
            {common_legend},pid;
            {adress_legend},name,alias,street,street2,postal,city,country;
            {geo_legend},geo_explain,longitude,map,latitude,marker;
            {contact_legend},phone,fax,url,target,email;
            {description_legend:hide},logo,description;
            {times_legend:hide},opening_times;
            {freeform_legend:hide},freeField1,freeField2,freeField3,freeField4,freeField5,freeField6;
            {seo_legend:hide},metatitle,metadescription;
            {publish_legend},published
        '
    ),
    'subpalettes' => array
    (
        'published' => 'start,stop'
    ),
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'label'      => &$GLOBALS['TL_LANG']['tl_anystores']['pid'],
            'exclude'    => true,
            'inputType'  => 'select',
            'foreignKey' => 'tl_anystores_category.title',
            'eval'       => array
            (
                'mandatory' => true,
                'chosen'    => true,
                'tl_class'  => 'clr'
            ),
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'name' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['name'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'alias' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['alias'],
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'rgxp'      => 'alias',
                'doNotCopy' => true,
                'maxlength' => 128,
                'tl_class'  => 'w50'
            ),
            'save_callback' => array
            (
                array('tl_anystores', 'generateAlias')
            ),
            'sql' => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
        ),
        'email' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['email'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'rgxp'      => 'email',
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'url' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['url'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'rgxp'           => 'url',
                'decodeEntities' => true,
                'maxlength'      => 255,
                'tl_class'       => 'w50 wizard'
            ),
            'wizard' => array
            (
                array('tl_anystores', 'pagePicker')
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'target' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['MSC']['target'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => array
            (
                'tl_class' => 'w50 m12'
            ),
            'sql'       => "char(1) NOT NULL default ''"
        ),
        'phone' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['phone'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'rgxp'      => 'phone',
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'fax' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['fax'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'rgxp'      => 'phone',
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'logo' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['logo'],
            'inputType' => 'fileTree',
            'exclude'   => true,
            'eval'      => array
            (
                'filesOnly'  => true,
                'extensions' => Config::get('validImageTypes'),
                'fieldType'  => 'radio',
                'tl_class'   => 'clr'
            ),
            'sql' => "binary(16) NULL"
        ),
        'street' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['street'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'street2' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['street2'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'eval'      => array
            (
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'postal' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['postal'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 10,
                'rgxp'      => 'alphanum',
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(10) NOT NULL default ''"
        ),
        'city' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['city'],
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'country' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['country'],
            'inputType' => 'select',
            'exclude'   => true,
            'options'   => System::getCountries(),
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'eval'      => array
            (
                'mandatory'          => true,
                'includeBlankOption' => true,
                'chosen'             => true
            ),
            'sql' => "varchar(2) NOT NULL default ''"
        ),
        'description' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['description'],
            'inputType' => 'textarea',
            'exclude'   => true,
            'eval'      => array
            (
                'rte'      => 'tinyMCE',
                'tl_class' => 'long'
            ),
            'sql' => "text NULL"
        ),
        'opening_times' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['opening_times'],
            'inputType' => 'multiColumnWizard',
            'exclude'   => true,
            'eval'      => array
            (
                'doNotShow'    => true,
                'columnFields' => array
                (
                    'weekday' => array
                    (
                        'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['times_weekday'],
                        'inputType' => 'select',
                        'options'   => &$GLOBALS['TL_LANG']['anystores']['days'],
                        'search'    => true,
                        'eval'      => array
                        (
                            'style' => 'width:250px'
                        )
                    ),
                    'from' => array
                    (
                        'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['times_from'],
                        'inputType' => 'text',
                        'eval'      => array
                        (
                            'maxlength' => 8,
                            'style'     => 'width:50px'
                        )
                    ),
                    'to' => array
                    (
                        'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['times_to'],
                        'inputType' => 'text',
                        'eval'      => array
                        (
                            'mandatory' => false,
                            'maxlength' => 8,
                            'style'     => 'width:50px'
                        )
                    ),
                    'isClosed' => array
                    (
                        'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['times_isClosed'],
                        'inputType' => 'checkbox'
                    )
                )
            ),
            'sql' => "text NULL"
        ),
        'longitude' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['longitude'],
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => false,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "float(10,6) NOT NULL"
        ),
        'latitude' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => false,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "float(10,6) NOT NULL"
        ),
        'map' => array
        (
            'label'                => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
            'exclude'              => true,
            'input_field_callback' => array('tl_anystores', 'showMap'),
            'eval'                 => array
            (
                'doNotShow' => true
            )
        ),
        'geo_explain' => array
        (
            'label'                => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
            'exclude'              => true,
            'input_field_callback' => function()
            {
                return '<div class="tl_help">'.$GLOBALS['TL_LANG']['tl_anystores']['geo_explain'][0].'</div>';
            }
        ),
        'file' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_anystores']['import']['file'],
            'eval'  => array
            (
                'fieldType'  => 'radio',
                'files'      => true,
                'filesOnly'  => true,
                'extensions' => 'csv',
                'class'      => 'mandatory'
            )
        ),
        'published' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['published'],
            'exclude'   => true,
            'filter'    => true,
            'flag'      => 2,
            'inputType' => 'checkbox',
            'eval'      => array
            (
                'submitOnChange' => true,
                'doNotCopy'      => true
            ),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'start' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['start'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'rgxp'       => 'datim',
                'datepicker' => true,
                'tl_class'   => 'w50 wizard'
            ),
            'sql' => "varchar(10) NOT NULL default ''"
        ),
        'stop' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['stop'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'rgxp'       => 'datim',
                'datepicker' => true,
                'tl_class'   => 'w50 wizard'
            ),
            'sql' => "varchar(10) NOT NULL default ''"
        ),
        'metatitle' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['metatitle'],
            'exclude'   => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'metadescription' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['metadescription'],
            'exclude'   => true,
            'inputType' => 'textarea',
            'eval'      => array
            (
                'maxlength' => 255
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'marker' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['marker'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array
            (
                'files'      => true,
                'fieldType'  => 'radio',
                'extensions' => Config::get('validImageTypes'),
                'tl_class'   => 'clr'
            ),
            'sql' => "binary(16) NULL"
        ),
        'freeField1' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField1'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'freeField2' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField2'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'freeField3' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField3'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'freeField4' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField4'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'freeField5' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField5'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'freeField6' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['freeField6'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'inputType' => 'text',
            'eval'      => array
            (
                'maxlength' => 255,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        )
    )
);


/**
 * Class tl_anystores
 */
class tl_anystores extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Generates the edit button
     *
     * @param $arrRow
     * @param $strHref
     * @param $strLabel
     * @param $strTitle
     * @param $strIcon
     * @param $strAttributes
     * @param $strTable
     * @param $arrRootsId
     * @param $arrChildrecords
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @param $dc
     *
     * @return string
     */
    public function generateEditButton($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes, $strTable, $arrRootsId, $arrChildrecords, $blnCircularReference, $strPrevious, $strNext, $dc)
    {
        return $this->User->canEditFieldsOf('tl_anystores') ? '<a href="'.$this->addToUrl($strHref.'&amp;id='.$arrRow['id']).'" title="'.specialchars($strTitle).'"'.$strAttributes.'>'.Image::getHtml($strIcon, $strLabel).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $strIcon)).' ';
    }


    /**
     * Generate the content button
     *
     * @param $arrRow
     * @param $strHref
     * @param $strLabel
     * @param $strTitle
     * @param $strIcon
     * @param $strAttributes
     * @param $strTable
     * @param $arrRootsId
     * @param $arrChildrecords
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @param $dc
     *
     * @return string
     */
    public function generateContentButton($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes, $strTable, $arrRootsId, $arrChildrecords, $blnCircularReference, $strPrevious, $strNext, $dc)
    {
        return $this->User->canEditFieldsOf('tl_content') && $this->User->hasAccess('create', 'anystores_permissions') ? '<a href="'.$this->addToUrl($strHref.'&amp;id='.$arrRow['id']).'" title="'.specialchars($strTitle).'"'.$strAttributes.'>'.Image::getHtml($strIcon, $strLabel).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $strIcon)).' ';
    }


    /**
     * Generate the copy button
     *
     * @param $arrRow
     * @param $strHref
     * @param $strLabel
     * @param $strTitle
     * @param $strIcon
     * @param $strAttributes
     * @param $strTable
     * @param $arrRootsId
     * @param $arrChildrecords
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @param $dc
     *
     * @return string
     */
    public function generateCopyButton($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes, $strTable, $arrRootsId, $arrChildrecords, $blnCircularReference, $strPrevious, $strNext, $dc)
    {
        return $this->User->canEditFieldsOf('tl_anystores') ? '<a href="'.$this->addToUrl($strHref.'&amp;id='.$arrRow['id'].'&amp;pid='.$arrRow['pid']).'" title="'.specialchars($strTitle).'"'.$strAttributes.'>'.Image::getHtml($strIcon, $strLabel).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $strIcon)).' ';
    }

    /**
     * Generates the delete button
     *
     * @param $arrRow
     * @param $strHref
     * @param $strLabel
     * @param $strTitle
     * @param $strIcon
     * @param $strAttributes
     * @param $strTable
     * @param $arrRootsId
     * @param $arrChildrecords
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @param $dc
     *
     * @return string
     */
    public function generateDeleteButton($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes, $strTable, $arrRootsId, $arrChildrecords, $blnCircularReference, $strPrevious, $strNext, $dc)
    {
        return $this->User->hasAccess('delete', 'anystores_permissions') ? '<a href="'.$this->addToUrl($strHref.'&amp;id='.$arrRow['id']).'" title="'.specialchars($strTitle).'"'.$strAttributes.'>'.Image::getHtml($strIcon, $strLabel).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $strIcon)).' ';
    }

    /**
     * Generate coordinates button and show if coords available
     *
     * @todo add function to get the coords
     * @param $arrRow
     * @param $strHref
     * @param $strLabel
     * @param $strTitle
     * @param $strIcon
     * @param $strAttributes
     * @param $strTable
     * @param $arrRootsId
     * @param $arrChildrecords
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @param $dc
     *
     * @return string
     */
    public function generateCoordsButton($arrRow, $strHref, $strLabel, $strTitle, $strIcon, $strAttributes, $strTable, $arrRootsId, $arrChildrecords, $blnCircularReference, $strPrevious, $strNext, $dc)
    {
        $icon  = ($arrRow['latitude'] != 0.000000 && $arrRow['longitude'] != 0.000000 ) ? $strIcon[1] : $strIcon[0];
        $label = ($arrRow['latitude'] != 0.000000 && $arrRow['longitude'] != 0.000000 ) ? $GLOBALS['TL_LANG']['tl_anystores']['coords'][1] : $GLOBALS['TL_LANG']['tl_anystores']['coords'][0];

        return Image::getHtml($icon, $label, 'title="'.$label.'"');
    }


    /**
     * Check permissions to edit
     */
    public function checkPermission()
    {
        if ( $this->User->isAdmin )
        {
            return;
        }

        // Set the root IDs
        if ( !is_array($this->User->anystores_categories) || empty($this->User->anystores_categories) )
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->anystores_categories;
        }

        $id = strlen(Input::get('id')) ? Input::get('id') : CURRENT_ID;

        // Check current action
        switch (Input::get('act'))
        {
            case 'paste':
                // Allow
                break;

            case 'create':
                if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
                {
                    $this->log('Not enough permissions to create locations in category ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'cut':
            case 'copy':
                if (!in_array(Input::get('pid'), $root))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' location ID "'.$id.'" to category ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
            // NO BREAK STATEMENT HERE

            case 'edit':
            case 'show':
            case 'delete':
            case 'toggle':
                $objArchive = $this->Database->prepare("SELECT pid FROM tl_anystores WHERE id=?")
                    ->limit(1)
                    ->execute($id);

                if ($objArchive->numRows < 1)
                {
                    $this->log('Invalid location ID "'.$id.'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                if (!in_array($objArchive->pid, $root))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' location ID "'.$id.'" of category ID "'.$objArchive->pid.'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'select':
            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
            case 'cutAll':
            case 'copyAll':
                if (!in_array($id, $root))
                {
                    $this->log('Not enough permissions to access category ID "'.$id.'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                $objArchive = $this->Database->prepare("SELECT id FROM tl_anystores WHERE pid=?")
                    ->execute($id);

                if ($objArchive->numRows < 1)
                {
                    $this->log('Invalid category ID "'.$id.'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }

                $session = $this->Session->getData();
                $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $objArchive->fetchEach('id'));
                $this->Session->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    $this->log('Invalid command "'.Input::get('act').'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                elseif (!in_array($id, $root))
                {
                    $this->log('Not enough permissions to access category ID ' . $id, __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;
        }
    }



    /**
     * Fills coordinates if not already set and saving
     * @param DataContainer
     * @return bool
     */
    public function fillCoordinates(DataContainer $dc)
    {
        // Return if both are set
        if ( $dc->activeRecord->latitude != '0.000000' && $dc->activeRecord->longitude != '0.000000' )
        {
            return;
        }
        
        // Get country name
        $arrCountries = \System::getCountries();

        // find coordinates
        $arrCoords = AnyStores::getLonLat(
            sprintf('%s, %s %s, %s',
                $dc->activeRecord->street,
                $dc->activeRecord->postal,
                $dc->activeRecord->city,
                $arrCountries[$dc->activeRecord->country]
            )
        );

        if ( !empty($arrCoords) )
        {
            $objStore = AnyStoresModel::findByPk($dc->id);
            $objStore->latitude  = $arrCoords['latitude'];
            $objStore->longitude = $arrCoords['longitude'];
            $objStore->save();
        }
    }


    /**
     * Set the opening times to null if nothing was set
     * @param DataContainer $dc
     */
    public function clearOpeningTimes(DataContainer $dc)
    {
        $arrOpeningTimes = deserialize($dc->activeRecord->opening_times);

        if ( empty($arrOpeningTimes[0]['from']) && empty($arrOpeningTimes[0]['isClosed']) )
        {
            $objStore = AnyStoresModel::findByPk($dc->id);
            $objStore->opening_times = null;
            $objStore->save();
        }
    }


    /**
     * Displays a little static Google Map with position of the address
     * @todo Make dynamic and change coordinates on click
     *
     * @param DataContainer
     * @return string
     */
    public function showMap(DataContainer $dc)
    {
        $strCoords = sprintf("%f,%f",
            $dc->activeRecord->latitude,
            $dc->activeRecord->longitude
        );

        $arrParams =
        [
            'size'     => '404x202',
            'maptype'  => 'roadmap',
            'markers'  => 'color:red|'.$strCoords,
            'language' => $GLOBALS['TL_LANGUAGE'],
            'key'      => \Config::get('anystores_apiBrowserKey')
        ];

        return sprintf(
            '<div class="w50">
                <h3><label>%s</label></h3>
                <img src="https://maps.google.com/maps/api/staticmap?%s">
            </div>',
            $GLOBALS['TL_LANG']['tl_anystores']['map'][0],
            http_build_query($arrParams)
        );
    }


    /**
     * Return the link picker wizard
     * @param \DataContainer
     * @return string
     */
    public function pagePicker(DataContainer $dc)
    {
        return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }


    /**
     * Auto-generate an article alias if it has not been set yet
     * @param mixed
     * @param \DataContainer
     * @return string
     * @throws \Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate an alias if there is none
        if ($varValue == '')
        {
            $autoAlias = true;
            //@todo make configureable for each category in dca category
            $varValue = $dc->activeRecord->name.'-'.$dc->activeRecord->postal.'-'.$dc->activeRecord->city;
            $varValue = standardize(String::restoreBasicEntities($varValue));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_anystores WHERE id=? OR alias=?")
                                   ->execute($dc->id, $varValue);

        // Check whether the page alias exists
        if ($objAlias->numRows > 1)
        {
            if (!$autoAlias)
            {
                throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
            }

            $varValue = $dc->id.'-'.$varValue;
        }

        return $varValue;
    }


    /**
     * Return the "toggle visibility" button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function generatePublishButton($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if ( !$this->User->hasAccess('tl_anystores::published', 'alexf') || !$this->User->hasAccess($row['pid'], 'anystores_categories') )
        {
            return '';
        }

        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }


    /**
     * Disable/enable a store
     * @param integer
     * @param boolean
     * @param \DataContainer
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
    {
        // Check permissions to publish
        if (!$this->User->hasAccess('tl_anystores::published', 'alexf'))
        {
            $this->log('Not enough permissions to publish/unpublish Store ID "'.$intId.'"', __METHOD__, TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $objVersions = new Versions('tl_anystores', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_anystores']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_anystores']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, ($dc ?: $this));
                }
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_anystores SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                       ->execute($intId);

        $objVersions->create();
        $this->log('A new version of record "tl_anystores.id='.$intId.'" has been created'.$this->getParentEntries('tl_anystores', $intId), __METHOD__, TL_GENERAL);
    }

}
