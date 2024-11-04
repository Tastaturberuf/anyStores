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

declare(strict_types=1);

namespace Tastaturberuf;


use Contao\Config;
use Contao\Controller;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\Session;
use Contao\StringUtil;
use Contao\System;
use Contao\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use function str_replace;

class FrontendAjax
{

    public static function run(int $moduleId, string $token): string
    {
        if (!static::validateRequestToken($moduleId, $token)) {
            static::respond(array('status' => 'error', 'message' => 'Invalid request token'));
        }

        $module = ModuleModel::findByPk($moduleId);

        if (!$module || $module->type !== 'anystores_map') {
            static::respond(array('status' => 'error', 'message' => 'Invalid module'));
        }

        // Hook to manipulate the module
        if (isset($GLOBALS['TL_HOOKS']['anystores_getAjaxModule']) && is_array($GLOBALS['TL_HOOKS']['anystores_getAjaxModule'])) {
            foreach ($GLOBALS['TL_HOOKS']['anystores_getAjaxModule'] as $callback) {
                System::importStatic($callback[0])->{$callback[1]}($module);
            }
        }

        if (Validator::isBinaryUuid($module->anystores_defaultMarker)) {
            $module->anystores_defaultMarker = FilesModel::findByPk($module->anystores_defaultMarker)?->path;
        }

        // Find stores
        $stores = AnyStoresModel::findPublishedByCategory(StringUtil::deserialize($module->anystores_categories));

        if (!$stores) {
            static::respond(array('status'  => 'error', 'message' => 'No stores found'));
        }

        while ($stores->next())
        {
            // generate jump to
            if ($module->jumpTo) {
                /** @var PageModel $objLocation */
                if (($objLocation = PageModel::findByPk($module->jumpTo)) !== null) {
                    //@todo language parameter
                    $strStoreKey   = !$GLOBALS['TL_CONFIG']['useAutoItem'] ? '/store/' : '/';
                    $strStoreValue = $stores->alias;

                    $href = $objLocation->getFrontendUrl($strStoreKey . $strStoreValue);

                    $stores->href = str_replace('ajax.php', '', $href);

                }
            }

            // Encode email
            $stores->email = StringUtil::encodeEmail($stores->email);

            // Encode opening times
            $stores->opening_times = StringUtil::deserialize($stores->opening_times);

            // decode logo
            if (Validator::isBinaryUuid($stores->logo)) {
                $stores->logo = FilesModel::findByPk($stores->logo)?->path;
            }

            // decode marker
            if (Validator::isBinaryUuid($stores->marker)) {
                $stores->marker = FilesModel::findByPk($stores->marker)?->path;
            }

            // add category marker
            $stores->categoryMarker = null;

            if ((($objCategory = AnyStoresCategoryModel::findByPk($stores->pid)) !== null) && Validator::isBinaryUuid($objCategory->defaultMarker)) {
                $objFile = FilesModel::findByPk($objCategory->defaultMarker);

                if ($objFile) {
                    $stores->categoryMarker = $objFile->path;
                }
            }

            // render html
            $strTemplate = $module->anystores_detailTpl ?: 'anystores_details';
            $objTemplate = new FrontendTemplate($strTemplate);
            $objTemplate->setData($stores->current()->row());

            $stores->tiphtml = Controller::replaceInsertTags($objTemplate->parse());
        }

        $arrRespond = [
            'status' => 'success',
            'count' => $stores->count(),
            'module' => [
                'latitude' => (float)$module->anystores_latitude,
                'longitude' => (float)$module->anystores_longitude,
                'zoom' => (int)$module->anystores_zoom,
                'streetview' => (bool)$module->anystores_streetview,
                'maptype' => (string)$module->anystores_maptype,
                'defaultMarker' => (string)$module->anystores_defaultMarker
            ],
            'stores' => $stores->fetchAll()
        ];

        // decode global default marker
        $arrRespond['global']['defaultMarker'] = null;

        if (Validator::isUuid(Config::get('anystores_defaultMarker')) && ($objFile = FilesModel::findByPk(Config::get('anystores_defaultMarker'))) !== null) {
            $arrRespond['global']['defaultMarker'] = $objFile->path;
        }

        static::respond($arrRespond);
    }


    public static function generateRequestToken(int $moduleId): string
    {
        // get session
        $session = Session::getInstance();
        $tokens = $session->get('anystores_token');

        // generate token
        if (empty($tokens[$moduleId])) {
            $tokens[$moduleId] = md5(uniqid((string)mt_rand(), true));

            $session->set('anystores_token', $tokens);
        }

        return $tokens[$moduleId];
    }


    private static function validateRequestToken(int $moduleId, string $token): bool
    {
        $session = Session::getInstance();

        $tokens = $session->get('anystores_token');

        return ($tokens[$moduleId] === $token);
    }


    private static function respond(array $json): never
    {
        header('Content-Type: application/json');
        echo (new JsonResponse($json))->getContent();
        exit();
    }

}
