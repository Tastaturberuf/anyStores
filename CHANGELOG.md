# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
###Added
###Changed
###Deprecated
###Removed
###Fixed
###Security

## [1.7.2]
### Added
- Add hook 'anystores_getAjaxModule' when map module is loaded
- Add getStoreFromUrl function

### Changed
- Change log format to http://keepachangelog.com/
- Remove the sensor parameter in google map urls

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
