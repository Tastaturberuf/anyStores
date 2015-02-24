<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
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
	'Tastaturberuf\AnyStoresInsertTags'     => 'system/modules/anyStores/classes/AnyStoresInsertTags.php',
	'Tastaturberuf\AnyStores'               => 'system/modules/anyStores/classes/AnyStores.php',
	'Tastaturberuf\OpenStreetMap'           => 'system/modules/anyStores/classes/API/OpenStreetMap.php',
	'Tastaturberuf\GoogleMaps'              => 'system/modules/anyStores/classes/API/GoogleMaps.php',

	// Models
	'Tastaturberuf\AnyStoresCategoryModel'  => 'system/modules/anyStores/models/AnyStoresCategoryModel.php',
	'Tastaturberuf\AnyStoresModel'          => 'system/modules/anyStores/models/AnyStoresModel.php',

	// Modules
	'Tastaturberuf\ModuleAnyStoresSearch'   => 'system/modules/anyStores/modules/ModuleAnyStoresSearch.php',
	'Tastaturberuf\ModuleAnyStoresMap'      => 'system/modules/anyStores/modules/ModuleAnyStoresMap.php',
	'Tastaturberuf\ModuleAnyStoresImporter' => 'system/modules/anyStores/modules/ModuleAnyStoresImporter.php',
	'Tastaturberuf\ModuleAnyStoresDetails'  => 'system/modules/anyStores/modules/ModuleAnyStoresDetails.php',
	'Tastaturberuf\ModuleAnyStoresList'     => 'system/modules/anyStores/modules/ModuleAnyStoresList.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'anystores_details'       => 'system/modules/anyStores/templates/anystores',
	'mod_anystores_list'      => 'system/modules/anyStores/templates/modules',
	'mod_anystores_search'    => 'system/modules/anyStores/templates/modules',
	'mod_anystores_inserttag' => 'system/modules/anyStores/templates/modules',
	'mod_anystores_details'   => 'system/modules/anyStores/templates/modules',
	'mod_anystores_map'       => 'system/modules/anyStores/templates/modules',
));
