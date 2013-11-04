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
 * This is the Admin controller class providing navigation and interaction functionality.
 */
class MUImage_Controller_External extends MUImage_Controller_Base_External
{

    /**
     * Post initialise.
     *
     * Run after construction.
     *
     * @return void
     */
    protected function postInitialize()
    {
        // Set caching to true by default.
        $this->view->setCaching(Zikula_View::CACHE_DISABLED);
    }

    /**
     * Popup selector for scribite plugins.
     * Finds items of a certain object type.
     *
     * @param array $args List of arguments.
     *
     * @return output The external album finder page
     */
    public function finderAlbum($args)
    {
        $view = Zikula_View::getInstance('MUImage', false);

        // we get the actual userid
        $uid = UserUtil::getVar('uid');
        $usergroups = UserUtil::getGroupsForUser($uid);

        $albumrepository = MUImage_Util_Model::getAlbumRepository();
        $where = 'tbl.parent_id IS NULL';
        // if user is not in the admingroup
        if (!in_array(2, $usergroups)) {
            $where .= 'AND';
            $where .= 'tbl.createdUserId = \'' . DataUtil::formatForStore($uid) . '\'';
        }
        $albums = $albumrepository->selectWhere($where);

        // if user is not in the admingroup
        $where2 = 'tbl.parent_id IS NOT NULL';
        if (!in_array(2, $usergroups)) {
            $where2 .= 'AND';
            $where2 .= 'tbl.createdUserId = \'' . DataUtil::formatForStore($uid) . '\'';
        }
        $subalbums = $albumrepository->selectWhere($where2);

        $view->clear_cache();

        // assign the albums to template
        $this->view->assign('albums', $albums);
        // assign the subalbums to template
        $this->view->assign('subalbums', $subalbums);

        return $view->display('external/' . 'album' . '/find.tpl');
    }

    public function finderImages($args)
    {
        $view = Zikula_View::getInstance('MUImage', false);
        $request = new Zikula_Request_Http();

        $mainalbum = $request->query->filter('mainalbum', 0, FILTER_SANITIZE_NUMBER_INT);
        $subalbum = $request->query->filter('subalbum', 0, FILTER_SANITIZE_NUMBER_INT);

        //$mainalbum = $args['muimage-album'];
        $albumrepository = MUImage_Util_Model::getAlbumRepository();
        if ($subalbum == 0) {
            $album = $albumrepository->selectById($mainalbum);
        } else {
            $album = $albumrepository->selectById($subalbum);
        }

        $imagerepository = MUImage_Util_Model::getPictureRepository();
        //if ($album) {
        $where = 'tbl.album  = \'' . DataUtil::formatForStore($album['id']) . '\'';
        //}
        $images = $imagerepository->selectWhere($where);

        // assign the images to template
        $this->view->assign('images', $images);


        return $view->display('external/' . 'picture' . '/find.tpl');
    }

    public function setImage()
    {
        $view = Zikula_View::getInstance('MUImage', false);
        $request = new Zikula_Request_Http();

        $imageid = $request->query->filter('id', 0, FILTER_SANITIZE_NUMBER_INT);
        $imagerepository = MUImage_Util_Model::getPictureRepository();




    }
}
