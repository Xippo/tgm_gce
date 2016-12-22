<?php
/**
 * Index repository
 *
 */
namespace TGM\TgmGce\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Index repository
 */
class EventGroupRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param $listOfUids string
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByList($listOfUids){
        $elements = explode(',',$listOfUids);
        $query = $this->createQuery();
        $query->matching($query->in('uid',$elements));
        return $query->execute();
    }
}
