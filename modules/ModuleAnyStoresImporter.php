<?php // with ♥ and Contao

/**
 * anyStores for Contao Open Source CMS
 *
 * @copyright   2014, 2015 Tastaturberuf <mail@tastaturberuf.de>
 *              2013 numero2 - Agentur für Internetdienstleistungen <www.numero2.de>
 * @author      Daniel Jahnsmüller <mail@jahnsmueller.net>
 *              Benny Born <benny.born@numero2.de>
 * @license     http://opensource.org/licenses/lgpl-3.0.html
 * @package     anyStores
 */


namespace Tastaturberuf;


class ModuleAnyStoresImporter extends \Backend {


	/**
	 * Generates a form to start import from csv file
	 */
	public function showImport() {

		if( $this->Input->post('FORM_SUBMIT') == 'tl_anystores_import' ) {

			$source = $this->Input->post('file', true);

			// check the file names
			if( !$source ) {
				$this->addErrorMessage($GLOBALS['TL_LANG']['ERR']['all_fields']);
				$this->reload();
			}

			// skip folders
			if( is_dir(TL_ROOT . '/' . $source) ) {
				$this->addErrorMessage(sprintf($GLOBALS['TL_LANG']['ERR']['importFolder'], basename($source)));
			}

			$objFile = new \File($source);

			// skip anything but .csv files
			if( $objFile->extension != 'csv' ) {
				$this->addErrorMessage(sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objFile->extension));
			}

			ini_set("max_execution_time",0);

			// read entries
			if( $objFile->handle !== FALSE ) {

				$pid = $this->Input->get('id');

				$count = 0;

				while( ($data = fgetcsv($objFile->handle, 1000)) !== FALSE ) {

					if( empty($data[0]) )
						continue;

					$count++;

					// get coordinates
					$coords = AnyStores::getCoordinates(
						$data[5] // street
					,	$data[6] // postal
					,	$data[7] // city
					,	$data[8] // country
					);

					// add "http" in front of url
					$data[2] = ( $data[2] && strpos($data[2],'http') === FALSE ) ? 'http://'.$data[2] : $data[2];

					try {
						$this->Database->prepare("INSERT INTO `tl_anystores` (`pid`,`tstamp`,`name`,`email`,`url`,`phone`,`fax`,`street`,`postal`,`city`,`country`,`longitude`,`latitude`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute(
							$pid
						,	time()
						,	$data[0]
						,	$data[1]
						,	$data[2]
						,	$data[3]
						,	$data[4]
						,	$data[5]
						,	$data[6]
						,	$data[7]
						,	strtolower($data[8])
						,	$coords ? $coords['longitude'] : ''
						,	$coords ? $coords['latitude'] : ''
						);
					} catch( Exception $e ) {
						continue;
					}

					if( $count > 5 ){
						sleep(2);
						$count = 0;
					}
				}

				$objFile->close();

				// Redirect
				setcookie('BE_PAGE_OFFSET', 0, 0, '/');
				$this->redirect(str_replace('&key=importStores', '', $this->Environment->request));
				return;
			}
		}

		$objTree = new \FileTree(
			$this->prepareForWidget(
				$GLOBALS['TL_DCA']['tl_anystores']['fields']['file']
			, 	'file'
			, 	null
			,	'file'
			,	'tl_anystores'
			)
		);

		// Return the form
		return '
			<div id="tl_buttons">
				<a href="'.ampersand(str_replace('&key=importStores', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'" accesskey="b">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
			</div>

			<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_anystores']['import']['head'].'</h2>
			'.$this->getMessages().'

			<form action="'.ampersand($this->Environment->request, true).'" id="tl_anystores_import" class="tl_form" method="post">
				<div class="tl_formbody_edit">
					<input type="hidden" name="FORM_SUBMIT" value="tl_anystores_import">
					<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">

					<div class="tl_tbox">
						<h3><label for="source">'.$GLOBALS['TL_LANG']['tl_anystores']['import']['file'][0].'</label> <a href="contao/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" data-lightbox="files 765 80%">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom"') . '</a></h3>'.$objTree->generate().(strlen($GLOBALS['TL_LANG']['tl_anystores']['import']['file'][1]) ? '
						<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_anystores']['import']['file'][1].'</p>' : '').'
					</div>
				</div>

				<div class="tl_formbody_submit">
					<div class="tl_submit_container">
						<input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_anystores']['import']['start']).'">
					</div>
				</div>
			</form>
		';
	}
}
