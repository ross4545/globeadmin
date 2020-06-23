<?php
/**
 * Created by PhpStorm.
 * User: Andrews
 * Date: 6/21/2020
 * Time: 1:07 PM
 */

namespace Globesol\globeadmin\Models;


/**
 * Interface EditDeleteInterface
 * @package Globesol\globeadmin\Models
 */
interface EditDeleteInterface
{


    /**
     * @return bool
     */
    public function is_deletable():bool ;

    /**
     * @return bool
     */
    public function is_editable():bool ;

    /**
     * @return bool
     */
    public function getIsDeletableAttribute():bool;

    /**
     * @return bool
     */
    public function getIsEditableAttribute():bool;
}