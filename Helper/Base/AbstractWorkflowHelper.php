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

use Psr\Log\LoggerInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Core\Doctrine\EntityAccess;
use Zikula\PermissionsModule\Api\PermissionApi;
use Zikula_Workflow_Util;
use MU\ImageModule\Entity\Factory\ImageFactory;
use MU\ImageModule\Helper\ListEntriesHelper;

/**
 * Helper base class for workflow methods.
 */
abstract class AbstractWorkflowHelper
{
    /**
     * Name of the application.
     *
     * @var string
     */
    protected $name;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PermissionApi
     */
    protected $permissionApi;

    /**
     * @var ImageFactory
     */
    protected $entityFactory;

    /**
     * @var ListEntriesHelper
     */
    protected $listEntriesHelper;

    /**
     * WorkflowHelper constructor.
     *
     * @param TranslatorInterface $translator        Translator service instance
     * @param LoggerInterface     $logger            Logger service instance
     * @param PermissionApi       $permissionApi     PermissionApi service instance
     * @param ImageFactory $entityFactory ImageFactory service instance
     * @param ListEntriesHelper   $listEntriesHelper ListEntriesHelper service instance
     *
     * @return void
     */
    public function __construct(TranslatorInterface $translator, LoggerInterface $logger, PermissionApi $permissionApi, ImageFactory $entityFactory, ListEntriesHelper $listEntriesHelper)
    {
        $this->name = 'MUImageModule';
        $this->translator = $translator;
        $this->logger = $logger;
        $this->permissionApi = $permissionApi;
        $this->entityFactory = $entityFactory;
        $this->listEntriesHelper = $listEntriesHelper;
    }

    /**
      * This method returns a list of possible object states.
      *
      * @return array List of collected state information
      */
     public function getObjectStates()
     {
         $states = [];
         $states[] = [
             'value' => 'initial',
             'text' => $this->translator->__('Initial'),
             'ui' => 'danger'
         ];
         $states[] = [
             'value' => 'approved',
             'text' => $this->translator->__('Approved'),
             'ui' => 'success'
         ];
         $states[] = [
             'value' => 'deleted',
             'text' => $this->translator->__('Deleted'),
             'ui' => 'danger'
         ];
         $states[] = [
             'value' => 'waiting',
             'text' => $this->translator->__('Waiting'),
             'ui' => 'warning'
         ];
    
         return $states;
     }
    
    /**
     * This method returns information about a certain state.
     *
     * @param string $state The given state value
     *
     * @return array|null The corresponding state information
     */
    public function getStateInfo($state = 'initial')
    {
        $result = null;
        $stateList = $this->getObjectStates();
        foreach ($stateList as $singleState) {
            if ($singleState['value'] != $state) {
                continue;
            }
            $result = $singleState;
            break;
        }
    
        return $result;
    }
    
    /**
     * This method returns the workflow name for a certain object type.
     *
     * @param string $objectType Name of treated object type
     *
     * @return string Name of the corresponding workflow
     */
    public function getWorkflowName($objectType = '')
    {
        $result = '';
        switch ($objectType) {
            case 'album':
                $result = 'none';
                break;
            case 'picture':
                $result = 'none';
                break;
            case 'avatar':
                $result = 'standard';
                break;
        }
    
        return $result;
    }
    
    /**
     * This method returns the workflow schema for a certain object type.
     *
     * @param string $objectType Name of treated object type
     *
     * @return array|null The resulting workflow schema
     */
    public function getWorkflowSchema($objectType = '')
    {
        $schema = null;
        $schemaName = $this->getWorkflowName($objectType);
        if ($schemaName != '') {
            $schema = Zikula_Workflow_Util::loadSchema($schemaName, $this->name);
        }
    
        return $schema;
    }
    
    /**
     * Retrieve the available actions for a given entity object.
     *
     * @param EntityAccess $entity The given entity instance
     *
     * @return array List of available workflow actions
     */
    public function getActionsForObject($entity)
    {
        // get possible actions for this object in it's current workflow state
        $objectType = $entity['_objectType'];
    
        $this->normaliseWorkflowData($entity);
    
        $idColumn = $entity['__WORKFLOW__']['obj_idcolumn'];
        $wfActions = Zikula_Workflow_Util::getActionsForObject($entity, $objectType, $idColumn, $this->name);
    
        // as we use the workflows for multiple object types we must maybe filter out some actions
        $states = $this->listEntriesHelper->getEntries($objectType, 'workflowState');
        $allowedStates = [];
        foreach ($states as $state) {
            $allowedStates[] = $state['value'];
        }
    
        $actions = [];
        foreach ($wfActions as $actionId => $action) {
            $nextState = (isset($action['nextState']) ? $action['nextState'] : '');
            if (!in_array($nextState, ['', 'deleted']) && !in_array($nextState, $allowedStates)) {
                continue;
            }
    
            $actions[$actionId] = $action;
            $actions[$actionId]['buttonClass'] = $this->getButtonClassForAction($actionId);
        }
    
        return $actions;
    }
    
