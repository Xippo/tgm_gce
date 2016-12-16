<?php
$extensionName = TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase('tgm_gce');
$pluginSignature = strtolower($extensionName) . '_main';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tgm_gce/Configuration/Flexform/Main.xml'
);

$pluginSignature = strtolower($extensionName) . '_map';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:tgm_gce/Configuration/Flexform/Map.xml'
);
