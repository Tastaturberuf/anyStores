# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [1.9.0]
###Added
- Add Google Maps API browser key support (fix #60 #61) Thanks to @DanMan
- Add possibility to login in the dynamic Google map
- Add table header customization at location list view in the backend
- Add dynamic value field in form location list

###Changed
- Sorting backend palettes
- Change ALL(!) templates to Contao 3.3+

###Deprecated

###Removed
- Remove back button in detail template (see #10)

###Fixed
- Use LIMIT in list module without trigger the search

###Security

## [1.8.3]
###Fixed
- fixed copy error for members

## [1.8.2]
###Fixed
- fixed error on generating coordinates

## [1.8.1]
###Fixed
- database error on install

###Deprecated
- AnyStoresDcaHelper::getCategories - use foreignKey instead

## [1.8.0]
###Added
- Google API key support
- add six free form fields for locations
- add template support for Google Maps info windows <br>
  IMPORTANT: To override templates put it in the templates root folder! The AJAX request has no layout object and can not find the template in other folders.
- runonce.php support
- add full user / groups permission support
- add search map module. You can see the results on a map

###Changed
- change ajax request to new class FrontendAjax.php
- save latitude and longitude in float(10,6) instead varchar(10)
- save map height in map module with InputUnit widget instead of pixel value
- Use JSON_PARTIAL_OUTPUT_ON_ERROR flag (PHP 5.5+) for json encoding
- load markerclusterer images local

###Removed
- deprecated functions

###Fixed
- generate sitemap and search index correctly

###Security
- add tokens for ajax map requests

## [1.7.2]
### Added
- Set markers global, module, category and location based
- Add hook 'anystores_getAjaxModule' when map module is loaded
- Add getStoreFromUrl function

### Changed
- Change log format to http://keepachangelog.com/
- Remove the sensor parameter in google map urls
- Change ajax method to GET

## [1.7.1]
### New
- Add field in map module for map height (remove hardcoded css style from template)

### Fixed
- Fixed awkward error with map loading


## [1.7.0]
### Added
- Add configuration values to map module
- Add error log when using invalid inserttag params
- Add additional street info field 'street2'

### Fixed
- Put sitemap setting on the page palettes ending

### Changed
- changed template mod_anystores_map!
- load module params and stores over ajax
- Add $this->rawstores to mod_anystores_list template

## [1.6.1]
### Fixed
- Encode email in map module in the json part

## [1.6.0]
### Added
- Add title and meta description support (see #25)

## [1.5.3]
### Added
- Add field for changing the locations category (fix #9)

## [1.5.2]
### Fixed
- Fixed recoverable error (see #36)
- Fixed table error on locations description

## [1.5.1]
### Fixed
- Namespace error

## [1.5.0]
### New
- Add support for locations to the sitemap

### Changed
- Change backend navigation
- OpenStreetView API is no longer experimental

## [1.4.3]
### Fixed
- Fixed search error in Contao 3.5

## [1.4.2]
### New
- Add option to sort the list individual (see #31)

### Fixed
- Make default country in list module optional

## [1.4.1]
### Fixed
- Fatal error on Contao 3.5 when using insert tags
- PHP notice (see #32)

## [1.4.0]
### New
- Add options in forms for sending a copy of the mail to the nearest location.
- Compatible with EFG.

## [1.3.0]
### New
- Add option to send forms to the locations email

## [1.2.1]
### Changed
- Improved filter by published in insert tags

### Fixed
- Fixed insert tag errors

## [1.2.0]
### New
- Added breadcrumb support

## [1.1.1-alpha]
### Fixed
- Fixed error with default language in search template

## [1.1.0-alpha]
### New
- Added content element support for location description (#11)

---

## [Unreleased]
###Added
###Changed
###Deprecated
###Removed
###Fixed
###Security