<?php
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
 * Event handler base class for page-related events.
 */
class MUImage_Listener_Base_Page
{
    /**
     * Listener for the `pageutil.addvar_filter` event.
     *
     * Used to override things like system or module stylesheets or javascript.
     * Subject is the `$varname`, and `$event->data` an array of values to be modified by the filter.
     *
     * This single filter can be used to override all css or js scripts or any other var types
     * sent to `PageUtil::addVar()`.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function pageutilAddvarFilter(Zikula_Event $event)
    {
    }
    
    /**
     * Listener for the `system.outputfilter` event.
     *
     * Filter type event for output filter HTML sanitisation.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function systemOutputFilter(Zikula_Event $event)
    {
    }
}
