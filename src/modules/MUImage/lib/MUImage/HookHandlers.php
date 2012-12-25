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
 * @version at Son Dec 23
 */

/**
 * HookHandler class
 */
class MUImage_HookHandlers extends Zikula_Hook_AbstractHandler
{

	/**
	 * Zikula_View instance
	 * @var object
	 */
	private $view;

	/**
	 * Post constructor hook.
	 */
	public function setup()
	{
		$this->view = Zikula_View::getInstance("MUImage");
	}

	/**
	 * Display a checkbox for choose to create an album or not
	 *
	 * @param Zikula_DisplayHook $hook
	 */
	public function uiEdit(Zikula_DisplayHook $hook)
	{

		// some initialization stuff
		$assign = (isset($params['assign']) && !empty($params['assign'])) ? $params['assign'] : 'smilies';
		$type = (isset($params['type']) && !empty($params['type'])) ? $params['type'] : '';

		$allowedFields = MUImage_Util_Controller::allowedFields();

		$albumrepository = MUImage_Util_Model::getAlbumRepository();
		$where = 'tbl.parent_id IS NULL';
		$albums = $albumrepository->selectWhere($where);

		$where2 = 'tbl.parent_id IS NOT NULL';
		$subalbums = $albumrepository->selectWhere($where2);

		// Assign the number of allowed fields to template
		$this->view->assign('allowedFields', $allowedFields);
		$this->view->assign('albums', $albums);
		$this->view->assign('subalbums', $subalbums);

		$hook->setResponse(new Zikula_Response_DisplayHook('provider.muimage.ui_hooks.service', $this->view, 'hook/edit.tpl'));
	}

	/**
	 * Display smilies and provide interface for their use in an edit object form
	 *
	 * @param Zikula_DisplayHook $hook
	 */
	public function processEdit(Zikula_DisplayHook $hook)
	{
		$view = new Zikula_Request_Http();
		$albumyes = $view->getPost()->filter('muimage-albumyes', '');

		$files = News_ImageUtil::reArrayFiles(FormUtil::getPassedValue('news_files', null, 'FILES'));
		// if the user has selected images for upload
		if ($files) {
			// if the user want to create a new muimage album
			if ($albumyes != '') {
				
				$serviceManager = ServiceUtil::getManager();
				$entityManager = $serviceManager->getService('doctrine.entitymanager');
				
				$story = FormUtil::getPassedValue('story', isset($args['story']) ? $args['story'] : null, 'POST');
				$newstitle = $story['title'];
				
				$album = new MUImage_Entity_Album();

				$uid = UserUtil::getVar('uid');
				$album->setCreatedUserId($uid);
				$album->setUpdatedUserId($uid);
				
				$date = new DateTime("now");

				$album->setCreatedDate($date);
				$album->setUpdatedDate($date);
				
				$title = DateUtil::formatDatetime($date, 'datebrief') . ' - ' . $newstitle;
				
				$album->setTitle($title);

				$entityManager->persist($album);
				$entityManager->flush();
				
				$dom = ZLanguage::getModuleDomain('MUImage');
				
				LogUtil::registerStatus(__('Album with title ', $dom) . $title . __(' created!', $dom));
			}
			else {
				
			}
		}
		else {
			// nothing to do
		}
		 
	}
}
