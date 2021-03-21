<?php
/**
 * Code generated using GlobeAdmin
 * Help: support@deltasoftltd.com
 * GlobeAdmin is open-sourced software licensed under the MIT license.
 * Developed by: DeltaSoft Technologies
 * Developer Website: https://deltasoftltd.com
 */

namespace Globesol\globeadmin;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Globesol\globeadmin\Helpers\LAHelper;

/**
 * Class LAProvider
 * @package Globesol\globeadmin
 *
 * This is GlobeAdmin Service Provider which looks after managing aliases, other required providers, blade directives
 * and Commands.
 */
class LAProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


            // Call to Entrust::hasRole
//            Blade::directive('role', function ($expression) {
/*                return "<?php if (\\Entrust::hasRole({$expression})) : ?>";*/
//            });
//
//            // Call to Entrust::can
//            Blade::directive('permission', function ($expression) {
/*                return "<?php if (\\Entrust::can({$expression})) : ?>";*/
//            });

            // Call to Entrust::ability
            Blade::directive('ability', function ($expression) {
                return "<?php if (\\Entrust::ability({$expression})) : ?>";
            });
    }
    
    /**
     * Register the application services including routes, Required Providers, Alias, Controllers, Blade Directives
     * and Commands.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            include __DIR__ . '/../../laeditor/src/routes.php';
        }
        
        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */
        
        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);
        
        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */
        
        $loader = AliasLoader::getInstance();
        
        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);
        
        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);
        
        // For GlobeAdmin Code Generation
        $loader->alias('CodeGenerator', \Globesol\globeadmin\CodeGenerator::class);
        
        // For GlobeAdmin Form Helper
        $loader->alias('LAFormMaker', \Globesol\globeadmin\LAFormMaker::class);
        
        // For GlobeAdmin Helper
        $loader->alias('LAHelper', \Globesol\globeadmin\Helpers\LAHelper::class);
        
        // GlobeAdmin Module Model
        $loader->alias('Module', \Globesol\globeadmin\Models\Module::class);
        
        // For GlobeAdmin Configuration Model
        $loader->alias('LAConfigs', \Globesol\globeadmin\Models\LAConfigs::class);
        
        // For Entrust
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);
        $loader->alias('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);
        
        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */
        
        $this->app->make('Globesol\globeadmin\Controllers\ModuleController');
        $this->app->make('Globesol\globeadmin\Controllers\FieldController');
        $this->app->make('Globesol\globeadmin\Controllers\MenuController');
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            $this->app->make('Dwij\Laeditor\Controllers\CodeEditorController');
        }
        
        /*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */
        
        // LAForm Input Maker
        app('view')->getEngineResolver()->resolve('blade')->getCompiler()->directive('la_input', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::input$expression; ?>";
        });
        
        // LAForm Form Maker
        Blade::directive('la_formAjax', function ($expression) {
                $expression = "(" . $expression . ")";
            return "<?php echo LAFormMaker::formAjax$expression; ?>";
        });

        // LAForm load Dta
        Blade::directive('la_loadData', function ($expression) {
            $expression = "(" . $expression . ")";
            return "<?php echo LAFormMaker::loadData$expression; ?>";
        });



        // LAForm Form Maker
        Blade::directive('la_formData', function ($expression) {
            $expression = "(" . $expression . ")";
            return "<?php echo LAFormMaker::formData$expression; ?>";
        });


        // LAForm Form Maker
        Blade::directive('la_form', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::form$expression; ?>";
        });
        
        // LAForm Maker - Display Values
        Blade::directive('la_display', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo LAFormMaker::display$expression; ?>";
        });
        
        // LAForm Maker - Check Whether User has Module Access
        Blade::directive('la_access', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(LAFormMaker::la_access$expression) { ?>";
        });
        Blade::directive('endla_access', function ($expression) {
            return "<?php } ?>";
        });
        
        // LAForm Maker - Check Whether User has Module Field Access
        Blade::directive('la_field_access', function ($expression) {
            if(LAHelper::laravel_ver() >= 5.4) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(LAFormMaker::la_field_access$expression) { ?>";
        });
        Blade::directive('endla_field_access', function ($expression) {
            return "<?php } ?>";
        });
        
        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */
        
        $commands = [
            \Globesol\globeadmin\Commands\Migration::class,
            \Globesol\globeadmin\Commands\Crud::class,
            \Globesol\globeadmin\Commands\Packaging::class,
            \Globesol\globeadmin\Commands\LAInstall::class
        ];
        
        // For LAEditor
        if(file_exists(__DIR__ . '/../../laeditor')) {
            $commands[] = \Dwij\Laeditor\Commands\LAEditor::class;
        }
        
        $this->commands($commands);
    }
}
