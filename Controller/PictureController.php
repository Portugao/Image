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

namespace MU\ImageModule\Controller;

use MU\ImageModule\Controller\Base\AbstractPictureController;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Zikula\ThemeModule\Engine\Annotation\Theme;
use MU\ImageModule\Entity\PictureEntity;

/**
 * Picture controller class providing navigation and interaction functionality.
 */
class PictureController extends AbstractPictureController
{
    /**
     * This is the default action handling the main admin area called without defining arguments.
     *
     * @Route("/admin/pictures",
     *        methods = {"GET"}
     * )
     * @Theme("admin")
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminIndexAction(Request $request)
    {
        return parent::adminIndexAction($request);
    }
    
    /**
     * This is the default action handling the main area called without defining arguments.
     *
     * @Route("/pictures",
     *        methods = {"GET"}
     * )
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }
    /**
     * This action provides an item list overview in the admin area.
     *
     * @Route("/admin/pictures/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|rss"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     * @Theme("admin")
     *
     * @param Request  $request      Current request instance
     * @param string  $sort         Sorting field
     * @param string  $sortdir      Sorting direction
     * @param int     $pos          Current pager position
     * @param int     $num          Amount of entries to display
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function adminViewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::adminViewAction($request, $sort, $sortdir, $pos, $num);
    }
    
    /**
     * This action provides an item list overview.
     *
     * @Route("/pictures/view/{sort}/{sortdir}/{pos}/{num}.{_format}",
     *        requirements = {"sortdir" = "asc|desc|ASC|DESC", "pos" = "\d+", "num" = "\d+", "_format" = "html|rss"},
     *        defaults = {"sort" = "", "sortdir" = "asc", "pos" = 1, "num" = 10, "_format" = "html"},
     *        methods = {"GET"}
     * )
     *
     * @param Request  $request      Current request instance
     * @param string  $sort         Sorting field
     * @param string  $sortdir      Sorting direction
     * @param int     $pos          Current pager position
     * @param int     $num          Amount of entries to display
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function viewAction(Request $request, $sort, $sortdir, $pos, $num)
    {
        return parent::viewAction($request, $sort, $sortdir, $pos, $num);
    }
    /**
     * This action provides a item detail view in the admin area.
     *
     * @Route("/admin/picture/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     * @Theme("admin")
     *
     * @param Request  $request      Current request instance
     * @param PictureEntity $picture      Treated picture instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if item to be displayed isn't found
     */
    public function adminDisplayAction(Request $request, PictureEntity $picture)
    {
        return parent::adminDisplayAction($request, $picture);
    }
    
