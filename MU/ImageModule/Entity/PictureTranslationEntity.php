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

namespace MU\ImageModule\Entity;

use MU\ImageModule\Entity\Base\AbstractPictureTranslationEntity as BaseEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing picture translations.
 *
 * This is the concrete translation class for picture entities.
 *
 * @ORM\Entity(repositoryClass="MU\ImageModule\Entity\Repository\PictureTranslationRepository")
 * @ORM\Table(
 *     name="mu_image_picture_translation",
 *     options={"row_format":"DYNAMIC"},
 *     indexes={
 *         @ORM\Index(name="translations_lookup_idx", columns={
 *             "locale", "object_class", "foreign_key"
 *         })
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="lookup_unique_idx", columns={
 *             "locale", "object_class", "field", "foreign_key"
 *         })
 *     }
 * )
 */
class PictureTranslationEntity extends BaseEntity
{
    // feel free to add your own methods here
}
