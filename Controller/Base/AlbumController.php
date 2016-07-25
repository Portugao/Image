<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

namespace MU\MUImageModule\Controller\Base;

use MU\MUImageModule\Entity\AlbumEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FormUtil;
use ModUtil;
use RuntimeException;
use System;
use ZLanguage;
use Zikula\Component\SortableColumns\Column;
use Zikula\Component\SortableColumns\SortableColumns;
use Zikula\Core\Controller\AbstractController;
use Zikula\Core\ModUrl;
use Zikula\Core\RouteUrl;
use Zikula\Core\Response\PlainResponse;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * Album controller base class.
 */
class AlbumController extends AbstractController
{
    /**
     * This is the default action handling the main admin area called without defining arguments.
     * @Theme("admin")
     * @Cache(expires="+7 days", public=true)
     *
     * @param Request  $request      Current request instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     */
    public function adminIndexAction(Request $request)
    {
        return $this->indexInternal($request, true);
    }
    
    /**
     * This is the default action handling the main area called without defining arguments.
     * @Cache(expires="+7 days", public=true)
     *
     * @param Request  $request      Current request instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     */
    public function indexAction(Request $request)
    {
        return $this->indexInternal($request, false);
    }
    
    /**
     * This method includes the common implementation code for adminIndex() and index().
     */
    protected function indexInternal(Request $request, $isAdmin = false)
    {
        $controllerHelper = $this->get('mu_muimage_module.controller_helper');
        
        // parameter specifying which type of objects we are treating
        $objectType = 'album';
        $utilArgs = ['controller' => 'album', 'action' => 'main'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_OVERVIEW;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        
        if ($isAdmin) {
            
            return $this->redirectToRoute('mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'view');
        }
        
        if (!$isAdmin) {
            
            return $this->redirectToRoute('mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'view');
        }
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        
        // return index template
        return $this->render('@MUMUImageModule/Album/index.html.twig', $templateParameters);
    }
    /**
     * This action provides an item list overview in the admin area.
     * @Theme("admin")
     * @Cache(expires="+2 hours", public=false)
     *
     * @param Request  $request      Current request instance.
     * @param string  $sort         Sorting field.
     * @param string  $sortdir      Sorting direction.
     * @param int     $pos          Current pager position.
     * @param int     $num          Amount of entries to display.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     */
    public function adminViewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return $this->viewInternal($request, $sort, $sortdir, $pos, $num, true);
    }
    
    /**
     * This action provides an item list overview.
     * @Cache(expires="+2 hours", public=false)
     *
     * @param Request  $request      Current request instance.
     * @param string  $sort         Sorting field.
     * @param string  $sortdir      Sorting direction.
     * @param int     $pos          Current pager position.
     * @param int     $num          Amount of entries to display.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     */
    public function viewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return $this->viewInternal($request, $sort, $sortdir, $pos, $num, false);
    }
    
    /**
     * This method includes the common implementation code for adminView() and view().
     */
    protected function viewInternal(Request $request, $sort, $sortdir, $pos, $num, $isAdmin = false)
    {
        $controllerHelper = $this->get('mu_muimage_module.controller_helper');
        
        // parameter specifying which type of objects we are treating
        $objectType = 'album';
        $utilArgs = ['controller' => 'album', 'action' => 'view'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_READ;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        // temporary workarounds
        // let repository know if we are in admin or user area
        $request->query->set('lct', $isAdmin ? 'admin' : 'user');
        // let entities know if we are in admin or user area
        System::queryStringSetVar('lct', $isAdmin ? 'admin' : 'user');
        
        $repository = $this->get('mu_muimage_module.' . $objectType . '_factory')->getRepository();
        $repository->setRequest($request);
        $viewHelper = $this->get('mu_muimage_module.view_helper');
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        
        // convenience vars to make code clearer
        $currentUrlArgs = [];
        $where = '';
        
        $showOwnEntries = $request->query->getInt('own', $this->getVar('showOnlyOwnEntries', 0));
        $showAllEntries = $request->query->getInt('all', 0);
        
        if (!$showAllEntries) {
            $csv = $request->getRequestFormat() == 'csv' ? 1 : 0;
            if ($csv == 1) {
                $showAllEntries = 1;
            }
        }
        
        $templateParameters['showOwnEntries'] = $showOwnEntries;
        $templateParameters['showAllEntries'] = $showAllEntries;
        if ($showOwnEntries == 1) {
            $currentUrlArgs['own'] = 1;
        }
        if ($showAllEntries == 1) {
            $currentUrlArgs['all'] = 1;
        }
        
        $additionalParameters = $repository->getAdditionalTemplateParameters('controllerAction', $utilArgs);
        
        $resultsPerPage = 0;
        if ($showAllEntries != 1) {
            // the number of items displayed on a page for pagination
            $resultsPerPage = $num;
            if ($resultsPerPage == 0) {
                $resultsPerPage = $this->getVar('pageSize', 10);
            }
        }
        
        // parameter for used sorting field
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
            System::queryStringSetVar('sort', $sort);
            $request->query->set('sort', $sort);
            // set default sorting in route parameters (e.g. for the pager)
            $routeParams = $request->attributes->get('_route_params');
            $routeParams['sort'] = $sort;
            $request->attributes->set('_route_params', $routeParams);
        }
        
        // parameter for used sort order
        $sortdir = strtolower($sortdir);
        
        $sortableColumns = new SortableColumns($this->get('router'), 'mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'view', 'sort', 'sortdir');
        $sortableColumns->addColumns([
            new Column('title'),
            new Column('description'),
            new Column('parent_id'),
            new Column('albumAccess'),
            new Column('passwordAccess'),
            new Column('myFriends'),
            new Column('notInFrontend'),
            new Column('parent'),
            new Column('createdUserId'),
            new Column('createdDate'),
            new Column('updatedUserId'),
            new Column('updatedDate'),
        ]);
        $sortableColumns->setOrderBy($sortableColumns->getColumn($sort), strtoupper($sortdir));
        
        $additionalUrlParameters = [
            'all' => $showAllEntries,
            'own' => $showOwnEntries,
            'pageSize' => $resultsPerPage
        ];
        $additionalUrlParameters = array_merge($additionalUrlParameters, $additionalParameters);
        $sortableColumns->setAdditionalUrlParameters($additionalUrlParameters);
        
        $selectionArgs = [
            'ot' => $objectType,
            'where' => $where,
            'orderBy' => $sort . ' ' . $sortdir
        ];
        if ($showAllEntries == 1) {
            // retrieve item list without pagination
            $entities = ModUtil::apiFunc($this->name, 'selection', 'getEntities', $selectionArgs);
        } else {
            // the current offset which is used to calculate the pagination
            $currentPage = $pos;
        
            // retrieve item list with pagination
            $selectionArgs['currentPage'] = $currentPage;
            $selectionArgs['resultsPerPage'] = $resultsPerPage;
            list($entities, $objectCount) = ModUtil::apiFunc($this->name, 'selection', 'getEntitiesPaginated', $selectionArgs);
        
            $templateParameters['currentPage'] = $currentPage;
            $templateParameters['pager'] = ['numitems' => $objectCount, 'itemsperpage' => $resultsPerPage];
        }
        
        foreach ($entities as $k => $entity) {
            $entity->initWorkflow();
        }
        
        // build ModUrl instance for display hooks
        $currentUrlObject = new ModUrl($this->name, 'album', 'view', ZLanguage::getLanguageCode(), $currentUrlArgs);
        
        $templateParameters['items'] = $entities;
        $templateParameters['sort'] = $sort;
        $templateParameters['sdir'] = $sortdir;
        $templateParameters['pagesize'] = $resultsPerPage;
        $templateParameters['currentUrlObject'] = $currentUrlObject;
        $templateParameters = array_merge($templateParameters, $additionalParameters);
        
        $formOptions = [
            'all' => $templateParameters['showAllEntries'],
            'own' => $templateParameters['showOwnEntries']
        ];
        $form = $this->createForm('MU\MUImageModule\Form\Type\QuickNavigation\\' . ucfirst($objectType) . 'QuickNavType', $templateParameters, $formOptions);
        
        $templateParameters['sort'] = $sortableColumns->generateSortableColumns();
        $templateParameters['quickNavForm'] = $form->createView();
        
        
        
        $modelHelper = $this->get('mu_muimage_module.model_helper');
        $templateParameters['canBeCreated'] = $modelHelper->canBeCreated($objectType);
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->get('twig'), $objectType, 'view', $request, $templateParameters);
    }
    /**
     * This action provides a item detail view in the admin area.
     * @Theme("admin")
     * @ParamConverter("album", class="MUMUImageModule:AlbumEntity", options={"id" = "id", "repository_method" = "selectById"})
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     * @param AlbumEntity $album      Treated album instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by param converter if item to be displayed isn't found.
     */
    public function adminDisplayAction(Request $request, AlbumEntity $album)
    {
        return $this->displayInternal($request, $album, true);
    }
    
    /**
     * This action provides a item detail view.
     * @ParamConverter("album", class="MUMUImageModule:AlbumEntity", options={"id" = "id", "repository_method" = "selectById"})
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     * @param AlbumEntity $album      Treated album instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by param converter if item to be displayed isn't found.
     */
    public function displayAction(Request $request, AlbumEntity $album)
    {
        return $this->displayInternal($request, $album, false);
    }
    
    /**
     * This method includes the common implementation code for adminDisplay() and display().
     */
    protected function displayInternal(Request $request, AlbumEntity $album, $isAdmin = false)
    {
        $controllerHelper = $this->get('mu_muimage_module.controller_helper');
        
        // parameter specifying which type of objects we are treating
        $objectType = 'album';
        $utilArgs = ['controller' => 'album', 'action' => 'display'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_READ;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        // temporary workarounds
        // let repository know if we are in admin or user area
        $request->query->set('lct', $isAdmin ? 'admin' : 'user');
        // let entities know if we are in admin or user area
        System::queryStringSetVar('lct', $isAdmin ? 'admin' : 'user');
        
        $repository = $this->get('mu_muimage_module.' . $objectType . '_factory')->getRepository();
        $repository->setRequest($request);
        
        $entity = $album;
        
        
        $entity->initWorkflow();
        
        // build ModUrl instance for display hooks; also create identifier for permission check
        $currentUrlArgs = $entity->createUrlArgs();
        $instanceId = $entity->createCompositeIdentifier();
        $currentUrlArgs['id'] = $instanceId; // TODO remove this
        $currentUrlObject = new ModUrl($this->name, 'album', 'display', ZLanguage::getLanguageCode(), $currentUrlArgs);
        
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', $instanceId . '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        
        $viewHelper = $this->get('mu_muimage_module.view_helper');
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        $templateParameters[$objectType] = $entity;
        $templateParameters['currentUrlObject'] = $currentUrlObject;
        $templateParameters = array_merge($templateParameters, $repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->get('twig'), $objectType, 'display', $request, $templateParameters);
    }
    /**
     * This action provides a handling of edit requests in the admin area.
     * @Theme("admin")
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found.
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available).
     */
    public function adminEditAction(Request $request)
    {
        return $this->editInternal($request, true);
    }
    
    /**
     * This action provides a handling of edit requests.
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found.
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available).
     */
    public function editAction(Request $request)
    {
        return $this->editInternal($request, false);
    }
    
    /**
     * This method includes the common implementation code for adminEdit() and edit().
     */
    protected function editInternal(Request $request, $isAdmin = false)
    {
        $controllerHelper = $this->get('mu_muimage_module.controller_helper');
        
        // parameter specifying which type of objects we are treating
        $objectType = 'album';
        $utilArgs = ['controller' => 'album', 'action' => 'edit'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        // temporary workarounds
        // let repository know if we are in admin or user area
        $request->query->set('lct', $isAdmin ? 'admin' : 'user');
        // let entities know if we are in admin or user area
        System::queryStringSetVar('lct', $isAdmin ? 'admin' : 'user');
        
        $repository = $this->get('mu_muimage_module.' . $objectType . '_factory')->getRepository();
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        $templateParameters = array_merge($templateParameters, $repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
        
        // delegate form processing to the form handler
        $formHandler = $this->get('mu_muimage_module.form.handler.album');
        $formHandler->processForm($templateParameters);
        
        $viewHelper = $this->get('mu_muimage_module.view_helper');
        $templateParameters = $formHandler->getTemplateParameters();
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->get('twig'), $objectType, 'edit', $request, $templateParameters);
    }
    /**
     * This action provides a handling of simple delete requests in the admin area.
     * @Theme("admin")
     * @ParamConverter("album", class="MUMUImageModule:AlbumEntity", options={"id" = "id", "repository_method" = "selectById"})
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     * @param AlbumEntity $album      Treated album instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by param converter if item to be deleted isn't found.
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available).
     */
    public function adminDeleteAction(Request $request, AlbumEntity $album)
    {
        return $this->deleteInternal($request, $album, true);
    }
    
    /**
     * This action provides a handling of simple delete requests.
     * @ParamConverter("album", class="MUMUImageModule:AlbumEntity", options={"id" = "id", "repository_method" = "selectById"})
     * @Cache(lastModified="album.getUpdatedDate()", ETag="'Album' ~ album.getid() ~ album.getUpdatedDate().format('U')")
     *
     * @param Request  $request      Current request instance.
     * @param AlbumEntity $album      Treated album instance.
     *
     * @return mixed Output.
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions.
     * @throws NotFoundHttpException Thrown by param converter if item to be deleted isn't found.
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available).
     */
    public function deleteAction(Request $request, AlbumEntity $album)
    {
        return $this->deleteInternal($request, $album, false);
    }
    
    /**
     * This method includes the common implementation code for adminDelete() and delete().
     */
    protected function deleteInternal(Request $request, AlbumEntity $album, $isAdmin = false)
    {
        $controllerHelper = $this->get('mu_muimage_module.controller_helper');
        
        // parameter specifying which type of objects we are treating
        $objectType = 'album';
        $utilArgs = ['controller' => 'album', 'action' => 'delete'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_DELETE;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        $entity = $album;
        
        $flashBag = $request->getSession()->getFlashBag();
        $logger = $this->get('logger');
        $logArgs = ['app' => 'MUMUImageModule', 'user' => $this->get('zikula_users_module.current_user')->get('uname'), 'entity' => 'album', 'id' => $entity->createCompositeIdentifier()];
        
        $entity->initWorkflow();
        
        // determine available workflow actions
        $workflowHelper = $this->get('mu_muimage_module.workflow_helper');
        $actions = $workflowHelper->getActionsForObject($entity);
        if ($actions === false || !is_array($actions)) {
            $flashBag->add(\Zikula_Session::MESSAGE_ERROR, $this->__('Error! Could not determine workflow actions.'));
            $logger->error('{app}: User {user} tried to delete the {entity} with id {id}, but failed to determine available workflow actions.', $logArgs);
            throw new \RuntimeException($this->__('Error! Could not determine workflow actions.'));
        }
        
        if ($isAdmin) {
            // redirect to the list of albums
            $redirectRoute = 'mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'view';
        } else {
            // redirect to the list of albums
            $redirectRoute = 'mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'view';
        }
        
        // check whether deletion is allowed
        $deleteActionId = 'delete';
        $deleteAllowed = false;
        foreach ($actions as $actionId => $action) {
            if ($actionId != $deleteActionId) {
                continue;
            }
            $deleteAllowed = true;
            break;
        }
        if (!$deleteAllowed) {
            $flashBag->add(\Zikula_Session::MESSAGE_ERROR, $this->__('Error! It is not allowed to delete this album.'));
            $logger->error('{app}: User {user} tried to delete the {entity} with id {id}, but this action was not allowed.', $logArgs);
        
            return $this->redirectToRoute($redirectRoute);
        }
        
        $form = $this->createForm('MU\MUImageModule\Form\DeleteEntityType', $entity);
        
        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $hookHelper = $this->get('mu_muimage_module.hook_helper');
                // Let any hooks perform additional validation actions
                $hookType = 'validate_delete';
                $validationHooksPassed = $hookHelper->callValidationHooks($entity, $hookType);
                if ($validationHooksPassed) {
                    // execute the workflow action
                    $success = $workflowHelper->executeAction($entity, $deleteActionId);
                    if ($success) {
                        $flashBag->add(\Zikula_Session::MESSAGE_STATUS, $this->__('Done! Item deleted.'));
                        $logger->notice('{app}: User {user} deleted the {entity} with id {id}.', $logArgs);
                    }
                    
                    // Let any hooks know that we have deleted the album
                    $hookType = 'process_delete';
                    $hookHelper->callProcessHooks($entity, $hookType, null);
                    
                    return $this->redirectToRoute($redirectRoute);
                }
            } elseif ($form->get('cancel')->isClicked()) {
                $this->addFlash(\Zikula_Session::MESSAGE_STATUS, $this->__('Operation cancelled.'));
        
                return $this->redirectToRoute($redirectRoute);
            }
        }
        
        $repository = $this->get('mu_muimage_module.' . $objectType . '_factory')->getRepository();
        
        $viewHelper = $this->get('mu_muimage_module.view_helper');
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : '',
            'deleteForm' => $form->createView()
        ];
        
        $templateParameters[$objectType] = $entity;
        $templateParameters = array_merge($templateParameters, $repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->get('twig'), $objectType, 'delete', $request, $templateParameters);
    }

    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @param Request $request Current request instance.
     *
     * @return bool true on sucess, false on failure.
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    public function adminHandleSelectedEntriesAction(Request $request)
    {
        return $this->handleSelectedEntriesActionInternal($request, true);
    }
    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @param Request $request Current request instance.
     *
     * @return bool true on sucess, false on failure.
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    public function handleSelectedEntriesAction(Request $request)
    {
        return $this->handleSelectedEntriesActionInternal($request, false);
    }
    
    /**
     * This method includes the common implementation code for adminHandleSelectedEntriesAction() and handleSelectedEntriesAction().
     */
    protected function handleSelectedEntriesActionInternal(Request $request, $isAdmin = false)
    {
        $objectType = 'album';
        
        // Get parameters
        $action = $request->request->get('action', null);
        $items = $request->request->get('items', null);
        
        $action = strtolower($action);
        
        $workflowHelper = $this->get('mu_muimage_module.workflow_helper');
        $hookHelper = $this->get('mu_muimage_module.hook_helper');
        $flashBag = $request->getSession()->getFlashBag();
        $logger = $this->get('logger');
        $userName = $this->get('zikula_users_module.current_user')->get('uname');
        
        // process each item
        foreach ($items as $itemid) {
            // check if item exists, and get record instance
            $selectionArgs = [
                'ot' => $objectType,
                'id' => $itemid,
                'useJoins' => false
            ];
            $entity = ModUtil::apiFunc($this->name, 'selection', 'getEntity', $selectionArgs);
        
            $entity->initWorkflow();
        
            // check if $action can be applied to this entity (may depend on it's current workflow state)
            $allowedActions = $workflowHelper->getActionsForObject($entity);
            $actionIds = array_keys($allowedActions);
            if (!in_array($action, $actionIds)) {
                // action not allowed, skip this object
                continue;
            }
        
            // Let any hooks perform additional validation actions
            $hookType = $action == 'delete' ? 'validate_delete' : 'validate_edit';
            $validationHooksPassed = $hookHelper->callValidationHooks($entity, $hookType);
            if (!$validationHooksPassed) {
                continue;
            }
        
            $success = false;
            try {
                if (!$entity->validate()) {
                    continue;
                }
                // execute the workflow action
                $success = $workflowHelper->executeAction($entity, $action);
            } catch(\Exception $e) {
                $flashBag->add(\Zikula_Session::MESSAGE_ERROR, $this->__f('Sorry, but an unknown error occured during the %s action. Please apply the changes again!', [$action]));
                $logger->error('{app}: User {user} tried to execute the {action} workflow action for the {entity} with id {id}, but failed. Error details: {errorMessage}.', ['app' => 'MUMUImageModule', 'user' => $userName, 'action' => $action, 'entity' => 'album', 'id' => $itemid, 'errorMessage' => $e->getMessage()]);
            }
        
            if (!$success) {
                continue;
            }
        
            if ($action == 'delete') {
                $flashBag->add(\Zikula_Session::MESSAGE_STATUS, $this->__('Done! Item deleted.'));
                $logger->notice('{app}: User {user} deleted the {entity} with id {id}.', ['app' => 'MUMUImageModule', 'user' => $userName, 'entity' => 'album', 'id' => $itemid]);
            } else {
                $flashBag->add(\Zikula_Session::MESSAGE_STATUS, $this->__('Done! Item updated.'));
                $logger->notice('{app}: User {user} executed the {action} workflow action for the {entity} with id {id}.', ['app' => 'MUMUImageModule', 'user' => $userName, 'action' => $action, 'entity' => 'album', 'id' => $itemid]);
            }
        
            // Let any hooks know that we have updated or deleted an item
            $hookType = $action == 'delete' ? 'process_delete' : 'process_edit';
            $url = null;
            if ($action != 'delete') {
                $urlArgs = $entity->createUrlArgs();
                $url = new RouteUrl('mumuimagemodule_album_' . /*($isAdmin ? 'admin' : '') . */'display', $urlArgs);
            }
            $hookHelper->callProcessHooks($entity, $hookType, $url);
        }
        
        return $this->redirectToRoute('mumuimagemodule_album_' . ($isAdmin ? 'admin' : '') . 'index');
    }
}
