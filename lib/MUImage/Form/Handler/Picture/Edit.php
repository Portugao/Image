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
class MUImage_Form_Handler_Picture_Edit extends MUImage_Form_Handler_Picture_Base_Edit
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

        $picturerepository = MUImage_Util_Model::getPictureRepository();
        $albumrepository = MUImage_Util_Model::getAlbumRepository();

        if ($id > 0) {
            $picture = $picturerepository->selectById($id);
        }
         
        // we get the allowed filesize
        $fileSize = MUImage_Util_Controller::maxSize('picture');
        // we check if deleting of pictures is allowed
        $deletePictures = ModUtil::getVar($this->name, 'userDeletePictures');
        // we check for required width for pictures
        $minWidth = MUImage_Util_Controller::minWidth();
        // we check for maximum width for pictures
        $maxWidth = MUImage_Util_Controller::maxWidth();
        // we check for maximum height for pictures
        $maxHeight = MUImage_Util_Controller::maxHeight();
        // we check for user is in admin group
        $inAdminGroup = MUImage_Util_View::isAdmin();

        // if we want to edit an item
        if ($id > 0) {
            $myAlbums = MUImage_Util_View::getAlbums($id, 2);

            $myalbums = array();

            /*if (MUImage_Util_View::isAdmin() === true || MUImage_Util_View::otherUserMainAlbums() === true) {
             $myalbums[] = array('value' => '', 'text' => __('Choose an album'), $dom);
            }*/

            foreach ($myAlbums as $myAlbum) {
                $myalbums[] = array('value' => $myAlbum['id'], 'text' => $myAlbum['title'] . ' - ' . __('Owner:', $dom) . ' ' . UserUtil::getVar('uname', $myAlbum['createdUserId']) . ' - ' . __('Main album:', $dom) . ' ' . $myAlbum['parent']['title']);
            }
        }

        // controlling of albums in edit form
        // of pictures and albums
        $mainalbum = $this->view->get_template_vars('mainalbum');
        $mainalbum['muimageAlbum_AlbumItemListItems'] = $myalbums;
        $this->view->assign('mainalbum', $mainalbum);

        if ($id > 0) {

            if ($picture) {
                $pictureAlbum = $picture->getAlbum();
                if ($pictureAlbum) {
                    $pictureAlbumId = $pictureAlbum->getId();
                }
            }

            $this->view->assign('savedAlbum', $pictureAlbumId);
        }
         
        $this->view->assign('fileSize', $fileSize)
        ->assign('minWidth', $minWidth)
        ->assign('maxWidth', $maxWidth)
        ->assign('maxHeight', $maxHeight)
        ->assign('deletePictures', $deletePictures)
        ->assign('inAdminGroup', $inAdminGroup);

        if (MUImage_Util_View::otherUserMainAlbums() == true) {
            $this->view->assign('otherMainAlbum', true);
        } else {
            $this->view->assign('otherMainAlbum', false);
        }
        parent::initialize($view);
    }

    /**
     * Input data processing called by handleCommand method.
     */
    public function fetchInputData(Zikula_Form_View $view, &$args)
    {
        parent::fetchInputData($view, $args);


        // get treated entity reference from persisted member var
        $entity = $this->entityRef;

        $entityData = array();
        if ($args['commandName'] == 'create') {
            //$this->reassignRelatedObjects();
            $entityData['Album'] = ((isset($selectedRelations['album'])) ? $selectedRelations['album'] : $this->retrieveRelatedObjects('album', 'muimageAlbum_AlbumItemList', false, 'POST'));
        }

        if ($args['commandName'] == 'update') {
            $album = $this->request->getPost()->filter('muimageAlbum_AlbumItemList', 0, FILTER_SANITIZE_NUMBER_INT);
            if ($album[0] > 0 && is_array($album)) {
                $albumrepository = MUImage_Util_Model::getAlbumRepository();
                $thisalbum = $albumrepository->selectById($album[0]);
                if ($thisalbum) {
                    $entityData['Album'] = $thisalbum;
                }
            } else {
                $entityData['Album'] = null;
            }
            $serviceManager = ServiceUtil::getManager();
            $entityManager = $serviceManager->getService('doctrine.entitymanager');
            $picturerepository = MUImage_Util_Model::getPictureRepository();

            if ($thisalbum) {
                $pictures = $thisalbum->getPicture();
                // if (count($pictures) > 0 && is_array($pictures)) {
                foreach ($pictures as $picture) {
                    $thisPicture = $picturerepository->selectById($picture['id']);
                    $thisPicture->setAlbumImage(0);
                    $entityManager->flush();
                }
                // }
            }
            $albumImage = $this->request->request->filter('albumImage', 0, FILTER_SANITIZE_NUMBER_INT);
            if ($albumImage == 1) {
                $entityData['albumImage'] = 1;
            } else {
                $entityData['albumImage'] = 0;
            }
        }

        // assign fetched data
        if (count($entityData) > 0) {
            $entity->merge($entityData);
        }

        // save updated entity
        $this->entityRef = $entity;
    }

    /**
     * Get the default redirect url. Required if no returnTo parameter has been supplied.
     * This method is called in handleCommand so we know which command has been performed.
     */
    protected function getDefaultReturnUrl($args, $obj)
    {
        $pictureId = $this->request->query->filter('id', 0, FILTER_SANITIZE_NUMBER_INT);
        $type = $this->request->query->filter('type', 'admin', FILTER_SANITIZE_STRING);

        $picturerepository = MUImage_Util_Model::getPictureRepository();
        if ($args['commandName'] == 'create') {
            $picture = $picturerepository->selectById($this->idValues['id']);
        } else {
            $picture = $picturerepository->selectById($pictureId);
        }

        if ($picture) {
            $album = $picture->getAlbum();
            if ($album) {
                $albumid = $album->getId();
            } else {
                $albumid = 0;
            }
        } else {
            $viewArgs = array('ot' => 'album', 'lct' => $type);
            $url = ModUtil::url($this->name, 'user', 'view', $viewArgs);
            return $url;
        }
         
        // redirect to the album if existing
        if ($albumid > 0) {
            $viewArgs = array('lct' => $type, 'ot' => 'album', 'id' => $albumid);
            $url = ModUtil::url($this->name, 'user', 'display', $viewArgs);
            return $url;
        } else {
            $viewArgs = array('lct' => $type, 'ot' => 'album');
            $url = ModUtil::url($this->name, 'user', 'view', $viewArgs);
            return  $url;
        }


        if ($args['commandName'] != 'delete' && !($this->mode == 'create' && $args['commandName'] == 'cancel')) {
            // redirect to the detail page of treated picture
            $url = ModUtil::url($this->name, 'user', 'display', array('ot' => 'picture', 'id' => $this->idValues['id']));
        }
        return $url;
    }
}
