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

namespace MU\ImageModule\Entity\Repository\Base;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\UsersModule\Api\CurrentUserApi;
use MU\ImageModule\Entity\AlbumEntity;
use MU\ImageModule\Helper\CollectionFilterHelper;

/**
 * Repository class used to implement own convenience methods for performing certain DQL queries.
 *
 * This is the base repository class for album entities.
 */
abstract class AbstractAlbumRepository extends EntityRepository
{
    /**
     * @var string The default sorting field/expression
     */
    protected $defaultSortingField = 'title';

    /**
     * @var CollectionFilterHelper
     */
    protected $collectionFilterHelper = null;

    /**
     * Retrieves an array with all fields which can be used for sorting instances.
     *
     * @return array Sorting fields array
     */
    public function getAllowedSortingFields()
    {
        return [
            'title',
            'description',
            'album',
            'albumAccess',
            'passwordAccess',
            'myFriends',
            'notInFrontend',
            'pos',
            'createdBy',
            'createdDate',
            'updatedBy',
            'updatedDate',
        ];
    }

    /**
     * Returns the default sorting field.
     *
     * @return string
     */
    public function getDefaultSortingField()
    {
        return $this->defaultSortingField;
    }
    
    /**
     * Sets the default sorting field.
     *
     * @param string $defaultSortingField
     *
     * @return void
     */
    public function setDefaultSortingField($defaultSortingField)
    {
        if ($this->defaultSortingField != $defaultSortingField) {
            $this->defaultSortingField = $defaultSortingField;
        }
    }
    
    /**
     * Returns the collection filter helper.
     *
     * @return CollectionFilterHelper
     */
    public function getCollectionFilterHelper()
    {
        return $this->collectionFilterHelper;
    }
    
    /**
     * Sets the collection filter helper.
     *
     * @param CollectionFilterHelper $collectionFilterHelper
     *
     * @return void
     */
    public function setCollectionFilterHelper($collectionFilterHelper)
    {
        if ($this->collectionFilterHelper != $collectionFilterHelper) {
            $this->collectionFilterHelper = $collectionFilterHelper;
        }
    }
    

    /**
     * Helper method for truncating the table.
     * Used during installation when inserting default data.
     *
     * @param LoggerInterface $logger Logger service instance
     */
    public function truncateTable(LoggerInterface $logger)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('MU\ImageModule\Entity\AlbumEntity', 'tbl');
        $query = $qb->getQuery();
    
        $query->execute();
    
