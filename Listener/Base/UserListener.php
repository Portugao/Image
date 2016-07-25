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

namespace MU\MUImageModule\Listener\Base;

use ServiceUtil;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use UserUtil;
use Zikula\Core\Event\GenericEvent;
use Zikula\UsersModule\UserEvents;

/**
 * Event handler base class for user-related events.
 */
class UserListener implements EventSubscriberInterface
{
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return [
            'user.gettheme'            => ['getTheme', 5],
            UserEvents::CREATE_ACCOUNT => ['create', 5],
            UserEvents::UPDATE_ACCOUNT => ['update', 5],
            UserEvents::DELETE_ACCOUNT => ['delete', 5]
        ];
    }
    
    /**
     * Listener for the `user.gettheme` event.
     *
     * Called during UserUtil::getTheme() and is used to filter the results.
     * Receives arg['type'] with the type of result to be filtered
     * and the $themeName in the $event->data which can be modified.
     * Must $event->stopPropagation() if handler performs filter.
     *
     * @param GenericEvent $event The event instance
     */
    public function getTheme(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `user.account.create` event.
     *
     * Occurs after a user account is created. All handlers are notified.
     * It does not apply to creation of a pending registration.
     * The full user record created is available as the subject.
     * This is a storage-level event, not a UI event. It should not be used for UI-level actions such as redirects.
     * The subject of the event is set to the user record that was created.
     *
     * @param GenericEvent $event The event instance
     */
    public function create(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `user.account.update` event.
     *
     * Occurs after a user is updated. All handlers are notified.
     * The full updated user record is available as the subject.
     * This is a storage-level event, not a UI event. It should not be used for UI-level actions such as redirects.
     * The subject of the event is set to the user record, with the updated values.
     *
     * @param GenericEvent $event The event instance
     */
    public function update(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `user.account.delete` event.
     *
     * Occurs after the deletion of a user account. Subject is $uid.
     * This is a storage-level event, not a UI event. It should not be used for UI-level actions such as redirects.
     *
     * @param GenericEvent $event The event instance
     */
    public function delete(GenericEvent $event)
    {
        $uid = $event->getSubject();
    
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->get('doctrine.entitymanager');
        
        $repo = $entityManager->getRepository('MU\MUImageModule\Entity\AlbumEntity');
        // set creator to admin (2) for all albums created by this user
        $repo->updateCreator($uid, 2);
        
        // set last editor to admin (2) for all albums updated by this user
        $repo->updateLastEditor($uid, 2);
        
        $logger = $serviceManager->get('logger');
        $logArgs = ['app' => 'MUMUImageModule', 'user' => $serviceManager->get('zikula_users_module.current_user')->get('uname'), 'entities' => 'albums'];
        $logger->notice('{app}: User {user} has been deleted, so we deleted corresponding {entities}, too.', $logArgs);
        
        $repo = $entityManager->getRepository('MU\MUImageModule\Entity\PictureEntity');
        // set creator to admin (2) for all pictures created by this user
        $repo->updateCreator($uid, 2);
        
        // set last editor to admin (2) for all pictures updated by this user
        $repo->updateLastEditor($uid, 2);
        
        $logger = $serviceManager->get('logger');
        $logArgs = ['app' => 'MUMUImageModule', 'user' => $serviceManager->get('zikula_users_module.current_user')->get('uname'), 'entities' => 'pictures'];
        $logger->notice('{app}: User {user} has been deleted, so we deleted corresponding {entities}, too.', $logArgs);
    }
}
