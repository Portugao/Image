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

namespace MU\MUImageModule\Base;

/**
 * Events definition base class.
 */
class MUImageEvents
{
    /**
     * The mumuimagemodule.album_post_load event is thrown when albums
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::postLoadCallback()
     * @var string
     */
    const ALBUM_POST_LOAD = 'mumuimagemodule.album_post_load';
    
    /**
     * The mumuimagemodule.album_pre_persist event is thrown before a new album
     * is created in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::prePersistCallback()
     * @var string
     */
    const ALBUM_PRE_PERSIST = 'mumuimagemodule.album_pre_persist';
    
    /**
     * The mumuimagemodule.album_post_persist event is thrown after a new album
     * has been created in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::postPersistCallback()
     * @var string
     */
    const ALBUM_POST_PERSIST = 'mumuimagemodule.album_post_persist';
    
    /**
     * The mumuimagemodule.album_pre_remove event is thrown before an existing album
     * is removed from the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::preRemoveCallback()
     * @var string
     */
    const ALBUM_PRE_REMOVE = 'mumuimagemodule.album_pre_remove';
    
    /**
     * The mumuimagemodule.album_post_remove event is thrown after an existing album
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::postRemoveCallback()
     * @var string
     */
    const ALBUM_POST_REMOVE = 'mumuimagemodule.album_post_remove';
    
    /**
     * The mumuimagemodule.album_pre_update event is thrown before an existing album
     * is updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::preUpdateCallback()
     * @var string
     */
    const ALBUM_PRE_UPDATE = 'mumuimagemodule.album_pre_update';
    
    /**
     * The mumuimagemodule.album_post_update event is thrown after an existing new album
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::postUpdateCallback()
     * @var string
     */
    const ALBUM_POST_UPDATE = 'mumuimagemodule.album_post_update';
    
    /**
     * The mumuimagemodule.album_pre_save event is thrown before a new album
     * is created or an existing album is updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::preSaveCallback()
     * @var string
     */
    const ALBUM_PRE_SAVE = 'mumuimagemodule.album_pre_save';
    
    /**
     * The mumuimagemodule.album_post_save event is thrown after a new album
     * has been created or an existing album has been updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterAlbumEvent instance.
     *
     * @see MU\MUImageModule\Entity\AlbumEntity::postSaveCallback()
     * @var string
     */
    const ALBUM_POST_SAVE = 'mumuimagemodule.album_post_save';
    
    /**
     * The mumuimagemodule.picture_post_load event is thrown when pictures
     * are loaded from the database.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::postLoadCallback()
     * @var string
     */
    const PICTURE_POST_LOAD = 'mumuimagemodule.picture_post_load';
    
    /**
     * The mumuimagemodule.picture_pre_persist event is thrown before a new picture
     * is created in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::prePersistCallback()
     * @var string
     */
    const PICTURE_PRE_PERSIST = 'mumuimagemodule.picture_pre_persist';
    
    /**
     * The mumuimagemodule.picture_post_persist event is thrown after a new picture
     * has been created in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::postPersistCallback()
     * @var string
     */
    const PICTURE_POST_PERSIST = 'mumuimagemodule.picture_post_persist';
    
    /**
     * The mumuimagemodule.picture_pre_remove event is thrown before an existing picture
     * is removed from the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::preRemoveCallback()
     * @var string
     */
    const PICTURE_PRE_REMOVE = 'mumuimagemodule.picture_pre_remove';
    
    /**
     * The mumuimagemodule.picture_post_remove event is thrown after an existing picture
     * has been removed from the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::postRemoveCallback()
     * @var string
     */
    const PICTURE_POST_REMOVE = 'mumuimagemodule.picture_post_remove';
    
    /**
     * The mumuimagemodule.picture_pre_update event is thrown before an existing picture
     * is updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::preUpdateCallback()
     * @var string
     */
    const PICTURE_PRE_UPDATE = 'mumuimagemodule.picture_pre_update';
    
    /**
     * The mumuimagemodule.picture_post_update event is thrown after an existing new picture
     * has been updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::postUpdateCallback()
     * @var string
     */
    const PICTURE_POST_UPDATE = 'mumuimagemodule.picture_post_update';
    
    /**
     * The mumuimagemodule.picture_pre_save event is thrown before a new picture
     * is created or an existing picture is updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::preSaveCallback()
     * @var string
     */
    const PICTURE_PRE_SAVE = 'mumuimagemodule.picture_pre_save';
    
    /**
     * The mumuimagemodule.picture_post_save event is thrown after a new picture
     * has been created or an existing picture has been updated in the system.
     *
     * The event listener receives an
     * MU\MUImageModule\Event\FilterPictureEvent instance.
     *
     * @see MU\MUImageModule\Entity\PictureEntity::postSaveCallback()
     * @var string
     */
    const PICTURE_POST_SAVE = 'mumuimagemodule.picture_post_save';
    
}
