<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\ImageModule\Controller;

use MU\ImageModule\Controller\Base\AbstractPictureController;

use RuntimeException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zikula\ThemeModule\Engine\Annotation\Theme;
use MU\ImageModule\Entity\PictureEntity;

/**
 * Picture controller class providing navigation and interaction functionality.
 */
class PictureController extends AbstractPictureController
{
    /**
     * @inheritDoc
     *
     * @Route("/admin/pictures",
     *        methods = {"GET"}
     * )
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminIndexAction(Request $request)
    {
        return parent::adminIndexAction($request);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/pictures",
     *        methods = {"GET"}
     * )
     *
     * @param Request $request Current request instance
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/pictures/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|rss"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     * @param string $sort         Sorting field
     * @param string $sortdir      Sorting direction
     * @param int    $pos          Current pager position
     * @param int    $num          Amount of entries to display
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminViewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::adminViewAction($request, $sort, $sortdir, $pos, $num);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/pictures/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|rss"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     *
     * @param Request $request Current request instance
     * @param string $sort         Sorting field
     * @param string $sortdir      Sorting direction
     * @param int    $pos          Current pager position
     * @param int    $num          Amount of entries to display
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function viewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::viewAction($request, $sort, $sortdir, $pos, $num);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/picture/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     * @ParamConverter("picture", class="MUImageModule:PictureEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Theme("admin")
     *
     * @param Request $request Current request instance
     * @param integer $id Identifier of treated picture instance
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if picture to be displayed isn't found
     */
    public function adminDisplayAction(Request $request, $id)
    {
        return parent::adminDisplayAction($request, $id);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/picture/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     * @ParamConverter("picture", class="MUImageModule:PictureEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     *
     * @param Request $request Current request instance
     * @param integer $id Identifier of treated picture instance
     *
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if picture to be displayed isn't found
     */
    public function displayAction(Request $request, $id)
    {
        return parent::displayAction($request, $id);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/picture/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @Theme("admin")
     */
    public function adminEditAction(Request $request)
    {
        return parent::adminEditAction($request);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/picture/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     */
    public function editAction(Request $request)
    {
        return parent::editAction($request);
    }
    /**
     * @inheritDoc
     *
     * @Route("/admin/picture/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @ParamConverter("picture", class="MUImageModule:PictureEntity", options = {"repository_method" = "selectById", "mapping": {"id": "id"}, "map_method_signature" = true})
     * @Theme("admin")
     */
    public function adminDeleteAction(Request $request, $id)
    {
        return parent::adminDeleteAction($request, $id);
    }
    
    /**
     * @inheritDoc
     *
     * @Route("/picture/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::deleteAction($request, $id);
    }

    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @Route("/admin/pictures/handleSelectedEntries",
     *        methods = {"POST"}
     * )
     * @Theme("admin")
     */
    public function adminHandleSelectedEntriesAction(Request $request)
    {
        return parent::adminHandleSelectedEntriesAction($request);
    }
    
    /**
     * Process status changes for multiple items.
     *
     * This function processes the items selected in the admin view page.
     * Multiple items may have their state changed or be deleted.
     *
     * @Route("/pictures/handleSelectedEntries",
     *        methods = {"POST"}
     * )
     *
     */
    public function handleSelectedEntriesAction(Request $request)
    {
        return parent::handleSelectedEntriesAction($request);
    }
    
    /**
     * This action provides a handling of edit requests.
     *
     * @Route("/picture/multiupload/{albumid}.{_format}",
     *        requirements = {"albumid" = "\d+", "_format" = "html"},
     *        defaults = {"albumid" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     */
    public function multiuploadAction(Request $request)
    {
    	return self::multiuploadInternal($request);
    }
    
    /**
     * This action provides a handling of edit requests.
     *
     * @Route("/picture/zipupload/{albumid}.{_format}",
     *        requirements = {"albumid" = "\d+", "_format" = "html"},
     *        defaults = {"albumid" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     */
    public function zipuploadAction(Request $request)
    {
    	return self::zipuploadInternal($request);
    }
    
    /**
     * This method includes the common implementation code for adminView() and view().
     */
    protected function viewInternal(Request $request, $sort, $sortdir, $pos, $num, $isAdmin = false)
    {
    	$num = $isAdmin ? $this->getVar('MUImageModule', 'pictureEntriesPerPageInBackend') : $this->getVar('MUImageModule', 'pictureEntriesPerPage');
    	return parent::viewInternal($request, $sort, $sortdir, $pos, $num, $isAdmin);
    }
    
    /**
     * This method includes the common implementation code for multiupload().
     */
    protected function multiuploadInternal(Request $request, $isAdmin = false)
    {
    	// parameter specifying which type of objects we are treating
    	$objectType = 'picture';
    	$permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
    	if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
    		throw new AccessDeniedException();
    	}
    	$templateParameters = [
    			'routeArea' => $isAdmin ? 'admin' : ''
    	];
    
    	$controllerHelper = $this->get('mu_image_module.controller_helper');
    	$templateParameters = $controllerHelper->processEditActionParameters($objectType, $templateParameters);
    
    	// delegate form processing to the form handler
    	$formHandler = $this->get('mu_image_module.form.handler.multipicture');
    	$result = $formHandler->processForm($templateParameters);
    	if ($result instanceof RedirectResponse) {
    		return $result;
    	}
    
    	$templateParameters = $formHandler->getTemplateParameters();
    
    	// fetch and return the appropriate template
    	return $this->get('mu_image_module.view_helper')->processTemplate($objectType, 'multiupload', $templateParameters);
    }
    
    /**
     * This method includes the common implementation code for multiupload().
     */
    protected function zipuploadInternal(Request $request, $isAdmin = false)
    {
    	// parameter specifying which type of objects we are treating
    	$objectType = 'picture';
    	$permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
    	if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
    		throw new AccessDeniedException();
    	}
    	$templateParameters = [
    			'routeArea' => $isAdmin ? 'admin' : ''
    	];
    
    	$controllerHelper = $this->get('mu_image_module.controller_helper');
    	$templateParameters = $controllerHelper->processEditActionParameters($objectType, $templateParameters);
    
    	// delegate form processing to the form handler
    	$formHandler = $this->get('mu_image_module.form.handler.picture');
    	$result = $formHandler->processForm($templateParameters);
    	if ($result instanceof RedirectResponse) {
    		return $result;
    	}
    
    	$templateParameters = $formHandler->getTemplateParameters();
    
    	// fetch and return the appropriate template
    	return $this->get('mu_image_module.view_helper')->processTemplate($objectType, 'zipupload', $templateParameters);
    }

    // feel free to add your own controller methods here
}
