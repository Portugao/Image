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

namespace MU\ImageModule\Controller\Base;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use RuntimeException;
use Zikula\Core\Controller\AbstractController;
use Zikula\Core\Response\Ajax\AjaxResponse;
use Zikula\Core\Response\Ajax\BadDataResponse;
use Zikula\Core\Response\Ajax\FatalResponse;
use Zikula\Core\Response\Ajax\NotFoundResponse;

/**
 * Ajax controller base class.
 */
abstract class AbstractAjaxController extends AbstractController
{
    
    /**
     * Retrieve item list for finder selections in Forms, Content type plugin and Scribite.
     *
     * @param string $ot      Name of currently used object type
     * @param string $sort    Sorting field
     * @param string $sortdir Sorting direction
     *
     * @return AjaxResponse
     */
    public function getItemListFinderAction(Request $request)
    {
        if (!$this->hasPermission($this->name . '::Ajax', '::', ACCESS_EDIT)) {
            return true;
        }
        
        $objectType = 'album';
        if ($request->isMethod('POST') && $request->request->has('ot')) {
            $objectType = $request->request->getAlnum('ot', 'album');
        } elseif ($request->isMethod('GET') && $request->query->has('ot')) {
            $objectType = $request->query->getAlnum('ot', 'album');
        }
        $controllerHelper = $this->get('mu_image_module.controller_helper');
        $utilArgs = ['controller' => 'ajax', 'action' => 'getItemListFinder'];
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        
        $repository = $this->get('mu_image_module.' . $objectType . '_factory')->getRepository();
        $repository->setRequest($request);
        $selectionHelper = $this->get('mu_image_module.selection_helper');
        $idFields = $selectionHelper->getIdFields($objectType);
        
        $descriptionField = $repository->getDescriptionFieldName();
        
        $sort = $request->request->getAlnum('sort', '');
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
        }
        
        $sdir = strtolower($request->request->getAlpha('sortdir', ''));
        if ($sdir != 'asc' && $sdir != 'desc') {
            $sdir = 'asc';
        }
        
        $where = ''; // filters are processed inside the repository class
        $sortParam = $sort . ' ' . $sdir;
        
        $entities = $repository->selectWhere($where, $sortParam);
        
        $slimItems = [];
        $component = $this->name . ':' . ucfirst($objectType) . ':';
        foreach ($entities as $item) {
            $itemId = '';
            foreach ($idFields as $idField) {
                $itemId .= ((!empty($itemId)) ? '_' : '') . $item[$idField];
            }
            if (!$this->hasPermission($component, $itemId . '::', ACCESS_READ)) {
                continue;
            }
            $slimItems[] = $this->prepareSlimItem($objectType, $item, $itemId, $descriptionField);
        }
        
