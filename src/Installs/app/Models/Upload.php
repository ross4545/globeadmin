<?php
/**
 * Model generated using GlobeAdmin
 * Help: http://deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes;
	
	protected $table = 'uploads';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];

	/**
     * Get the user that owns upload.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get File path
     */
    public function path()
    {
        return url("files/".$this->hash."/".$this->name);
    }
}
