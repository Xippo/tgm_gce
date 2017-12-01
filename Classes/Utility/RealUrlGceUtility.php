<?php
namespace TGM\TgmGce\Utility;

use DmitryDulepov\Realurl\Configuration\ConfigurationReader;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class RealUrlGceUtility {

    public function getTitle($params)
    {
        /** @var \DmitryDulepov\Realurl\Encoder\UrlEncoder  $realurlObj */
        //DebuggerUtility::var_dump($params);
        $realurlObj = $params['pObj'];
        //DebuggerUtility::var_dump($params);
        if(is_a($realurlObj,\DmitryDulepov\Realurl\Encoder\UrlEncoder::class)){
            /** @var \TYPO3\CMS\Core\Database\DatabaseConnection $DB */
            $DB = $GLOBALS['TYPO3_DB'];
            $foreignUid =  $DB->exec_SELECTgetSingleRow('foreign_uid', 'tx_calendarize_domain_model_index', 'uid=' . $params['value'])['foreign_uid'];
            $title =  $DB->exec_SELECTgetSingleRow('title', 'tx_tgmgce_domain_model_events', 'uid=' . $foreignUid)['title'];
            $urlSegment = $title . '-' .$params['value'];

            /** @var ConfigurationReader $conf */
            $conf = $realurlObj->getConfiguration();
            $conf->getGetVarsToSet();
            $spaceChar = $conf->get('pagePath')['spaceCharacter'];
            $urlSegment = $this->encodeTitle($urlSegment,$spaceChar);
            return $urlSegment;
        }else{
            //DebuggerUtility::var_dump($params);
           return (int)substr($params['origValue'],(strrpos($params['origValue'],'-')+1));
        }
    }

    public function encodeTitle($title,$spaceChar) {
        // Fetch character set
        $charset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] ? $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] : $GLOBALS['TSFE']->defaultCharSet;

        // Convert to lowercase
        $processedTitle = $GLOBALS['TSFE']->csConvObj->conv_case($charset, $title, 'toLower');

        // Strip tags
        $processedTitle = strip_tags($processedTitle);

        // Convert some special tokens to the space character
        $space = !empty($spaceChar) ? $spaceChar : '_';
        $processedTitle = preg_replace('/[ \/\+_]+/', $space, $processedTitle); // convert spaces

        // Convert extended letters to ascii equivalents
        $processedTitle = $GLOBALS['TSFE']->csConvObj->specCharsToASCII($charset, $processedTitle);

        $processedTitle = preg_replace('/\\' . $space . '{2,}/', $space, $processedTitle); // Convert multiple 'spaces' to a single one
        $processedTitle = trim($processedTitle, $space);

        return $processedTitle;
    }
}
