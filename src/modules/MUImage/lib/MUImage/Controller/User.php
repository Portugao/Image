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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Sun Feb 19 15:20:07 CET 2012.
 */

/**
 * This is the User controller class providing navigation and interaction functionality.
 */
class MUImage_Controller_User extends MUImage_Controller_Base_User
{
	    /**
     * This method provides a generic item detail view.
     *
     * @param string  $ot           Treated object type.
     * @param string  $tpl          Name of alternative template (for alternative display options, feeds and xml output)
     * @param boolean $raw          Optional way to display a template instead of fetching it (needed for standalone output)
     * @return mixed Output.
     */
    public function display($args)
    {
    	$view = new Zikula_Request_Http();
    	$id = $view->getGet()->filter('id', 0 , FILTER_SANITIZE_STRING);
    	
    	if ($id != 0) {

    		$count = MUImage_Util_View::countPictures();
    		$count2 = MUImage_Util_View::countAlbums();
    		
    		$this->view->assign('numpictures', $count);
    		$this->view->assign('numalbums', $count2);
    	}
    	
    	return parent::display($args);
    	
    }
}