    /**
     * Returns a button class for a certain action.
     *
     * @param string $actionId Id of the treated action
     *
     * @return string The button class
     */
    protected function getButtonClassForAction($actionId)
    {
        $buttonClass = '';
        switch ($actionId) {
            case 'submit':
                $buttonClass = 'success';
                break;
            case 'update':
                $buttonClass = 'success';
                break;
            case 'approve':
                $buttonClass = '';
                break;
            case 'delete':
                $buttonClass = 'danger';
                break;
        }
    
        if (empty($buttonClass)) {
            $buttonClass = 'default';
        }
    
        return 'btn btn-' . $buttonClass;
    }
    
    /**
     * Executes a certain workflow action for a given entity object.
     *
     * @param EntityAccess $entity    The given entity instance
     * @param string       $actionId  Name of action to be executed
     * @param bool         $recursive True if the function called itself
     *
     * @return bool False on error or true if everything worked well
     */
    public function executeAction($entity, $actionId = '', $recursive = false)
    {
        $objectType = $entity['_objectType'];
        $schemaName = $this->getWorkflowName($objectType);
    
        $entity->initWorkflow(true);
        $idColumn = $entity['__WORKFLOW__']['obj_idcolumn'];
    
        $this->normaliseWorkflowData($entity);
    
        $result = Zikula_Workflow_Util::executeAction($schemaName, $entity, $actionId, $objectType, 'MUImageModule', $idColumn);
    
        if (false !== $result && !$recursive) {
            $entities = $entity->getRelatedObjectsToPersist();
            foreach ($entities as $rel) {
                if ($rel->getWorkflowState() == 'initial') {
                    $this->executeAction($rel, $actionId, true);
                }
            }
        }
    
        return (false !== $result);
    }
    /**
     * Performs a conversion of the workflow object back to an array.
     *
     * @param EntityAccess $entity The given entity instance (excplicitly assigned by reference as form handlers use arrays)
     *
     * @return bool False on error or true if everything worked well
     */
    public function normaliseWorkflowData(&$entity)
    {
        $workflow = $entity['__WORKFLOW__'];
        if (!isset($workflow[0]) && isset($workflow['module'])) {
            return true;
        }
    
        if (isset($workflow[0])) {
            $workflow = $workflow[0];
        }
    
        if (!is_object($workflow)) {
            $workflow['module'] = 'MUImageModule';
            $entity['__WORKFLOW__'] = $workflow;
    
            return true;
        }
    
        $entity['__WORKFLOW__'] = [
            'module'        => 'MUImageModule',
            'id'            => $workflow->getId(),
            'state'         => $workflow->getState(),
            'obj_table'     => $workflow->getObjTable(),
            'obj_idcolumn'  => $workflow->getObjIdcolumn(),
            'obj_id'        => $workflow->getObjId(),
            'schemaname'    => $workflow->getSchemaname()
        ];
    
        return true;
    }
    
    /**
     * Collects amount of moderation items foreach object type.
     *
     * @return array List of collected amounts
     */
    public function collectAmountOfModerationItems()
    {
        $amounts = [];
    
    
        // check if objects are waiting for approval
        $state = 'waiting';
        $objectType = 'avatar';
        if ($this->permissionApi->hasPermission('MUImageModule:' . ucfirst($objectType) . ':', '::', ACCESS_ADD)) {
            $amount = $this->getAmountOfModerationItems($objectType, $state);
            if ($amount > 0) {
                $amounts[] = [
                    'aggregateType' => 'avatarsApproval',
                    'description' => $this->translator->__('Avatars pending approval'),
                    'amount' => $amount,
                    'objectType' => $objectType,
                    'state' => $state,
                    'message' => $this->translator->_fn('One avatar is waiting for approval.', '%s avatars are waiting for approval.', $amount, ['%s' => $amount])
                ];
        
                $this->logger->info('{app}: There are {amount} {entities} waiting for approval.', ['app' => 'MUImageModule', 'amount' => $amount, 'entities' => 'avatars']);
            }
        }
    
        return $amounts;
    }
    
    /**
     * Retrieves the amount of moderation items for a given object type
     * and a certain workflow state.
     *
     * @param string $objectType Name of treated object type
     * @param string $state The given state value
     *
     * @return integer The affected amount of objects
     */
    public function getAmountOfModerationItems($objectType, $state)
    {
        $repository = $this->entityFactory->getRepository($objectType);
    
        $where = 'tbl.workflowState:eq:' . $state;
        $parameters = ['workflowState' => $state];
        $useJoins = false;
    
        return $repository->selectCount($where, $useJoins, $parameters);
    }
}
