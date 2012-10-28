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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Thu Feb 23 22:43:24 CET 2012.
 */

/**
 * Installer base class
 */
class MUImage_Base_Installer extends Zikula_AbstractInstaller
{
    /**
     * Install the MUImage application.
     *
     * @return boolean True on success, or false.
     */
    public function install()
    {
        $basePath = MUImage_Util_Controller::getFileBaseFolder('picture', 'imageUpload');
        if (!is_dir($basePath)) {
            return LogUtil::registerError($this->__f('The upload folder "%s" does not exist. Please create it before installing this application.', array($basePath)));
        }
        if (!is_writable($basePath)) {
            return LogUtil::registerError($this->__f('The upload folder "%s" is not writable. Please change permissions accordingly before installing this application.', array($basePath)));
        }

        // create all tables from according entity definitions
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while creating the tables for the %s module.', array($this->getName())));
        }

        // set up all our vars with initial values
        $this->setVar('pagesize', 10);
        $this->setVar('showTitle', false);
        $this->setVar('showDescription', false);
        $this->setVar('countImageView', false);
        $this->setVar('numberParentAlbums', 1);
        $this->setVar('numberSubAlbums', 2);
        $this->setVar('numberPictures', 20);
        $this->setVar('fileSize', '');

        // create the default data for MUImage
        $this->createDefaultData();

        // add entries to category registry
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/Global');
        CategoryRegistryUtil::insertEntry('MUImage', 'Album', 'Main', $rootcat['id']);

        // register persistent event handlers
        $this->registerPersistentEventHandlers();

