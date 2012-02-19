<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Sun Feb 19 15:20:07 CET 2012.
 */

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\StandardFields\Mapping\Annotation as ZK;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the base entity class for picture entities.
 *
 * @abstract
 */
abstract class MUImage_Entity_Base_Picture extends Zikula_EntityAccess
{

    /**
     * @var string The tablename this object maps to
     */
    protected $_objectType = 'picture';

    /**
     * @var array List of primary key field names
     */
    protected $_idFields = array();

    /**
     * @var MUImage_Entity_Validator_Picture The validator for this entity
     */
    protected $_validator = null;

    /**
     * @var boolean Whether this entity supports unique slugs
     */
    protected $_hasUniqueSlug = false;

    /**
     * @var array List of available item actions
     */
    protected $_actions = array();



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", unique=true)
     * @var integer $id.
     */
    protected $id = 0;


    /**
     * @ORM\Column(length=255, unique=true)
     * @var string $title.
     */
    protected $title = '';


    /**
     * @ORM\Column(length=2000)
     * @var string $description.
     */
    protected $description = '';


    /**
     * @ORM\Column(type="boolean")
     * @var boolean $showTitle.
     */
    protected $showTitle = false;


    /**
     * @ORM\Column(type="boolean")
     * @var boolean $showDescription.
     */
    protected $showDescription = false;
    /**
     * Image upload meta data array.
     *
     * @ORM\Column(type="array")
     * @var array $imageUploadMeta.
     */
    protected $imageUploadMeta = array();



    /**
     * @ORM\Column(length=255)
     * @var string $imageUpload.
     */
    protected $imageUpload = '';

    /**
     * The full path to the image upload.
     *
     * @var string $imageUploadFullPath.
     */
    protected $imageUploadFullPath = '';

    /**
     * Full image upload path as url.
     *
     * @var string $imageUploadFullPathUrl.
     */
    protected $imageUploadFullPathUrl = '';


    /**
     * @ORM\Column(type="bigint")
     * @var bigint $imageView.
     */
    protected $imageView = 0;


    /**
     * @ORM\Column(type="integer")
     * @ZK\StandardFields(type="userid", on="create")
     * @var integer $createdUserId.
     */
    protected $createdUserId;

    /**
     * @ORM\Column(type="integer")
     * @ZK\StandardFields(type="userid", on="update")
     * @var integer $updatedUserId.
     */
    protected $updatedUserId;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * @var datetime $createdDate.
     */
    protected $createdDate;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @var datetime $updatedDate.
     */
    protected $updatedDate;


    /**
     * Bidirectional - Many picture [pictures] are linked by one album [album] (OWNING SIDE).
     *
     * @ORM\ManyToOne(targetEntity="MUImage_Entity_Album", inversedBy="picture", cascade={"all"})
     * @ORM\JoinTable(name="muimage_album")
     * @var MUImage_Entity_Album $album.
     */
    protected $album;


    /**
     * Constructor.
     * Will not be called by Doctrine and can therefore be used
     * for own implementation purposes. It is also possible to add
     * arbitrary arguments as with every other class method.
     */
    public function __construct()
    {
        $this->id = 1;
        $this->_idFields = array('id');
        $this->initValidator();
        $this->_hasUniqueSlug = false;
    }

    /**
     * Get _object type.
     *
     * @return string
     */
    public function get_objectType()
    {
        return $this->_objectType;
    }

    /**
     * Set _object type.
     *
     * @param string $_objectType.
     *
     * @return void
     */
    public function set_objectType($_objectType)
    {
        $this->_objectType = $_objectType;
    }


    /**
     * Get _id fields.
     *
     * @return array
     */
    public function get_idFields()
    {
        return $this->_idFields;
    }

    /**
     * Set _id fields.
     *
     * @param array $_idFields.
     *
     * @return void
     */
    public function set_idFields(array $_idFields = Array())
    {
        $this->_idFields = $_idFields;
    }


    /**
     * Get _validator.
     *
     * @return MUImage_Entity_Validator_Picture
     */
    public function get_validator()
    {
        return $this->_validator;
    }

    /**
     * Set _validator.
     *
     * @param MUImage_Entity_Validator_Picture $_validator.
     *
     * @return void
     */
    public function set_validator(MUImage_Entity_Validator_Picture $_validator = null)
    {
        $this->_validator = $_validator;
    }


