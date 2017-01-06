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

namespace MU\ImageModule\Twig\Base;

use Twig_Extension;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\ExtensionsModule\Api\VariableApi;
use MU\ImageModule\Helper\ControllerHelper;
use MU\ImageModule\Helper\ListEntriesHelper;
use MU\ImageModule\Helper\ViewHelper;
use MU\ImageModule\Helper\WorkflowHelper;

/**
 * Twig extension base class.
 */
abstract class AbstractTwigExtension extends Twig_Extension
{
    use TranslatorTrait;
    
    /**
     * @var VariableApi
     */
    protected $variableApi;
    
    /**
     * @var WorkflowHelper
     */
    protected $workflowHelper;
    
    /**
     * @var ViewHelper
     */
    protected $viewHelper;
    
    /**
     * @var ListEntriesHelper
     */
    protected $listHelper;
    
    /**
     * @var ControllerHelper
     */
    protected $controllerHelper;
    
    /**
     * TwigExtension constructor.
     *
     * @param TranslatorInterface $translator     Translator service instance
     * @param VariableApi         $variableApi    VariableApi service instance
     * @param WorkflowHelper      $workflowHelper WorkflowHelper service instance
     * @param ViewHelper          $viewHelper     ViewHelper service instance
     * @param ListEntriesHelper   $listHelper     ListEntriesHelper service instance
     */
    public function __construct(TranslatorInterface $translator, VariableApi $variableApi, WorkflowHelper $workflowHelper, ViewHelper $viewHelper, ListEntriesHelper $listHelper)
    {
        $this->setTranslator($translator);
        $this->variableApi = $variableApi;
        $this->workflowHelper = $workflowHelper;
        $this->viewHelper = $viewHelper;
        $this->listHelper = $listHelper;
    }
    
    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }
    
    /**
     * Returns a list of custom Twig functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('muimagemodule_moderationObjects', [$this, 'getModerationObjects']),
            new \Twig_SimpleFunction('muimagemodule_objectTypeSelector', [$this, 'getObjectTypeSelector']),
            new \Twig_SimpleFunction('muimagemodule_templateSelector', [$this, 'getTemplateSelector']),
            new \Twig_SimpleFunction('muimagemodule_userVar', [$this, 'getUserVar']),
            new \Twig_SimpleFunction('muimagemodule_userAvatar', [$this, 'getUserAvatar'], ['is_safe' => ['html']])
        ];
    }
    
    /**
     * Returns a list of custom Twig filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('muimagemodule_fileSize', [$this, 'getFileSize'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('muimagemodule_listEntry', [$this, 'getListEntry']),
            new \Twig_SimpleFilter('muimagemodule_objectState', [$this, 'getObjectState'], ['is_safe' => ['html']])
        ];
    }
    
    /**
     * The muimagemodule_objectState filter displays the name of a given object's workflow state.
     * Examples:
     *    {{ item.workflowState|muimagemodule_objectState }}        {# with visual feedback #}
     *    {{ item.workflowState|muimagemodule_objectState(false) }} {# no ui feedback #}
     *
     * @param string  $state      Name of given workflow state
     * @param boolean $uiFeedback Whether the output should include some visual feedback about the state
     *
     * @return string Enriched and translated workflow state ready for display
     */
    public function getObjectState($state = 'initial', $uiFeedback = true)
    {
        $stateInfo = $this->workflowHelper->getStateInfo($state);
    
        $result = $stateInfo['text'];
        if (true === $uiFeedback) {
            $result = '<span class="label label-' . $stateInfo['ui'] . '">' . $result . '</span>';
        }
    
        return $result;
    }
    
    
    /**
     * The muimagemodule_fileSize filter displays the size of a given file in a readable way.
     * Example:
     *     {{ 12345|muimagemodule_fileSize }}
     *
     * @param integer $size     File size in bytes
     * @param string  $filepath The input file path including file name (if file size is not known)
     * @param boolean $nodesc   If set to true the description will not be appended
     * @param boolean $onlydesc If set to true only the description will be returned
     *
     * @return string File size in a readable form
     */
    public function getFileSize($size = 0, $filepath = '', $nodesc = false, $onlydesc = false)
    {
        if (!is_numeric($size)) {
            $size = (int) $size;
        }
        if (!$size) {
            if (empty($filepath) || !file_exists($filepath)) {
                return '';
            }
            $size = filesize($filepath);
        }
        if (!$size) {
            return '';
        }
    
        return $this->viewHelper->getReadableFileSize($size, $nodesc, $onlydesc);
    }
    
    
    /**
     * The muimagemodule_listEntry filter displays the name
     * or names for a given list item.
     * Example:
     *     {{ entity.listField|muimagemodule_listEntry('entityName', 'fieldName') }}
     *
     * @param string $value      The dropdown value to process
     * @param string $objectType The treated object type
     * @param string $fieldName  The list field's name
     * @param string $delimiter  String used as separator for multiple selections
     *
     * @return string List item name
     */
    public function getListEntry($value, $objectType = '', $fieldName = '', $delimiter = ', ')
    {
        if ((empty($value) && $value != '0') || empty($objectType) || empty($fieldName)) {
            return $value;
        }
    
        return $this->listHelper->resolve($value, $objectType, $fieldName, $delimiter);
    }
    
    
    /**
     * The muimagemodule_moderationObjects function determines the amount of unapproved objects.
     * It uses the same logic as the moderation block and the pending content listener.
     *
     * @return string The output of the plugin
     */
    public function getModerationObjects()
    {
        return $this->workflowHelper->collectAmountOfModerationItems();
    }
    
    
    /**
     * The muimagemodule_objectTypeSelector function provides items for a dropdown selector.
     *
     * @return string The output of the plugin
     */
    public function getObjectTypeSelector()
    {
        $result = [];
    
        $result[] = ['text' => $this->__('Albums'), 'value' => 'album'];
        $result[] = ['text' => $this->__('Pictures'), 'value' => 'picture'];
        $result[] = ['text' => $this->__('Avatars'), 'value' => 'avatar'];
    
        return $result;
    }
    
    
    /**
     * The muimagemodule_templateSelector function provides items for a dropdown selector.
     *
     * @return string The output of the plugin
     */
    public function getTemplateSelector()
    {
        $result = [];
    
        $result[] = ['text' => $this->__('Only item titles'), 'value' => 'itemlist_display.html.twig'];
        $result[] = ['text' => $this->__('With description'), 'value' => 'itemlist_display_description.html.twig'];
        $result[] = ['text' => $this->__('Custom template'), 'value' => 'custom'];
    
        return $result;
    }
    
    /**
     * Returns the value of a user variable.
     *
     * @param string     $name    Name of desired property
     * @param int        $uid     The user's id
     * @param string|int $default The default value
     *
     * @return string
     */
    public function getUserVar($name, $uid = -1, $default = '')
    {
        if (!$uid) {
            $uid = -1;
        }
    
        $result = \UserUtil::getVar($name, $uid, $default);
    
        return $result;
    }
    
    /**
     * Display the avatar of a user.
     *
     * @param int    $uid    The user's id
     * @param int    $width  Image width (optional)
     * @param int    $height Image height (optional)
     * @param int    $size   Gravatar size (optional)
     * @param string $rating Gravatar self-rating [g|pg|r|x] see: http://en.gravatar.com/site/implement/images/ (optional)
     *
     * @return string
     */
    public function getUserAvatar($uid = 0, $width = 0, $height = 0, $size = 0, $rating = '')
    {
        $params = ['uid' => $uid];
        if ($width > 0) {
            $params['width'] = $width;
        }
        if ($height > 0) {
            $params['height'] = $height;
        }
        if ($size > 0) {
            $params['size'] = $size;
        }
        if ($rating != '') {
            $params['rating'] = $rating;
        }
    
        include_once 'lib/legacy/viewplugins/function.useravatar.php';
    
        $view = \Zikula_View::getInstance('MUImageModule');
        $result = smarty_function_useravatar($params, $view);
    
        return $result;
    }
}
