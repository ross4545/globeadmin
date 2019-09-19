<?php
/**
 * Created by PhpStorm.
 * User: Andrews
 * Date: 9/13/2019
 * Time: 7:00 AM
 */

namespace Globesol\globeadmin\Models;

use Illuminate\Database\Schema\Blueprint;
interface GlobeQueryInterface
{

    public function getSearchQuery(): array ;

    public function getRoleQuery(): array ;

    public function getInsertQuery(): array ;

    public function getSchemaQuery(Blueprint $table):Blueprint;
}