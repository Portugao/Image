<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Thu Feb 23 22:43:24 CET 2012.
 */

/**
 * This handler class handles the page events of the Form called by the MUImage_user_edit() function.
 * It aims on the album object type.
 */
class MUImage_Form_Handler_User_Album_Edit extends MUImage_Form_Handler_User_Album_Base_Edit
{
	/**
	 * Initialize form handler.
	 *
	 * This method takes care of all necessary initialisation of our data and form states.
	 *
	 * @return boolean False in case of initialization errors, otherwise true.
	 */
	public function initialize(Zikula_Form_View $view)
	{
		$dom = ZLanguage::getModuleDomain('MUImage');
		$id = $this->request->query->filter('id', 0, FILTER_SANITIZE_NUMBER_INT);

		$mainAlbumMode = MUImage_Util_Controller::ruleEditMainAlbum($id);

		// we check if user is in admin group
		$inAdminGroup = MUImage_Util_View::isAdmin();

		// if we want to edit an item
		if ($id > 0) {
			$myAlbums = MUImage_Util_View::getAlbums($id);

			$myalbums = array();

			if (MUImage_Util_View::isAdmin() === true || ($mainAlbumMode != C && $mainAlbumMode != D)) {
				$myalbums[] = array('value' => '', 'text' => __('No main album'), $dom);
			}

			if (MUImage_Util_View::isAdmin() === true || $mainAlbumMode == 1 || $mainAlbumMode == 2 || $mainAlbumMode == 3 || $mainAlbumMode == A || $mainAlbumMode == B || $mainAlbumMode == C || $mainAlbumMode == D) {
				foreach ($myAlbums as $myAlbum) {
					$myalbums[] = array('value' => $myAlbum['id'], 'text' => $myAlbum['title'] . ' - ' . __('Owner:') . ' ' . UserUtil::getVar('uname', $myAlbum['createdUserId']) . ' - ' . __('Main album:') . ' ' . $myAlbum['parent']['title']);
				}
			}
		}
		// we check if there is an item in the dropdownlist
		$countmyalbums = count($myalbums);

		$this->view->assign('mainAlbumMode', $mainAlbumMode)
		->assign('inAdminGroup', $inAdminGroup)
		->assign('countmyalbums', $countmyalbums);

		// controlling of albums in edit form
		// of pictures and albums
		$mainalbum = $this->view->get_template_vars('mainalbum');
		$mainalbum['muimageAlbum_ParentItemListItems'] = $myalbums;
		$this->view->assign('mainalbum', $mainalbum);

		$albumrepository = MUImage_Util_Model::getAlbumRepository();
		if ($id > 0) {
			// we get this album to edit
			$thisalbum = $albumrepository->selectById($id);
			$parent = $thisalbum->getParent();
			if ($parent) {
				$parentid = $parent->getId();
			}
			else {
				$parentid = '';
			}

			$this->view->assign('savedParent', $parentid);
		}

		if (MUImage_Util_View::otherUserMainAlbums() == true) {
			$this->view->assign('otherMainAlbum', true);
		}
		else {
			$this->view->assign('otherMainAlbum', false);
		}

		parent::initialize($view);
	}

	/**
	 * Input data processing called by handleCommand method.
	 */
	public function fetchInputData(Zikula_Form_View $view, &$args)
	{
		if ($args['commandName'] == 'create') {
			parent::fetchInputData($view, $args);
		}
		
		// get treated entity reference from persisted member var
		$entity = $this->entityRef;

		$entityData = array();

		if ($args['commandName'] == 'create') {
			$this->reassignRelatedObjects();
			$entityData['Parent'] = ((isset($selectedRelations['parent'])) ? $selectedRelations['parent'] : $this->retrieveRelatedObjects('album', 'muimageAlbum_ParentItemList', false, 'POST'));
		}
		if ($args['commandName'] == 'update') {
			$parent = $this->request->getPost()->filter('muimageAlbum_ParentItemList', 0, FILTER_SANITIZE_NUMBER_INT);
			if ($parent[0] > 0 && is_array($parent)) {
				$albumrepository = MUImage_Util_Model::getAlbumRepository();
				$album = $albumrepository->selectById($parent[0]);
				if ($album) {
					$entityData['Parent'] = $album;
				}
			}
			else {
				$entityData['Parent'] = null;
			}
		}

		// assign fetched data
		if (count($entityData) > 0) {
			$entity->merge($entityData);
		}

		// save updated entity
		$this->entityRef = $entity;
	}
}