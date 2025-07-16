<?php


namespace Application\Concrete\Models\Common;

use Application\Concrete\Page\Controller\PageResponse;
use Application\Concrete\Page\Page;

class CommonList extends \Concrete\Core\Page\PageList
{
    protected $baseClassName;

    public function __construct($baseClassName = "", $excludePageList = true)
    {
        parent::__construct();
        if($excludePageList) {
            $this->includeExcludePageList();
        }
        $this->setBaseClassName($baseClassName);
    }

    public function includeExcludePageList()
    {
        $this->filter(false, '(ak_exclude_page_list = 0 or ak_exclude_page_list is null)');
    }

    public function getResult($queryRow)
    {
        $c = Page::getByID($queryRow['cID'], 'ACTIVE');

        if (is_object($c) && $this->checkPermissions($c)) {

            if ($this->pageVersionToRetrieve == self::PAGE_VERSION_RECENT) {
                $cp = new \Permissions($c);
                if ($cp->canViewPageVersions() || $this->permissionsChecker === -1) {
                    $c->loadVersionObject('RECENT');
                }
            } elseif ($this->pageVersionToRetrieve == self::PAGE_VERSION_SCHEDULED) {
                $cp = new \Permissions($c);
                if ($cp->canViewPageVersions() || $this->permissionsChecker === -1) {
                    $c->loadVersionObject('SCHEDULED');
                }
            } elseif ($this->pageVersionToRetrieve == self::PAGE_VERSION_RECENT_UNAPPROVED) {
                $cp = new \Permissions($c);
                if ($cp->canViewPageVersions() || $this->permissionsChecker === -1) {
                    $c->loadVersionObject('RECENT_UNAPPROVED');
                }
            }
            if (isset($queryRow['cIndexScore'])) {
                $c->setPageIndexScore($queryRow['cIndexScore']);
            }

            if($this->getBaseClassName()){
                $class = $this->getBaseClassName();
                $baseObject = new $class($c);
            }
            else{
                $baseObject = $c;
            }

            return $baseObject;
        }

        return null;
    }

    /**
     * @param int $page
     * @return PageResponse
     */
    public function getPage($page = 1)
    {
        $pages    = [];
        $loadMore = false;

        $pagination = $this->getPagination();

        if ($pagination->getTotalPages() >= $page) {
            $pagination->setCurrentPage($page);
            $pages = $pagination->getCurrentPageResults();
        }

        if($pagination->hasNextPage()) {
            $loadMore = true;
        }

        return new PageResponse($pages, $loadMore, $pagination->getTotalResults(), $pagination->getTotalPages());
    }


    /** Returns a full array of results. */
    public function getResults()
    {
        $results = array();

        $this->debugStart();

        $executeResults = $this->executeGetResults();

        $this->debugStop();

        foreach ($executeResults as $result) {
            $r = $this->getResult($result);
            if ($r != null) {
                $results[] = $r;
            }
        }

        return $results;
    }

    public function excludeByID($ID)
    {
        $params = [];
        if (!is_array($ID)) {
            $items = [$ID];
        } else {
            $items = $ID;
        }
        foreach ($items as $key => $value) {
            $params[] = ':CID' . $key;
            $this->getQueryObject()->setParameter('CID' . $key, $value);
        }

        $this->getQueryObject()->andWhere($this->getQueryObject()->expr()->notIn('p.cID', $params));
    }

    protected function setBaseClassName($cm)
    {
        $this->baseClassName = $cm;
    }

    protected function getBaseClassName()
    {
        return $this->baseClassName;
    }

    public function sortByApplication($value)
    {
        switch ($value){
            case 'date_asc':
                $this->sortByPublicDate();
                break;
            case 'date_desc':
                $this->sortByPublicDateDescending();
                break;
            case 'name_asc':
                $this->sortByName();
                break;
            case 'name_desc':
                $this->sortByNameDescending();
                break;
            case 'display_asc':
                $this->sortByDisplayOrder();
                break;
            case 'display_desc':
                $this->sortByDisplayOrderDescending();
                break;
        }
    }
    public function filterByIDs($ids) {
        $params = [];
        if (!is_array($ids)) {
            $items = [$ids];
        } else {
            $items = $ids;
        }
        foreach ($items as $key => $value) {
            $params[] = ':CID' . $key;
            $this->getQueryObject()->setParameter('CID' . $key, $value);
        }

        $this->getQueryObject()->andWhere($this->getQueryObject()->expr()->In('p.cID', $params));

    }
}