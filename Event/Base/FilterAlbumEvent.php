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
use MU\MUImageModule\Entity\AlbumEntity;

/**
 * Event base class for filtering album processing.
 */
class FilterAlbumEvent extends Event
{
    /**
     * @var AlbumEntity Reference to treated entity instance.
     */
    protected $album;

    public function __construct(AlbumEntity $album)
    {
        $this->album = $album;
    }

    public function getAlbum()
    {
        return $this->album;
    }
}
