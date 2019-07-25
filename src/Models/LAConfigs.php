<?php
/**
 * Code generated using GlobeAdmin
 * Help: support@deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

namespace Globesol\globeadmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Globesol\globeadmin\Helpers\LAHelper;

/**
 * Class LAConfigs
 * @package Globesol\globeadmin\Models
 *
 * Config Class looks after GlobeAdmin configurations.
 * Check details on http://deltasoftltd.com/docs
 */
class LAConfigs extends Model
{
    protected $table = 'la_configs';
    
    protected $fillable = [
        "key", "value"
    ];
    
    protected $hidden = [
    
    ];
    
    /**
     * Get configuration string value by using key such as 'sitename'
     *
     * LAConfigs::getByKey('sitename');
     *
     * @param $key key string of configuration
     * @return bool value of configuration
     */
    public static function getByKey($key)
    {
        $row = LAConfigs::where('key', $key)->first();
        if(isset($row->value)) {
            return $row->value;
        } else {
            return false;
        }
    }
    
    /**
     * Get all configuration as object
     *
     * LAConfigs::getAll();
     *
     * @return object
     */
    public static function getAll()
    {
        $configs = array();
        $configs_db = LAConfigs::all();
        foreach($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        return (object)$configs;
    }
}
