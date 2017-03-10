<?php
namespace TGM\TgmGce\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Oliver Pfaff <op@teamgeist-medien.de>, Teamgeist Medien GbR
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use HDNET\Calendarize\Domain\Model\Index;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * EventsController
 */
class EventsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * eventsRepository
     *
     * @var \TGM\TgmGce\Domain\Repository\EventsRepository
     * @inject
     */
    protected $eventsRepository = NULL;

    /**
     * indexRepository
     *
     * @var \TGM\TgmGce\Domain\Repository\IndexRepository
     * @inject
     */
    protected $indexRepository = NULL;


    /**
     * @param array $filter
     */
    public function filterAction($filter = NULL)
    {
        if($filter){
            $this->redirect('list',null,null,array('filter'=>$filter));
        }
        $this->forward('list');
    }
    /**
     * action list
     *
     * @param array $filter
     * @return void
     */
    public function listAction($filter = NULL)
    {
        $limit = 999;
        $settings = $this->settings;
        $filter['data'] = $this->getFilterData($settings);

        if(!empty($settings['flex']['event']['itemLimit'])){
            $limit = (int)$settings['flex']['event']['itemLimit'];
        }

        //Override default plugin Settings with filter stuff from FE
        if(!empty($filter['category'])){
            //override settings
            $settings['flex']['filter']['categories'] = $filter['category'];
        }
        if(!empty($filter['group'])){
            //override settings
            $settings['flex']['filter']['group'] = $filter['group'];
        }

        //get the right uids from our event repo -> here we do the filter magic
        $filteredEvents = $this->eventsRepository->findByGroupAndCats($settings['flex']['filter'],true);
        //Set the right indexIds
        foreach ($filteredEvents as $event){
            $uids[] = $event['uid'];
        }

        $indices = $this->indexRepository->findByEventUids($uids,$limit);

        $this->view->assignMultiple(array(
            'indices' => $indices,
            'settings' => $settings,
            'filter' => $filter
        ));
    }

    public function mapAction()
    {
        $settings = $this->settings;
        $settings = $this->getMapFilterRestriction($settings);
        //we could use also findAll if we dont have filter settings could be a bit more performant
        $filteredEvents = $this->eventsRepository->findByGroupAndCats($settings['flex']['filter'],true);

        //Set the right indexIds
        foreach ($filteredEvents as $event){
            $uids[] = $event['uid'];
        }

        if(!empty($uids)){
            $uidList = implode(',',$uids);
            $events =  $this->indexRepository->findNextEvents($uidList);
            $events = $events->toArray();
        }

        $this->createGoogleMap($settings,$events);

        $this->view->assignMultiple(array(
            'map' => $settings['flex']['map']
        ));
    }

    protected function getMapFilterRestriction($settings)
    {
        //Get arguments from main plugin
        $argumentsMainPlugin = GeneralUtility::_GP('tx_tgmgce_main');
        //override default plugin filter settings
        if(!empty($argumentsMainPlugin['filter'])){
            if(!empty($argumentsMainPlugin['filter']['category'])){
               $settings['flex']['filter']['categories'] = $argumentsMainPlugin['filter']['category'];
            }
            if(!empty($argumentsMainPlugin['filter']['group'])){
               $settings['flex']['filter']['group'] = $argumentsMainPlugin['filter']['group'];
            }
        }
        return $settings;
    }

    /**
     * action show
     *
     * @param \TGM\TgmGce\Domain\Model\Index $index
     * @param integer $formSent
     */
    public function showAction(\TGM\TgmGce\Domain\Model\Index $index = null,$formSent = null)
    {
        if ($index === null) {
            if ($this->request->hasArgument('index')) {
                $indexId = (int)$this->request->getArgument('index');
                if ($indexId > 0) {
                    $index = $this->indexRepository->findByUid($indexId);
                }
            }
        }

        $settings = $this->settings;
        $this->createGoogleMap($settings,$index);

        $this->view->assignMultiple([
            'index' => $index,
            'settings' => $settings,
            'formSent'=> $formSent
        ]);
    }

    protected function getFilterData($settings){
        //Check if we need and we have category data
        if(!empty($settings['flex']['PlugFilter']['categories']) && !empty($settings['flex']['PlugFilter']['category'])){
            /** @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository $catRepo */
            $catRepo = $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository::class);
            $cats = $catRepo->findAll();
            $categories = explode(',',$settings['flex']['PlugFilter']['categories']);
            foreach ($cats as $category){
                if(in_array($category->getUid(),$categories)){
                    $filterCats[] = $category;
                }
            }
            $filter['category'] = $filterCats;
        }

        //Check if we need and we have group data
        if(!empty($settings['flex']['PlugFilter']['groups']) && !empty($settings['flex']['PlugFilter']['group'])){
            /** @var \TGM\TgmGce\Domain\Repository\EventGroupRepository $eventGrpRepo */
            $eventGrpRepo = $this->objectManager->get(\TGM\TgmGce\Domain\Repository\EventGroupRepository::class);
            $groups = $eventGrpRepo->findByList($settings['flex']['PlugFilter']['groups']);
            $filter['groups'] = $groups;
        }

        if(!empty($filter)){
            return $filter;
        }
        return false;
    }
    /**
     * @param array $form
     */
    public function formDispatcherAction($form){
        //TODO add Signal so somebody can perform db Stuff if he want
        /** @var \TGM\TgmGce\Domain\Model\Events $event */
        $event = $this->eventsRepository->findByUid((int)$form['eventUid']);

        //Get Index for the show view
        /** @var \TGM\TgmGce\Domain\Model\Index $index */
        $index = $this->indexRepository->findByUid((int)$form['indexUid']);

        /** @var \TGM\TgmGce\Utility\StandaloneViewRenderer $standaloneViewRenerer */
        $standaloneViewRenerer = $this->objectManager->get('TGM\TgmGce\Utility\StandaloneViewRenderer');
        $receiverMailContent = $standaloneViewRenerer->renderStandaloneTempl('Email/'.$event->getForm().'/','Receiver',array('formEntrys'=>$form),$this->controllerContext);

        if(!empty($event->getFormReceiverMail())) $receiverMail = $event->getFormReceiverMail();
        else $receiverMail = $this->settings['email']['receiver'];

        //get Subject
        $subject = $this->getMailSubject('mail.subject',$index,$event);
        $mailSent = \TGM\TgmGce\Utility\GeneralUtility::sendMail($this->settings['email']['sender'],$receiverMail,$subject,$receiverMailContent);

        //send email to costumer if the setting is set and we have a email field in the form
        if($this->settings['email']['confmail'] && !empty($form['email'])){
            $subject = $this->getMailSubject('mailconf.subject',$index,$event);
            $receiverMailContent='';
            try{
                //I catch the error, so if the template dont exists we don't get exceptions
                $receiverMailContent = $standaloneViewRenerer->renderStandaloneTempl('Email/'.$event->getForm().'/','Customer',array('formEntrys'=>$form),$this->controllerContext);
            }catch(\Throwable $t){};
            try{
                \TGM\TgmGce\Utility\GeneralUtility::sendMail($this->settings['email']['sender'],$form['email'],$subject,$receiverMailContent);
            }catch(\Throwable $t){};
        }
        //Clear the cache form this page, so we can render success/error msg
        $this->cacheService->clearPageCache($GLOBALS['TSFE']->id);

        $this->redirect('show',null,null,array(
            'index' => $index,
            'formSent' => $mailSent
        ));
    }

    /**
     * @param $settings array
     * @param $events \TGM\TgmGce\Domain\Model\Index|array events to display on the map
     */
    protected function createGoogleMap($settings,$events){
        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRender */
        $pageRender = $this->objectManager->get('TYPO3\CMS\Core\Page\PageRenderer');
        //init empty marker
        $marker='';
        //only if we have events we generate markers 
        if(!empty($events)){
            $marker = $this->generateMarker($events, $settings);
        }
        $googleApi = 'https://maps.googleapis.com/maps/api/js?key=' . $settings['google']['apiKey'];
        $pageRender->addHeaderData('<script  src="' . $googleApi . '"></script>');
        if (is_array($events)) {
            $mapJs = '
            function initMap() {
                var gm = google.maps;
                // Create a map object and specify the DOM element for display.
                var map = new google.maps.Map(document.getElementById("map"), {
                        center: {lat: ' . $settings['flex']['map']['lat'] . ', lng: ' . $settings['flex']['map']['lon'] . '} ,
                        scrollwheel: true ,
                        zoom: ' . $settings['flex']['map']['zoom'] . '
                    });
                var oms = new OverlappingMarkerSpiderfier(map,{keepSpiderfied:true});
                var iw = new gm.InfoWindow();
                oms.addListener("click", function(marker, event) {
                  iw.setContent(marker.desc);
                  iw.open(map, marker);
                });
                ' . $marker . '
            }';
            $pageRender->addHeaderData('<script src="typo3conf/ext/tgm_gce/Resources/Public/Js/overlappingMarkerSpiderfier.min.js"></script>');
        } elseif(!empty($events)) {
            /** @var \TGM\TgmGce\Domain\Model\Index $event */
            $event = $events;
            /** @var \TGM\TgmGce\Domain\Model\Events $eventOrigin */
            $eventOrigin = $event->getOriginalObject();
            $mapJs = '
            function initMap() {
                var map = new google.maps.Map(document.getElementById("map"), {
                    center: {lat: ' . $eventOrigin->getLat() . ', lng: ' . $eventOrigin->getLon() . '},
                    scrollwheel: true ,
                    zoom: ' . $settings['flex']['map']['zoom'] . '
                });
                ' . $marker . '
            }';
        }else{
            //empty map
            $mapJs = '
            function initMap() {
                var gm = google.maps;
                // Create a map object and specify the DOM element for display.
                var map = new google.maps.Map(document.getElementById("map"), {
                        center: {lat: ' . $settings['flex']['map']['lat'] . ', lng: ' . $settings['flex']['map']['lon'] . '} ,
                        scrollwheel: true ,
                        zoom: ' . $settings['flex']['map']['zoom'] . '
                    });
            }';
        }
        $pageRender->addJsFooterInlineCode('map', $mapJs);
        // Init the map, onload is important for the spider script
        $pageRender->addFooterData('<script> window.onload = function () {initMap();}</script>');
    }

    protected function generateMarker($events,$settings){
        /** @var \TGM\TgmGce\Utility\StandaloneViewRenderer $standaloneViewRenerer */
        $standaloneViewRenerer = $this->objectManager->get('TGM\TgmGce\Utility\StandaloneViewRenderer');
        $markerNumber = '';
        $markerJS = "";
        if(is_array($events)){
            foreach ($events as $event){
                /** @var \TGM\TgmGce\Domain\Model\Events $eventOrigin */
                $eventOrigin = $event->getOriginalObject();
                //Avoid to try to generate the marker if no coordinates. Will generate js error if no coords are stored
                if(!empty($eventOrigin->getLat()) && !empty($eventOrigin->getLon())){
                    $markerJS .= "
                        var contentString = '" . str_replace("'",'"',preg_replace( "/\r|\n/", "", (string)$standaloneViewRenerer->renderStandaloneTempl('Maps/Marker/','Info',array('event'=>$event,'settings'=>$settings),$this->controllerContext))) . "';
                        
                        var marker" . $markerNumber . " = new google.maps.Marker({
                            position: {lat: " . $eventOrigin->getLat() . ", lng: " . $eventOrigin->getLon() . "},
                            map: map,
                            title: '" . $eventOrigin->getTitle() . "'
                        });
                        marker" . $markerNumber . ".desc = contentString;
                        oms.addMarker(marker" . $markerNumber . "); 
                        ";
                    $markerNumber++;
                }
            }
        }else{
            /** @var \TGM\TgmGce\Domain\Model\Index $event */
            $event = $events;
            /** @var \TGM\TgmGce\Domain\Model\Events $eventOrigin */
            $eventOrigin = $event->getOriginalObject();
            //Avoid to try to generate the marker if no coordinates. Will generate js error if no coords are stored
            if(!empty($eventOrigin->getLat()) && !empty($eventOrigin->getLon())) {
                $markerJS .= "
                    var marker = new google.maps.Marker({
                        position: {lat: " . $eventOrigin->getLat() . ", lng: " . $eventOrigin->getLon() . "},
                        map: map,
                        title: '" . $eventOrigin->getStreet() . "'
                    });
                ";
            }
        }
        return $markerJS;
    }

    /**
     * @param string $key
     * @param \TGM\TgmGce\Domain\Model\Index $index
     * @param \TGM\TgmGce\Domain\Model\Events $event
     * @return mixed|NULL|string
     */
    protected function getMailSubject($key,$index,$event)
    {
        $subject = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, 'tgm_gce');
        $markers = $this->getInbetweenStrings('###','###',$subject);
        if(is_array($markers)){
            foreach ($markers as $marker){
                switch ($marker[1]){
                    case 'title';
                        $replacement = $event->getTitle();
                        break;
                    case 'date';
                        //TODO Get the TYPO3 format
                        $replacement = $index->getStartDate()->format('d.m.Y');
                        break;
                    default;
                        $replacement = $marker[0]. '(marker not supported)';
                }
                $subject = preg_replace('/'.$marker[0].'/', $replacement, $subject);
            }
        }
        return $subject;
    }

    protected function getInbetweenStrings($start, $end, $str){
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_.]*)$end/";
        preg_match_all($regex, $str, $matches,PREG_SET_ORDER);
        return $matches;
    }

}