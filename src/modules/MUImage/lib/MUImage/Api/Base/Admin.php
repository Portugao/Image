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
 * This is the Admin api helper class.
 */
class MUImage_Api_Base_Admin extends Zikula_AbstractApi
{
    /**
     * get available Admin panel links
     *
     * @return array Array of admin links
     */
    public function getlinks()
    {
        $links = array();

        if (SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            $links[] = array('url'   => ModUtil::url($this->name, 'user', 'main'),
                'text'  => $this->__('Frontend'),
                'title' => $this->__('Switch to user area.'),
                'class' => 'z-icon-es-home');
        }
        if (SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            $links[] = array('url'   => ModUtil::url($this->name, 'admin', 'view', array('ot' => 'album')),
                'text'  => $this->__('Albums'),
                'title' => $this->__('Album list'));
        }
        if (SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            $links[] = array('url'   => ModUtil::url($this->name, 'admin', 'view', array('ot' => 'picture')),
                'text'  => $this->__('Pictures'),
                'title' => $this->__('Picture list'));
        }
        if (SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            $links[] = array('url'   => ModUtil::url($this->name, 'admin', 'config'),
                'text'  => $this->__('Configuration'),
                'title' => $this->__('Manage settings for this application'));
        }
        return $links;
    }
}
