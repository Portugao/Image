<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\ImageModule\Container;

use MU\ImageModule\Container\Base\AbstractLinkContainer;
use Zikula\Core\LinkContainer\LinkContainerInterface;

/**
 * This is the link container service implementation class.
 */
class LinkContainer extends AbstractLinkContainer
{
    /**
     * Returns available header links.
     *
     * @param string $type The type to collect links for
     *
     * @return array Array of header links
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $contextArgs = ['api' => 'linkContainer', 'action' => 'getLinks'];
        $allowedObjectTypes = $this->controllerHelper->getObjectTypes('api', $contextArgs);

        $permLevel = LinkContainerInterface::TYPE_ADMIN == $type ? ACCESS_ADMIN : ACCESS_READ;
        $extended = $this->variableApi->get('MUImageModule', 'useExtendedFeatures');
        $avatars = $this->variableApi->get('MUImageModule', 'useAvatars');

        // Create an array of links to return
        $links = [];

            if (LinkContainerInterface::TYPE_ACCOUNT == $type) {
            if (!$this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_OVERVIEW)) {
                return $links;
            }

            /*if (true === $this->variableApi->get('MUImageModule', 'linkOwnAlbumsOnAccountPage', true)) {
                $objectType = 'album';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('muimagemodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My albums', 'muimagemodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if (true === $this->variableApi->get('MUImageModule', 'linkOwnPicturesOnAccountPage', true)) {
                $objectType = 'picture';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)) {
                    $links[] = [
                        'url' => $this->router->generate('muimagemodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My pictures', 'muimagemodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }*/

            if (true === $this->variableApi->get('MUImageModule', 'linkOwnAvatarsOnAccountPage', true)) {
                $objectType = 'avatar';
                if ($this->permissionApi->hasPermission($this->getBundleName() . ':' . ucfirst($objectType) . ':', '::', ACCESS_READ)
                    && $extended == true
        	        && $avatars == true) {
                    $links[] = [
                        'url' => $this->router->generate('muimagemodule_' . strtolower($objectType) . '_view', ['own' => 1]),
                        'text' => $this->__('My avatars', 'muimagemodule'),
                        'icon' => 'list-alt'
                    ];
                }
            }

            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('muimagemodule_album_adminindex'),
                    'text' => $this->__('Image Backend', 'muimagemodule'),
                    'icon' => 'wrench'
                ];
            }


            return $links;
        }


        $routeArea = LinkContainerInterface::TYPE_ADMIN == $type ? 'admin' : '';
        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_READ)) {
                $links[] = [
                    'url' => $this->router->generate('muimagemodule_album_index'),
                    'text' => $this->__('Frontend'),
                    'title' => $this->__('Switch to user area.'),
                    'icon' => 'home'
                ];
            }
        } else {
            if ($this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('muimagemodule_album_adminindex'),
                    'text' => $this->__('Backend'),
                    'title' => $this->__('Switch to administration area.'),
                    'icon' => 'wrench'
                ];
            }
        }
        
        if (in_array('album', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Album:', '::', $permLevel)) {
            $links[] = [
                'url' => $this->router->generate('muimagemodule_album_' . $routeArea . 'view'),
                'text' => $this->__('Albums'),
                'title' => $this->__('Album list')
            ];
        }

        if (in_array('picture', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Picture:', '::', $permLevel) && $routeArea == 'admin') {
            $links[] = [
                'url' => $this->router->generate('muimagemodule_picture_' . $routeArea . 'view'),
                'text' => $this->__('Pictures'),
                'title' => $this->__('Picture list')
            ];
        }
        if (in_array('album', $allowedObjectTypes)
        		&& $this->permissionApi->hasPermission($this->getBundleName() . ':Album:', '::', ACCESS_EDIT) && $routeArea != 'admin') {
        			$links[] = [
        					'url' => $this->router->generate('muimagemodule_album_' . $routeArea . 'edit'),
        					'text' => $this->__('New album'),
        					'title' => $this->__('Create new album')
        			];
        		}
        if (in_array('avatar', $allowedObjectTypes)
            && $this->permissionApi->hasPermission($this->getBundleName() . ':Avatar:', '::', $permLevel) && $routeArea == 'admin' 
        		&& $extended == 1 
        		&& $avatars == 1) {
            $links[] = [
                'url' => $this->router->generate('muimagemodule_avatar_' . $routeArea . 'view'),
                'text' => $this->__('Avatars'),
                'title' => $this->__('Avatar list')
            ];
        }
        if ($routeArea == 'admin' && $this->permissionApi->hasPermission($this->getBundleName() . '::', '::', ACCESS_ADMIN)) {
            $links[] = [
                'url' => $this->router->generate('muimagemodule_config_config'),
                'text' => $this->__('Configuration'),
                'title' => $this->__('Manage settings for this application'),
                'icon' => 'wrench'
            ];
        }

        return $links;
    }
}
