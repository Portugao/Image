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
 * Event handler base class for frontend controller interaction events.
 */
class MUImage_Listener_Base_FrontController
{
    /**
     * Listener for the `frontcontroller.predispatch` event.
     *
     * Runs before the front controller does any work.
     *
     * @param Zikula_Event $event The event instance.
     */
    public static function preDispatch(Zikula_Event $event)
    {
    }
}
