<?php
/**
 * Code generated using GlobeAdmin
 * Help: support@deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

namespace Globesol\Globeadmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Log;
use Schema;
use Auth;
use Globesol\Globeadmin\Models\Module;
use Globesol\Globeadmin\Models\ModuleFields;
use Globesol\Globeadmin\Models\ModuleFieldTypes;
use Globesol\Globeadmin\Helpers\LAHelper;

/**
 * Class FieldController
 * @package Globesol\Globeadmin\Controllers
 *
 * Controller looks after
 */
class FieldController extends Controller
{
    /**
     * Store a newly created Module Field via "Module Manager"
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $module = Module::find($request->module_id);
        $module_id = $request->module_id;
        
        $field_id = ModuleFields::createField($request);
        
        // Give Default Full Access to Super Admin
        $role = \App\Role::where("name", "SUPER_ADMIN")->first();
        Module::setDefaultFieldRoleAccess($field_id, $role->id, "full");
        
        return redirect()->route(config('laraadmin.adminRoute') . '.modules.show', [$module_id]);
    }
    
    /**
     * Show the form for editing of Module Field via "Module Manager"
     *
     * @param $id Field's ID to be Edited
     * @return $this
     */
    public function edit($id)
    {
        $field = ModuleFields::find($id);
        
        $module = Module::find($field->module);
        $ftypes = ModuleFieldTypes::getFTypes2();
        
        $tables = LAHelper::getDBTables([]);
        
        return view('la.modules.field_edit', [
            'module' => $module,
            'ftypes' => $ftypes,
            'tables' => $tables
        ])->with('field', $field);
    }
    
    /**
     * Update the specified Module Field via "Module Manager"
     *
     * @param Request $request
     * @param $id Field's ID to be Updated
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $module_id = $request->module_id;
        
        ModuleFields::updateField($id, $request);
        
        return redirect()->route(config('laraadmin.adminRoute') . '.modules.show', [$module_id]);
    }
    
    /**
     * Remove the specified Module Field from Database Context + Table
     *
     * @param $id Field's ID to be Destroyed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Get Context
        $field = ModuleFields::find($id);
        $module = Module::find($field->module);
        
        // Delete from Table module_field
        Schema::table($module->name_db, function ($table) use ($field) {
            try
            {
               // $table->dropForeign([$field->colname]);	// Issue #239

            }
            catch (Exception $e)
            {

            }
            try
            {
                $table->dropColumn($field->colname);
            }
            catch (Exception $e)
            {

            }

        });

        try
        {
            $field->delete();
        }
        catch (Exception $e)
        {

        }
        
        // Delete Context

        return redirect()->route(config('laraadmin.adminRoute') . '.modules.show', [$module->id]);
    }
    
    /**
     * Check unique values for particular field
     *
     * @param Request $request
     * @param $field_id Field ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_unique_val(Request $request, $field_id)
    {
        $valExists = false;
        if($request->input('role_id')=='global')
        {
            $role='role';
        }
        else{
            $role='default';
        }

        
        // Get Field
        $field = ModuleFields::find($field_id);
        // Get Module
        $module = Module::find($field->module);
        
        // echo $module->name_db." ".$field->colname." ".$request->field_value;

        $fields=Module::getSchemafilterfields($role);

        $rowCount = DB::table($module->name_db)->where($field->colname, $request->field_value)
            ->where(function ($builder)use($fields)
            {
                foreach ($fields as $field=>$key)
                {
                    $builder->where($field,$key);
                }
            })

            ->where(function ($builder) use($request) {
                if($request->input('isEdit')=="true")
                {
                    $builder->where("id", "!=", $request->row_id);
                }

            })

            ->whereNull('deleted_at')->count();
        
        if($rowCount > 0) {
            $valExists = true;
        }
        
        return response()->json(['exists' => $valExists]);
    }
    
    /**
     * Save column visibility in listing/index view
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function module_field_listing_show_ajax(Request $request)
    {
        if($request->state == "true") {
            $state = 1;
        } else {
            $state = 0;
        }
        $module_field = ModuleFields::find($request->listid);
        if(isset($module_field->id)) {
            $module_field->listing_col = $state;
            $module_field->save();
            
            return response()->json(['status' => 'success', 'message' => "Module field listing visibility saved to " . $state]);
        } else {
            return response()->json(['status' => 'failed', 'message' => "Module field not found"]);
        }
    }
}
