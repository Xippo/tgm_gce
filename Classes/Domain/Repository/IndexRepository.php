<?php
/**
 * Index repository
 *
 */
namespace TGM\TgmGce\Domain\Repository;

use Exception;
use HDNET\Calendarize\Domain\Model\Index;
use HDNET\Calendarize\Register;
use HDNET\Calendarize\Utility\DateTimeUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
}
