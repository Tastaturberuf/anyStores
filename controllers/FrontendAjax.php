<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   (c) 2016 Tastaturberuf <mail@tastaturberuf.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 * @since       1.8.0
 */


namespace Tastaturberuf;


class FrontendAjax extends \Controller
{

    /**
     * FrontendAjax constructor.
     *
     * @param int $intModuleId
     */
    public static function run($intModuleId, $strToken)
    {
        if ( !static::validateRequestToken($intModuleId, $strToken) )
        {
            static::respond(array('status' => 'error', 'message' => 'Invalid request token'));
        }

        $objModule = \ModuleModel::findByPk($intModuleId);

        if (!$objModule || $objModule->type !== 'anystores_map')
        {
            static::respond(array('status' => 'error', 'message' => 'Invalid module'));
        }

        // Hook to manipulate the module
        if (isset($GLOBALS['TL_HOOKS']['anystores_getAjaxModule']) && is_array($GLOBALS['TL_HOOKS']['anystores_getAjaxModule']))
        {
            foreach ($GLOBALS['TL_HOOKS']['anystores_getAjaxModule'] as $callback)
            {
                \System::importStatic($callback[0])->{$callback[1]}($objModule);
            }
        }

        if (\Validator::isBinaryUuid($objModule->anystores_defaultMarker))
        {
            $objFile = \FilesModel::findByPk($objModule->anystores_defaultMarker);
            
            $objModule->anystores_defaultMarker = ($objFile) ? $objFile->path : null;
        }

        // Find stores
        $objStores = AnyStoresModel::findPublishedByCategory(deserialize($objModule->anystores_categories));

        if (!$objStores)
        {
            static::respond(array('status'  => 'error', 'message' => 'No stores found'));
        }

        while ($objStores->next())
        {
            // generate jump to
            if ($objModule->jumpTo)
            {
                if (($objLocation = \PageModel::findByPk($objModule->jumpTo)) !== null)
                {
                    //@todo language parameter
                    $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                    $strStoreValue = $objStores->alias;

                    $objStores->href = \Controller::generateFrontendUrl($objLocation->row(), $strStoreKey.$strStoreValue);
                }
            }

            // Encode email
            $objStores->email = \String::encodeEmail($objStores->email);

            // Encode opening times
            $objStores->opening_times = deserialize($objStores->opening_times);

            // decode logo
            if (\Validator::isBinaryUuid($objStores->logo))
            {
                $objFile = \FilesModel::findByPk($objStores->logo);
                
                $objStores->logo = ($objFile) ? $objFile->path : null;
            }

            // decode marker
            if (\Validator::isBinaryUuid($objStores->marker))
            {
                $objFile = \FilesModel::findByPk($objStores->marker);
                
                $objStores->marker = ($objFile) ? $objFile->path : null;
            }

            // add category marker
            $objStores->categoryMarker = null;

            if (($objCategory = AnyStoresCategoryModel::findByPk($objStores->pid)) !== null)
            {
                if (\Validator::isBinaryUuid($objCategory->defaultMarker))
                {
                    $objFile = \FilesModel::findByPk($objCategory->defaultMarker);
                    
                    if ($objFile)
                    {
                        $objStores->categoryMarker = $objFile->path;
                    }
                }
            }

            // render html
            $strTemplate = $objModule->anystores_detailTpl ?: 'anystores_details';
            $objTemplate = new \FrontendTemplate($strTemplate);
            $objTemplate->setData($objStores->current()->row());

            $objStores->tiphtml = static::replaceInsertTags($objTemplate->parse());
        }

        $arrRespond = array
        (
            'status' => 'success',
            'count'  => (int) $objStores->count(),
            'module' => array
            (
                'latitude'      => (float) $objModule->anystores_latitude,
                'longitude'     => (float) $objModule->anystores_longitude,
                'zoom'          => (int) $objModule->anystores_zoom,
                'streetview'    => (bool) $objModule->anystores_streetview,
                'maptype'       => (string) $objModule->anystores_maptype,
                'defaultMarker' => (string) $objModule->anystores_defaultMarker
            ),
            'stores' => $objStores->fetchAll()
        );

        // decode global default marker
        $arrRespond['global']['defaultMarker'] = null;

        if (\Validator::isUuid(\Config::get('anystores_defaultMarker')))
        {
            if (($objFile = \FilesModel::findByPk(\Config::get('anystores_defaultMarker'))) !== null)
            {
                $arrRespond['global']['defaultMarker'] = $objFile->path;
            }
        }

        static::respond($arrRespond);
    }


    public static function generateRequestToken($intModuleId)
    {
        // get session
        $objSession = \Session::getInstance();

        // generate token
        $arrTokens            = $objSession->get('anystores_token');

        if ( empty($arrTokens[$intModuleId]) )
        {
            $arrTokens[$intModuleId] = md5(uniqid(mt_rand(), true));

            $objSession->set('anystores_token', $arrTokens);
        }

        return $arrTokens[$intModuleId];
    }


    protected static function validateRequestToken($intModuleId, $strToken)
    {
        $objSession = \Session::getInstance();

        $arrTokens = $objSession->get('anystores_token');

        return ($arrTokens[$intModuleId] === $strToken);
    }


    protected static function respond($arrRespond)
    {
        $strRespose = json_encode($arrRespond);

        header('Content-Type: application/json');

        if ( $strRespose )
        {
            echo $strRespose;
        }
        else
        {
            echo json_encode(array('status' => 'error', 'message' => json_last_error_msg()));
        }

        exit;
    }

}
