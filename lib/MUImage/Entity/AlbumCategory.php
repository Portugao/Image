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

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing album categories.
 *
 * This is the concrete category class for album entities.
 * @ORM\Entity(repositoryClass="MUImage_Entity_Repository_AlbumCategory")
 * @ORM\Table(name="muimage_album_category",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="cat_unq", columns={"registryId", "categoryId", "entityId"})
 *     }
 * )
 */
class MUImage_Entity_AlbumCategory extends MUImage_Entity_Base_AlbumCategory
{
    // feel free to add your own methods here
}