        $logArgs = ['app' => 'MUImageModule', 'entity' => 'album'];
        $logger->debug('{app}: Truncated the {entity} entity table.', $logArgs);
    }
    /**
     * Updates the creator of all objects created by a certain user.
     *
     * @param integer             $userId         The userid of the creator to be replaced
     * @param integer             $newUserId      The new userid of the creator as replacement
     * @param TranslatorInterface $translator     Translator service instance
     * @param LoggerInterface     $logger         Logger service instance
     * @param CurrentUserApi      $currentUserApi CurrentUserApi service instance
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if invalid parameters are received
     */
    public function updateCreator($userId, $newUserId, TranslatorInterface $translator, LoggerInterface $logger, CurrentUserApi $currentUserApi)
    {
        // check id parameter
        if ($userId == 0 || !is_numeric($userId)
         || $newUserId == 0 || !is_numeric($newUserId)) {
            throw new InvalidArgumentException($translator->__('Invalid user identifier received.'));
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('MU\ImageModule\Entity\AlbumEntity', 'tbl')
           ->set('tbl.createdBy', $newUserId)
           ->where('tbl.createdBy = :creator')
           ->setParameter('creator', $userId);
        $query = $qb->getQuery();
        $query->execute();
    
        $logArgs = ['app' => 'MUImageModule', 'user' => $currentUserApi->get('uname'), 'entities' => 'albums', 'userid' => $userId];
        $logger->debug('{app}: User {user} updated {entities} created by user id {userid}.', $logArgs);
    }
    
    /**
     * Updates the last editor of all objects updated by a certain user.
     *
     * @param integer             $userId         The userid of the last editor to be replaced
     * @param integer             $newUserId      The new userid of the last editor as replacement
     * @param TranslatorInterface $translator     Translator service instance
     * @param LoggerInterface     $logger         Logger service instance
     * @param CurrentUserApi      $currentUserApi CurrentUserApi service instance
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if invalid parameters are received
     */
    public function updateLastEditor($userId, $newUserId, TranslatorInterface $translator, LoggerInterface $logger, CurrentUserApi $currentUserApi)
    {
        // check id parameter
        if ($userId == 0 || !is_numeric($userId)
         || $newUserId == 0 || !is_numeric($newUserId)) {
            throw new InvalidArgumentException($translator->__('Invalid user identifier received.'));
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('MU\ImageModule\Entity\AlbumEntity', 'tbl')
           ->set('tbl.updatedBy', $newUserId)
           ->where('tbl.updatedBy = :editor')
           ->setParameter('editor', $userId);
        $query = $qb->getQuery();
        $query->execute();
    
        $logArgs = ['app' => 'MUImageModule', 'user' => $currentUserApi->get('uname'), 'entities' => 'albums', 'userid' => $userId];
        $logger->debug('{app}: User {user} updated {entities} edited by user id {userid}.', $logArgs);
    }
    
    /**
     * Deletes all objects created by a certain user.
     *
     * @param integer             $userId         The userid of the creator to be removed
     * @param TranslatorInterface $translator     Translator service instance
     * @param LoggerInterface     $logger         Logger service instance
     * @param CurrentUserApi      $currentUserApi CurrentUserApi service instance
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if invalid parameters are received
     */
    public function deleteByCreator($userId, TranslatorInterface $translator, LoggerInterface $logger, CurrentUserApi $currentUserApi)
    {
        // check id parameter
        if ($userId == 0 || !is_numeric($userId)) {
            throw new InvalidArgumentException($translator->__('Invalid user identifier received.'));
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('MU\ImageModule\Entity\AlbumEntity', 'tbl')
           ->where('tbl.createdBy = :creator')
           ->setParameter('creator', $userId);
        $query = $qb->getQuery();
        $query->execute();
    
        $logArgs = ['app' => 'MUImageModule', 'user' => $currentUserApi->get('uname'), 'entities' => 'albums', 'userid' => $userId];
        $logger->debug('{app}: User {user} deleted {entities} created by user id {userid}.', $logArgs);
    }
    
    /**
     * Deletes all objects updated by a certain user.
     *
     * @param integer             $userId         The userid of the last editor to be removed
     * @param TranslatorInterface $translator     Translator service instance
     * @param LoggerInterface     $logger         Logger service instance
     * @param CurrentUserApi      $currentUserApi CurrentUserApi service instance
     *
     * @return void
     *
     * @throws InvalidArgumentException Thrown if invalid parameters are received
     */
    public function deleteByLastEditor($userId, TranslatorInterface $translator, LoggerInterface $logger, CurrentUserApi $currentUserApi)
    {
        // check id parameter
        if ($userId == 0 || !is_numeric($userId)) {
            throw new InvalidArgumentException($translator->__('Invalid user identifier received.'));
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete('MU\ImageModule\Entity\AlbumEntity', 'tbl')
           ->where('tbl.updatedBy = :editor')
           ->setParameter('editor', $userId);
        $query = $qb->getQuery();
        $query->execute();
    
        $logArgs = ['app' => 'MUImageModule', 'user' => $currentUserApi->get('uname'), 'entities' => 'albums', 'userid' => $userId];
        $logger->debug('{app}: User {user} deleted {entities} edited by user id {userid}.', $logArgs);
    }

    /**
     * Adds an array of id filters to given query instance.
     *
     * @param array        $idList The array of ids to use to retrieve the object
     * @param QueryBuilder $qb     Query builder to be enhanced
     *
     * @return QueryBuilder Enriched query builder instance
     *
     * @throws InvalidArgumentException Thrown if invalid parameters are received
     */
    protected function addIdListFilter($idList, QueryBuilder $qb)
    {
        $orX = $qb->expr()->orX();
    
        foreach ($idList as $id) {
            // check id parameter
            if ($id == 0) {
                throw new InvalidArgumentException('Invalid identifier received.');
            }
    
            $orX->add($qb->expr()->eq('tbl.id', $id));
        }
    
        $qb->andWhere($orX);
    
        return $qb;
    }
    
    /**
     * Selects an object from the database.
     *
     * @param mixed   $id       The id (or array of ids) to use to retrieve the object (optional) (default=0)
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return array|albumEntity Retrieved data array or albumEntity instance
     */
    public function selectById($id = 0, $useJoins = true, $slimMode = false)
    {
        $results = $this->selectByIdList(is_array($id) ? $id : [$id], $useJoins, $slimMode);
    
        return count($results) > 0 ? $results[0] : null;
    }
    
    /**
     * Selects a list of objects with an array of ids
     *
     * @param mixed   $idList   The array of ids to use to retrieve the objects (optional) (default=0)
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return ArrayCollection Collection containing retrieved albumEntity instances
     */
    public function selectByIdList($idList = [0], $useJoins = true, $slimMode = false)
    {
        $qb = $this->genericBaseQuery('', '', $useJoins, $slimMode);
        $qb = $this->addIdListFilter($idList, $qb);
    
        $query = $this->getQueryFromBuilder($qb);
    
        $results = $query->getResult();
    
        return count($results) > 0 ? $results : null;
    }

    /**
     * Adds where clauses excluding desired identifiers from selection.
     *
     * @param QueryBuilder $qb           Query builder to be enhanced
     * @param array        $excludesions Array of ids to be excluded from selection
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function addExclusion(QueryBuilder $qb, array $exclusions = [])
    {
        if (count($exclusions) > 0) {
            $qb->andWhere('tbl.id NOT IN (:excludedIdentifiers)')
               ->setParameter('excludedIdentifiers', $exclusions);
        }
    
        return $qb;
    }

    /**
     * Returns query builder for selecting a list of objects with a given where clause.
     *
     * @param string  $where    The where clause to use when retrieving the collection (optional) (default='')
     * @param string  $orderBy  The order-by clause to use when retrieving the collection (optional) (default='')
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return QueryBuilder Query builder for the given arguments
     */
    public function getListQueryBuilder($where = '', $orderBy = '', $useJoins = true, $slimMode = false)
    {
        $qb = $this->genericBaseQuery($where, $orderBy, $useJoins, $slimMode);
        if ((!$useJoins || !$slimMode) && null !== $this->collectionFilterHelper) {
            $qb = $this->collectionFilterHelper->addCommonViewFilters('album', $qb);
        }
    
        return $qb;
    }
    
    /**
     * Selects a list of objects with a given where clause.
     *
     * @param string  $where    The where clause to use when retrieving the collection (optional) (default='')
     * @param string  $orderBy  The order-by clause to use when retrieving the collection (optional) (default='')
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return ArrayCollection Collection containing retrieved albumEntity instances
     */
    public function selectWhere($where = '', $orderBy = '', $useJoins = true, $slimMode = false)
    {
        $qb = $this->getListQueryBuilder($where, $orderBy, $useJoins, $slimMode);
    
        $query = $this->getQueryFromBuilder($qb);
    
        return $this->retrieveCollectionResult($query, false);
    }

    /**
     * Returns query builder instance for retrieving a list of objects with a given where clause and pagination parameters.
     *
     * @param QueryBuilder $qb             Query builder to be enhanced
     * @param integer      $currentPage    Where to start selection
     * @param integer      $resultsPerPage Amount of items to select
     *
     * @return Query Created query instance
     */
    public function getSelectWherePaginatedQuery(QueryBuilder $qb, $currentPage = 1, $resultsPerPage = 25)
    {
        $query = $this->getQueryFromBuilder($qb);
        $offset = ($currentPage-1) * $resultsPerPage;
    
        $query->setFirstResult($offset)
              ->setMaxResults($resultsPerPage);
    
        return $query;
    }
    
    /**
     * Selects a list of objects with a given where clause and pagination parameters.
     *
     * @param string  $where          The where clause to use when retrieving the collection (optional) (default='')
     * @param string  $orderBy        The order-by clause to use when retrieving the collection (optional) (default='')
     * @param integer $currentPage    Where to start selection
     * @param integer $resultsPerPage Amount of items to select
     * @param boolean $useJoins       Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode       If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return array Retrieved collection and amount of total records affected by this query
     */
    public function selectWherePaginated($where = '', $orderBy = '', $currentPage = 1, $resultsPerPage = 25, $useJoins = true, $slimMode = false)
    {
        $qb = $this->getListQueryBuilder($where, $orderBy, $useJoins, $slimMode);
        $query = $this->getSelectWherePaginatedQuery($qb, $currentPage, $resultsPerPage);
    
        return $this->retrieveCollectionResult($query, true);
    }

    /**
     * Selects entities by a given search fragment.
     *
     * @param string  $fragment       The fragment to search for
     * @param array   $exclude        List with identifiers to be excluded from search
     * @param string  $orderBy        The order-by clause to use when retrieving the collection (optional) (default='')
     * @param integer $currentPage    Where to start selection
     * @param integer $resultsPerPage Amount of items to select
     * @param boolean $useJoins       Whether to include joining related objects (optional) (default=true)
     *
     * @return array Retrieved collection and amount of total records affected by this query
     */
    public function selectSearch($fragment = '', $exclude = [], $orderBy = '', $currentPage = 1, $resultsPerPage = 25, $useJoins = true)
    {
        $qb = $this->getListQueryBuilder('', $orderBy, $useJoins);
        if (count($exclude) > 0) {
            $qb = $this->addExclusion($qb, $exclude);
        }
    
        if (null !== $this->collectionFilterHelper) {
            $qb = $this->collectionFilterHelper->addSearchFilter('album', $qb, $fragment);
        }
    
        $query = $this->getSelectWherePaginatedQuery($qb, $currentPage, $resultsPerPage);
    
        return $this->retrieveCollectionResult($query, true);
    }

    /**
     * Performs a given database selection and post-processed the results.
     *
     * @param Query   $query       The Query instance to be executed
     * @param boolean $isPaginated Whether the given query uses a paginator or not (optional) (default=false)
     *
     * @return array Retrieved collection and (for paginated queries) the amount of total records affected
     */
    public function retrieveCollectionResult(Query $query, $isPaginated = false)
    {
        $count = 0;
        if (!$isPaginated) {
            $result = $query->getResult();
        } else {
            $paginator = new Paginator($query, true);
    
            $count = count($paginator);
            $result = $paginator;
        }
    
        if (!$isPaginated) {
            return $result;
        }
    
        return [$result, $count];
    }

    /**
     * Returns query builder instance for a count query.
     *
     * @param string  $where    The where clause to use when retrieving the object count (optional) (default='')
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=false)
     *
     * @return QueryBuilder Created query builder instance
     */
    public function getCountQuery($where = '', $useJoins = false)
    {
        $selection = 'COUNT(tbl.id) AS numAlbums';
        if (true === $useJoins) {
            $selection .= $this->addJoinsToSelection();
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($selection)
           ->from('MU\ImageModule\Entity\AlbumEntity', 'tbl');
    
        if (!empty($where)) {
            $qb->andWhere($where);
        }
    
        if (true === $useJoins) {
            $this->addJoinsToFrom($qb);
        }
    
        return $qb;
    }

    /**
     * Selects entity count with a given where clause.
     *
     * @param string  $where      The where clause to use when retrieving the object count (optional) (default='')
     * @param boolean $useJoins   Whether to include joining related objects (optional) (default=false)
     * @param array   $parameters List of determined filter options
     *
     * @return integer Amount of affected records
     */
    public function selectCount($where = '', $useJoins = false, $parameters = [])
    {
        $qb = $this->getCountQuery($where, $useJoins);
    
        if (null !== $this->collectionFilterHelper) {
            $qb = $this->collectionFilterHelper->applyDefaultFilters('album', $qb, $parameters);
        }
    
        $query = $qb->getQuery();
    
        return $query->getSingleScalarResult();
    }


    /**
     * Checks for unique values.
     *
     * @param string  $fieldName  The name of the property to be checked
     * @param string  $fieldValue The value of the property to be checked
     * @param integer $excludeId  Id of albums to exclude (optional)
     *
     * @return boolean Result of this check, true if the given album does not already exist
     */
    public function detectUniqueState($fieldName, $fieldValue, $excludeId = 0)
    {
        $qb = $this->getCountQuery('', false);
        $qb->andWhere('tbl.' . $fieldName . ' = :' . $fieldName)
           ->setParameter($fieldName, $fieldValue);
    
        if ($excludeId > 0) {
            $qb = $this->addExclusion($qb, [$excludeId]);
        }
    
        $query = $qb->getQuery();
    
        $count = $query->getSingleScalarResult();
    
        return ($count == 0);
    }

    /**
     * Builds a generic Doctrine query supporting WHERE and ORDER BY.
     *
     * @param string  $where    The where clause to use when retrieving the collection (optional) (default='')
     * @param string  $orderBy  The order-by clause to use when retrieving the collection (optional) (default='')
     * @param boolean $useJoins Whether to include joining related objects (optional) (default=true)
     * @param boolean $slimMode If activated only some basic fields are selected without using any joins (optional) (default=false)
     *
     * @return QueryBuilder Query builder instance to be further processed
     */
    public function genericBaseQuery($where = '', $orderBy = '', $useJoins = true, $slimMode = false)
    {
        // normally we select the whole table
        $selection = 'tbl';
    
        if (true === $slimMode) {
            // but for the slim version we select only the basic fields, and no joins
    
            $selection = 'tbl.id';
            
            
            $selection .= ', tbl.title';
            $useJoins = false;
        }
    
        if (true === $useJoins) {
            $selection .= $this->addJoinsToSelection();
        }
    
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select($selection)
           ->from('MU\ImageModule\Entity\AlbumEntity', 'tbl');
    
        if (true === $useJoins) {
            $this->addJoinsToFrom($qb);
        }
    
        if (!empty($where)) {
            $qb->andWhere($where);
        }
    
        $this->genericBaseQueryAddOrderBy($qb, $orderBy);
    
        return $qb;
    }

    /**
     * Adds ORDER BY clause to given query builder.
     *
     * @param QueryBuilder $qb      Given query builder instance
     * @param string       $orderBy The order-by clause to use when retrieving the collection (optional) (default='')
     *
     * @return QueryBuilder Query builder instance to be further processed
     */
    protected function genericBaseQueryAddOrderBy(QueryBuilder $qb, $orderBy = '')
    {
        if ($orderBy == 'RAND()') {
            // random selection
            $qb->addSelect('MOD(tbl.id, ' . mt_rand(2, 15) . ') AS HIDDEN randomIdentifiers')
               ->add('orderBy', 'randomIdentifiers');
    
            return $qb;
        }
    
        if (empty($orderBy)) {
            $orderBy = $this->defaultSortingField;
        }
    
        if (empty($orderBy)) {
            return $qb;
        }
    
        // add order by clause
        if (false === strpos($orderBy, '.')) {
            $orderBy = 'tbl.' . $orderBy;
        }
        if (false !== strpos($orderBy, 'tbl.createdBy')) {
            $qb->addSelect('tblCreator')
               ->leftJoin('tbl.createdBy', 'tblCreator');
            $orderBy = str_replace('tbl.createdBy', 'tblCreator.uname', $orderBy);
        }
        if (false !== strpos($orderBy, 'tbl.updatedBy')) {
            $qb->addSelect('tblUpdater')
               ->leftJoin('tbl.updatedBy', 'tblUpdater');
            $orderBy = str_replace('tbl.updatedBy', 'tblUpdater.uname', $orderBy);
        }
        $qb->add('orderBy', $orderBy);
    
        return $qb;
    }

    /**
     * Retrieves Doctrine query from query builder.
     *
     * @param QueryBuilder $qb Query builder instance
     *
     * @return Query Query instance to be further processed
     */
    public function getQueryFromBuilder(QueryBuilder $qb)
    {
        $query = $qb->getQuery();
    
        return $query;
    }

    /**
     * Helper method to add join selections.
     *
     * @return String Enhancement for select clause
     */
    protected function addJoinsToSelection()
    {
        $selection = ', tblAlbum, tblAlbums, tblPictures';
    
        $selection = ', tblCategories';
    
        return $selection;
    }
    
    /**
     * Helper method to add joins to from clause.
     *
     * @param QueryBuilder $qb Query builder instance used to create the query
     *
     * @return QueryBuilder The query builder enriched by additional joins
     */
    protected function addJoinsToFrom(QueryBuilder $qb)
    {
        $qb->leftJoin('tbl.album', 'tblAlbum');
        $qb->leftJoin('tbl.albums', 'tblAlbums');
        $qb->leftJoin('tbl.pictures', 'tblPictures');
    
        $qb->leftJoin('tbl.categories', 'tblCategories');
    
        return $qb;
    }
}
