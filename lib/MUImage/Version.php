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
 * Version information implementation class.
 */
class MUImage_Version extends MUImage_Base_Version
{

    public function getMetaData()
    {
        $meta = array();
        // the current module version
        $meta['version'] = '1.1.1';
        // the displayed name of the module
        $meta['displayname'] = $this->__('MUImage');
        // the module description
        $meta['description'] = $this->__('MUImage Pictures in Albums and SubAlbums');
        //! url version of name, should be in lowercase without space
        $meta['url'] = $this->__('muimage');
        // core requirement
        $meta['core_min'] = '1.3.1'; // requires minimum 1.3.1 or later
        $meta['core_max'] = '1.3.99'; // not ready for 1.4.0 yet

        // define special capabilities of this module
        $meta['capabilities'] = array(
            HookUtil::SUBSCRIBER_CAPABLE => array('enabled' => true), 
            HookUtil::PROVIDER_CAPABLE => array('enabled' => true) // TODO: see #15
           /*,  'authentication' => array('version' => '1.0'),
             'profile'        => array('version' => '1.0', 'anotherkey' => 'anothervalue'),
             'message'        => array('version' => '1.0', 'anotherkey' => 'anothervalue')
             */
        );

        // permission schema
        // DEBUG: permission schema aspect starts
        $meta['securityschema'] = array(
            'MUImage::'             => '::',

            'MUImage:Album:Album'   => 'AlbumID:AlbumID:',

            'MUImage:Album:'        => 'AlbumID::',
            'MUImage:Album:Picture' => 'AlbumID:PictureID:',

            'MUImage:Picture:'      => 'PictureID::',
            
            'MUImage:OneItemBlock:'      => 'BlockId::',
            'MUImage:ItemListBlock:'      => 'BlockId::'
        );
        // DEBUG: permission schema aspect ends

        return $meta;
    }
    
    /**
     * Define hook subscriber bundles.
     */
    protected function setupHookBundles()
    {
    	$bundle = new Zikula_HookManager_ProviderBundle($this->name, 'provider.muimage.ui_hooks.service', 'ui_hooks', $this->__('MUImage - Create album'));
    	// form_edit hook is used to add smiley selector and other code to new object form (validate and process hooks unneeded)
    	$bundle->addServiceHandler('form_edit', 'MUImage_HookHandlers', 'uiEdit', 'muimage.album');
    	$bundle->addServiceHandler('process_edit', 'MUImage_HookHandlers', 'processEdit', 'muimage.album');
    	$this->registerHookProviderBundle($bundle);
    	
    	parent::setupHookBundles();
    }
}