    /**
     * Get _has unique slug.
     *
     * @return boolean
     */
    public function get_hasUniqueSlug()
    {
        return $this->_hasUniqueSlug;
    }

    /**
     * Set _has unique slug.
     *
     * @param boolean $_hasUniqueSlug.
     *
     * @return void
     */
    public function set_hasUniqueSlug($_hasUniqueSlug)
    {
        $this->_hasUniqueSlug = $_hasUniqueSlug;
    }


    /**
     * Get _actions.
     *
     * @return array
     */
    public function get_actions()
    {
        return $this->_actions;
    }

    /**
     * Set _actions.
     *
     * @param array $_actions.
     *
     * @return void
     */
    public function set_actions(array $_actions = Array())
    {
        $this->_actions = $_actions;
    }



    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param integer $id.
     *
     * @return void
     */
    public function setId($id)
    {
        if ($id != $this->id) {
            $this->id = $id;
        }
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title.
     *
     * @return void
     */
    public function setTitle($title)
    {
        if ($title != $this->title) {
            $this->title = $title;
        }
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description.
     *
     * @return void
     */
    public function setDescription($description)
    {
        if ($description != $this->description) {
            $this->description = $description;
        }
    }

    /**
     * Get show title.
     *
     * @return boolean
     */
    public function getShowTitle()
    {
        return $this->showTitle;
    }

    /**
     * Set show title.
     *
     * @param boolean $showTitle.
     *
     * @return void
     */
    public function setShowTitle($showTitle)
    {
        if ($showTitle !== $this->showTitle) {
            $this->showTitle = (bool)$showTitle;
        }
    }

    /**
     * Get show description.
     *
     * @return boolean
     */
    public function getShowDescription()
    {
        return $this->showDescription;
    }

    /**
     * Set show description.
     *
     * @param boolean $showDescription.
     *
     * @return void
     */
    public function setShowDescription($showDescription)
    {
        if ($showDescription !== $this->showDescription) {
            $this->showDescription = (bool)$showDescription;
        }
    }

    /**
     * Get image upload.
     *
     * @return string
     */
    public function getImageUpload()
    {
        return $this->imageUpload;
    }

    /**
     * Set image upload.
     *
     * @param string $imageUpload.
     *
     * @return void
     */
    public function setImageUpload($imageUpload)
    {
        if ($imageUpload != $this->imageUpload) {
            $this->imageUpload = $imageUpload;
        }
    }

    /**
     * Get image upload full path.
     *
     * @return string
     */
    public function getImageUploadFullPath()
    {
        return $this->imageUploadFullPath;
    }

    /**
     * Set image upload full path.
     *
     * @param string $imageUploadFullPath.
     *
     * @return void
     */
    public function setImageUploadFullPath($imageUploadFullPath)
    {
        if ($imageUploadFullPath != $this->imageUploadFullPath) {
            $this->imageUploadFullPath = $imageUploadFullPath;
        }
    }

    /**
     * Get image upload full path url.
     *
     * @return string
     */
    public function getImageUploadFullPathUrl()
    {
        return $this->imageUploadFullPathUrl;
    }

    /**
     * Set image upload full path url.
     *
     * @param string $imageUploadFullPathUrl.
     *
     * @return void
     */
    public function setImageUploadFullPathUrl($imageUploadFullPathUrl)
    {
        if ($imageUploadFullPathUrl != $this->imageUploadFullPathUrl) {
            $this->imageUploadFullPathUrl = $imageUploadFullPathUrl;
        }
    }

    /**
     * Get image upload meta.
     *
     * @return array
     */
    public function getImageUploadMeta()
    {
        return $this->imageUploadMeta;
    }

    /**
     * Set image upload meta.
     *
     * @param array $imageUploadMeta.
     *
     * @return void
     */
    public function setImageUploadMeta($imageUploadMeta = Array())
    {
        if ($imageUploadMeta != $this->imageUploadMeta) {
            $this->imageUploadMeta = $imageUploadMeta;
        }
    }

    /**
     * Get image view.
     *
     * @return bigint
     */
    public function getImageView()
    {
        return $this->imageView;
    }

    /**
     * Set image view.
     *
     * @param bigint $imageView.
     *
     * @return void
     */
    public function setImageView($imageView)
    {
        if ($imageView != $this->imageView) {
            $this->imageView = $imageView;
        }
    }


    /**
     * Get created user id.
     *
     * @return integer[]
     */
    public function getCreatedUserId()
    {
        return $this->createdUserId;
    }

    /**
     * Set created user id.
     *
     * @param integer[] $createdUserId.
     *
     * @return void
     */
    public function setCreatedUserId($createdUserId)
    {
        $this->createdUserId = $createdUserId;
    }

    /**
     * Get updated user id.
     *
     * @return integer[]
     */
    public function getUpdatedUserId()
    {
        return $this->updatedUserId;
    }

    /**
     * Set updated user id.
     *
     * @param integer[] $updatedUserId.
     *
     * @return void
     */
    public function setUpdatedUserId($updatedUserId)
    {
        $this->updatedUserId = $updatedUserId;
    }

    /**
     * Get created date.
     *
     * @return datetime[]
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set created date.
     *
     * @param datetime[] $createdDate.
     *
     * @return void
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * Get updated date.
     *
     * @return datetime[]
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set updated date.
     *
     * @param datetime[] $updatedDate.
     *
     * @return void
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * Get album.
     *
     * @return MUImage_Entity_Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * Set album.
     *
     * @param MUImage_Entity_Album $album.
     *
     * @return void
     */
    public function setAlbum(MUImage_Entity_Album $album = null)
    {
        $this->album = $album;
    }


    /**
     * Adds an instance of MUImage_Entity_Album to the list of album.
     *
     * @param MUImage_Entity_Album $album.
     *
     * @return void
     */
    public function addAlbum(MUImage_Entity_Album $album)
    {
        $this->album[] = $album;
        $nameSingle->setPicture($this);
    }

    /**
     * Removes an instance of MUImage_Entity_Album from the list of album.
     *
     * @param MUImage_Entity_Album $album.
     *
     * @return void
     */
    public function removeAlbum(MUImage_Entity_Album $album)
    {
        $this->album->removeElement($album);
        $nameSingle->setPicture(null);
    }

    /**
     * Removes an instance of MUImage_Entity_Album from the list of album by it's identifier.
     *
     * @param integer $album.
     *
     * @return void
     */
    public function removeAlbumById($id)
    {
        $this->album->remove($id);
        $nameSingle->setPicture(null);
    }




    /**
     * Initialise validator and return it's instance.
     *
     * @return MUImage_Entity_Validator_Picture The validator for this entity.
     */
    public function initValidator()
    {
        if (!is_null($this->_validator)) {
            return $this->_validator;
        }
        $this->_validator = new MUImage_Entity_Validator_Picture($this);
        return $this->_validator;
    }

    /**
     * Start validation and raise exception if invalid data is found.
     *
     * @return void.
     */
    public function validate()
    {
        $result = $this->initValidator()->validateAll();
        if (is_array($result)) {
            throw new Zikula_Exception($result['message'], $result['code'], $result['debugArray']);
        }
    }

    /**
     * Return entity data in JSON format.
     *
     * @return string JSON-encoded data.
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Collect available actions for this entity.
     */
    protected function prepareItemActions()
    {
        if (!empty($this->_actions)) {
            return;
        }

        $currentType = FormUtil::getPassedValue('type', 'user', 'GETPOST', FILTER_SANITIZE_STRING);
        $currentFunc = FormUtil::getPassedValue('func', 'main', 'GETPOST', FILTER_SANITIZE_STRING);
        $dom = ZLanguage::getModuleDomain('MUImage');
        if ($currentType == 'admin') {
            if (in_array($currentFunc, array('main', 'view'))) {
                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'display', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'preview',
                        'linkTitle' => __('Open preview page', $dom),
                        'linkText' => __('Preview', $dom)
                    );
                    $this->_actions[] = array(
                        'url' => array('type' => 'admin', 'func' => 'display', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'display',
                        'linkTitle' => str_replace('"', '', $this['title']),
                        'linkText' => __('Details', $dom)
                    );
            }

            if (in_array($currentFunc, array('main', 'view', 'display'))) {
                if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_EDIT)) {

                    $this->_actions[] = array(
                        'url' => array('type' => 'admin', 'func' => 'edit', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'edit',
                        'linkTitle' => __('Edit', $dom),
                        'linkText' => __('Edit', $dom)
                    );
                    $this->_actions[] = array(
                        'url' => array('type' => 'admin', 'func' => 'edit', 'arguments' => array('ot' => 'picture', 'astemplate' => $this['id'])),
                        'icon' => 'saveas',
                        'linkTitle' => __('Reuse for new item', $dom),
                        'linkText' => __('Reuse', $dom)
                    );
                }
                if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_DELETE)) {
                    $this->_actions[] = array(
                        'url' => array('type' => 'admin', 'func' => 'delete', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'delete',
                        'linkTitle' => __('Delete', $dom),
                        'linkText' => __('Delete', $dom)
                    );
                }
            }
            if ($currentFunc == 'display') {
                    $this->_actions[] = array(
                        'url' => array('type' => 'admin', 'func' => 'view', 'arguments' => array('ot' => 'picture')),
                        'icon' => 'back',
                        'linkTitle' => __('Back to overview', $dom),
                        'linkText' => __('Back to overview', $dom)
                    );
            }
        }
        if ($currentType == 'user') {
            if (in_array($currentFunc, array('main', 'view'))) {
                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'display', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'display',
                        'linkTitle' => str_replace('"', '', $this['title']),
                        'linkText' => __('Details', $dom)
                    );
            }

            if (in_array($currentFunc, array('main', 'view', 'display'))) {
                if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_EDIT)) {

                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'edit', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'edit',
                        'linkTitle' => __('Edit', $dom),
                        'linkText' => __('Edit', $dom)
                    );
                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'edit', 'arguments' => array('ot' => 'picture', 'astemplate' => $this['id'])),
                        'icon' => 'saveas',
                        'linkTitle' => __('Reuse for new item', $dom),
                        'linkText' => __('Reuse', $dom)
                    );
                }
                if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_DELETE)) {
                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'delete', 'arguments' => array('ot' => 'picture', 'id' => $this['id'])),
                        'icon' => 'delete',
                        'linkTitle' => __('Delete', $dom),
                        'linkText' => __('Delete', $dom)
                    );
                }
            }
            if ($currentFunc == 'display') {
                    $this->_actions[] = array(
                        'url' => array('type' => 'user', 'func' => 'view', 'arguments' => array('ot' => 'picture')),
                        'icon' => 'back',
                        'linkTitle' => __('Back to overview', $dom),
                        'linkText' => __('Back to overview', $dom)
                    );
            }
        }
    }




    /**
     * Post-Process the data after the entity has been constructed by the entity manager.
     * The event happens after the entity has been loaded from database or after a refresh call.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - no access to associations (not initialised yet)
     *
     * @see MUImage_Entity_Picture::postLoadCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPostLoadCallback()
    {
        // echo 'loaded a record ...';

        $currentType = FormUtil::getPassedValue('type', 'user', 'GETPOST', FILTER_SANITIZE_STRING);
        $currentFunc = FormUtil::getPassedValue('func', 'main', 'GETPOST', FILTER_SANITIZE_STRING);
        // initialise the upload handler
        $uploadManager = new MUImage_UploadHandler();

        $this['id'] = (int) ((isset($this['id']) && !empty($this['id'])) ? DataUtil::formatForDisplay($this['id']) : 0);
    if ($currentFunc != 'edit') {
        $this['title'] = ((isset($this['title']) && !empty($this['title'])) ? DataUtil::formatForDisplayHTML($this['title']) : '');
    }
    if ($currentFunc != 'edit') {
        $this['description'] = ((isset($this['description']) && !empty($this['description'])) ? DataUtil::formatForDisplayHTML($this['description']) : '');
    }
        $this['showTitle'] = (bool) $this['showTitle'];
        $this['showDescription'] = (bool) $this['showDescription'];
        if (!empty($this['imageUpload'])) {
            $basePath = MUImage_Util_Controller::getFileBaseFolder('picture', 'imageUpload');
            $fullPath = $basePath .  $this['imageUpload'];
            $this['imageUploadFullPath'] = $fullPath;
            $this['imageUploadFullPathURL'] = System::getBaseUrl() . $fullPath;

            // just some backwards compatibility stuff
            if (!isset($this['imageUploadMeta']) || !is_array($this['imageUploadMeta']) || !count($this['imageUploadMeta'])) {
                // assign new meta data
                $this['imageUploadMeta'] = $uploadManager->readMetaDataForFile($this['imageUpload'], $fullPath);
            }
        }
        $this['imageView'] = (int) ((isset($this['imageView']) && !empty($this['imageView'])) ? DataUtil::formatForDisplay($this['imageView']) : 0);
        $this->prepareItemActions();
        return true;
    }

    /**
     * Pre-Process the data prior to an insert operation.
     * The event happens before the entity managers persist operation is executed for this entity.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - no identifiers available if using an identity generator like sequences
     *     - Doctrine won't recognize changes on relations which are done here
     *       if this method is called by cascade persist
     *     - no creation of other entities allowed
     *
     * @see MUImage_Entity_Picture::prePersistCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPrePersistCallback()
    {
        // echo 'inserting a record ...';
        $this->validate();
        return true;
    }

    /**
     * Post-Process the data after an insert operation.
     * The event happens after the entity has been made persistant.
     * Will be called after the database insert operations.
     * The generated primary key values are available.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *
     * @see MUImage_Entity_Picture::postPersistCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPostPersistCallback()
    {
        // echo 'inserted a record ...';
        return true;
    }

    /**
     * Pre-Process the data prior a delete operation.
     * The event happens before the entity managers remove operation is executed for this entity.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - will not be called for a DQL DELETE statement
     *
     * @see MUImage_Entity_Picture::preRemoveCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPreRemoveCallback()
    {
/*        // delete workflow for this entity
        $result = Zikula_Workflow_Util::deleteWorkflow($this);
        if ($result === false) {
            $dom = ZLanguage::getModuleDomain('MUImage');
            return LogUtil::registerError(__('Error! Could not remove stored workflow.', $dom));
        }*/
        return true;
    }

    /**
     * Post-Process the data after a delete.
     * The event happens after the entity has been deleted.
     * Will be called after the database delete operations.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - will not be called for a DQL DELETE statement
     *
     * @see MUImage_Entity_Picture::postRemoveCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPostRemoveCallback()
    {
        // echo 'deleted a record ...';
        // initialise the upload handler
        $uploadManager = new MUImage_UploadHandler();

        $uploadFields = array('imageUpload');
        foreach ($uploadFields as $uploadField) {
            if (empty($this->$uploadField)) {
                continue;
            }

            // remove upload file (and image thumbnails)
            $uploadManager->deleteUploadFile('picture', $this, $uploadField);
        }
        return true;
    }

    /**
     * Pre-Process the data prior to an update operation.
     * The event happens before the database update operations for the entity data.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - will not be called for a DQL UPDATE statement
     *     - changes on associations are not allowed and won't be recognized by flush
     *     - changes on properties won't be recognized by flush as well
     *     - no creation of other entities allowed
     *
     * @see MUImage_Entity_Picture::preUpdateCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPreUpdateCallback()
    {
        // echo 'updating a record ...';
        $this->validate();
        return true;
    }

    /**
     * Post-Process the data after an update operation.
     * The event happens after the database update operations for the entity data.
     *
     * Restrictions:
     *     - no access to entity manager or unit of work apis
     *     - will not be called for a DQL UPDATE statement
     *
     * @see MUImage_Entity_Picture::postUpdateCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPostUpdateCallback()
    {
        // echo 'updated a record ...';
        return true;
    }

    /**
     * Pre-Process the data prior to a save operation.
     * This combines the PrePersist and PreUpdate events.
     * For more information see corresponding callback handlers.
     *
     * @see MUImage_Entity_Picture::preSaveCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPreSaveCallback()
    {
        // echo 'saving a record ...';
        $this->validate();
        return true;
    }

    /**
     * Post-Process the data after a save operation.
     * This combines the PostPersist and PostUpdate events.
     * For more information see corresponding callback handlers.
     *
     * @see MUImage_Entity_Picture::postSaveCallback()
     * @return boolean true if completed successfully else false.
     */
    protected function performPostSaveCallback()
    {
        // echo 'saved a record ...';
        return true;
    }

}
