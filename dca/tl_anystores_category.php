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
* Table tl_anystores_category
*/
$GLOBALS['TL_DCA']['tl_anystores_category'] = array
(
    'config' => array
    (
        'dataContainer'    => 'Table',
        'ctable'           => array('tl_anystores'),
        'switchToEdit'     => true,
        'enableVersioning' => true,
        'onload_callback'  => array
        (
            array('tl_anystores_category', 'checkPermisson')
        ),
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary'
            )
        )
    ),

    'list' => array
    (
        'sorting' => array
        (
            'mode'        => 1,
            'fields'      => array('title'),
            'flag'        => 1,
            'panelLayout' => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields' => array('title'),
            'format' => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores_category']['editchild'],
                'href'            => 'table=tl_anystores',
                'icon'            => 'edit.gif',
                'button_callback' => array('tl_anystores_category', 'generateEditButton')
            ),
            'editheader' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores_category']['edit'],
                'href'            => 'act=edit',
                'icon'            => 'header.gif',
                'button_callback' => array('tl_anystores_category', 'generateHeaderButton')
            ),
            'copy' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores_category']['copy'],
                'href'            => 'act=copy',
                'icon'            => 'copy.gif',
                'button_callback' => array('tl_anystores_category', 'generateCopyButton')
            ),
            'delete' => array
            (
                'label'           => &$GLOBALS['TL_LANG']['tl_anystores_category']['delete'],
                'href'            => 'act=delete',
                'icon'            => 'delete.gif',
                'attributes'      => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
                'button_callback' => array('tl_anystores_category', 'generateDeleteButton')
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_anystores_category']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            )
        )
    ),

    'palettes' => array
    (
        'default' => '{title_legend},title,defaultMarker'
    ),

    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title'  => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores_category']['title'],
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => array
            (
                'mandatory' => true,
                'maxlength' => 64
            ),
            'sql' => "varchar(64) NOT NULL default ''"
        ),
        'defaultMarker' => array
        (
            'label'     => &$GLOBALS['TL_LANG']['tl_anystores_category']['defaultMarker'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array
            (
                'files'      => true,
                'fieldType'  => 'radio',
                'extensions' => Config::get('validImageTypes'),
            ),
            'sql' => "binary(16) NULL"
        )
    )
);


/**
 * Class tl_anystores_category
 */
class tl_anystores_category extends Backend
{

    /**
     * tl_anystores_category constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    public function checkPermisson()
    {
        if ($this->User->isAdmin)
        {
            return;
        }

        // Set root IDs
        if (!is_array($this->User->anystores_categories) || empty($this->User->anystores_categories))
        {
            $root = array(0);
        }
        else
        {
            $root = $this->User->anystores_categories;
        }

        $GLOBALS['TL_DCA']['tl_anystores_category']['list']['sorting']['root'] = $root;

        // Check permissions to add archives
        if (!$this->User->hasAccess('create', 'anystores_permissions'))
        {
            $GLOBALS['TL_DCA']['tl_anystores_category']['config']['closed'] = true;
        }

        // Check current action
        switch (Input::get('act'))
        {
            case 'create':
            case 'select':
                // Allow
                break;

            case 'edit':
                // Dynamically add the record to the user profile
                if ( !in_array(Input::get('id'), $root) )
                {
                    $arrNew = $this->Session->get('new_records');

                    if ( is_array($arrNew['tl_anystores_category']) && in_array(Input::get('id'), $arrNew['tl_anystores_category']) )
                    {
                        // Add permissions on user level
                        if ( $this->User->inherit == 'custom' || !$this->User->groups[0] )
                        {
                            //@todo find only groups with create permissons
                            $objUser = UserModel::findByPk($this->User->id);

                            $arrAnystoresPermissions = deserialize($objUser->anystores_permissions);

                            if ( is_array($arrAnystoresPermissions) && in_array('create', $arrAnystoresPermissions) )
                            {
                                $arrAnystoresCategories = deserialize($objUser->anystores_categories);
                                $arrAnystoresCategories[] = Input::get('id');

                                $objUser->anystores_categories = serialize($arrAnystoresCategories);
                                $objUser->save();
                            }
                        }

                        // Add permissions on group level
                        elseif ( $this->User->groups[0] > 0 )
                        {
                            $objGroup = UserGroupModel::findByPk($this->User->groups[0]);

                            $arrAnystoresPermissions = deserialize($objGroup->anystores_permissions);

                            if ( is_array($arrAnystoresPermissions) && in_array('create', $arrAnystoresPermissions) )
                            {
                                $arrAnystoresCategories = deserialize($objGroup->anystores_categories);
                                $arrAnystoresCategories[] = Input::get('id');

                                $objGroup->anystores_categories = serialize($arrAnystoresCategories);
                                $objGroup->save();
                            }
                        }

                        // Add new element to the user object
                        $root[] = Input::get('id');
                        $this->User->anystores_categories = $root;
                    }
                }
                // No break;

            case 'copy':
            case 'delete':
            case 'show':
                if (!in_array(Input::get('id'), $root) || (Input::get('act') == 'delete' && !$this->User->hasAccess('delete', 'anystores_permissons')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' location category ID "'.Input::get('id').'"', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;

            case 'editAll':
            case 'deleteAll':
            case 'overrideAll':
                $session = $this->Session->getData();
                if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'anystores_permissons'))
                {
                    $session['CURRENT']['IDS'] = array();
                }
                else
                {
                    $session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
                }
                $this->Session->setData($session);
                break;

            default:
                if (strlen(Input::get('act')))
                {
                    $this->log('Not enough permissions to '.Input::get('act').' location category', __METHOD__, TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
                }
                break;
        }
    }


    /**
     * Generate the edit button
     *
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     *
     * @return string
     */
    public function generateEditButton($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_anystores') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }


    /**
     * Generate the header button
     *
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     *
     * @return string
     */
    public function generateHeaderButton($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_anystores_category') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }


    /**
     * Generate the copy button
     *
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     *
     * @return string
     */
    public function generateCopyButton($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->canEditFieldsOf('tl_anystores_category') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }


    /**
     * Generate the delete button
     *
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     *
     * @return string
     */
    public function generateDeleteButton($row, $href, $label, $title, $icon, $attributes)
    {
        return $this->User->hasAccess('delete', 'anystores_permissons') ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
    }

}
