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

namespace MU\ImageModule\Helper\Base;

use ServiceUtil;
use Zikula\Core\RouteUrl;
use Zikula\SearchModule\AbstractSearchable;
use MU\ImageModule\Helper\FeatureActivationHelper;

/**
 * Search helper base class.
 */
abstract class AbstractSearchHelper extends AbstractSearchable
{
    /**
     * Display the search form.
     *
     * @param boolean    $active  if the module should be checked as active
     * @param array|null $modVars module form vars as previously set
     *
     * @return string Template output
     */
    public function getOptions($active, $modVars = null)
    {
        $serviceManager = ServiceUtil::getManager();
        $permissionApi = $serviceManager->get('zikula_permissions_module.api.permission');
    
        if (!$permissionApi->hasPermission($this->name . '::', '::', ACCESS_READ)) {
            return '';
        }
    
        $templateParameters = [];
    
        $searchTypes = array('album', 'picture', 'avatar');
        foreach ($searchTypes as $searchType) {
            $templateParameters['active_' . $searchType] = (!isset($args['mUImageModuleSearchTypes']) || in_array($searchType, $args['mUImageModuleSearchTypes']));
        }
    
        return $this->getContainer()->get('twig')->render('@MUImageModule/Search/options.html.twig', $templateParameters);
    }
    
    /**
     * Returns the search results.
     *
     * @param array      $words      Array of words to search for
     * @param string     $searchType AND|OR|EXACT (defaults to AND)
     * @param array|null $modVars    Module form vars passed though
     *
     * @return array List of fetched results
     */
    public function getResults(array $words, $searchType = 'AND', $modVars = null)
    {
        $serviceManager = ServiceUtil::getManager();
        $permissionApi = $serviceManager->get('zikula_permissions_module.api.permission');
        $featureActivationHelper = $serviceManager->get('mu_image_module.feature_activation_helper');
        $request = $serviceManager->get('request_stack')->getMasterRequest();
    
        if (!$permissionApi->hasPermission($this->name . '::', '::', ACCESS_READ)) {
            return [];
        }
    
        // save session id as it is used when inserting search results below
        $session = $serviceManager->get('session');
        $sessionId = $session->getId();
    
        // initialise array for results
        $records = [];
    
        // retrieve list of activated object types
        $searchTypes = isset($modVars['objectTypes']) ? (array)$modVars['objectTypes'] : [];
        if (!is_array($searchTypes) || !count($searchTypes)) {
            if ($request->isMethod('GET')) {
                $searchTypes = $request->query->get('mUImageModuleSearchTypes', []);
            } elseif ($request->isMethod('POST')) {
                $searchTypes = $request->request->get('mUImageModuleSearchTypes', []);
            }
        }
    
        $controllerHelper = $serviceManager->get('mu_image_module.controller_helper');
        $utilArgs = ['helper' => 'search', 'action' => 'getResults'];
        $allowedTypes = $controllerHelper->getObjectTypes('helper', $utilArgs);
    
        foreach ($searchTypes as $objectType) {
            if (!in_array($objectType, $allowedTypes)) {
                continue;
            }
    
            $whereArray = [];
            $languageField = null;
            switch ($objectType) {
                case 'album':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.title';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.albumAccess';
                    $whereArray[] = 'tbl.passwordAccess';
                    $whereArray[] = 'tbl.myFriends';
                    break;
                case 'picture':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.title';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.imageUpload';
                    break;
                case 'avatar':
                    $whereArray[] = 'tbl.workflowState';
                    $whereArray[] = 'tbl.title';
                    $whereArray[] = 'tbl.description';
                    $whereArray[] = 'tbl.avatarUpload';
                    $whereArray[] = 'tbl.supportedModules';
                    break;
            }
    
            $repository = $serviceManager->get('mu_image_module.' . $objectType . '_factory')->getRepository();
    
            // build the search query without any joins
            $qb = $repository->genericBaseQuery('', '', false);
    
            // build where expression for given search type
            $whereExpr = $this->formatWhere($qb, $words, $whereArray, $searchType);
            $qb->andWhere($whereExpr);
    
            $query = $qb->getQuery();
    
            // set a sensitive limit
            $query->setFirstResult(0)
                  ->setMaxResults(250);
    
            // fetch the results
            $entities = $query->getResult();
    
            if (count($entities) == 0) {
                continue;
            }
    
            $descriptionField = $repository->getDescriptionFieldName();
    
            $entitiesWithDisplayAction = ['album', 'picture', 'avatar'];
    
            foreach ($entities as $entity) {
                $urlArgs = $entity->createUrlArgs();
                $hasDisplayAction = in_array($objectType, $entitiesWithDisplayAction);
    
                $instanceId = $entity->createCompositeIdentifier();
                // perform permission check
                if (!$permissionApi->hasPermission($this->name . ':' . ucfirst($objectType) . ':', $instanceId . '::', ACCESS_OVERVIEW)) {
                    continue;
                }
                if (in_array($objectType, ['album', 'avatar'])) {
                    if ($featureActivationHelper->isEnabled(FeatureActivationHelper::CATEGORIES, $objectType)) {
                        if (!$serviceManager->get('mu_image_module.category_helper')->hasPermission($entity)) {
                            continue;
                        }
                    }
                }
    
                $description = !empty($descriptionField) ? $entity[$descriptionField] : '';
                $created = isset($entity['createdDate']) ? $entity['createdDate'] : null;
    
                $urlArgs['_locale'] = (null !== $languageField && !empty($entity[$languageField])) ? $entity[$languageField] : $request->getLocale();
    
                $displayUrl = $hasDisplayAction ? new RouteUrl('muimagemodule_' . $objectType . '_display', $urlArgs) : '';
    
                $records[] = [
                    'title' => $entity->getTitleFromDisplayPattern(),
                    'text' => $description,
                    'module' => $this->name,
                    'sesid' => $sessionId,
                    'created' => $created,
                    'url' => $displayUrl
                ];
            }
        }
    
        return $records;
    }
}
