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
 * Utility implementation class for model helper methods.
 */
class MUImage_Util_Model extends MUImage_Util_Base_Model
{
    
    /**
	*
	 This method is for getting a repository for pictures
	*
	*/
    
    public static function getPictureRepository() {
    
     $serviceManager = ServiceUtil::getManager();
     $entityManager = $serviceManager->getService('doctrine.entitymanager');
     $repository = $entityManager->getRepository('MUImage_Entity_Picture');
    
     return $repository;
    }
    
    /**
	*
	 This method is for getting a repository for albums
	*
	*/
    
    public static function getAlbumRepository() {
    
     $serviceManager = ServiceUtil::getManager();
     $entityManager = $serviceManager->getService('doctrine.entitymanager');
     $repository = $entityManager->getRepository('MUImage_Entity_Album');
    
     return $repository;
    } 
}
