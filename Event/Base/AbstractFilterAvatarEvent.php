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

    public function __construct(AvatarEntity $avatar)
    {
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }
}