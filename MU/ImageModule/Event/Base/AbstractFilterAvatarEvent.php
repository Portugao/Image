<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link https://ziku.la
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\ImageModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\ImageModule\Entity\AvatarEntity;

/**
 * Event base class for filtering avatar processing.
 */
class AbstractFilterAvatarEvent extends Event
{
    /**
     * @var AvatarEntity Reference to treated entity instance.
     */
    protected $avatar;

    /**
     * @var array Entity change set for preUpdate events.
     */
    protected $entityChangeSet = [];

    /**
     * FilterAvatarEvent constructor.
     *
     * @param AvatarEntity $avatar Processed entity
     * @param array $entityChangeSet Change set for preUpdate events
     */
    public function __construct(AvatarEntity $avatar, array $entityChangeSet = [])
    {
        $this->avatar = $avatar;
        $this->entityChangeSet = $entityChangeSet;
    }

    /**
     * Returns the entity.
     *
     * @return AvatarEntity
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Returns the change set.
     *
     * @return array Entity change set
     */
    public function getEntityChangeSet()
    {
        return $this->entityChangeSet;
    }
}
