<?php
namespace TGM\TgmGce\Utility;
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

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class StandaloneViewRenderer
{
    /**
     * ObjectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager = NULL;

    /**
     * ConfigurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     * @inject
     */
    protected $configurationManager = NULL;
    
    /**
     * @param string $folderName e.g for /Email/Conf/ you need only Email/Conf/
     * @param string $templateName without .html
     * @param array $tmplVariables
     * @param \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext|NULL $controllerContext is useful when you create some internal link to show views or something like that
     * @return mixed
     * @throws \Exception
     */
    public function renderStandaloneTempl($folderName,$templateName,$tmplVariables = array(), \TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext $controllerContext = NULL){
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView  $view */
        $view = $this->objectManager->get('TYPO3\CMS\Fluid\View\StandaloneView');
        //Get extension TS config, works only inside the extension. If we want the renderer to be avaible outside the extension, we need the ext name as parameter.
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $view->setPartialRootPaths($extbaseFrameworkConfiguration['view']['partialRootPaths']);
        $view->setLayoutRootPaths($extbaseFrameworkConfiguration['view']['layoutRootPaths']);
        $view->setTemplateRootPaths($extbaseFrameworkConfiguration['view']['templateRootPaths']);
        $view->setTemplate($folderName.$templateName);
        $view->assignMultiple($tmplVariables);
        if($controllerContext)$view->setControllerContext($controllerContext);
        $output = $view->render();
        return $output;
    }

}