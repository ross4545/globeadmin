<?php
/**
 * Created by PhpStorm.
 * User: Andrews
 * Date: 9/13/2019
 * Time: 7:00 AM
 */

namespace Globesol\globeadmin\Models;

use Illuminate\Database\Schema\Blueprint;
abstract class GlobeQueryInterface
{

    public abstract function getSearchQuery(): array ;

    public abstract function getInsertQuery(): array ;

    public abstract function getRoleQuery(): array ;

    public  function getSchemaQuery(Blueprint $table)
    {
        $table->string('created_by',50)->nullable();
        $table->string('updated_by',50)->nullable();
        $table->string('deleted_by',50)->nullable();
        return $table;
    }

}