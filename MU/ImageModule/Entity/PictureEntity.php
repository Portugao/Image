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

use MU\ImageModule\Entity\Base\AbstractPictureEntity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for picture entities.
 * @Gedmo\TranslationEntity(class="MU\ImageModule\Entity\PictureTranslationEntity")
 * @ORM\Entity(repositoryClass="MU\ImageModule\Entity\Repository\PictureRepository")
 * @ORM\Table(name="mu_image_picture",
 *     indexes={
 *         @ORM\Index(name="workflowstateindex", columns={"workflowState"})
 *     }
 * )
 */
class PictureEntity extends BaseEntity
{
    // feel free to add your own methods here
}
