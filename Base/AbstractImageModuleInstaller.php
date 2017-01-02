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

namespace MU\ImageModule\Base;

use DBUtil;
use Doctrine\DBAL\Connection;
use EventUtil;
use ModUtil;
use RuntimeException;
use UserUtil;
use Zikula\Core\AbstractExtensionInstaller;
use Zikula_Workflow_Util;
use Zikula\CategoriesModule\Entity\CategoryRegistryEntity;

/**
 * Installer base class.
 */
abstract class AbstractImageModuleInstaller extends AbstractExtensionInstaller
{
    /**
     * Install the MUImageModule application.
     *
     * @return boolean True on success, or false
     *
     * @throws RuntimeException Thrown if database tables can not be created or another error occurs
     */
    public function install()
    {
        $logger = $this->container->get('logger');
    
        // Check if upload directories exist and if needed create them
        try {
            $container = $this->container;
            $controllerHelper = new \MU\ImageModule\Helper\ControllerHelper($container, $container->get('translator.default'), $container->get('session'), $container->get('logger'));
            $controllerHelper->checkAndCreateAllUploadFolders();
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            $logger->error('{app}: User {user} could not create upload folders during installation. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'user' => $userName, 'errorMessage' => $e->getMessage()]);
        
            return false;
        }
        // create all tables from according entity definitions
        try {
            $this->schemaTool->create($this->listEntityClasses());
        } catch (\Exception $e) {
            $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $e->getMessage());
            $logger->error('{app}: Could not create the database tables during installation. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'errorMessage' => $e->getMessage()]);
    
            return false;
        }
    
        // set up all our vars with initial values
        $this->setVar('supportCategories', false);
        $this->setVar('supportSubAlbums', false);
        $this->setVar('userDeletePictures', false);
        $this->setVar('slideshow1', false);
        $this->setVar('useAvatars', false);
        $this->setVar('useWatermark', false);
        $this->setVar('slide1Interval', 4000);
        $this->setVar('slide1Speed', 1000);
        $this->setVar('fileSizeForPictures', 102400);
        $this->setVar('fileSizeForAvatars', 0);
        $this->setVar('minWidthForPictures', 400);
        $this->setVar('maxWidthForPictures', 0);
        $this->setVar('maxHeightForPictures', 0);
        $this->setVar('minWidthForAvatars', 0);
        $this->setVar('maxWidthForAvatars', 0);
        $this->setVar('maxHeightForAvatars', 0);
        $this->setVar('firstWidth', 0);
        $this->setVar('firstHeight', 0);
        $this->setVar('secondWidth', 0);
        $this->setVar('secondHeight', 0);
        $this->setVar('thirdWidth', 0);
        $this->setVar('thirdHeight', 0);
        $this->setVar('fileNameForTitle', false);
        $this->setVar('numberOf', 2);
        $this->setVar('configAvatarWidthAndHeight', '200,200;400,400');
        $this->setVar('albumEntriesPerPageInBackend', 10);
        $this->setVar('pictureEntriesPerPageInBackend', 10);
        $this->setVar('avatarEntriesPerPageInBackend', 0);
        $this->setVar('countImageView', false);
        $this->setVar('numberParentAlbums', 1);
        $this->setVar('numberSubAlbums', 2);
        $this->setVar('numberPictures', 20);
        $this->setVar('groupForCommonAlbums',  'none' );
        $this->setVar('kindOfShowSubAlbums',  'panel' );
        $this->setVar('breadcrumbsInFrontend', false);
        $this->setVar('ending', 'html');
        $this->setVar('watermark', '');
        $this->setVar('bottom', 0);
        $this->setVar('left', 0);
        $this->setVar('right', 0);
        $this->setVar('top', 0);
        $this->setVar('moderationGroupForAvatars', 2);
        $this->setVar('albumEntriesPerPage', 10);
        $this->setVar('pictureEntriesPerPage', 10);
        $this->setVar('avatarEntriesPerPage', 10);
        $this->setVar('enableShrinkingForPictureImageUpload', false);
        $this->setVar('shrinkWidthPictureImageUpload', 800);
        $this->setVar('shrinkHeightPictureImageUpload', 600);
        $this->setVar('enableShrinkingForAvatarAvatarUpload', false);
        $this->setVar('shrinkWidthAvatarAvatarUpload', 800);
        $this->setVar('shrinkHeightAvatarAvatarUpload', 600);
        $this->setVar('thumbnailModePicture',  'inset' );
        $this->setVar('thumbnailWidthPictureImageUploadView', 32);
        $this->setVar('thumbnailHeightPictureImageUploadView', 24);
        $this->setVar('thumbnailWidthPictureImageUploadDisplay', 240);
        $this->setVar('thumbnailHeightPictureImageUploadDisplay', 180);
        $this->setVar('thumbnailWidthPictureImageUploadEdit', 240);
        $this->setVar('thumbnailHeightPictureImageUploadEdit', 180);
        $this->setVar('thumbnailModeAvatar',  'inset' );
        $this->setVar('thumbnailWidthAvatarAvatarUploadView', 32);
        $this->setVar('thumbnailHeightAvatarAvatarUploadView', 24);
        $this->setVar('thumbnailWidthAvatarAvatarUploadDisplay', 240);
        $this->setVar('thumbnailHeightAvatarAvatarUploadDisplay', 180);
        $this->setVar('thumbnailWidthAvatarAvatarUploadEdit', 240);
        $this->setVar('thumbnailHeightAvatarAvatarUploadEdit', 180);
    
        $categoryRegistryIdsPerEntity = [];
    
        // add default entry for category registry (property named Main)
        $categoryHelper = new \MU\ImageModule\Helper\CategoryHelper(
            $this->container,
            $this->container->get('translator.default'),
            $this->container->get('session'),
            $logger,
            $this->container->get('request_stack'),
            $this->container->get('zikula_users_module.current_user'),
            $this->container->get('zikula_categories_module.api.category_registry'),
            $this->container->get('zikula_categories_module.api.category_permission')
        );
        $categoryGlobal = $this->container->get('zikula_categories_module.api.category')->getCategoryByPath('/__SYSTEM__/Modules/Global');
    
        $registry = new CategoryRegistryEntity();
        $registry->setModname('MUImageModule');
        $registry->setEntityname('AlbumEntity');
        $registry->setProperty($categoryHelper->getPrimaryProperty(['ot' => 'Album']));
        $registry->setCategory_Id($categoryGlobal['id']);
    
        try {
            $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
            $entityManager->persist($registry);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('error', $this->__f('Error! Could not create a category registry for the %s entity.', ['%s' => 'album']));
            $logger->error('{app}: User {user} could not create a category registry for {entities} during installation. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'user' => $userName, 'entities' => 'albums', 'errorMessage' => $e->getMessage()]);
        }
        $categoryRegistryIdsPerEntity['album'] = $registry->getId();
    
        $registry = new CategoryRegistryEntity();
        $registry->setModname('MUImageModule');
        $registry->setEntityname('AvatarEntity');
        $registry->setProperty($categoryHelper->getPrimaryProperty(['ot' => 'Avatar']));
        $registry->setCategory_Id($categoryGlobal['id']);
    
        try {
            $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
            $entityManager->persist($registry);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->addFlash('error', $this->__f('Error! Could not create a category registry for the %s entity.', ['%s' => 'avatar']));
            $logger->error('{app}: User {user} could not create a category registry for {entities} during installation. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'user' => $userName, 'entities' => 'avatars', 'errorMessage' => $e->getMessage()]);
        }
        $categoryRegistryIdsPerEntity['avatar'] = $registry->getId();
    
        // create the default data
        $this->createDefaultData($categoryRegistryIdsPerEntity);
    
        // install subscriber hooks
        $this->hookApi->installSubscriberHooks($this->bundle->getMetaData());
        
    
        // initialisation successful
        return true;
    }
    
    /**
     * Upgrade the MUImageModule application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldVersion Version to upgrade from
     *
     * @return boolean True on success, false otherwise
     *
     * @throws RuntimeException Thrown if database tables can not be updated
     */
    public function upgrade($oldVersion)
    {
    /*
        $logger = $this->container->get('logger');
    
        // Upgrade dependent on old version number
        switch ($oldVersion) {
            case '1.0.0':
                // do something
                // ...
                // update the database schema
                try {
                    $this->schemaTool->update($this->listEntityClasses());
                } catch (\Exception $e) {
                    $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $e->getMessage());
                    $logger->error('{app}: Could not update the database tables during the upgrade. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'errorMessage' => $e->getMessage()]);
    
                    return false;
                }
        }
    
        // Note there are several helpers available for making migration of your extension easier.
        // The following convenience methods are each responsible for a single aspect of upgrading to Zikula 1.4.0.
    
        // here is a possible usage example
        // of course 1.2.3 should match the number you used for the last stable 1.3.x module version.
        /* if ($oldVersion = '1.2.3') {
            // rename module for all modvars
            $this->updateModVarsTo14();
            
            // update extension information about this app
            $this->updateExtensionInfoFor14();
            
            // rename existing permission rules
            $this->renamePermissionsFor14();
            
            // rename existing category registries
            $this->renameCategoryRegistriesFor14();
            
            // rename all tables
            $this->renameTablesFor14();
            
            // remove event handler definitions from database
            $this->dropEventHandlersFromDatabase();
            
            // update module name in the hook tables
            $this->updateHookNamesFor14();
            
            // update module name in the workflows table
            $this->updateWorkflowsFor14();
        } * /
    */
    
        // update successful
        return true;
    }
    
    /**
     * Renames the module name for variables in the module_vars table.
     */
    protected function updateModVarsTo14()
    {
        $dbName = $this->getDbName();
        $conn = $this->getConnection();
    
        $conn->executeQuery("
            UPDATE $dbName.module_vars
            SET modname = 'MUImageModule'
            WHERE modname = 'Image';
        ");
    }
    
    /**
     * Renames this application in the core's extensions table.
     */
    protected function updateExtensionInfoFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $conn->executeQuery("
            UPDATE $dbName.modules
            SET name = 'MUImageModule',
                directory = 'MU/ImageModule'
            WHERE name = 'Image';
        ");
    }
    
    /**
     * Renames all permission rules stored for this app.
     */
    protected function renamePermissionsFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $componentLength = strlen('Image') + 1;
    
        $conn->executeQuery("
            UPDATE $dbName.group_perms
            SET component = CONCAT('MUImageModule', SUBSTRING(component, $componentLength))
            WHERE component LIKE 'Image%';
        ");
    }
    
    /**
     * Renames all category registries stored for this app.
     */
    protected function renameCategoryRegistriesFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $componentLength = strlen('Image') + 1;
    
        $conn->executeQuery("
            UPDATE $dbName.categories_registry
            SET modname = CONCAT('MUImageModule', SUBSTRING(modname, $componentLength))
            WHERE modname LIKE 'Image%';
        ");
    }
    
    /**
     * Renames all (existing) tables of this app.
     */
    protected function renameTablesFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $oldPrefix = 'muimage_';
        $oldPrefixLength = strlen($oldPrefix);
        $newPrefix = 'mu_muimage_';
    
        $sm = $conn->getSchemaManager();
        $tables = $sm->listTables();
        foreach ($tables as $table) {
            $tableName = $table->getName();
            if (substr($tableName, 0, $oldPrefixLength) != $oldPrefix) {
                continue;
            }
    
            $newTableName = str_replace($oldPrefix, $newPrefix, $tableName);
    
            $conn->executeQuery("
                RENAME TABLE $dbName.$tableName
                TO $dbName.$newTableName;
            ");
        }
    }
    
    /**
     * Removes event handlers from database as they are now described by service definitions and managed by dependency injection.
     */
    protected function dropEventHandlersFromDatabase()
    {
        EventUtil::unregisterPersistentModuleHandlers('Image');
    }
    
    /**
     * Updates the module name in the hook tables.
     */
    protected function updateHookNamesFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $conn->executeQuery("
            UPDATE $dbName.hook_area
            SET owner = 'MUImageModule'
            WHERE owner = 'Image';
        ");
    
        $componentLength = strlen('subscriber.image') + 1;
        $conn->executeQuery("
            UPDATE $dbName.hook_area
            SET areaname = CONCAT('subscriber.muimagemodule', SUBSTRING(areaname, $componentLength))
            WHERE areaname LIKE 'subscriber.image%';
        ");
    
        $conn->executeQuery("
            UPDATE $dbName.hook_binding
            SET sowner = 'MUImageModule'
            WHERE sowner = 'Image';
        ");
    
        $conn->executeQuery("
            UPDATE $dbName.hook_runtime
            SET sowner = 'MUImageModule'
            WHERE sowner = 'Image';
        ");
    
        $componentLength = strlen('image') + 1;
        $conn->executeQuery("
            UPDATE $dbName.hook_runtime
            SET eventname = CONCAT('muimagemodule', SUBSTRING(eventname, $componentLength))
            WHERE eventname LIKE 'image%';
        ");
    
        $conn->executeQuery("
            UPDATE $dbName.hook_subscriber
            SET owner = 'MUImageModule'
            WHERE owner = 'Image';
        ");
    
        $componentLength = strlen('image') + 1;
        $conn->executeQuery("
            UPDATE $dbName.hook_subscriber
            SET eventname = CONCAT('muimagemodule', SUBSTRING(eventname, $componentLength))
            WHERE eventname LIKE 'image%';
        ");
    }
    
    /**
     * Updates the module name in the workflows table.
     */
    protected function updateWorkflowsFor14()
    {
        $conn = $this->getConnection();
        $dbName = $this->getDbName();
    
        $conn->executeQuery("
            UPDATE $dbName.workflows
            SET module = 'MUImageModule'
            WHERE module = 'Image';
        ");
    }
    
    /**
     * Returns connection to the database.
     *
     * @return Connection the current connection
     */
    protected function getConnection()
    {
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $connection = $entityManager->getConnection();
    
        return $connection;
    }
    
    /**
     * Returns the name of the default system database.
     *
     * @return string the database name
     */
    protected function getDbName()
    {
        return $this->container->getParameter('database_name');
    }
    
    /**
     * Uninstall MUImageModule.
     *
     * @return boolean True on success, false otherwise
     *
     * @throws RuntimeException Thrown if database tables or stored workflows can not be removed
     */
    public function uninstall()
    {
        $logger = $this->container->get('logger');
    
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule('MUImageModule');
        if (false === $result) {
            $this->addFlash('error', $this->__f('An error was encountered while removing stored object workflows for the %s extension.', ['%s' => 'MUImageModule']));
            $logger->error('{app}: Could not remove stored object workflows during uninstallation.', ['app' => 'MUImageModule']);
    
            return false;
        }
    
        try {
            $this->schemaTool->drop($this->listEntityClasses());
        } catch (\Exception $e) {
            $this->addFlash('error', $this->__('Doctrine Exception') . ': ' . $e->getMessage());
            $logger->error('{app}: Could not remove the database tables during uninstallation. Error details: {errorMessage}.', ['app' => 'MUImageModule', 'errorMessage' => $e->getMessage()]);
    
            return false;
        }
    
        // uninstall subscriber hooks
        $this->hookApi->uninstallSubscriberHooks($this->bundle->getMetaData());
        
    
        // remove all module vars
        $this->delVars();
    
        // remove category registry entries
        ModUtil::dbInfoLoad('ZikulaCategoriesModule');
        DBUtil::deleteWhere('categories_registry', 'modname = \'MUImageModule\'');
    
        // remove all thumbnails
        $manager = $this->container->get('systemplugin.imagine.manager');
        $manager->setModule('MUImageModule');
        $manager->cleanupModuleThumbs();
    
        // remind user about upload folders not being deleted
        $uploadPath = $this->container->getParameter('datadir') . '/MUImageModule/';
        $this->addFlash('status', $this->__f('The upload directories at [%s] can be removed manually.', ['%s' => $uploadPath]));
    
        // uninstallation successful
        return true;
    }
    
    /**
     * Build array with all entity classes for MUImageModule.
     *
     * @return array list of class names
     */
    protected function listEntityClasses()
    {
        $classNames = [];
        $classNames[] = 'MU\ImageModule\Entity\AlbumEntity';
        $classNames[] = 'MU\ImageModule\Entity\AlbumCategoryEntity';
        $classNames[] = 'MU\ImageModule\Entity\PictureEntity';
        $classNames[] = 'MU\ImageModule\Entity\AvatarEntity';
        $classNames[] = 'MU\ImageModule\Entity\AvatarCategoryEntity';
    
        return $classNames;
    }
    
    /**
     * Create the default data for MUImageModule.
     *
     * @param array $categoryRegistryIdsPerEntity List of category registry ids
     *
     * @return void
     */
    protected function createDefaultData($categoryRegistryIdsPerEntity)
    {
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $logger = $this->container->get('logger');
        $request = $this->container->get('request_stack')->getMasterRequest();
        
        $entityClass = 'MU\ImageModule\Entity\AlbumEntity';
        $entityManager->getRepository($entityClass)->truncateTable($logger);
        $entityClass = 'MU\ImageModule\Entity\PictureEntity';
        $entityManager->getRepository($entityClass)->truncateTable($logger);
        $entityClass = 'MU\ImageModule\Entity\AvatarEntity';
        $entityManager->getRepository($entityClass)->truncateTable($logger);
    }
}
