<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TGM.' . $_EXTKEY,
	'Main',
	array(
		'Events' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Events' => 'formDispatcher, filter',
	)
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TGM.' . $_EXTKEY,
	'Map',
	array(
		'Events' => 'map',
	),
	// non-cacheable actions
	array(
		'Events' => '',
	)
);

$configuration = [
    'uniqueRegisterKey' => 'TgmGceEvent', // A unique Key for the register (e.g. you Extension Key + "Event")
    'title'             => 'TgM gce Event', // The title for your events (this is shown in the FlexForm configuration of the Plugins)
    'modelName'         => \TGM\TgmGce\Domain\Model\Events::class, // the name of your model
    'partialIdentifier' => 'TgmGceEvent', // the identifier of the partials for your event. In most cases this is also unique
    'tableName'         => 'tx_tgmgce_domain_model_events', // the table name of your event table
    'required'          => true, // set to true, than your event need a least one event configuration
];

\HDNET\Calendarize\Register::extTables($configuration);

/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
/*
$signalSlotDispatcher->connect(
    \HDNET\Calendarize\Domain\Repository\IndexRepository::class,
    'getDefaultConstraints',
    \TGM\TgmGce\Controller\EventsController::class,
    'limitConstraintWhenFilteredOptionsAreSetSlot'
);
*/
//Register Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:tgm_gce/Classes/Hooks/class.tx_tgmgce_tcemainproc.php:tx_tgmgce_tcemainproc';