        // register hook subscriber bundles
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());

        // initialisation successful
        return true;
    }

    /**
     * Upgrade the MUImage application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldversion Version to upgrade from.
     *
     * @return boolean True on success, false otherwise.
     */
    public function upgrade($oldversion)
    {
        /*
         // Upgrade dependent on old version number
         switch ($oldversion) {
         case 1.0.0:
         // do something
         // ...
         // update the database schema
         try {
         DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
         } catch (Exception $e) {
         if (System::isDevelopmentMode()) {
         LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
         }
         return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
         }
         }
         */

        // update successful
        return true;
    }

    /**
     * Uninstall MUImage.
     *
     * @return boolean True on success, false otherwise.
     */
    public function uninstall()
    {
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule($this->getName());
        if ($result === false) {
            return LogUtil::registerError($this->__f('An error was encountered while removing stored object workflows for the %s module.', array($this->getName())));
        }

        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
        }

        // unregister persistent event handlers
        EventUtil::unregisterPersistentModuleHandlers('MUImage');

        // unregister hook subscriber bundles
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());

        // remove all module vars
        $this->delVars();

        // remove category registry entries
        ModUtil::dbInfoLoad('Categories');
        DBUtil::deleteWhere('categories_registry', "modname = 'MUImage'");

        // deletion successful
        return true;
    }

    /**
     * Build array with all entity classes for MUImage.
     *
     * @return array list of class names.
     */
    protected function listEntityClasses()
    {
        $classNames = array();
        $classNames[] = 'MUImage_Entity_Album';
        $classNames[] = 'MUImage_Entity_AlbumCategory';
        $classNames[] = 'MUImage_Entity_Picture';

        return $classNames;
    }
    /**
     * Create the default data for MUImage.
     *
     * @return void
     */
    protected function createDefaultData()
    {
        // Ensure that tables are cleared
        $this->entityManager->transactional(function ($entityManager)
        {
            $entityManager->getRepository('MUImage_Entity_Album')->truncateTable();
            $entityManager->getRepository('MUImage_Entity_Picture')->truncateTable();
        }
        );

        // Insertion successful
        return true;
    }

    /**
     * Register persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    protected function registerPersistentEventHandlers()
    {
        // core
        EventUtil::registerPersistentModuleHandler('MUImage', 'api.method_not_found', array('MUImage_Listener_Core', 'apiMethodNotFound'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'core.preinit', array('MUImage_Listener_Core', 'preInit'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'core.init', array('MUImage_Listener_Core', 'init'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'core.postinit', array('MUImage_Listener_Core', 'postInit'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'controller.method_not_found', array('MUImage_Listener_Core', 'controllerMethodNotFound'));

        // installer
        EventUtil::registerPersistentModuleHandler('MUImage', 'installer.module.installed', array('MUImage_Listener_Installer', 'moduleInstalled'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'installer.module.upgraded', array('MUImage_Listener_Installer', 'moduleUpgraded'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'installer.module.uninstalled', array('MUImage_Listener_Installer', 'moduleUninstalled'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'installer.subscriberarea.uninstalled', array('MUImage_Listener_Installer', 'subscriberAreaUninstalled'));

        // modules
        EventUtil::registerPersistentModuleHandler('MUImage', 'module_dispatch.postloadgeneric', array('MUImage_Listener_ModuleDispatch', 'postLoadGeneric'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module_dispatch.preexecute', array('MUImage_Listener_ModuleDispatch', 'preExecute'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module_dispatch.postexecute', array('MUImage_Listener_ModuleDispatch', 'postExecute'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module_dispatch.custom_classname', array('MUImage_Listener_ModuleDispatch', 'customClassname'));

        // mailer
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.mailer.api.sendmessage', array('MUImage_Listener_Mailer', 'sendMessage'));

        // page
        EventUtil::registerPersistentModuleHandler('MUImage', 'pageutil.addvar_filter', array('MUImage_Listener_Page', 'pageutilAddvarFilter'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'system.outputfilter', array('MUImage_Listener_Page', 'systemOutputfilter'));

        // errors
        EventUtil::registerPersistentModuleHandler('MUImage', 'setup.errorreporting', array('MUImage_Listener_Errors', 'setupErrorReporting'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'systemerror', array('MUImage_Listener_Errors', 'systemError'));

        // theme
        EventUtil::registerPersistentModuleHandler('MUImage', 'theme.preinit', array('MUImage_Listener_Theme', 'preInit'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'theme.init', array('MUImage_Listener_Theme', 'init'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'theme.load_config', array('MUImage_Listener_Theme', 'loadConfig'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'theme.prefetch', array('MUImage_Listener_Theme', 'preFetch'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'theme.postfetch', array('MUImage_Listener_Theme', 'postFetch'));

        // view
        EventUtil::registerPersistentModuleHandler('MUImage', 'view.init', array('MUImage_Listener_View', 'init'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'view.postfetch', array('MUImage_Listener_View', 'postFetch'));

        // user login
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.login.started', array('MUImage_Listener_UserLogin', 'started'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.login.veto', array('MUImage_Listener_UserLogin', 'veto'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.login.succeeded', array('MUImage_Listener_UserLogin', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.login.failed', array('MUImage_Listener_UserLogin', 'failed'));

        // user logout
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.logout.succeeded', array('MUImage_Listener_UserLogout', 'succeeded'));

        // user
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.gettheme', array('MUImage_Listener_User', 'getTheme'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.account.create', array('MUImage_Listener_User', 'create'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.account.update', array('MUImage_Listener_User', 'update'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.account.delete', array('MUImage_Listener_User', 'delete'));

        // registration
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.registration.started', array('MUImage_Listener_UserRegistration', 'started'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.registration.succeeded', array('MUImage_Listener_UserRegistration', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.ui.registration.failed', array('MUImage_Listener_UserRegistration', 'failed'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.registration.create', array('MUImage_Listener_UserRegistration', 'create'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.registration.update', array('MUImage_Listener_UserRegistration', 'update'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'user.registration.delete', array('MUImage_Listener_UserRegistration', 'delete'));

        // users module
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.users.config.updated', array('MUImage_Listener_Users', 'configUpdated'));

        // group
        EventUtil::registerPersistentModuleHandler('MUImage', 'group.create', array('MUImage_Listener_Group', 'create'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'group.update', array('MUImage_Listener_Group', 'update'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'group.delete', array('MUImage_Listener_Group', 'delete'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'group.adduser', array('MUImage_Listener_Group', 'addUser'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'group.removeuser', array('MUImage_Listener_Group', 'removeUser'));

        // special purposes and 3rd party api support
        EventUtil::registerPersistentModuleHandler('MUImage', 'get.pending_content', array('MUImage_Listener_ThirdParty', 'pendingContentListener'));
        EventUtil::registerPersistentModuleHandler('MUImage', 'module.content.gettypes', array('MUImage_Listener_ThirdParty', 'contentGetTypes'));
    }
}
