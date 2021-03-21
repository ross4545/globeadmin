<?php
/**
 * Model generated using GlobeAdmin
 * Help: support@deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

namespace App;

use Spatie\Permission\Models\Permission as  SpatiePermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends SpatiePermission
{
    use SoftDeletes;
	
	protected $table = 'permissions';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