        return new AjaxResponse($slimItems);
    }
    
    /**
     * Builds and returns a slim data array from a given entity.
     *
     * @param string $objectType       The currently treated object type
     * @param object $item             The currently treated entity
     * @param string $itemid           Data item identifier(s)
     * @param string $descriptionField Name of item description field
     *
     * @return array The slim data representation
     */
    protected function prepareSlimItem($objectType, $item, $itemId, $descriptionField)
    {
        $view = Zikula_View::getInstance('MUImageModule', false);
        $view->assign($objectType, $item);
        $previewInfo = base64_encode($view->fetch('External/' . ucfirst($objectType) . '/info.html.twig'));
    
        $title = $item->getTitleFromDisplayPattern();
        $description = $descriptionField != '' ? $item[$descriptionField] : '';
    
        return [
            'id'          => $itemId,
            'title'       => str_replace('&amp;', '&', $title),
            'description' => $description,
            'previewInfo' => $previewInfo
        ];
    }
    
    /**
     * Searches for entities for auto completion usage.
     *
     * @param Request $request Current request instance
     *
     * @return JsonResponse
     */
    public function getItemListAutoCompletionAction(Request $request)
    {
        if (!$this->hasPermission($this->name . '::Ajax', '::', ACCESS_EDIT)) {
            return true;
        }
        
        $objectType = 'album';
        if ($request->isMethod('POST') && $request->request->has('ot')) {
            $objectType = $request->request->getAlnum('ot', 'album');
        } elseif ($request->isMethod('GET') && $request->query->has('ot')) {
            $objectType = $request->query->getAlnum('ot', 'album');
        }
        $controllerHelper = $this->get('mu_image_module.controller_helper');
        $utilArgs = ['controller' => 'ajax', 'action' => 'getItemListAutoCompletion'];
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        
        $repository = $this->get('mu_image_module.' . $objectType . '_factory')->getRepository();
        $selectionHelper = $this->get('mu_image_module.selection_helper');
        $idFields = $selectionHelper->getIdFields($objectType);
        
        $fragment = '';
        $exclude = '';
        if ($request->isMethod('POST') && $request->request->has('fragment')) {
            $fragment = $request->request->get('fragment', '');
            $exclude = $request->request->get('exclude', '');
        } elseif ($request->isMethod('GET') && $request->query->has('fragment')) {
            $fragment = $request->query->get('fragment', '');
            $exclude = $request->query->get('exclude', '');
        }
        $exclude = !empty($exclude) ? explode(',', $exclude) : [];
        
        // parameter for used sorting field
        $sort = $request->query->get('sort', '');
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
            System::queryStringSetVar('sort', $sort);
            $request->query->set('sort', $sort);
            // set default sorting in route parameters (e.g. for the pager)
            $routeParams = $request->attributes->get('_route_params');
            $routeParams['sort'] = $sort;
            $request->attributes->set('_route_params', $routeParams);
        }
        $sortParam = $sort . ' asc';
        
        $currentPage = 1;
        $resultsPerPage = 20;
        
        // get objects from database
        list($entities, $objectCount) = $repository->selectSearch($fragment, $exclude, $sortParam, $currentPage, $resultsPerPage);
        
        $resultItems = [];
        
        if ((is_array($entities) || is_object($entities)) && count($entities) > 0) {
            $descriptionFieldName = $repository->getDescriptionFieldName();
            $previewFieldName = $repository->getPreviewFieldName();
            
            //$imageHelper = $this->get('mu_image_module.image_helper');
            //$imagineManager = $imageHelper->getManager($objectType, $previewFieldName, 'controllerAction', $utilArgs);
            $imagineManager = $this->get('systemplugin.imagine.manager');
            foreach ($entities as $item) {
                $itemTitle = $item->getTitleFromDisplayPattern();
                $itemTitleStripped = str_replace('"', '', $itemTitle);
                $itemDescription = isset($item[$descriptionFieldName]) && !empty($item[$descriptionFieldName]) ? $item[$descriptionFieldName] : '';//$this->__('No description yet.')
                if (!empty($itemDescription)) {
                    $itemDescription = substr($itemDescription, 0, 50) . '&hellip;';
                }
        
                $resultItem = [
                    'id' => $item->createCompositeIdentifier(),
                    'title' => $item->getTitleFromDisplayPattern(),
                    'description' => $itemDescription,
                    'image' => ''
                ];
        
                // check for preview image
                if (!empty($previewFieldName) && !empty($item[$previewFieldName])) {
                    $fullObjectId = $objectType . '-' . $resultItem['id'];
                    $thumbImagePath = $imagineManager->getThumb($item[$previewFieldName], $fullObjectId);
                    $preview = '<img src="' . $thumbImagePath . '" width="50" height="50" alt="' . $itemTitleStripped . '" />';
                    $resultItem['image'] = $preview;
                }
        
                $resultItems[] = $resultItem;
            }
        }
        
        return new JsonResponse($resultItems);
    }
    
    /**
     * Checks whether a field value is a duplicate or not.
     *
     * @param Request $request Current request instance
     *
     * @return AjaxResponse
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function checkForDuplicateAction(Request $request)
    {
        if (!$this->hasPermission($this->name . '::Ajax', '::', ACCESS_EDIT)) {
            throw new AccessDeniedException();
        }
        
        $postData = $request->request;
        
        $objectType = $postData->getAlnum('ot', 'album');
        $controllerHelper = $this->get('mu_image_module.controller_helper');
        $utilArgs = ['controller' => 'ajax', 'action' => 'checkForDuplicate'];
        if (!in_array($objectType, $controllerHelper->getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = $controllerHelper->getDefaultObjectType('controllerAction', $utilArgs);
        }
        
        $fieldName = $postData->getAlnum('fn', '');
        $value = $postData->get('v', '');
        
        if (empty($fieldName) || empty($value)) {
            return new BadDataResponse($this->__('Error: invalid input.'));
        }
        
        // check if the given field is existing and unique
        $uniqueFields = [];
        switch ($objectType) {
            case 'album':
                    $uniqueFields = ['title'];
                    break;
        }
        if (!count($uniqueFields) || !in_array($fieldName, $uniqueFields)) {
            return new BadDataResponse($this->__('Error: invalid input.'));
        }
        
        $exclude = $postData->get('ex', '');
        /* can probably be removed
         * $createMethod = 'create' . ucfirst($objectType);
         * $object = $this->get('mu_image_module.' . $objectType . '_factory')->$createMethod();
         */
        
        $result = false;
        switch ($objectType) {
        case 'album':
            $repository = $this->get('mu_image_module.' . $objectType . '_factory')->getRepository();
            switch ($fieldName) {
            case 'title':
                    $result = $repository->detectUniqueState('title', $value, $exclude);
                    break;
            }
            break;
        }
        
        // return response
        $result = ['isDuplicate' => $result];
        
        return new AjaxResponse($result);
    }
}
