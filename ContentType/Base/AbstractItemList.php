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

namespace MU\ImageModule\ContentType\Base;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use MU\ImageModule\Helper\FeatureActivationHelper;

/**
 * Generic item list content plugin base class.
 */
abstract class AbstractItemList extends \Content_AbstractContentType implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * The treated object type.
     *
     * @var string
     */
    protected $objectType;
    
    /**
     * The sorting criteria.
     *
     * @var string
     */
    protected $sorting;
    
    /**
     * The amount of desired items.
     *
     * @var integer
     */
    protected $amount;
    
    /**
     * Name of template file.
     *
     * @var string
     */
    protected $template;
    
    /**
     * Name of custom template file.
     *
     * @var string
     */
    protected $customTemplate;
    
    /**
     * Optional filters.
     *
     * @var string
     */
    protected $filter;
    
    /**
     * List of object types allowing categorisation.
     *
     * @var array
     */
    protected $categorisableObjectTypes;
    
    /**
     * List of category registries for different trees.
     *
     * @var array
     */
    protected $catRegistries;
    
    /**
     * List of category properties for different trees.
     *
     * @var array
     */
    protected $catProperties;
    
    /**
     * List of category ids with sub arrays for each registry.
     *
     * @var array
     */
    protected $catIds;
    
    /**
     * ItemList constructor.
     */
    public function __construct()
    {
        $this->setContainer(\ServiceUtil::getManager());
    }
    
    /**
     * Returns the module providing this content type.
     *
     * @return string The module name
     */
    public function getModule()
    {
        return 'MUImageModule';
    }
    
    /**
     * Returns the name of this content type.
     *
     * @return string The content type name
     */
    public function getName()
    {
        return 'ItemList';
    }
    
    /**
     * Returns the title of this content type.
     *
     * @return string The content type title
     */
    public function getTitle()
    {
        return $this->container->get('translator.default')->__('MUImageModule list view');
    }
    
    /**
     * Returns the description of this content type.
     *
     * @return string The content type description
     */
    public function getDescription()
    {
        return $this->container->get('translator.default')->__('Display list of MUImageModule objects.');
    }
    
    /**
     * Loads the data.
     *
     * @param array $data Data array with parameters
     */
    public function loadData(&$data)
    {
        $controllerHelper = $this->container->get('mu_image_module.controller_helper');
    
        $contextArgs = ['name' => 'list'];
        if (!isset($data['objectType']) || !in_array($data['objectType'], $controllerHelper->getObjectTypes('contentType', $contextArgs))) {
            $data['objectType'] = $controllerHelper->getDefaultObjectType('contentType', $contextArgs);
        }
    
        $this->objectType = $data['objectType'];
    
        if (!isset($data['sorting'])) {
            $data['sorting'] = 'default';
        }
        if (!isset($data['amount'])) {
            $data['amount'] = 1;
        }
        if (!isset($data['template'])) {
            $data['template'] = 'itemlist_' . $this->objectType . '_display.html.twig';
        }
        if (!isset($data['customTemplate'])) {
            $data['customTemplate'] = '';
        }
        if (!isset($data['filter'])) {
            $data['filter'] = '';
        }
    
        $this->sorting = $data['sorting'];
        $this->amount = $data['amount'];
        $this->template = $data['template'];
        $this->customTemplate = $data['customTemplate'];
        $this->filter = $data['filter'];
        $featureActivationHelper = $this->container->get('mu_image_module.feature_activation_helper');
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $this->objectType)) {
            $this->categorisableObjectTypes = ['album', 'avatar'];
            $categoryHelper = $this->container->get('mu_image_module.category_helper');
    
            // fetch category properties
            $this->catRegistries = [];
            $this->catProperties = [];
            if (in_array($this->objectType, $this->categorisableObjectTypes)) {
                $selectionHelper = $this->container->get('mu_image_module.selection_helper');
                $idFields = $selectionHelper->getIdFields($this->objectType);
                $this->catRegistries = $categoryHelper->getAllPropertiesWithMainCat($this->objectType, $idFields[0]);
                $this->catProperties = $categoryHelper->getAllProperties($this->objectType);
            }
    
            if (!isset($data['catIds'])) {
                $primaryRegistry = $categoryHelper->getPrimaryProperty($this->objectType);
                $data['catIds'] = [$primaryRegistry => []];
                // backwards compatibility
                if (isset($data['catId'])) {
                    $data['catIds'][$primaryRegistry][] = $data['catId'];
                    unset($data['catId']);
                }
            } elseif (!is_array($data['catIds'])) {
                $data['catIds'] = explode(',', $data['catIds']);
            }
    
            foreach ($this->catRegistries as $registryId => $registryCid) {
                $propName = '';
                foreach ($this->catProperties as $propertyName => $propertyId) {
                    if ($propertyId == $registryId) {
                        $propName = $propertyName;
                        break;
                    }
                }
                if (isset($data['catids' . $propName])) {
                    $data['catIds'][$propName] = $data['catids' . $propName];
                }
                if (!is_array($data['catIds'][$propName])) {
                    if ($data['catIds'][$propName]) {
                        $data['catIds'][$propName] = [$data['catIds'][$propName]];
                    } else {
                        $data['catIds'][$propName] = [];
                    }
                }
            }
    
            $this->catIds = $data['catIds'];
        }
    }
    
    /**
     * Displays the data.
     *
     * @return string The returned output
     */
    public function display()
    {
        $repository = $this->container->get('mu_image_module.entity_factory')->getRepository($objectType);
        $permissionApi = $this->container->get('zikula_permissions_module.api.permission');
    
        // create query
        $where = $this->filter;
        $orderBy = $this->getSortParam($repository);
        $qb = $repository->genericBaseQuery($where, $orderBy);
    
        $featureActivationHelper = $this->container->get('mu_image_module.feature_activation_helper');
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $this->objectType)) {
            // apply category filters
            if (in_array($this->objectType, $this->categorisableObjectTypes)) {
                if (is_array($this->catIds) && count($this->catIds) > 0) {
                    $categoryHelper = $this->container->get('mu_image_module.category_helper');
                    $qb = $categoryHelper->buildFilterClauses($qb, $this->objectType, $this->catIds);
                }
            }
        }
    
        // get objects from database
        $currentPage = 1;
        $resultsPerPage = isset($this->amount) ? $this->amount : 1;
        $query = $repository->getSelectWherePaginatedQuery($qb, $currentPage, $resultsPerPage);
        list($entities, $objectCount) = $repository->retrieveCollectionResult($query, $orderBy, true);
    
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $this->objectType)) {
            $entities = $categoryHelper->filterEntitiesByPermission($entities);
        }
    
        $data = [
            'objectType' => $this->objectType,
            'catids' => $this->catIds,
            'sorting' => $this->sorting,
            'amount' => $this->amount,
            'template' => $this->template,
            'customTemplate' => $this->customTemplate,
            'filter' => $this->filter
        ];
    
        $templateParameters = [
            'vars' => $data,
            'objectType' => $this->objectType,
            'items' => $entities
        ];
    
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $this->objectType)) {
            $templateParameters['registries'] = $this->catRegistries;
            $templateParameters['properties'] = $this->catProperties;
        }
    
        $imageHelper = $this->container->get('mu_image_module.image_helper');
        $templateParameters = array_merge($templateData, $repository->getAdditionalTemplateParameters($imageHelper, 'contentType'));
    
        $template = $this->getDisplayTemplate();
    
        return $this->container->get('twig')->render('@MUImageModule/' . $template, $templateParameters);
    }
    
    /**
     * Returns the template used for output.
     *
     * @return string the template path
     */
    protected function getDisplayTemplate()
    {
        $templateFile = $this->template;
        if ($templateFile == 'custom') {
            $templateFile = $this->customTemplate;
        }
    
        $templateForObjectType = str_replace('itemlist_', 'itemlist_' . $this->objectType . '_', $templateFile);
    
        $template = '';
        if ($this->view->template_exists('ContentType/' . $templateForObjectType)) {
            $template = 'ContentType/' . $templateForObjectType;
        } elseif ($this->view->template_exists('ContentType/' . $templateFile)) {
            $template = 'ContentType/' . $templateFile;
        } else {
            $template = 'ContentType/itemlist_display.html.twig';
        }
    
        return $template;
    }
    
    /**
     * Determines the order by parameter for item selection.
     *
     * @param Doctrine_Repository $repository The repository used for data fetching
     *
     * @return string the sorting clause
     */
    protected function getSortParam($repository)
    {
        if ($this->sorting == 'random') {
            return 'RAND()';
        }
    
        $sortParam = '';
        if ($this->sorting == 'newest') {
            $selectionHelper = $this->container->get('mu_image_module.selection_helper');
            $idFields = $selectionHelper->getIdFields($this->objectType);
            if (count($idFields) == 1) {
                $sortParam = $idFields[0] . ' DESC';
            } else {
                foreach ($idFields as $idField) {
                    if (!empty($sortParam)) {
                        $sortParam .= ', ';
                    }
                    $sortParam .= $idField . ' DESC';
                }
            }
        } elseif ($this->sorting == 'default') {
            $sortParam = $repository->getDefaultSortingField() . ' ASC';
        }
    
        return $sortParam;
    }
    
    /**
     * Displays the data for editing.
     */
    public function displayEditing()
    {
        return $this->display();
    }
    
    /**
     * Returns the default data.
     *
     * @return array Default data and parameters
     */
    public function getDefaultData()
    {
        return [
            'objectType' => 'album',
            'sorting' => 'default',
            'amount' => 1,
            'template' => 'itemlist_display.html.twig',
            'customTemplate' => '',
            'filter' => ''
        ];
    }
    
    /**
     * Executes additional actions for the editing mode.
     */
    public function startEditing()
    {
        // ensure that the view does not look for templates in the Content module (#218)
        $this->view->toplevelmodule = 'MUImageModule';
    
        // ensure our custom plugins are loaded
        array_push($this->view->plugins_dir, 'modules/MU/ImageModule/Resources/views//plugins');
    
        $featureActivationHelper = $this->container->get('mu_image_module.feature_activation_helper');
        if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $this->objectType)) {
            // assign category data
            $this->view->assign('registries', $this->catRegistries)
                       ->assign('properties', $this->catProperties);
    
            // assign categories lists for simulating category selectors
            $translator = $this->container->get('translator.default');
            $locale = $this->container->get('request_stack')->getCurrentRequest()->getLocale();
            $categories = [];
            $categoryApi = $this->container->get('zikula_categories_module.api.category');
            foreach ($this->catRegistries as $registryId => $registryCid) {
                $propName = '';
                foreach ($this->catProperties as $propertyName => $propertyId) {
                    if ($propertyId == $registryId) {
                        $propName = $propertyName;
                        break;
                    }
                }
    
                //$mainCategory = $categoryApi->getCategoryById($registryCid);
                $cats = $categoryApi->getSubCategories($registryCid, true, true, false, true, false, null, '', null, 'sort_value');
                $catsForDropdown = [
                    ['value' => '', 'text' => $translator->__('All')]
                ];
                foreach ($cats as $cat) {
                    $catName = isset($cat['display_name'][$locale]) ? $cat['display_name'][$locale] : $cat['name'];
                    $catsForDropdown[] = ['value' => $cat['id'], 'text' => $catName];
                }
                $categories[$propName] = $catsForDropdown;
            }
    
            $this->view->assign('categories', $categories)
                       ->assign('categoryHelper', $this->container->get('mu_image_module.category_helper'));
        }
    }
    
    /**
     * Returns the edit template path.
     *
     * @return string
     */
    public function getEditTemplate()
    {
        $absoluteTemplatePath = str_replace('ContentType/Base/AbstractItemList.php', 'Resources/views/ContentType/itemlist_edit.tpl', __FILE__);
    
        return 'file:' . $absoluteTemplatePath;
    }
}
