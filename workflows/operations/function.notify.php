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

/**
 * Notify operation.
 *
 * @param object $entity The treated object
 * @param array  $params Additional arguments
 *
 * @return bool False on failure or true if everything worked well
 *
 * @throws RuntimeException Thrown if executing the workflow action fails
 */
function MUImageModule_operation_notify(&$entity, $params)
{

    // workflow parameters are always lower-cased (#656)
    $recipientType = isset($params['recipientType']) ? $params['recipientType'] : $params['recipienttype'];
    
    $notifyArgs = [
        'recipientType' => $recipientType,
        'action' => $params['action'],
        'entity' => $entity
    ];
    
    $result = \ServiceUtil::get('mu_image_module.notification_helper')->process($notifyArgs);

    // return result of this operation
    return $result;
}
