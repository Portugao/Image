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

namespace MU\ImageModule\Form\Handler\Picture\Base;

use MU\ImageModule\Form\Handler\Common\EditHandler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use RuntimeException;
use MU\ImageModule\Helper\FeatureActivationHelper;

/**
 * This handler class handles the page events of editing forms.
 * It aims on the picture object type.
 */
abstract class AbstractEditHandler extends EditHandler
{
    /**
     * Initialise form handler.
     *
     * This method takes care of all necessary initialisation of our data and form states.
     *
     * @param array $templateParameters List of preassigned template variables
     *
     * @return boolean False in case of initialisation errors, otherwise true
     */
    public function processForm(array $templateParameters)
    {
        $this->objectType = 'picture';
        $this->objectTypeCapital = 'Picture';
        $this->objectTypeLower = 'picture';
        
        $this->hasPageLockSupport = true;
    
        $result = parent::processForm($templateParameters);
        if ($result instanceof RedirectResponse) {
            return $result;
        }
    
        if ($this->templateParameters['mode'] == 'create') {
            if (!$this->modelHelper->canBeCreated($this->objectType)) {
                $this->request->getSession()->getFlashBag()->add('error', $this->__('Sorry, but you can not create the picture yet as other items are required which must be created before!'));
                $logArgs = ['app' => 'MUImageModule', 'user' => $this->currentUserApi->get('uname'), 'entity' => $this->objectType];
                $this->logger->notice('{app}: User {user} tried to create a new {entity}, but failed as it other items are required which must be created before.', $logArgs);
    
                return new RedirectResponse($this->getRedirectUrl(['commandName' => '']), 302);
            }
        }
    
        $entityData = $this->entityRef->toArray();
    
        // assign data to template as array (for additions like standard fields)
        $this->templateParameters[$this->objectTypeLower] = $entityData;
    
        return $result;
    }
    
    /**
     * Initialises relationship presets.
     */
    protected function initRelationPresets()
    {
        $entity = $this->entityRef;
    
        
        // assign identifiers of predefined incoming relationships
        // editable relation, we store the id and assign it now to show it in UI
        $this->relationPresets['album'] = $this->request->get('album', '');
        if (!empty($this->relationPresets['album'])) {
            $relObj = $this->entityFactory->getRepository('album')->selectById($this->relationPresets['album']);
            if (null !== $relObj) {
                $relObj->addPictures($entity);
            }
        }
    
        // save entity reference for later reuse
        $this->entityRef = $entity;
    }
    
    /**
     * Creates the form type.
     */
    protected function createForm()
    {
        $options = [
            'entity' => $this->entityRef,
            'mode' => $this->templateParameters['mode'],
            'actions' => $this->templateParameters['actions'],
            'has_moderate_permission' => $this->permissionApi->hasPermission($this->permissionComponent, $this->idValue . '::', ACCESS_MODERATE),
            'filter_by_ownership' => !$this->permissionApi->hasPermission($this->permissionComponent, $this->idValue . '::', ACCESS_ADD)
        ];
    
        return $this->formFactory->create('MU\ImageModule\Form\Type\PictureType', $this->entityRef, $options);
    }


    /**
     * Get list of allowed redirect codes.
     *
     * @return array list of possible redirect codes
     */
    protected function getRedirectCodes()
    {
        $codes = parent::getRedirectCodes();
    
        // user index page of picture area
        $codes[] = 'userIndex';
        // admin index page of picture area
        $codes[] = 'adminIndex';
        // user list of pictures
        $codes[] = 'userView';
        // admin list of pictures
        $codes[] = 'adminView';
        // user list of own pictures
        $codes[] = 'userOwnView';
        // admin list of own pictures
        $codes[] = 'adminOwnView';
        // user detail page of treated picture
        $codes[] = 'userDisplay';
        // admin detail page of treated picture
        $codes[] = 'adminDisplay';
    
        // user list of albums
        $codes[] = 'userViewAlbums';
        // admin list of albums
        $codes[] = 'adminViewAlbums';
        // user list of own albums
        $codes[] = 'userOwnViewAlbums';
        // admin list of own albums
        $codes[] = 'adminOwnViewAlbums';
        // user detail page of related album
        $codes[] = 'userDisplayAlbum';
        // admin detail page of related album
        $codes[] = 'adminDisplayAlbum';
    
        return $codes;
    }

    /**
     * Get the default redirect url. Required if no returnTo parameter has been supplied.
     * This method is called in handleCommand so we know which command has been performed.
     *
     * @param array $args List of arguments
     *
     * @return string The default redirect url
     */
    protected function getDefaultReturnUrl($args)
    {
        $objectIsPersisted = $args['commandName'] != 'delete' && !($this->templateParameters['mode'] == 'create' && $args['commandName'] == 'cancel');
    
        if (null !== $this->returnTo) {
            $isDisplayOrEditPage = substr($this->returnTo, -7) == 'display' || substr($this->returnTo, -4) == 'edit';
            if (!$isDisplayOrEditPage || $objectIsPersisted) {
                // return to referer
                return $this->returnTo;
            }
        }
    
        $routeArea = array_key_exists('routeArea', $this->templateParameters) ? $this->templateParameters['routeArea'] : '';
        $routePrefix = 'muimagemodule_' . $this->objectTypeLower . '_' . $routeArea;
    
        // redirect to the list of pictures
        $url = $this->router->generate($routePrefix . 'view');
    
        return $url;
    }

