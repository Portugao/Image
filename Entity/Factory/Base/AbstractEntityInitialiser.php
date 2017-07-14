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

namespace MU\ImageModule\Entity\Factory\Base;

use MU\ImageModule\Entity\AlbumEntity;
use MU\ImageModule\Entity\PictureEntity;
use MU\ImageModule\Entity\AvatarEntity;
use MU\ImageModule\Helper\ListEntriesHelper;

/**
 * Entity initialiser class used to dynamically apply default values to newly created entities.
 */
abstract class AbstractEntityInitialiser
{
    /**
     * @var ListEntriesHelper Helper service for managing list entries
     */
    protected $listEntriesHelper;

    /**
     * EntityInitialiser constructor.
     *
     * @param ListEntriesHelper $listEntriesHelper Helper service for managing list entries
     */
    public function __construct(ListEntriesHelper $listEntriesHelper)
    {
        $this->listEntriesHelper = $listEntriesHelper;
    }

    /**
     * Initialises a given album instance.
     *
     * @param AlbumEntity $entity The newly created entity instance
     *
     * @return AlbumEntity The updated entity instance
     */
    public function initAlbum(AlbumEntity $entity)
    {
        $listEntries = $this->listEntriesHelper->getAlbumAccessEntriesForAlbum();
        $items = [];
        foreach ($listEntries as $listEntry) {
            if (true === $listEntry['default']) {
                $items[] = $listEntry['value'];
            }
        }
        $entity->setAlbumAccess(implode('###', $items));


        return $entity;
    }

    /**
     * Initialises a given picture instance.
     *
     * @param PictureEntity $entity The newly created entity instance
     *
     * @return PictureEntity The updated entity instance
     */
    public function initPicture(PictureEntity $entity)
    {

        return $entity;
    }

    /**
     * Initialises a given avatar instance.
     *
     * @param AvatarEntity $entity The newly created entity instance
     *
     * @return AvatarEntity The updated entity instance
     */
    public function initAvatar(AvatarEntity $entity)
    {
        $listEntries = $this->listEntriesHelper->getSupportedModulesEntriesForAvatar();
        $items = [];
        foreach ($listEntries as $listEntry) {
            if (true === $listEntry['default']) {
                $items[] = $listEntry['value'];
            }
        }
        $entity->setSupportedModules(implode('###', $items));


        return $entity;
    }

    /**
     * Returns the list entries helper.
     *
     * @return ListEntriesHelper
     */
    public function getListEntriesHelper()
    {
        return $this->listEntriesHelper;
    }
    
    /**
     * Sets the list entries helper.
     *
     * @param ListEntriesHelper $listEntriesHelper
     *
     * @return void
     */
    public function setListEntriesHelper($listEntriesHelper)
    {
        if ($this->listEntriesHelper != $listEntriesHelper) {
            $this->listEntriesHelper = $listEntriesHelper;
        }
    }
    
}
