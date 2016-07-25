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

namespace MU\MUImageModule\Container\Base;

use Symfony\Component\Routing\RouterInterface;
use UserUtil;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\PermissionsModule\Api\PermissionApi;
use MU\MUImageModule\Helper\ControllerHelper;

/**
 * This is the link container service implementation class.
 */
class LinkContainer implements LinkContainerInterface
{
    use TranslatorTrait;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var PermissionApi
     */
    protected $permissionApi;

    /**
     * @var ControllerHelper
     */
    protected $controllerHelper;

    /**
     * Constructor.
     * Initialises member vars.
     *
     * @param TranslatorInterface $translator       Translator service instance.
     * @param Routerinterface     $router           Router service instance.
     * @param PermissionApi       $permissionApi    PermissionApi service instance.
     * @param ControllerHelper    $controllerHelper ControllerHelper service instance.
     */
    public function __construct(TranslatorInterface $translator, RouterInterface $router, PermissionApi $permissionApi, ControllerHelper $controllerHelper)
    {
        $this->setTranslator($translator);
        $this->router = $router;
        $this->permissionApi = $permissionApi;
        $this->controllerHelper = $controllerHelper;
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance.
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Returns available header links.
     *
     * @param string $type The type to collect links for.
     *
     * @return array Array of header links.
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $utilArgs = ['api' => 'linkContainer', 'action' => 'getLinks'];
        $allowedObjectTypes = $this->controllerHelper->getObjectTypes('api', $utilArgs);

        $permLevel = LinkContainerInterface::TYPE_ADMIN == $type ? ACCESS_ADMIN : ACCESS_READ;

        // Create an array of links to return
        $links = [];

        if (LinkContainerInterface::TYPE_ACCOUNT == $type) {
            $useAccountPage = $serviceManager->get('zikula_extensions_module.api.variable')->get('MUMUImageModule', 'useAccountPage', true);
            if ($useAccountPage === false) {
                return $links;
            }

            $userName = (isset($args['uname'])) ? $args['uname'] : $serviceManager->get('zikula_users_module.current_user')->get('uname');
            // does this user exist?
            if (UserUtil::getIdFromName($userName) === false) {
                // user does not exist
                return $links;
            }

            if (!$this->permissionApi->hasPermission($this->name . '::', '::', ACCESS_OVERVIEW)) {
                return $links;
            }

            if ($this->permissionApi->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_admin_index'),
                    'text' => $this->__('Ajax Backend'),
                    'icon' => 'wrench'
                ];
            }

            return $links;
        }

        
        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_user_index'),
                     'text' => $this->__('Frontend'),
                     'title' => $this->__('Switch to user area.'),
                     'icon' => 'home'
                 ];
            }
            
            if (in_array('album', $allowedObjectTypes)
                && $this->permissionApi->hasPermission($this->getBundleName() . ':Album:', '::', $permLevel)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_album_adminview'),
                     'text' => $this->__('Albums'),
                     'title' => $this->__('Album list')
                 ];
            }
            if (in_array('picture', $allowedObjectTypes)
                && $this->permissionApi->hasPermission($this->getBundleName() . ':Picture:', '::', $permLevel)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_picture_adminview'),
                     'text' => $this->__('Pictures'),
                     'title' => $this->__('Picture list')
                 ];
            }
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_admin_config'),
                     'text' => $this->__('Configuration'),
                     'title' => $this->__('Manage settings for this application'),
                     'icon' => 'wrench'
                 ];
            }
        }
        if (LinkContainerInterface::TYPE_USER == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_admin_index'),
                     'text' => $this->__('Backend'),
                     'title' => $this->__('Switch to administration area.'),
                     'icon' => 'wrench'
                 ];
            }
            
            if (in_array('album', $allowedObjectTypes)
                && $this->permissionApi->hasPermission($this->getBundleName() . ':Album:', '::', $permLevel)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_album_view'),
                     'text' => $this->__('Albums'),
                     'title' => $this->__('Album list')
                 ];
            }
            if (in_array('picture', $allowedObjectTypes)
                && $this->permissionApi->hasPermission($this->getBundleName() . ':Picture:', '::', $permLevel)) {
                $links[] = [
                    'url' => $this->router->generate('mumuimagemodule_picture_view'),
                     'text' => $this->__('Pictures'),
                     'title' => $this->__('Picture list')
                 ];
            }
        }

        return $links;
    }

    public function getBundleName()
    {
        return 'MUMUImageModule';
    }
}
