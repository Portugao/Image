<?php
use Imagine\Gd\Imagine;

/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.6.2 (http://modulestudio.de).
 */

/**
 * Picture controller class providing navigation and interaction functionality.
 */
class MUImage_Controller_Picture extends MUImage_Controller_Base_Picture
{
    /**
     * This method provides a item list overview.
     *
     * @param string  $sort         Sorting field.
     * @param string  $sortdir      Sorting direction.
     * @param int     $pos          Current pager position.
     * @param int     $num          Amount of entries to display.
     * @param string  $tpl          Name of alternative template (to be used instead of the default template).
     * @param boolean $raw          Optional way to display a template instead of fetching it (required for standalone output).
     *
     * @return mixed Output.
     */
    public function view()
    {
        $legacyControllerType = $this->request->query->filter('lct', 'user', FILTER_SANITIZE_STRING);
        System::queryStringSetVar('type', $legacyControllerType);
        $this->request->query->set('type', $legacyControllerType);
    
        $controllerHelper = new MUImage_Util_Controller($this->serviceManager);
        
        // parameter specifying which type of objects we are treating
        $objectType = 'picture';
        $utilArgs = array('controller' => 'picture', 'action' => 'view');
        $permLevel = $legacyControllerType == 'admin' ? ACCESS_ADMIN : ACCESS_READ;
        $this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel), LogUtil::getErrorMsgPermission());
        $entityClass = $this->name . '_Entity_' . ucfirst($objectType);
        $repository = $this->entityManager->getRepository($entityClass);
        $repository->setControllerArguments(array());
        $viewHelper = new MUImage_Util_View($this->serviceManager);
        
        // parameter for used sorting field
        $sort = $this->request->query->filter('sort', '', FILTER_SANITIZE_STRING);
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
        }
        
        // parameter for used sort order
        $sortdir = $this->request->query->filter('sortdir', '', FILTER_SANITIZE_STRING);
        $sortdir = strtolower($sortdir);
        if ($sortdir != 'asc' && $sortdir != 'desc') {
            $sortdir = 'asc';
        }
        
        // convenience vars to make code clearer
        $currentUrlArgs = array();
        
        $where = '';
        
        $selectionArgs = array(
            'ot' => $objectType,
            'where' => $where,
            'orderBy' => $sort . ' ' . $sortdir
        );
        
        $showOwnEntries = (int) $this->request->query->filter('own', $this->getVar('showOnlyOwnEntries', 0), FILTER_VALIDATE_INT);
        $showAllEntries = (int) $this->request->query->filter('all', 0, FILTER_VALIDATE_INT);
        
        if (!$showAllEntries) {
            $csv = (int) $this->request->query->filter('usecsvext', 0, FILTER_VALIDATE_INT);
            if ($csv == 1) {
                $showAllEntries = 1;
            }
        }
        
        $this->view->assign('showOwnEntries', $showOwnEntries)
                   ->assign('showAllEntries', $showAllEntries);
        if ($showOwnEntries == 1) {
            $currentUrlArgs['own'] = 1;
        }
        if ($showAllEntries == 1) {
            $currentUrlArgs['all'] = 1;
        }
        
        // prepare access level for cache id
        $accessLevel = ACCESS_READ;
        $component = 'MUImage:' . ucfirst($objectType) . ':';
        $instance = '::';
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_COMMENT)) {
            $accessLevel = ACCESS_COMMENT;
        }
        if (SecurityUtil::checkPermission($component, $instance, ACCESS_EDIT)) {
            $accessLevel = ACCESS_EDIT;
        }
        
        $templateFile = $viewHelper->getViewTemplate($this->view, $objectType, 'view', array());
        $cacheId = 'view|ot_' . $objectType . '_sort_' . $sort . '_' . $sortdir;
        $resultsPerPage = 0;
        if ($showAllEntries == 1) {
            // set cache id
            $this->view->setCacheId($cacheId . '_all_1_own_' . $showOwnEntries . '_' . $accessLevel);
        
            // if page is cached return cached content
            if ($this->view->is_cached($templateFile)) {
                return $viewHelper->processTemplate($this->view, $objectType, 'view', array(), $templateFile);
            }
        
            // retrieve item list without pagination
            $entities = ModUtil::apiFunc($this->name, 'selection', 'getEntities', $selectionArgs);
        } else {
            // the current offset which is used to calculate the pagination
            $currentPage = (int) $this->request->query->filter('pos', 1, FILTER_VALIDATE_INT);
        
            // the number of items displayed on a page for pagination
            $resultsPerPage = (int) $this->request->query->filter('num', 0, FILTER_VALIDATE_INT);
            if ($resultsPerPage == 0) {
                $resultsPerPage = $this->getVar('pageSize', 10);
            }
            
            if ($legacyControllerType == 'admin') {
                $resultsPerPage = ModUtil::getVar($this->name, 'pageSizeAdminPictures', 10);
            }
        
            // set cache id
            $this->view->setCacheId($cacheId . '_amount_' . $resultsPerPage . '_page_' . $currentPage . '_own_' . $showOwnEntries . '_' . $accessLevel);
        
            // if page is cached return cached content
            if ($this->view->is_cached($templateFile)) {
                return $viewHelper->processTemplate($this->view, $objectType, 'view', array(), $templateFile);
            }
        
            // retrieve item list with pagination
            $selectionArgs['currentPage'] = $currentPage;
            $selectionArgs['resultsPerPage'] = $resultsPerPage;
            list($entities, $objectCount) = ModUtil::apiFunc($this->name, 'selection', 'getEntitiesPaginated', $selectionArgs);
        
            $this->view->assign('currentPage', $currentPage)
                       ->assign('pager', array('numitems'     => $objectCount,
                                               'itemsperpage' => $resultsPerPage));
        }
        
        foreach ($entities as $k => $entity) {
            $entity->initWorkflow();
        }
        
        // build ModUrl instance for display hooks
        $currentUrlObject = new Zikula_ModUrl($this->name, 'picture', 'view', ZLanguage::getLanguageCode(), $currentUrlArgs);
        
        // assign the object data, sorting information and details for creating the pager
        $this->view->assign('items', $entities)
                   ->assign('sort', $sort)
                   ->assign('sdir', $sortdir)
                   ->assign('pageSize', $resultsPerPage)
                   ->assign('currentUrlObject', $currentUrlObject)
                   ->assign($repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
        
        $modelHelper = new MUImage_Util_Model($this->serviceManager);
        $this->view->assign('canBeCreated', $modelHelper->canBeCreated($objectType));
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->view, $objectType, 'view', array(), $templateFile);
    }
    
    /**
     * This is a custom method. Documentation for this will be improved in later versions.
     *
     * @return mixed Output.
     */
    public function multiUpload()
    {
        // DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('MUImage::', '::', ACCESS_EDIT));
        // DEBUG: permission check aspect ends
        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'picture', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'multiUpload');
        if (!in_array($objectType, MUImage_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = MUImage_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        // create new Form reference
        $view = FormUtil::newForm($this->name, $this);
    
        // build form handler class name
        $handlerClass = 'MUImage_Form_Handler_' . ucfirst($objectType) . '_MultiUpload';
    
        // execute form using supplied template and page event handler
        return $view->execute($objectType . '/multiUpload.tpl', new $handlerClass());
    }
    
    /**
     * This is a custom method. Documentation for this will be improved in later versions.
     *
     * @return mixed Output.
     */
    public function editMulti()
    {
        // DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('MUImage::', '::', ACCESS_EDIT));
        // DEBUG: permission check aspect ends
        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'picture', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'editMulti');
        if (!in_array($objectType, MUImage_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = MUImage_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        // create new Form reference
        $view = FormUtil::newForm($this->name, $this);
    
        // build form handler class name
        $handlerClass = 'MUImage_Form_Handler_' . ucfirst($objectType) . '_EditMulti';
    
        // execute form using supplied template and page event handler
        return $view->execute($objectType . '/editMulti.tpl', new $handlerClass());
    
    }
    
    /**
     * 
     */
    public function savePosition()
    {
        $request = new Zikula_Request_Http();
        
        $pictures = $request->request->filter('pictures', '');
        $picturerepository = MUImage_Util_Model::getPictureRepository();

        
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
                
        if (is_array($pictures)) {
            $index = 0;
            foreach ($pictures as $picture) {
                $index = $index + 1;

                $thispicture = $picturerepository->selectById($picture);
                $thispicture->setPos($index);
                $entityManager->flush();
                $thisalbum = $thispicture->getAlbum();
                $thisAlbumId = $thisalbum['id'];
                
            }
        }
        $url = ModUtil::url('MUImage', 'user', 'display', array('ot' => 'album', 'id' => $thisAlbumId));
        return System::redirect($url);
        
        
    }
    
    /**
     *
     */
    public function rotateRight()
    {
        $request = new Zikula_Request_Http();
    
        $id = $request->query->filter('id', 0, FILTER_SANITIZE_NUMBER_INT);
        $picturerepository = MUImage_Util_Model::getPictureRepository();
    
        $thispicture = $picturerepository->selectById($id);
        $thisalbum = $thispicture->getAlbum();
        $thisAlbumId = $thisalbum['id'];
        $fullPath = $thispicture->getImageUploadFullPath();
    
        $imagine = new Imagine();
        $image = $imagine->open($fullPath);
        $image->rotate(90);
        $image->save($fullPath);
    
        $url = ModUtil::url('MUImage', 'user', 'display', array('ot' => 'album', 'id' => $thisAlbumId));
        return System::redirect($url);
    }
    
    /**
     * 
     */
    public function rotateLeft()
    {
        $request = new Zikula_Request_Http();
        
        $id = $request->query->filter('id', 0, FILTER_SANITIZE_NUMBER_INT);
        $picturerepository = MUImage_Util_Model::getPictureRepository();
        
        $thispicture = $picturerepository->selectById($id);
        $thisalbum = $thispicture->getAlbum();
        $thisAlbumId = $thisalbum['id'];
        $fullPath = $thispicture->getImageUploadFullPath();
        
        $imagine = new Imagine();
        $image = $imagine->open($fullPath);
        $image->rotate(-90);
        $image->save($fullPath);
        
        $url = ModUtil::url('MUImage', 'user', 'display', array('ot' => 'album', 'id' => $thisAlbumId));
        return System::redirect($url);
    }
}
