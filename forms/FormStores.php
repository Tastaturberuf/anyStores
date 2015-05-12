<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */

namespace Tastaturberuf;


class FormStores extends \FormSelectMenu
{

    public function __construct($arrAttributes = null)
    {
        parent::__construct($arrAttributes);
        
        $arrCategories = deserialize($this->anystores_categories);
        $arrOptions    = array('order'=>'postal');

        $objLocations = AnyStoresModel::findPublishedByCategory($arrCategories, $arrOptions);

        if ( $objLocations )
        {
            while ($objLocations->next())
            {
                $arrLocations[] = array
                (
                    'type'  => 'option',
                    'value' => $objLocations->id,
                    'label' => $objLocations->postal.' '.$objLocations->name
                );
            }

            $this->arrOptions = $arrLocations;
        }

    }

}
