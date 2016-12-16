<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'TGM.' . $_EXTKEY,
	'Main',
	'TgM gce Events'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'TGM.' . $_EXTKEY,
	'Map',
	'TgM gce Events Map'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TgM Google Calendarize Events');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tgmgce_domain_model_events', 'EXT:tgm_gce/Resources/Private/Language/locallang_csh_tx_tgmgce_domain_model_events.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tgmgce_domain_model_events');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_tgmgce_domain_model_eventgroup', 'EXT:tgm_gce/Resources/Private/Language/locallang_csh_tx_tgmgce_domain_model_eventgroup.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_tgmgce_domain_model_eventgroup');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    $_EXTKEY,
    'tx_tgmgce_domain_model_events'
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
