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

namespace MU\ImageModule\Menu\Base;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\UsersModule\Constant as UsersConstant;
use MU\ImageModule\Entity\AlbumEntity;
use MU\ImageModule\Entity\PictureEntity;
use MU\ImageModule\Entity\AvatarEntity;

/**
 * This is the item actions menu implementation class.
 */
class AbstractItemActionsMenu implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    use TranslatorTrait;

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * Builds the menu.
     *
     * @param FactoryInterface $factory Menu factory
     * @param array            $options Additional options
     *
     * @return MenuItem The assembled menu
     */
    public function menu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('itemActions');
        if (!isset($options['entity']) || !isset($options['area']) || !isset($options['context'])) {
            return $menu;
        }

        $this->setTranslator($this->container->get('translator.default'));

        $entity = $options['entity'];
        $routeArea = $options['area'];
        $context = $options['context'];

        $permissionApi = $this->container->get('zikula_permissions_module.api.permission');
        $currentUserApi = $this->container->get('zikula_users_module.current_user');
        $entityDisplayHelper = $this->container->get('mu_image_module.entity_display_helper');
        $menu->setChildrenAttribute('class', 'list-inline');

        $currentUserId = $currentUserApi->isLoggedIn() ? $currentUserApi->get('uid') : UsersConstant::USER_ID_ANONYMOUS;
        if ($entity instanceof AlbumEntity) {
            $component = 'MUImageModule:Album:';
            $instance = $entity->getKey() . '::';
            $routePrefix = 'muimagemodule_album_';
            $isOwner = $currentUserId > 0 && null !== $entity->getCreatedBy() && $currentUserId == $entity->getCreatedBy()->getUid();
        
            if ($routeArea == 'admin') {
                $menu->addChild($this->__('Preview'), [
                    'route' => $routePrefix . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-search-plus');
                $menu[$this->__('Preview')]->setLinkAttribute('target', '_blank');
                $menu[$this->__('Preview')]->setLinkAttribute('title', $this->__('Open preview page'));
            }
            if ($context != 'display') {
                $menu->addChild($this->__('Details'), [
                    'route' => $routePrefix . $routeArea . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-eye');
                $menu[$this->__('Details')]->setLinkAttribute('title', str_replace('"', '', $entityDisplayHelper->getFormattedTitle($entity)));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_EDIT)) {
                $menu->addChild($this->__('Edit'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-pencil-square-o');
                $menu[$this->__('Edit')]->setLinkAttribute('title', $this->__('Edit this album'));
                $menu->addChild($this->__('Reuse'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => ['astemplate' => $entity->getKey()]
                ])->setAttribute('icon', 'fa fa-files-o');
                $menu[$this->__('Reuse')]->setLinkAttribute('title', $this->__('Reuse for new album'));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_DELETE)) {
                $menu->addChild($this->__('Delete'), [
                    'route' => $routePrefix . $routeArea . 'delete',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-trash-o');
                $menu[$this->__('Delete')]->setLinkAttribute('title', $this->__('Delete this album'));
            }
            if ($context == 'display') {
                $title = $this->__('Back to overview');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'view'
                ])->setAttribute('icon', 'fa fa-reply');
                $menu[$title]->setLinkAttribute('title', $title);
            }
            
            // more actions for adding new related items
            
            $relatedComponent = 'MUImageModule:Album:';
            $relatedInstance = $entity->getKey() . '::';
            if ($isOwner || $permissionApi->hasPermission($relatedComponent, $relatedInstance, ACCESS_EDIT)) {
                $title = $this->__('Create album');
                $menu->addChild($title, [
                    'route' => 'muimagemodule_album_' . $routeArea . 'edit',
                    'routeParameters' => ['album' => $entity->getKey()]
                ])->setAttribute('icon', 'fa fa-plus');
                $menu[$title]->setLinkAttribute('title', $title);
            }
            
            $relatedComponent = 'MUImageModule:Picture:';
            $relatedInstance = $entity->getKey() . '::';
            if ($isOwner || $permissionApi->hasPermission($relatedComponent, $relatedInstance, ACCESS_EDIT)) {
                $title = $this->__('Create picture');
                $menu->addChild($title, [
                    'route' => 'muimagemodule_picture_' . $routeArea . 'edit',
                    'routeParameters' => ['album' => $entity->getKey()]
                ])->setAttribute('icon', 'fa fa-plus');
                $menu[$title]->setLinkAttribute('title', $title);
            }
        }
        if ($entity instanceof PictureEntity) {
            $component = 'MUImageModule:Picture:';
            $instance = $entity->getKey() . '::';
            $routePrefix = 'muimagemodule_picture_';
            $isOwner = $currentUserId > 0 && null !== $entity->getCreatedBy() && $currentUserId == $entity->getCreatedBy()->getUid();
        
            if ($routeArea == 'admin') {
                $menu->addChild($this->__('Preview'), [
                    'route' => $routePrefix . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-search-plus');
                $menu[$this->__('Preview')]->setLinkAttribute('target', '_blank');
                $menu[$this->__('Preview')]->setLinkAttribute('title', $this->__('Open preview page'));
            }
            if ($context != 'display') {
                $menu->addChild($this->__('Details'), [
                    'route' => $routePrefix . $routeArea . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-eye');
                $menu[$this->__('Details')]->setLinkAttribute('title', str_replace('"', '', $entityDisplayHelper->getFormattedTitle($entity)));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_EDIT)) {
                $menu->addChild($this->__('Edit'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-pencil-square-o');
                $menu[$this->__('Edit')]->setLinkAttribute('title', $this->__('Edit this picture'));
                $menu->addChild($this->__('Reuse'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => ['astemplate' => $entity->getKey()]
                ])->setAttribute('icon', 'fa fa-files-o');
                $menu[$this->__('Reuse')]->setLinkAttribute('title', $this->__('Reuse for new picture'));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_DELETE)) {
                $menu->addChild($this->__('Delete'), [
                    'route' => $routePrefix . $routeArea . 'delete',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-trash-o');
                $menu[$this->__('Delete')]->setLinkAttribute('title', $this->__('Delete this picture'));
            }
            if ($context == 'display') {
                $title = $this->__('Back to overview');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'view'
                ])->setAttribute('icon', 'fa fa-reply');
                $menu[$title]->setLinkAttribute('title', $title);
            }
        }
        if ($entity instanceof AvatarEntity) {
            $component = 'MUImageModule:Avatar:';
            $instance = $entity->getKey() . '::';
            $routePrefix = 'muimagemodule_avatar_';
            $isOwner = $currentUserId > 0 && null !== $entity->getCreatedBy() && $currentUserId == $entity->getCreatedBy()->getUid();
        
            if ($routeArea == 'admin') {
                $menu->addChild($this->__('Preview'), [
                    'route' => $routePrefix . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-search-plus');
                $menu[$this->__('Preview')]->setLinkAttribute('target', '_blank');
                $menu[$this->__('Preview')]->setLinkAttribute('title', $this->__('Open preview page'));
            }
            if ($context != 'display') {
                $menu->addChild($this->__('Details'), [
                    'route' => $routePrefix . $routeArea . 'display',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-eye');
                $menu[$this->__('Details')]->setLinkAttribute('title', str_replace('"', '', $entityDisplayHelper->getFormattedTitle($entity)));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_EDIT)) {
                $menu->addChild($this->__('Edit'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-pencil-square-o');
                $menu[$this->__('Edit')]->setLinkAttribute('title', $this->__('Edit this avatar'));
                $menu->addChild($this->__('Reuse'), [
                    'route' => $routePrefix . $routeArea . 'edit',
                    'routeParameters' => ['astemplate' => $entity->getKey()]
                ])->setAttribute('icon', 'fa fa-files-o');
                $menu[$this->__('Reuse')]->setLinkAttribute('title', $this->__('Reuse for new avatar'));
            }
            if ($permissionApi->hasPermission($component, $instance, ACCESS_DELETE)) {
                $menu->addChild($this->__('Delete'), [
                    'route' => $routePrefix . $routeArea . 'delete',
                    'routeParameters' => $entity->createUrlArgs()
                ])->setAttribute('icon', 'fa fa-trash-o');
                $menu[$this->__('Delete')]->setLinkAttribute('title', $this->__('Delete this avatar'));
            }
            if ($context == 'display') {
                $title = $this->__('Back to overview');
                $menu->addChild($title, [
                    'route' => $routePrefix . $routeArea . 'view'
                ])->setAttribute('icon', 'fa fa-reply');
                $menu[$title]->setLinkAttribute('title', $title);
            }
        }

        return $menu;
    }
}