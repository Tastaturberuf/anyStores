<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Tastaturberuf',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Tastaturberuf\AnyStores'               => 'system/modules/anyStores/classes/AnyStores.php',
	'Tastaturberuf\AnyStoresHooks'          => 'system/modules/anyStores/classes/AnyStoresHooks.php',
	'Tastaturberuf\GoogleMaps'              => 'system/modules/anyStores/classes/API/GoogleMaps.php',
	'Tastaturberuf\OpenStreetMap'           => 'system/modules/anyStores/classes/API/OpenStreetMap.php',

	// Controllers
	'Tastaturberuf\FrontendAjax'            => 'system/modules/anyStores/controllers/FrontendAjax.php',

	// Forms
	'Tastaturberuf\FormStores'              => 'system/modules/anyStores/forms/FormStores.php',

	// Models
	'Tastaturberuf\AnyStoresCategoryModel'  => 'system/modules/anyStores/models/AnyStoresCategoryModel.php',
	'Tastaturberuf\AnyStoresModel'          => 'system/modules/anyStores/models/AnyStoresModel.php',

	// Modules
	'Tastaturberuf\ModuleAnyStoresDetails'  => 'system/modules/anyStores/modules/ModuleAnyStoresDetails.php',
	'Tastaturberuf\ModuleAnyStoresImporter' => 'system/modules/anyStores/modules/ModuleAnyStoresImporter.php',
	'Tastaturberuf\ModuleAnyStoresList'     => 'system/modules/anyStores/modules/ModuleAnyStoresList.php',
	'Tastaturberuf\ModuleAnyStoresMap'      => 'system/modules/anyStores/modules/ModuleAnyStoresMap.php',
	'Tastaturberuf\ModuleAnyStoresSearch'   => 'system/modules/anyStores/modules/ModuleAnyStoresSearch.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'anystores_details'       => 'system/modules/anyStores/templates/anystores',
	'map_google_dynamic'      => 'system/modules/anyStores/templates/maps',
	'map_google_static'       => 'system/modules/anyStores/templates/maps',
	'mod_anystores_details'   => 'system/modules/anyStores/templates/modules',
	'mod_anystores_inserttag' => 'system/modules/anyStores/templates/modules',
	'mod_anystores_list'      => 'system/modules/anyStores/templates/modules',
	'mod_anystores_map'       => 'system/modules/anyStores/templates/modules',
	'mod_anystores_search'    => 'system/modules/anyStores/templates/modules',
));
