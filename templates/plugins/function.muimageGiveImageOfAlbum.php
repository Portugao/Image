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
 * The muimageGiveImageOfAlbum plugin provides an image for an album.
 *
 * Available parameters:
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array            $params  All attributes passed to this function from the template.
 * @param  Zikula_Form_View $view    Reference to the view object.
 *
 * @return string The output of the plugin.
 */
function smarty_function_muimageGiveImageOfAlbum($params, $view)
{
    $moduleid = $params['moduleid'];
    $repository = MUImage_Util_Model::getPictureRepository();
    $where = 'tbl.album = ' . DataUtil::formatForStore($moduleid);
    $pictures = $repository->selectWhere($where);

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $pictures[0]);
        return;
    }
    return $picture[0];
}
