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

namespace MU\MUImageModule\Event\Base;

use Symfony\Component\EventDispatcher\Event;
use MU\MUImageModule\Entity\PictureEntity;

/**
 * Event base class for filtering picture processing.
 */
class FilterPictureEvent extends Event
{
    /**
     * @var PictureEntity Reference to treated entity instance.
     */
    protected $picture;

    public function __construct(PictureEntity $picture)
    {
        $this->picture = $picture;
    }

    public function getPicture()
    {
        return $this->picture;
    }
}
