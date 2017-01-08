<?php

/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio (http://modulestudio.de).
 */
namespace MU\ImageModule\Helper;

use MU\ImageModule\Helper\Base\AbstractControllerHelper;
use DataUtil;
use ModUtil;
use UserUtil;

/**
 * Helper implementation class for controller layer methods.
 */
class ControllerHelper extends AbstractControllerHelper {
	
	/**
	 * The muimageCheckGroupMember method is checking if the actual user
	 * is in the same group as user created the relevant item
	 *
	 * @param unknown $createdBy        	
	 */
	public function checkGroupMember($created) {
		if (\UserUtil::isLoggedIn () === false) {
			return false;
		}
		$uid = \UserUtil::getVar('uid');
		if ($uid == $created) {
			return true;
		}
		
		$uidGroups = \UserUtil::getGroupListForUser ( $uid );
		$uidGroups = explode ( ',', $uidGroups );
		
		$createdUserIdGroups = \UserUtil::getGroupListForUser ($created);
		$createdUserIdGroups = explode ( ',', $createdUserIdGroups );
		
		$commonGroup = \ModUtil::getVar ( 'MUImage', 'groupForCommonAlbums' );
		
		if ($commonGroup != 'notset') {
			foreach ( $uidGroups as $uidGroup ) {
				if ($uidGroup == 2) {
					return true;
				}
				if (in_array ( $uidGroup, $createdUserIdGroups )) {
					if ($uidGroup > 2) {
						return true;
					}
				}
			}
		} else {
			foreach ( $uidGroups as $uidGroup ) {
				if ($uidGroup == 2) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	
	public function checkAlbumAccess($albumid) 
	{
		// we get the actual user id
		$userid = \UserUtil::getVar('uid');
		
		$albumrepository = $this->container->get('mu_image_module.album_factory')->getRepository();
		
		$thisAlbum = $albumrepository->selectById($albumid);
		
		$groupMember = self::checkGroupMember($thisAlbum['createdBy_id']);
		if ($groupMember == 1) {
			return 1;
		}
		
		if ($thisAlbum['notInFrontend'] == 1 && $thisAlbum['createdBy_id'] != $userid) {
			return 0;
		}
		if ($thisAlbum['albumAccess'] == 'all' ) {
			return 1;
		}
		if ($thisAlbum['albumAccess'] == 'users' && \UserUtil::isLoggedIn() === true) {
			return 1;
		}
		if ($thisAlbum['albumAccess'] == 'friends') {
			 
			if ($thisAlbum['createdBy'] == $userid) {
				return 1;
			}
			$friends = explode(',', $thisAlbum['myFriends']);
			if (is_array($friends)) {
				foreach ($friends as $friend) {
					$friendIds[] = \UserUtil::getIdFromName($friend);
				}
			}
			if (is_array($friendIds)) {
				if (in_array($userid, $friendIds)) {
					return 1;
				}
			}
		}
		if ($thisAlbum['albumAccess'] == 'known') {
			$userid = \UserUtil::getVar('uid');
			if ($thisAlbum['createdBy'] == $userid) {
				return 1;
			} else {
				$passwordArray = SessionUtil::getVar('muimagePasswordArray');
				if (is_array($passwordArray)) {
					foreach ($passwordArray as $key => $password) {
						if ($key == $thisAlbum['id'] && $password == $thisAlbum['passwordAccess']) {
							return 1;
						}
					}
					return 2;
		
				} else {
					return 2;
				}
			}
		}
		
		return false;		
	}
	
	/**
	 * 
	 * @param int $albumId
	 * @return unknown|array
	 */
	public function giveImageOfAlbum($albumId)
	{
		//$repository = $this->container->get('mu_image_module.picture_factory')->getRepository();
		$selectionHelper = $this->container->get('mu_image_module.selection_helper');
		$where = 'tbl.album = ' . \DataUtil::formatForStore($albumId);
		$where .= ' AND ';
		$where .= 'tbl.albumImage = 1';
		$pictures = $selectionHelper->getEntities('picture', [], $where);
		
		
		if (count($pictures) == 0) {
			$where = 'tbl.album = ' . \DataUtil::formatForStore($albumId);
			$pictures = $selectionHelper->getEntities('picture', [], $where);
		}
		if (count($pictures) >= 0) {
		return $pictures[0];
		} else {
			return '';
		}
	}
	
	public function breadcrumb($albumId, $params = array())
	{
		$dom = ZLanguage::getModuleDomain('MUImage');
		
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

				return $out;
			}
		}		
	}
}
