
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
 * Configuration handler base class
 */
class MUImage_Form_Handler_Admin_Base_Import extends Zikula_Form_AbstractHandler
{
	/**
	 * Post construction hook.
	 *
	 * @return mixed
	 */
	public function setup()
	{
	}

	/**
	 * Initialize form handler.
	 *
	 * This method takes care of all necessary initialisation of our data and form states.
	 *
	 * @return boolean False in case of initialization errors, otherwise true.
	 */
	public function initialize(Zikula_Form_View $view)
	{
		// permission check
		if (!SecurityUtil::checkPermission('MUImage::', '::', ACCESS_ADMIN)) {
			return $view->registerError(LogUtil::registerPermissionError());
		}

		// custom initialisation aspects
		$this->initializeAdditions();

		// everything okay, no initialization errors occured
		return true;
	}

	/**
	 * Method stub for own additions in subclasses.
	 */
	protected function initializeAdditions()
	{
		$view = new Zikula_Request_Http();
		$step = MUImage_Util_View::getStep();

		if ($step == 'first') {
			$modules = ModUtil::apiFunc($this->name, 'import', 'getModules');

			$supportedmodules = array();

			foreach($modules as $module => $value) {
				$supportedmodules[] = array('value' => $value, 'text' => $value);
			}

			$import = $this->view->get_template_vars('import');
			$import['importmoduleItems'] = $supportedmodules;
			$this->view->assign('import', $import);
		}
	}

	/**
	 * Pre-initialise hook.
	 *
	 * @return void
	 */
	public function preInitialize()
	{
	}

	/**
	 * Post-initialise hook.
	 *
	 * @return void
	 */
	public function postInitialize()
	{
	}

	/**
	 * Command event handler.
	 *
	 * This event handler is called when a command is issued by the user. Commands are typically something
	 * that originates from a {@link Zikula_Form_Plugin_Button} plugin. The passed args contains different properties
	 * depending on the command source, but you should at least find a <var>$args['commandName']</var>
	 * value indicating the name of the command. The command name is normally specified by the plugin
	 * that initiated the command.
	 * @see Zikula_Form_Plugin_Button
	 * @see Zikula_Form_Plugin_ImageButton
	 */
	public function handleCommand(Zikula_Form_View $view, &$args)
	{
		$step = MUImage_Util_View::getStep();

		// Execute form using supplied template and page event handler
		//return ModUtil::func($this->name, 'admin', 'modulealbums');

		if ($args['commandName'] == 'start') {
			// check if all fields are valid


			// retrieve form data
			$data = $this->view->getValues();
				
			// check if existing supporters deleting
			$arguments['importmodule'] = $data['import']['importmodule'];

		}
		// redirect back to the config page
		$url = ModUtil::url('MUImage', 'admin', 'modulealbums', $arguments);
		return $this->view->redirect($url);

	}
}
