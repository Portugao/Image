<?php
/**
 * Image.
 *
 * @copyright Michael Ueberschaer (MU)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Michael Ueberschaer <info@homepages-mit-zikula.de>.
 * @link https://homepages-mit-zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio (https://modulestudio.de).
 */

namespace MU\ImageModule\Helper\Base;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\UsersModule\Api\ApiInterface\CurrentUserApiInterface;
use Zikula\UsersModule\Constant as UsersConstant;
use MU\ImageModule\Entity\AlbumEntity;
use MU\ImageModule\Entity\PictureEntity;
use MU\ImageModule\Entity\AvatarEntity;
use MU\ImageModule\Helper\CategoryHelper;

/**
 * Entity collection filter helper base class.
 */
abstract class AbstractCollectionFilterHelper
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var CurrentUserApiInterface
     */
    protected $currentUserApi;

    /**
     * @var CategoryHelper
     */
    private $categoryHelper;

    /**
     * @var bool Fallback value to determine whether only own entries should be selected or not
     */
    protected $showOnlyOwnEntries = false;

    /**
     * CollectionFilterHelper constructor.
     *
     * @param RequestStack   $requestStack        RequestStack service instance
     * @param CurrentUserApiInterface $currentUserApi CurrentUserApi service instance
     * @param CategoryHelper $categoryHelper      CategoryHelper service instance
     * @param bool           $showOnlyOwnEntries  Fallback value to determine whether only own entries should be selected or not
     */
    public function __construct(
        RequestStack $requestStack,
        CurrentUserApiInterface $currentUserApi,
        CategoryHelper $categoryHelper,
        $showOnlyOwnEntries
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->currentUserApi = $currentUserApi;
        $this->categoryHelper = $categoryHelper;
        $this->showOnlyOwnEntries = $showOnlyOwnEntries;
    }

    /**
     * Returns an array of additional template variables for view quick navigation forms.
     *
     * @param string $objectType Name of treated entity type
     * @param string $context    Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args       Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    public function getViewQuickNavParameters($objectType = '', $context = '', $args = [])
    {
        if (!in_array($context, ['controllerAction', 'api', 'actionHandler', 'block', 'contentType'])) {
            $context = 'controllerAction';
        }
    
        if ($objectType == 'album') {
            return $this->getViewQuickNavParametersForAlbum($context, $args);
        }
        if ($objectType == 'picture') {
            return $this->getViewQuickNavParametersForPicture($context, $args);
        }
        if ($objectType == 'avatar') {
            return $this->getViewQuickNavParametersForAvatar($context, $args);
        }
    
        return [];
    }
    
    /**
     * Adds quick navigation related filter options as where clauses.
     *
     * @param string       $objectType Name of treated entity type
     * @param QueryBuilder $qb         Query builder to be enhanced
     *
     * @return QueryBuilder Enriched query builder instance
     */
    public function addCommonViewFilters($objectType, QueryBuilder $qb)
    {
        if ($objectType == 'album') {
            return $this->addCommonViewFiltersForAlbum($qb);
        }
        if ($objectType == 'picture') {
            return $this->addCommonViewFiltersForPicture($qb);
        }
        if ($objectType == 'avatar') {
            return $this->addCommonViewFiltersForAvatar($qb);
        }
    
        return $qb;
    }
    
    /**
     * Adds default filters as where clauses.
     *
     * @param string       $objectType Name of treated entity type
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param array        $parameters List of determined filter options
     *
     * @return QueryBuilder Enriched query builder instance
     */
    public function applyDefaultFilters($objectType, QueryBuilder $qb, $parameters = [])
    {
        if ($objectType == 'album') {
            return $this->applyDefaultFiltersForAlbum($qb, $parameters);
        }
        if ($objectType == 'picture') {
            return $this->applyDefaultFiltersForPicture($qb, $parameters);
        }
        if ($objectType == 'avatar') {
            return $this->applyDefaultFiltersForAvatar($qb, $parameters);
        }
    
        return $qb;
    }
    
    /**
     * Returns an array of additional template variables for view quick navigation forms.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args    Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    protected function getViewQuickNavParametersForAlbum($context = '', $args = [])
    {
        $parameters = [];
        if (null === $this->request) {
            return $parameters;
        }
    
        $parameters['catId'] = $this->request->query->get('catId', '');
        $parameters['catIdList'] = $this->categoryHelper->retrieveCategoriesFromRequest('album', 'GET');
        $parameters['album'] = $this->request->query->get('album', 0);
        $parameters['workflowState'] = $this->request->query->get('workflowState', '');
        $parameters['albumAccess'] = $this->request->query->get('albumAccess', '');
        $parameters['q'] = $this->request->query->get('q', '');
        $parameters['notInFrontend'] = $this->request->query->get('notInFrontend', '');
    
        return $parameters;
    }
    
    /**
     * Returns an array of additional template variables for view quick navigation forms.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args    Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    protected function getViewQuickNavParametersForPicture($context = '', $args = [])
    {
        $parameters = [];
        if (null === $this->request) {
            return $parameters;
        }
    
        $parameters['album'] = $this->request->query->get('album', 0);
        $parameters['workflowState'] = $this->request->query->get('workflowState', '');
        $parameters['q'] = $this->request->query->get('q', '');
        $parameters['albumImage'] = $this->request->query->get('albumImage', '');
    
        return $parameters;
    }
    
    /**
     * Returns an array of additional template variables for view quick navigation forms.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType)
     * @param array  $args    Additional arguments
     *
     * @return array List of template variables to be assigned
     */
    protected function getViewQuickNavParametersForAvatar($context = '', $args = [])
    {
        $parameters = [];
        if (null === $this->request) {
            return $parameters;
        }
    
        $parameters['catId'] = $this->request->query->get('catId', '');
        $parameters['catIdList'] = $this->categoryHelper->retrieveCategoriesFromRequest('avatar', 'GET');
        $parameters['workflowState'] = $this->request->query->get('workflowState', '');
        $parameters['supportedModules'] = $this->request->query->get('supportedModules', '');
        $parameters['q'] = $this->request->query->get('q', '');
    
        return $parameters;
    }
    
    /**
     * Adds quick navigation related filter options as where clauses.
     *
     * @param QueryBuilder $qb Query builder to be enhanced
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function addCommonViewFiltersForAlbum(QueryBuilder $qb)
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        if (false !== strpos($routeName, 'edit')) {
            return $qb;
        }
    
        $parameters = $this->getViewQuickNavParametersForAlbum();
        foreach ($parameters as $k => $v) {
            if ($k == 'catId') {
                // single category filter
                if ($v > 0) {
                    $qb->andWhere('tblCategories.category = :category')
                       ->setParameter('category', $v);
                }
            } elseif ($k == 'catIdList') {
                // multi category filter
                /* old
                $qb->andWhere('tblCategories.category IN (:categories)')
                   ->setParameter('categories', $v);
                 */
                $qb = $this->categoryHelper->buildFilterClauses($qb, 'album', $v);
            } elseif (in_array($k, ['q', 'searchterm'])) {
                // quick search
                if (!empty($v)) {
                    $qb = $this->addSearchFilter('album', $qb, $v);
                }
            } elseif (in_array($k, ['notInFrontend'])) {
                // boolean filter
                if ($v == 'no') {
                    $qb->andWhere('tbl.' . $k . ' = 0');
                } elseif ($v == 'yes' || $v == '1') {
                    $qb->andWhere('tbl.' . $k . ' = 1');
                }
            } else if (!is_array($v)) {
                // field filter
                if ((!is_numeric($v) && $v != '') || (is_numeric($v) && $v > 0)) {
                    if ($k == 'workflowState' && substr($v, 0, 1) == '!') {
                        $qb->andWhere('tbl.' . $k . ' != :' . $k)
                           ->setParameter($k, substr($v, 1, strlen($v)-1));
                    } elseif (substr($v, 0, 1) == '%') {
                        $qb->andWhere('tbl.' . $k . ' LIKE :' . $k)
                           ->setParameter($k, '%' . $v . '%');
                    } else {
                        $qb->andWhere('tbl.' . $k . ' = :' . $k)
                           ->setParameter($k, $v);
                   }
                }
            }
        }
    
        $qb = $this->applyDefaultFiltersForAlbum($qb, $parameters);
    
        return $qb;
    }
    
    /**
     * Adds quick navigation related filter options as where clauses.
     *
     * @param QueryBuilder $qb Query builder to be enhanced
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function addCommonViewFiltersForPicture(QueryBuilder $qb)
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        if (false !== strpos($routeName, 'edit')) {
            return $qb;
        }
    
        $parameters = $this->getViewQuickNavParametersForPicture();
        foreach ($parameters as $k => $v) {
            if (in_array($k, ['q', 'searchterm'])) {
                // quick search
                if (!empty($v)) {
                    $qb = $this->addSearchFilter('picture', $qb, $v);
                }
            } elseif (in_array($k, ['albumImage'])) {
                // boolean filter
                if ($v == 'no') {
                    $qb->andWhere('tbl.' . $k . ' = 0');
                } elseif ($v == 'yes' || $v == '1') {
                    $qb->andWhere('tbl.' . $k . ' = 1');
                }
            } else if (!is_array($v)) {
                // field filter
                if ((!is_numeric($v) && $v != '') || (is_numeric($v) && $v > 0)) {
                    if ($k == 'workflowState' && substr($v, 0, 1) == '!') {
                        $qb->andWhere('tbl.' . $k . ' != :' . $k)
                           ->setParameter($k, substr($v, 1, strlen($v)-1));
                    } elseif (substr($v, 0, 1) == '%') {
                        $qb->andWhere('tbl.' . $k . ' LIKE :' . $k)
                           ->setParameter($k, '%' . $v . '%');
                    } else {
                        $qb->andWhere('tbl.' . $k . ' = :' . $k)
                           ->setParameter($k, $v);
                   }
                }
            }
        }
    
        $qb = $this->applyDefaultFiltersForPicture($qb, $parameters);
    
        return $qb;
    }
    
    /**
     * Adds quick navigation related filter options as where clauses.
     *
     * @param QueryBuilder $qb Query builder to be enhanced
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function addCommonViewFiltersForAvatar(QueryBuilder $qb)
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        if (false !== strpos($routeName, 'edit')) {
            return $qb;
        }
    
        $parameters = $this->getViewQuickNavParametersForAvatar();
        foreach ($parameters as $k => $v) {
            if ($k == 'catId') {
                // single category filter
                if ($v > 0) {
                    $qb->andWhere('tblCategories.category = :category')
                       ->setParameter('category', $v);
                }
            } elseif ($k == 'catIdList') {
                // multi category filter
                /* old
                $qb->andWhere('tblCategories.category IN (:categories)')
                   ->setParameter('categories', $v);
                 */
                $qb = $this->categoryHelper->buildFilterClauses($qb, 'avatar', $v);
            } elseif (in_array($k, ['q', 'searchterm'])) {
                // quick search
                if (!empty($v)) {
                    $qb = $this->addSearchFilter('avatar', $qb, $v);
                }
            } else if (!is_array($v)) {
                // field filter
                if ((!is_numeric($v) && $v != '') || (is_numeric($v) && $v > 0)) {
                    if ($k == 'workflowState' && substr($v, 0, 1) == '!') {
                        $qb->andWhere('tbl.' . $k . ' != :' . $k)
                           ->setParameter($k, substr($v, 1, strlen($v)-1));
                    } elseif (substr($v, 0, 1) == '%') {
                        $qb->andWhere('tbl.' . $k . ' LIKE :' . $k)
                           ->setParameter($k, '%' . $v . '%');
                    } else {
                        $qb->andWhere('tbl.' . $k . ' = :' . $k)
                           ->setParameter($k, $v);
                   }
                }
            }
        }
    
        $qb = $this->applyDefaultFiltersForAvatar($qb, $parameters);
    
        return $qb;
    }
    
    /**
     * Adds default filters as where clauses.
     *
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param array        $parameters List of determined filter options
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function applyDefaultFiltersForAlbum(QueryBuilder $qb, $parameters = [])
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        $isAdminArea = false !== strpos($routeName, 'muimagemodule_album_admin');
        if ($isAdminArea) {
            return $qb;
        }
    
        $showOnlyOwnEntries = (bool)$this->request->query->getInt('own', $this->showOnlyOwnEntries);
    
        if ($showOnlyOwnEntries) {
            $qb = $this->addCreatorFilter($qb);
        }
    
        return $qb;
    }
    
    /**
     * Adds default filters as where clauses.
     *
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param array        $parameters List of determined filter options
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function applyDefaultFiltersForPicture(QueryBuilder $qb, $parameters = [])
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        $isAdminArea = false !== strpos($routeName, 'muimagemodule_picture_admin');
        if ($isAdminArea) {
            return $qb;
        }
    
        $showOnlyOwnEntries = (bool)$this->request->query->getInt('own', $this->showOnlyOwnEntries);
    
        if ($showOnlyOwnEntries) {
            $qb = $this->addCreatorFilter($qb);
        }
    
        return $qb;
    }
    
    /**
     * Adds default filters as where clauses.
     *
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param array        $parameters List of determined filter options
     *
     * @return QueryBuilder Enriched query builder instance
     */
    protected function applyDefaultFiltersForAvatar(QueryBuilder $qb, $parameters = [])
    {
        if (null === $this->request) {
            return $qb;
        }
        $routeName = $this->request->get('_route');
        $isAdminArea = false !== strpos($routeName, 'muimagemodule_avatar_admin');
        if ($isAdminArea) {
            return $qb;
        }
    
        $showOnlyOwnEntries = (bool)$this->request->query->getInt('own', $this->showOnlyOwnEntries);
    
        if ($showOnlyOwnEntries) {
            $qb = $this->addCreatorFilter($qb);
        }
    
        return $qb;
    }
    
    /**
     * Adds a where clause for search query.
     *
     * @param string       $objectType Name of treated entity type
     * @param QueryBuilder $qb         Query builder to be enhanced
     * @param string       $fragment   The fragment to search for
     *
     * @return QueryBuilder Enriched query builder instance
     */
    public function addSearchFilter($objectType, QueryBuilder $qb, $fragment = '')
    {
        if ($fragment == '') {
            return $qb;
        }
    
        $filters = [];
        $parameters = [];
    
        if ($objectType == 'album') {
            $filters[] = 'tbl.title LIKE :searchTitle';
            $parameters['searchTitle'] = '%' . $fragment . '%';
            $filters[] = 'tbl.description LIKE :searchDescription';
            $parameters['searchDescription'] = '%' . $fragment . '%';
            $filters[] = 'tbl.parent_id = :searchParent_id';
            $parameters['searchParent_id'] = $fragment;
            $filters[] = 'tbl.albumAccess = :searchAlbumAccess';
            $parameters['searchAlbumAccess'] = $fragment;
            $filters[] = 'tbl.passwordAccess LIKE :searchPasswordAccess';
            $parameters['searchPasswordAccess'] = '%' . $fragment . '%';
            $filters[] = 'tbl.myFriends LIKE :searchMyFriends';
            $parameters['searchMyFriends'] = '%' . $fragment . '%';
            $filters[] = 'tbl.pos = :searchPos';
            $parameters['searchPos'] = $fragment;
        }
        if ($objectType == 'picture') {
            $filters[] = 'tbl.title LIKE :searchTitle';
            $parameters['searchTitle'] = '%' . $fragment . '%';
            $filters[] = 'tbl.description LIKE :searchDescription';
            $parameters['searchDescription'] = '%' . $fragment . '%';
            $filters[] = 'tbl.imageUpload = :searchImageUpload';
            $parameters['searchImageUpload'] = $fragment;
            $filters[] = 'tbl.imageView = :searchImageView';
            $parameters['searchImageView'] = $fragment;
            $filters[] = 'tbl.pos = :searchPos';
            $parameters['searchPos'] = $fragment;
        }
        if ($objectType == 'avatar') {
            $filters[] = 'tbl.title LIKE :searchTitle';
            $parameters['searchTitle'] = '%' . $fragment . '%';
            $filters[] = 'tbl.description LIKE :searchDescription';
            $parameters['searchDescription'] = '%' . $fragment . '%';
            $filters[] = 'tbl.avatarUpload = :searchAvatarUpload';
            $parameters['searchAvatarUpload'] = $fragment;
            $filters[] = 'tbl.supportedModules = :searchSupportedModules';
            $parameters['searchSupportedModules'] = $fragment;
        }
    
        $qb->andWhere('(' . implode(' OR ', $filters) . ')');
    
        foreach ($parameters as $parameterName => $parameterValue) {
            $qb->setParameter($parameterName, $parameterValue);
        }
    
        return $qb;
    }
    
    /**
     * Adds a filter for the createdBy field.
     *
     * @param QueryBuilder $qb     Query builder to be enhanced
     * @param integer      $userId The user identifier used for filtering
     *
     * @return QueryBuilder Enriched query builder instance
     */
    public function addCreatorFilter(QueryBuilder $qb, $userId = null)
    {
        if (null === $userId) {
            $userId = $this->currentUserApi->isLoggedIn() ? $this->currentUserApi->get('uid') : UsersConstant::USER_ID_ANONYMOUS;
        }
    
        if (is_array($userId)) {
            $qb->andWhere('tbl.createdBy IN (:userIds)')
               ->setParameter('userIds', $userId);
        } else {
            $qb->andWhere('tbl.createdBy = :userId')
               ->setParameter('userId', $userId);
        }
    
        return $qb;
    }
}