    /**
     * This action provides a item detail view.
     *
     * @Route("/picture/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET"}
     * )
     *
     * @param Request  $request      Current request instance
     * @param PictureEntity $picture      Treated picture instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if item to be displayed isn't found
     */
    public function displayAction(Request $request, PictureEntity $picture)
    {
        return parent::displayAction($request, $picture);
    }
    /**
     * This action provides a handling of edit requests in the admin area.
     *
     * @Route("/admin/picture/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @Theme("admin")
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function adminEditAction(Request $request)
    {
        return parent::adminEditAction($request);
    }
    
    /**
     * This action provides a handling of edit requests.
     *
     * @Route("/picture/edit/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"id" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function editAction(Request $request)
    {
        return parent::editAction($request);
    }
    
    /**
     * This action provides a handling of edit requests.
     *
     * @Route("/picture/multiupload/{albumid}.{_format}",
     *        requirements = {"albumid" = "\d+", "_format" = "html"},
     *        defaults = {"albumid" = "0", "_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
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
     *
     * @param Request  $request      Current request instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by form handler if item to be edited isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function zipuploadAction(Request $request)
    {
    	return self::zipuploadInternal($request);
    }
    /**
     * This action provides a handling of simple delete requests in the admin area.
     *
     * @Route("/admin/picture/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     * @Theme("admin")
     *
     * @param Request  $request      Current request instance
     * @param PictureEntity $picture      Treated picture instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if item to be deleted isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function adminDeleteAction(Request $request, PictureEntity $picture)
    {
        return parent::adminDeleteAction($request, $picture);
    }
    
    /**
     * This action provides a handling of simple delete requests.
     *
     * @Route("/picture/delete/{id}.{_format}",
     *        requirements = {"id" = "\d+", "_format" = "html"},
     *        defaults = {"_format" = "html"},
     *        methods = {"GET", "POST"}
     * )
     *
     * @param Request  $request      Current request instance
     * @param PictureEntity $picture      Treated picture instance
     *
     * @return mixed Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     * @throws NotFoundHttpException Thrown by param converter if item to be deleted isn't found
     * @throws RuntimeException      Thrown if another critical error occurs (e.g. workflow actions not available)
     */
    public function deleteAction(Request $request, PictureEntity $picture)
    {
        return parent::deleteAction($request, $picture);
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
     * @param Request $request Current request instance
     *
     * @return bool true on sucess, false on failure
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
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
     * @param Request $request Current request instance
     *
     * @return bool true on sucess, false on failure
     *
     * @throws RuntimeException Thrown if executing the workflow action fails
     */
    public function handleSelectedEntriesAction(Request $request)
    {
        return parent::handleSelectedEntriesAction($request);
    }

    /**
     * This method includes the common implementation code for multiupload().
     */
    protected function multiuploadInternal(Request $request, $isAdmin = false)
    {
        // parameter specifying which type of objects we are treating
        $objectType = 'picture';
        $utilArgs = ['controller' => 'picture', 'action' => 'multiupload'];
        $permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
        if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
            throw new AccessDeniedException();
        }
        $repository = $this->get('mu_image_module.' . $objectType . '_factory')->getRepository();
        
        $templateParameters = [
            'routeArea' => $isAdmin ? 'admin' : ''
        ];
        $imageHelper = $this->get('mu_image_module.image_helper');
        $templateParameters = array_merge($templateParameters, $repository->getAdditionalTemplateParameters($imageHelper, 'controllerAction', $utilArgs));
        
        // delegate form processing to the form handler
        $formHandler = $this->get('mu_image_module.form.handler.picture');
        $result = $formHandler->processForm($templateParameters);
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        
        $viewHelper = $this->get('mu_image_module.view_helper');
        $templateParameters = $formHandler->getTemplateParameters();
        $templateParameters['featureActivationHelper'] = $this->get('mu_image_module.feature_activation_helper');
        
        // fetch and return the appropriate template
        return $viewHelper->processTemplate($this->get('twig'), $objectType, 'multiupload', $request, $templateParameters);
    }
    
    /**
     * This method includes the common implementation code for zipupload().
     */
    protected function zipuploadInternal(Request $request, $isAdmin = false)
    {
    	// parameter specifying which type of objects we are treating
    	$objectType = 'picture';
    	$utilArgs = ['controller' => 'picture', 'action' => 'zipupload'];
    	$permLevel = $isAdmin ? ACCESS_ADMIN : ACCESS_EDIT;
    	if (!$this->hasPermission($this->name . ':' . ucfirst($objectType) . ':', '::', $permLevel)) {
    		throw new AccessDeniedException();
    	}
    	$repository = $this->get('mu_image_module.' . $objectType . '_factory')->getRepository();
    
    	$templateParameters = [
    			'routeArea' => $isAdmin ? 'admin' : ''
    	];
    	$imageHelper = $this->get('mu_image_module.image_helper');
    	$templateParameters = array_merge($templateParameters, $repository->getAdditionalTemplateParameters($imageHelper, 'controllerAction', $utilArgs));
    
    	// delegate form processing to the form handler
    	$formHandler = $this->get('mu_image_module.form.handler.picture');
    	$result = $formHandler->processForm($templateParameters);
    	if ($result instanceof RedirectResponse) {
    		return $result;
    	}
    
    	$viewHelper = $this->get('mu_image_module.view_helper');
    	$templateParameters = $formHandler->getTemplateParameters();
    	$templateParameters['featureActivationHelper'] = $this->get('mu_image_module.feature_activation_helper');
    
    	// fetch and return the appropriate template
    	return $viewHelper->processTemplate($this->get('twig'), $objectType, 'zipupload', $request, $templateParameters);
    }
}
