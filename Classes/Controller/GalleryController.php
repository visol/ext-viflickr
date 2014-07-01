<?php
namespace Visol\ViFlickr\Controller;

	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2013 Lorenz Ulrich <lorenz.ulrich@visol.ch>, visol digitale Dienstleistungen GmbH
	 *
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 3 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/
use TYPO3\CMS\Core\Utility\DebugUtility;

/**
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GalleryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$requiredSettings = array('apiKey', 'albumId', 'thumbnailSize', 'lightboxSize');
		foreach ($requiredSettings as $requiredSetting) {
			if (empty($this->settings[$requiredSetting])) {
				$this->flashMessageContainer->add('Required setting "' . $requiredSetting . '" missing.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
			}
		}

		$webserviceBase = 'https://api.flickr.com/services/rest/?format=json';
		$webserviceUrl = $webserviceBase . '&method=flickr.photosets.getPhotos&api_key=' . $this->settings['apiKey'] . '&photoset_id=' . $this->settings['albumId'] . '&nojsoncallback=1';
		$albumData = json_decode(file_get_contents($webserviceUrl));
		$this->view->assignMultiple(array(
			'albumData' => $albumData
		));
	}

}
?>
