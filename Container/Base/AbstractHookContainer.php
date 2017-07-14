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

namespace MU\ImageModule\Container\Base;

use Zikula\Bundle\HookBundle\AbstractHookContainer as ZikulaHookContainer;
use Zikula\Bundle\HookBundle\Bundle\SubscriberBundle;

/**
 * Base class for hook container methods.
 */
abstract class AbstractHookContainer extends ZikulaHookContainer
{
    /**
     * Define the hook bundles supported by this module.
     *
     * @return void
     */
    protected function setupHookBundles()
    {
        $bundle = new SubscriberBundle('MUImageModule', 'subscriber.muimagemodule.ui_hooks.albums', 'ui_hooks', $this->__('muimagemodule. Albums Display Hooks'));
        
        // Display hook for view/display templates.
        $bundle->addEvent('display_view', 'muimagemodule.ui_hooks.albums.display_view');
        // Display hook for create/edit forms.
        $bundle->addEvent('form_edit', 'muimagemodule.ui_hooks.albums.form_edit');
        // Display hook for delete dialogues.
        $bundle->addEvent('form_delete', 'muimagemodule.ui_hooks.albums.form_delete');
        // Validate input from an ui create/edit form.
        $bundle->addEvent('validate_edit', 'muimagemodule.ui_hooks.albums.validate_edit');
        // Validate input from an ui delete form.
        $bundle->addEvent('validate_delete', 'muimagemodule.ui_hooks.albums.validate_delete');
        // Perform the final update actions for a ui create/edit form.
        $bundle->addEvent('process_edit', 'muimagemodule.ui_hooks.albums.process_edit');
        // Perform the final delete actions for a ui form.
        $bundle->addEvent('process_delete', 'muimagemodule.ui_hooks.albums.process_delete');
        $this->registerHookSubscriberBundle($bundle);
        
        $bundle = new SubscriberBundle('MUImageModule', 'subscriber.muimagemodule.filter_hooks.albums', 'filter_hooks', $this->__('muimagemodule. Albums Filter Hooks'));
        // A filter applied to the given area.
        $bundle->addEvent('filter', 'muimagemodule.filter_hooks.albums.filter');
        $this->registerHookSubscriberBundle($bundle);
        
        $bundle = new SubscriberBundle('MUImageModule', 'subscriber.muimagemodule.ui_hooks.pictures', 'ui_hooks', $this->__('muimagemodule. Pictures Display Hooks'));
        
        // Display hook for view/display templates.
        $bundle->addEvent('display_view', 'muimagemodule.ui_hooks.pictures.display_view');
        // Display hook for create/edit forms.
        $bundle->addEvent('form_edit', 'muimagemodule.ui_hooks.pictures.form_edit');
        // Display hook for delete dialogues.
        $bundle->addEvent('form_delete', 'muimagemodule.ui_hooks.pictures.form_delete');
        // Validate input from an ui create/edit form.
        $bundle->addEvent('validate_edit', 'muimagemodule.ui_hooks.pictures.validate_edit');
        // Validate input from an ui delete form.
        $bundle->addEvent('validate_delete', 'muimagemodule.ui_hooks.pictures.validate_delete');
        // Perform the final update actions for a ui create/edit form.
        $bundle->addEvent('process_edit', 'muimagemodule.ui_hooks.pictures.process_edit');
        // Perform the final delete actions for a ui form.
        $bundle->addEvent('process_delete', 'muimagemodule.ui_hooks.pictures.process_delete');
        $this->registerHookSubscriberBundle($bundle);
        
        $bundle = new SubscriberBundle('MUImageModule', 'subscriber.muimagemodule.filter_hooks.pictures', 'filter_hooks', $this->__('muimagemodule. Pictures Filter Hooks'));
        // A filter applied to the given area.
        $bundle->addEvent('filter', 'muimagemodule.filter_hooks.pictures.filter');
        $this->registerHookSubscriberBundle($bundle);
        
        
    }
}
