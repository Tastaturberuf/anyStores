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
            'fields'      => array('name', 'street', 'postal', 'city', 'country'),
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
                'label' => &$GLOBALS['TL_LANG']['tl_anystores']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ),
            'edit_description' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_anystores']['edit_description'],
                'href'  => 'table=tl_content',
                'icon'  => 'system/modules/anyStores/assets/images/description.png'
            ),
            'copy' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_anystores']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif'
            ),
            'delete' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['tl_anystores']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\''.$GLOBALS['TL_LANG']['MSC']['deleteConfirm'].'\')) return false; Backend.getScrollOffset();"'
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
                'button_callback' => array('tl_anystores', 'coordsButton')
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
                'button_callback' => array('tl_anystores', 'toggleIcon')
            ),
        )
    ),
    'palettes' => array
    (
        '__selector__' => array('published'),
        'default' =>
        '
            {common_legend},pid,name,alias,phone,fax,url,target,email,logo,description;
            {adress_legend},street,postal,city,country;
            {times_legend},opening_times;
            {geo_legend},geo_explain,longitude,map,latitude;
            {seo_legend},metatitle,metadescription;
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
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes'],
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
            'default'   => 'de',
            'search'    => true,
            'sorting'   => true,
            'filter'    => true,
            'flag'      => 1,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 64,
                'chosen'    => true,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(2) NOT NULL default 'de'"
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
                            'style' => 'width:380px'
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
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => false,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'latitude' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => false,
                'maxlength' => 64,
                'tl_class'  => 'w50'
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'map' => array
        (
            'label'                => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
            'input_field_callback' => array('tl_anystores', 'showMap'),
            'eval' => array
            (
                'doNotShow' => true
            )
        ),
        'geo_explain' => array
        (
            'label'                => &$GLOBALS['TL_LANG']['tl_anystores']['latitude'],
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
        )
    )
);


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
     * Generates button to show if coordinates are available
     * @param array
     * @param srting
     * @param array
     * @param string
     * @param mixed
     * @param array
     * @return string
     */
    public function coordsButton($row = NULL, $href = NULL, $label = NULL, $title = NULL, $icon = NULL, $attributes = NULL)
    {
        $objEntry = NULL;
        $objEntry = $this->Database->prepare("SELECT latitude, longitude FROM tl_anystores WHERE id = ?")
            ->limit(1)
            ->execute($row['id']);

        $icon = ($objEntry->latitude || $objEntry->longitude) ? $icon[1] : $icon[0];
        $label = ($objEntry->latitude || $objEntry->longitude) ? $label[1] : $label[0];

        return '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon,
                        $label).'</a> ';
    }


    /**
     * Fills coordinates if not already set and saving
     * @param DataContainer
     * @return bool
     */
    public function fillCoordinates(DataContainer $dc)
    {
        // Return if both are numeric
        if
        (
            is_numeric($dc->activeRecord->latitude) &&
            is_numeric($dc->activeRecord->longitude)
        )
        {
            return;

        }

        // find coordinates
        $arrCoords = AnyStores::getLonLat(
            $dc->activeRecord->street.' '
            .$dc->activeRecord->postal.' '
            .$dc->activeRecord->city,
            $dc->activeRecord->country
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
     * Returns geographical coordinates
     * @param string
     * @param string
     * @param string
     * @param string
     * @return array
     */
    public function getCoordinates($street = NULL, $postal = NULL, $city = NULL, $country = NULL)
    {
        return StoreLocator::getCoordinates($street, $postal, $city, $country);
    }


    /**
     * Displays a little static Google Map with position of the address
     * @param DataContainer
     * @return string
     */
    public function showMap(DataContainer $dc)
    {

        $sCoords = sprintf("%s,%s",
                $dc->activeRecord->latitude,
                $dc->activeRecord->longitude
        );

        return '<div style="float: right; height: 139px; margin-right: 23px; overflow: hidden; width: 320px;">'
                .'<h3><label>'.$GLOBALS['TL_LANG']['tl_anystores']['map'][0].'</label></h3> '
                .'<img style="margin-top: 1px;" src="http://maps.google.com/maps/api/staticmap?center='.$sCoords.'&zoom=16&size=320x139&maptype=roadmap&markers=color:red|label:|'.$sCoords.'" />'
                .'</div>';
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
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_anystores::published', 'alexf'))
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
