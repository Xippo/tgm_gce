<?php
/**
 * Index repository
 *
 */
namespace TGM\TgmGce\Domain\Repository;

use HDNET\Calendarize\Utility\DateTimeUtility;

/**
 * Index repository
 */
class IndexRepository extends \HDNET\Calendarize\Domain\Repository\IndexRepository
{
    //find only the next valid index from event
    public function findNextEvents($filteredList = NULL){
        $query = $this->createQuery();
        //UTC Date
        $today = gmmktime(0,0,0);
        // TODO optimize this query
        if($filteredList){
            $query->statement('SELECT *, min(start_date) 
                            FROM tx_calendarize_domain_model_index
                            WHERE start_date >= ' . $today . ' AND foreign_uid IN('.$filteredList.') 
                            GROUP BY foreign_uid');
        }else{
            $query->statement('SELECT *, min(start_date) 
                            FROM tx_calendarize_domain_model_index
                            WHERE start_date >= ' . $today . '
                            GROUP BY foreign_uid');
        }
        return $query->execute();
    }

    /**
     * @param array $uids
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByEventUids($uids,$limit = NULL)
    {
        $query = $this->createQuery();
        $constraints[] = $query->in('foreign_uid', $uids);
        $now = DateTimeUtility::getNow();
        $this->addTimeFrameConstraints($constraints,$query,$now->getTimestamp());
        if($limit){
            $query->setLimit($limit);
        }
        return $this->matchAndExecute($query,$constraints);
    }
}


