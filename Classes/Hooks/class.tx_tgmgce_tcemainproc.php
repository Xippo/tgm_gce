<?php

class tx_tgmgce_tcemainproc {
    function processDatamap_afterDatabaseOperations($status, $table, $id, &$fieldArray, &$reference) {
        if($table == 'tx_tgmgce_domain_model_events' && ($status=='update' || $status=='new')) {
			if(isset($fieldArray['street']) || isset($fieldArray['zip']) || isset($fieldArray['city'])) {
				$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
                /** @var \TGM\TgmGce\Domain\Repository\EventsRepository $eventRepository */
				$eventRepository = $objectManager->get('TGM\TgmGce\Domain\Repository\EventsRepository');

				$querySettings = $objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings');
				$querySettings->setIgnoreEnableFields(TRUE);
				$eventRepository->setDefaultQuerySettings($querySettings);

                if($status=='new'){
                    //Die persitierte id der unterstüzung
                    $id = $reference->substNEWwithIDs[$id];
                }

				/** @var \TGM\TgmGce\Domain\Model\Events $event */
				$event = $eventRepository->findByUid($id);
				if(($coords = \TGM\TgmGce\Utility\GeoGoogleUtility::getCoordsFromGoogle($event->getZip(), $event->getCity(), $event->getStreet(), $event->getCountry())) !== FALSE) {
					$event->setLat($coords['lat']);
					$event->setLon($coords['lng']);
					$eventRepository->update($event);
                    /** @var TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager  $persistenceManager */
					$persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
					$persistenceManager->persistAll();
				}
			}
        }
    }
}
