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

namespace MU\ImageModule\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * Entity extension domain class storing picture translations.
 *
 * This is the base translation class for picture entities.
 */
abstract class AbstractPictureTranslationEntity extends AbstractTranslation
{
    /**
     * Use integer instead of string for increased performance.
     * @see https://github.com/Atlantic18/DoctrineExtensions/issues/1512
     *
     * @var integer $foreignKey
     *
     * @ORM\Column(name="foreign_key", type="integer")
     */
    protected $foreignKey;
    
    /**
     * Clone interceptor implementation.
     * Performs a quite simple shallow copy.
     *
     * See also:
     * (1) http://docs.doctrine-project.org/en/latest/cookbook/implementing-wakeup-or-clone.html
     * (2) http://www.php.net/manual/en/language.oop5.cloning.php
     * (3) http://stackoverflow.com/questions/185934/how-do-i-create-a-copy-of-an-object-in-php
     */
    public function __clone()
    {
        // if the entity has no identity do nothing, do NOT throw an exception
        if (!$this->id) {
            return;
        }
    
        // unset identifier
        $this->id = 0;
    }
}
