<?php
namespace TGM\TgmGce\Domain\Repository;


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

/**
 * The repository for Events
 */
class EventsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param $filter array
     * @param $raw boolean
     */
    public function findByGroupAndCats($filter,$raw = false){
        $frequencys = ['daily','weekly','monthly','yearly'];
        $query = $this->createQuery();
        //Only Events with frequencys or startdates greater then now. Standard Constraints
        $constraints[] = $query->in('calendarize.frequency',$frequencys);
        $constraints[] = $query->greaterThanOrEqual('calendarize.start_date',time());

        //Evaluate Filter settings from Plugin
        $filterConstraints = $this->evaluateFilterAndBuildConstraint($filter);
        if(!empty($filterConstraints)){
            $query->matching($query->logicalAnd(
                $query->logicalOr($constraints),
                $filterConstraints
            ));
        }else{
            $query->matching($query->logicalOr($constraints));
        }
        return $query->execute($raw);
    }

    /**
     * @param $filter array
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\AndInterface|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface|null
     */
    protected function evaluateFilterAndBuildConstraint($filter){
        $query = $this->createQuery();
        $filterConstraints = [];
        if(!empty($filter['group'])){
            $groupConstraints = [];
            $filter['group'] = explode(',',$filter['group']);
            foreach ($filter['group'] as $groupUid){
                //TODO change to contains when we implement event to group 1:n rel (multi group selector)
                $groupConstraints[] = $query->equals('gruppe',$groupUid);
            }
            if($filter['groupConjunction'] === 'and'){
                //Not implemented, event has a 1:1 rel to the groups
                $filterConstraints[] = $query->logicalAnd($groupConstraints);
            }else{
                //or
                $filterConstraints[] = $query->logicalOr($groupConstraints);
            }
        }
        if(!empty($filter['categories'])){
            $categoriesConstraints = [];
            $filter['categories'] = explode(',',$filter['categories']);
            foreach ($filter['categories'] as $categoriesUid){
                $categoriesConstraints[] = $query->contains('categories',$categoriesUid);
            }
            if($filter['categoriesConjunction'] === 'and'){
                $filterConstraints[] = $query->logicalAnd($categoriesConstraints);
            }else{
                //or
                $filterConstraints[] = $query->logicalOr($categoriesConstraints);
            }
        }
        if(!empty($filter['categories']) && !empty($filter['group'])){
            if ($filter['categoriesAndGroupsConjunction'] === 'and'){
                return $query->logicalAnd($filterConstraints);
            }else{
                //or
                return $query->logicalOr($filterConstraints);
            }
        }
        return $filterConstraints[0];
    }
    
}