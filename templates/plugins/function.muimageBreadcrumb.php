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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Fri Feb 17 18:57:24 CET 2012.
 */

/**
 * The muimageBreadcrump method returns a breadcrump code to the template
 *
 * @return string
 */
function smarty_function_muimageBreadcrumb($params, $view)
{
    $dom = ZLanguage::getModuleDomain('MUImage');

    $albumId = $params['albumId'];
    $repository = MUImage_Util_Model::getAlbumRepository();
    $album = $repository->selectById($albumId);
    if (!isset($params['out'])) {
        $out = '';
    } else {
        $out = html_entity_decode($params['out']);
    }
    if (!isset($params['loop'])) {
        $loop = 0;
    } else {
        $loop = $params['loop'];
    }
    if ($loop == 0) {
        $thisAlbum = $album;
    } else {
        $thisAlbum = $params['thisAlbum'];
    }

    if ($album) {
        $albumParent = $album->getParent();
        if ($albumParent) {
            $url = ModUtil::url('MUImage', 'user', 'display', array('ot' => 'album', 'id' => $albumParent['id']));
            $out = '<li><a href="' . $url . '">' . $albumParent['title'] . '</a></li>' . $out;

            $params['albumId'] = $albumParent['id'];
            $params['out'] = $out;
            $params['loop'] = $loop + 1;
            $params['thisAlbum'] = $thisAlbum;
            smarty_function_muimageBreadcrumb($params, $view);
        } else {
            $url = ModUtil::url('MUImage', 'user', 'main');
            if (ModUtil::getVar('MUImage', 'layout') == 'bootstrap') {
                $out = '<ol class="breadcrumb">' . '<li><a href="' . $url . '">' . __('Albums', $dom) . '</a></li>' . $out . '<li>' . $thisAlbum['title'] . '</li>' . '</ol>';
            } else {
                $out = '<ol class="breadcrumb-normal">' . '<li><a href="' . $url . '">' . __('Albums', $dom) . '</a></li>' . $out . '<li>' . $thisAlbum['title'] . '</li>' . '</ol><br style="clear: both;" />';

            }
            if (array_key_exists('assign', $params)) {
                $view->assign($params['assign'], $out);
                return;
            }
            return $out;
        }
    }
}