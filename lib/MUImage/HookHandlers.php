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

        // we get the calling module
        $request = new Zikula_Request_Http();
        $module = $request->query->filter('module', '', FILTER_SANITIZE_STRING);
        // News module
        if($module == 'News') {
            $albumrepository = MUImage_Util_Model::getAlbumRepository();
            $where = 'tbl.parent_id IS NULL';
            $albums = $albumrepository->selectWhere($where);

            $where2 = 'tbl.parent_id IS NOT NULL';
            $subalbums = $albumrepository->selectWhere($where2);

            // assign the albums to template
            $this->view->assign('albums', $albums);
            // assign the subalbums to template
            $this->view->assign('subalbums', $subalbums);
        } else { // other modules
            $albumrepository = MUImage_Util_Model::getAlbumRepository();
            $allalbums = $albumrepository->selectWhere();
            // assign all albums
            $this->view->assign('allalbums', $allalbums);
        }

        $hook->setResponse(new Zikula_Response_DisplayHook('provider.muimage.ui_hooks.service', $this->view, 'hook/edit.tpl'));
    }

    /**
     * Display smilies and provide interface for their use in an edit object form
     *
     * @param Zikula_DisplayHook $hook
     */
    public function processEdit(Zikula_ProcessHook $hook)
    {
        $modname = $hook->getCaller();
        // we get a request instance
        $view = new Zikula_Request_Http();

        // if the hooked module is News
        if ($modname == 'News') {
            $story = $view->getPost()->filter('story');
            $args['newsaction'] = $story['action'];

            // we check if images are selected for upload
            $files = News_ImageUtil::reArrayFiles(FormUtil::getPassedValue('news_files', null, 'FILES'));

            $picturerepository = MUImage_Util_Model::getPictureRepository();
            $searchstring = '%' . 'sid' . $sid . '%';
            $where = 'tbl.title LIKE \'' . DataUtil::formatForStore($searchstring) . '\'';
            $pictures = $picturerepository->selectWhere($where);
             
            // if the user has selected images for upload
            // we have to do something further
            if ($files) {


                // we check if the user wants to create
                // or update an entry
                $func = $view->request->filter('func', 'view');

                if ($func == 'update') {
                    $args['sid'] = $view->getPost->filter('news_sid', 0 , FILTER_SANITIZE_NUMBER_INT);
                }
                $albumyes = $view->getPost()->filter('muimage-albumyes', '');
                $muimagealbum = $view->getPost()->filter('muimage-album', 0);
                $muimagesubalbum = $view->getPost()->filter('muimage-subalbum', 0);
                 

                $args['sid'] = $story['sid'];
                // if the user want to create a new muimage album
                if ($albumyes != '') {

                    $serviceManager = ServiceUtil::getManager();
                    $entityManager = $serviceManager->getService('doctrine.entitymanager');

                    // we get the title of the news
                    $newstitle = $story['title'];

                    // we create a new album object
                    $album = new MUImage_Entity_Album();

                    // we get the id of the user
                    $uid = UserUtil::getVar('uid');
                    // we set the user created this album
                    $album->setCreatedUserId($uid);
                    // we set the user updated this album
                    $album->setUpdatedUserId($uid);

                    // we get the actual time
                    $date = new DateTime("now");

                    // we set the time this album was created
                    $album->setCreatedDate($date);
                    // we set the time this album was updated
                    $album->setUpdatedDate($date);

                    // we build the title for this new album
                    $title = DateUtil::formatDatetime($date, 'datebrief') . ' - ' . $newstitle;

                    // we set the title
                    $album->setTitle($title);

                    /*$entityManager->persist($album);
                     $entityManager->flush();*/

                    $dom = ZLanguage::getModuleDomain('MUImage');

                    LogUtil::registerStatus(__('Album with title ', $dom) . $title . __(' created!', $dom));

                    $albumrepository = MUImage_Util_Model::getAlbumRepository();
                    $where = 'tbl.title = \'' . DataUtil::formatForStore($title) . '\'';
                    $newalbum = $albumrepository->selectWhere($where);

                    if ($func == 'create') {
                        $args['albumid'] = $newalbum[0]['id'];
                    }

                    $serviceManager = ServiceUtil::getManager();
                    // create new Form reference
                    $view = new Zikula_Form_View($serviceManager, 'MUImage');

                    MUImage_Form_Handler_User_Picture_HookUpload::HandleCommand($view, &$args);

                }
                else {
                    if ($muimagealbum >= 1) {
                        $albumrepository = MUImage_Util_Model::getAlbumRepository();
                        $where = 'tbl.id = \'' . DataUtil::formatForStore($muimagealbum) . '\'';
                        $args['albumid'] = $muimagealbum;
                        MUImage_Form_Handler_User_Picture_HookUpload::HandleCommand($view, &$args);

                    }
                    if ($muimagesubalbum >= 1) {
                        $albumrepository = MUImage_Util_Model::getAlbumRepository();
                        $where = 'tbl.id = \'' . DataUtil::formatForStore($muimagesubalbum) . '\'';
                        $args['albumid'] = $muimagesubalbum;
                        MUImage_Form_Handler_User_Picture_HookUpload::HandleCommand($view, &$args);
                         
                    }

                }
            }
            // no files uploaded in News
            else {
                // nothing to do
            }

        } else { // if ($modname == 'News')

        }
    }
}
