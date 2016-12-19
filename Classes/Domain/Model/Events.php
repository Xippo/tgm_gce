<?php
namespace TGM\TgmGce\Domain\Model;


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

/**
 * Events
 */
class Events extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';
    
    /**
     * description
     *
     * @var string
     */
    protected $description = '';
    
    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;
    
    /**
     * form
     *
     * @var string
     */
    protected $form = '';
    
    /**
     * formReceiverMail
     *
     * @var string
     */
    protected $formReceiverMail = '';
    
    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * surname
     *
     * @var string
     */
    protected $surname = '';
    
    /**
     * email
     *
     * @var string
     */
    protected $email = '';
    
    /**
     * salutation
     *
     * @var string
     */
    protected $salutation = '';
    
    /**
     * tel
     *
     * @var string
     */
    protected $tel = '';
    
    /**
     * street
     *
     * @var string
     */
    protected $street = '';
    
    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';
    
    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * country
     *
     * @var string
     */
    protected $country = '';

    /**
     * lon
     *
     * @var string
     */
    protected $lon = '';
    
    /**
     * lat
     *
     * @var string
     */
    protected $lat = '';
    
    /**
     * gruppe
     *
     * @var \TGM\TgmGce\Domain\Model\EventGroup
     */
    protected $gruppe = null;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     * @cascade remove
     */
    protected $categories = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration>
     */
    protected $calendarize;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->calendarize = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration>
     */
    public function getCalendarize() {
        return $this->calendarize;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HDNET\Calendarize\Domain\Model\Configuration> $calendarize
     */
    public function setCalendarize(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $calendarize) {
        $this->calendarize = $calendarize;
    }

    /**
     * @param \HDNET\Calendarize\Domain\Model\Configuration $calendarize
     */
    public function addCalendarize(\HDNET\Calendarize\Domain\Model\Configuration $calendarize) {
        $this->calendarize->attach($calendarize);
    }

    /**
     * Adds a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categories
     * @return void
     */
    public function addCategories(\TYPO3\CMS\Extbase\Domain\Model\Category $categories)
    {
        $this->categories->attach($categories);
    }

    /**
     * Removes a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoriesToRemove The Category to be removed
     * @return void
     */
    public function removeCategories(\TYPO3\CMS\Extbase\Domain\Model\Category $categoriesToRemove)
    {
        $this->categories->detach($categoriesToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }


    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }
    
    /**
     * Returns the form
     *
     * @return string $form
     */
    public function getForm()
    {
        $uppercase = ucfirst($this->form);
        return $uppercase;
    }
    
    /**
     * Sets the form
     *
     * @param string $form
     * @return void
     */
    public function setForm($form)
    {
        $this->form = $form;
    }
    
    /**
     * Returns the formReceiverMail
     *
     * @return string $formReceiverMail
     */
    public function getFormReceiverMail()
    {
        return $this->formReceiverMail;
    }
    
    /**
     * Sets the formReceiverMail
     *
     * @param string $formReceiverMail
     * @return void
     */
    public function setFormReceiverMail($formReceiverMail)
    {
        $this->formReceiverMail = $formReceiverMail;
    }
    
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the surname
     *
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }
    
    /**
     * Sets the surname
     *
     * @param string $surname
     * @return void
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    
    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * Returns the salutation
     *
     * @return string $salutation
     */
    public function getSalutation()
    {
        return $this->salutation;
    }
    
    /**
     * Sets the salutation
     *
     * @param string $salutation
     * @return void
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    }
    
    /**
     * Returns the tel
     *
     * @return string $tel
     */
    public function getTel()
    {
        return $this->tel;
    }
    
    /**
     * Sets the tel
     *
     * @param string $tel
     * @return void
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }
    
    /**
     * Returns the street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }
    
    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }
    
    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }
    
    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }
    
    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Sets the country
     *
     * @param string $country
     * @return void
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    /**
     * Returns the lon
     *
     * @return string $lon
     */
    public function getLon()
    {
        return $this->lon;
    }
    
    /**
     * Sets the lon
     *
     * @param string $lon
     * @return void
     */
    public function setLon($lon)
    {
        $this->lon = $lon;
    }
    
    /**
     * Returns the lat
     *
     * @return string $lat
     */
    public function getLat()
    {
        return $this->lat;
    }
    
    /**
     * Sets the lat
     *
     * @param string $lat
     * @return void
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }
    
    /**
     * Returns the gruppe
     *
     * @return \TGM\TgmGce\Domain\Model\EventGroup $gruppe
     */
    public function getGruppe()
    {
        return $this->gruppe;
    }
    
    /**
     * Sets the gruppe
     *
     * @param \TGM\TgmGce\Domain\Model\EventGroup $gruppe
     * @return void
     */
    public function setGruppe(\TGM\TgmGce\Domain\Model\EventGroup $gruppe)
    {
        $this->gruppe = $gruppe;
    }

}