<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\ImageModule\Entity;

use MU\ImageModule\Entity\Base\AbstractAvatarEntity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for avatar entities.
 * @ORM\Entity(repositoryClass="MU\ImageModule\Entity\Repository\AvatarRepository")
 * @ORM\Table(name="mu_image_avatar",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class AvatarEntity extends BaseEntity
{
    // feel free to add your own methods here
}
