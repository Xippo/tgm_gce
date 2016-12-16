<?php
namespace TGM\TgmGce\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class GeoGoogleUtility {

    static function getCoordsFromGoogle($zip='',$city='',$street='',$countryCode='de') {
        //get apiKey from config
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        /** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager */
        $configurationManager = $objectManager->get('TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface');
        $config = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK,'tgmgce');

        define("MAPURL",'https://maps.googleapis.com/maps/api/geocode/xml?key='. $config['google']['apiKey'] .'&address=');

        $suche =    array('  ','é','ö', 'ü', 'ä', 'Ö', 'Ü', 'Ä', 'ß');
        $ersetzen = array(' ', 'e','oe','ue','ae','Oe','Ue','Ae','ss');

        $location = urlencode(trim($zip).' '.str_replace($suche,$ersetzen,trim($city)).' '.str_replace($suche,$ersetzen,trim($street)));

        //Anfrage an Googel Mit PLZ ORT STRASSE UND HAUSNUMMER
        $url = MAPURL.$location.'&sensor=false&region='.$countryCode;

        //Ganz wichtig !!!
        $xmlDaten = utf8_encode(nl2br(file_get_contents($url)));
        $xmlDaten = substr($xmlDaten, 45, -7);
        $xmlDaten = str_replace('<br />','',$xmlDaten);

        //Neues XML Objekt erzeugen
        $xml = new \SimpleXMLElement($xmlDaten);

        # Bei Fehler neuen Versuch ohne Straßs starten 
        if((string)$xml->status != 'OK') {
            $zipCity = urlencode(trim($zip).' '.str_replace($suche,$ersetzen,trim($city)));
            $url = MAPURL.$zipCity.'&sensor=false&region='.$countryCode;

            $xmlDaten = utf8_encode(nl2br(file_get_contents($url)));
            $xmlDaten = substr($xmlDaten, 45, -7);
            $xmlDaten = str_replace('<br />','',$xmlDaten);
            $xml = new \SimpleXMLElement($xmlDaten);
        }

        //Ermittelt die Positionsangaben in Länge , Breite , Höhe [wird (noch) nicht von Googel unterstützt]

        if((string)$xml->status == 'OK' && !is_array($xml->result)) {
            $felderWerte = array(
                'lat' => (double) $xml->result->geometry->location->lat,
                'lng' => (double) $xml->result->geometry->location->lng,
                'kind_of_position'=> (string) $xml->result->type,
            );
            return $felderWerte;
        } else {
            return false;
        }
    }
}