    /**
     * Command event handler.
     *
     * This event handler is called when a command is issued by the user.
     *
     * @param array $args List of arguments
     *
     * @return mixed Redirect or false on errors
     */
    public function handleCommand($args = [])
    {
        $result = parent::handleCommand($args);
        if (false === $result) {
            return $result;
        }
    
        // build $args for BC (e.g. used by redirect handling)
        foreach ($this->templateParameters['actions'] as $action) {
            if ($this->form->get($action['id'])->isClicked()) {
                $args['commandName'] = $action['id'];
            }
        }
        if ($this->form->get('cancel')->isClicked()) {
            $args['commandName'] = 'cancel';
        }
    
        return new RedirectResponse($this->getRedirectUrl($args), 302);
    }
    
    /**
     * Get success or error message for default operations.
     *
     * @param array   $args    Arguments from handleCommand method
     * @param Boolean $success Becomes true if this is a success, false for default error
     *
     * @return String desired status or error message
     */
    protected function getDefaultMessage($args, $success = false)
    {
        if (false === $success) {
            return parent::getDefaultMessage($args, $success);
        }
    
        $message = '';
        switch ($args['commandName']) {
            case 'submit':
                if ($this->templateParameters['mode'] == 'create') {
                    $message = $this->__('Done! Picture created.');
                } else {
                    $message = $this->__('Done! Picture updated.');
                }
                break;
            case 'delete':
                $message = $this->__('Done! Picture deleted.');
                break;
            default:
                $message = $this->__('Done! Picture updated.');
                break;
        }
    
        return $message;
    }

    /**
     * This method executes a certain workflow action.
     *
     * @param array $args Arguments from handleCommand method
     *
     * @return bool Whether everything worked well or not
     *
     * @throws RuntimeException Thrown if concurrent editing is recognised or another error occurs
     */
    public function applyAction(array $args = [])
    {
        // get treated entity reference from persisted member var
        $entity = $this->entityRef;
    
        $action = $args['commandName'];
    
        $success = false;
        $flashBag = $this->request->getSession()->getFlashBag();
        try {
            // execute the workflow action
            $success = $this->workflowHelper->executeAction($entity, $action);
        } catch(\Exception $exception) {
            $flashBag->add('error', $this->__f('Sorry, but an error occured during the %action% action. Please apply the changes again!', ['%action%' => $action]) . ' ' . $exception->getMessage());
            $logArgs = ['app' => 'MUImageModule', 'user' => $this->currentUserApi->get('uname'), 'entity' => 'picture', 'id' => $entity->getKey(), 'errorMessage' => $exception->getMessage()];
            $this->logger->error('{app}: User {user} tried to edit the {entity} with id {id}, but failed. Error details: {errorMessage}.', $logArgs);
        }
    
        $this->addDefaultMessage($args, $success);
    
        if ($success && $this->templateParameters['mode'] == 'create') {
            // store new identifier
            $this->idValue = $entity->getKey();
        }
    
        return $success;
    }

    /**
     * Get url to redirect to.
     *
     * @param array $args List of arguments
     *
     * @return string The redirect url
     */
    protected function getRedirectUrl($args)
    {
        if ($this->repeatCreateAction) {
            return $this->repeatReturnUrl;
        }
    
        if ($this->request->getSession()->has('muimagemodule' . $this->objectTypeCapital . 'Referer')) {
            $this->request->getSession()->del('muimagemodule' . $this->objectTypeCapital . 'Referer');
        }
    
        // normal usage, compute return url from given redirect code
        if (!in_array($this->returnTo, $this->getRedirectCodes())) {
            // invalid return code, so return the default url
            return $this->getDefaultReturnUrl($args);
        }
    
        $routeArea = substr($this->returnTo, 0, 5) == 'admin' ? 'admin' : '';
        $routePrefix = 'muimagemodule_' . $this->objectTypeLower . '_' . $routeArea;
    
        // parse given redirect code and return corresponding url
        switch ($this->returnTo) {
            case 'userIndex':
            case 'adminIndex':
                return $this->router->generate($routePrefix . 'index');
            case 'userView':
            case 'adminView':
                return $this->router->generate($routePrefix . 'view');
            case 'userOwnView':
            case 'adminOwnView':
                return $this->router->generate($routePrefix . 'view', [ 'own' => 1 ]);
            case 'userDisplay':
            case 'adminDisplay':
                if ($args['commandName'] != 'delete' && !($this->templateParameters['mode'] == 'create' && $args['commandName'] == 'cancel')) {
                    return $this->router->generate($routePrefix . 'display', $this->entityRef->createUrlArgs());
                }
    
                return $this->getDefaultReturnUrl($args);
            case 'userViewAlbums':
            case 'adminViewAlbums':
                return $this->router->generate('muimagemodule_album_' . $routeArea . 'view');
            case 'userOwnViewAlbums':
            case 'adminOwnViewAlbums':
                return $this->router->generate('muimagemodule_album_' . $routeArea . 'view', ['own' => 1]);
            case 'userDisplayAlbum':
            case 'adminDisplayAlbum':
                if (!empty($this->relationPresets['album'])) {
                    return $this->router->generate('muimagemodule_album_' . $routeArea . 'display',  ['id' => $this->relationPresets['album']]);
                }
    
                return $this->getDefaultReturnUrl($args);
            default:
                return $this->getDefaultReturnUrl($args);
        }
    }
}
