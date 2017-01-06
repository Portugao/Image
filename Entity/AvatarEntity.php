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

namespace MU\ImageModule\Entity;

use MU\ImageModule\Entity\Base\AbstractAvatarEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use MU\ImageModule\Traits\EntityWorkflowTrait;
use MU\ImageModule\Traits\StandardFieldsTrait;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for avatar entities.
 * @ORM\Entity(repositoryClass="\MU\ImageModule\Entity\Repository\AvatarRepository")
 * @ORM\Table(name="mu_muimage_avatar",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class AvatarEntity extends BaseEntity
{
    // feel free to add your own methods here
}
