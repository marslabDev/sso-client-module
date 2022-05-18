<?php

namespace Modules\SsoClient\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PurgeOldAuthFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'ssoclient:purge_old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up original old Auth files.';

    private $not_found_error_msg = 'The file or directory might be DELETED or MOVED to other directory. In this case you might to delete it manually.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('START PURGING');
        $this->newLine();


        $models_path = app_path('Models');
        $user_model = $models_path . '/User.php';
        $role_model = $models_path . '/Role.php';
        $permission_model = $models_path . '/Permission.php';
        $models_to_delete = [
            $user_model,
            $role_model,
            $permission_model,
        ];
        foreach ($models_to_delete as $model) {
            if (file_exists($model)) {
                unlink($model);
                $this->info('Deleted Model: ' . $model);
                $this->newLine();
            } else {
                $this->warn('Model Not Found: ' . $model);
                $this->error($this->not_found_error_msg);
                $this->newLine();
            }
        }

        $this->newLine();

        $controllers_path = app_path('Http/Controllers');
        $user_verification_controller = $controllers_path . '/UserVerificationController.php';
        $permission_controller = $controllers_path . '/Admin' . '/PermissionsController.php';
        $roles_controller = $controllers_path . '/Admin' . '/RolesController.php';
        $user_alerts_controller = $controllers_path . '/Admin' . '/UserAlertsController.php';
        $users_controller = $controllers_path . '/Admin' . '/UsersController.php';
        $controllers_to_delete = [
            $user_verification_controller,
            $permission_controller,
            $roles_controller,
            $user_alerts_controller,
            $users_controller,
        ];
        foreach ($controllers_to_delete as $controller) {
            if (file_exists($controller)) {
                unlink($controller);
                $this->info('Deleted Controller: ' . $controller);
                $this->newLine();
            } else {
                $this->warn('Controller Not Found: ' . $controller);
                $this->error($this->not_found_error_msg);
                $this->newLine();
            }
        }

        $this->newLine();

        $auth_controllers_dir = $controllers_path . '/Auth';
        $this->removeDirectory($auth_controllers_dir, 'Auth Controller');

        $this->newLine();

        $middleware_path = app_path('Http/Middleware');
        $auth_gates = $middleware_path . '/AuthGates.php';
        $approval = $middleware_path . '/ApprovalMiddleware.php';
        $two_factor = $middleware_path . '/TwoFactorMiddleware.php';
        $verification = $middleware_path . '/VerificationMiddleware.php';
        $middleware_to_delete = [
            $auth_gates,
            $approval,
            $two_factor,
            $verification,
        ];
        foreach ($middleware_to_delete  as $middleware) {
            if (file_exists($middleware)) {
                unlink($middleware);
                $this->info('Deleted Middleware: ' . $middleware);
                $this->newLine();
            } else {
                $this->warn('Middleware Not Found: ' . $middleware);
                $this->error($this->not_found_error_msg);
                $this->newLine();
            }
        }

        $this->newLine();

        $requests_path = app_path('Http/Requests');
        $check_two_factor = $requests_path . '/CheckTwoFactorRequest.php';
        $mass_destroy_permission = $requests_path . '/MassDestroyPermissionRequest.php';
        $mass_destroy_role = $requests_path . '/MassDestroyRoleRequest.php';
        $mass_destroy_user_alert = $requests_path . '/MassDestroyUserAlertRequest.php';
        $mass_destroy_user = $requests_path . '/MassDestroyUserRequest.php';
        $update_permission = $requests_path . '/UpdatePermissionRequest.php';
        $update_role = $requests_path . '/UpdateRoleRequest.php';
        $update_user_alert = $requests_path . '/UpdateUserAlertRequest.php';
        $update_user = $requests_path . '/UpdateUserRequest.php';
        $store_permission = $requests_path . '/StorePermissionRequest.php';
        $store_role = $requests_path . '/StoreRoleRequest.php';
        $store_user_alert = $requests_path . '/StoreUserAlertRequest.php';
        $store_user = $requests_path . '/StoreUserRequest.php';
        $requests_to_delete = [
            $check_two_factor,
            $mass_destroy_permission,
            $mass_destroy_role,
            $mass_destroy_user,
            $mass_destroy_user_alert,
            $update_permission,
            $update_role,
            $update_user,
            $update_user_alert,
            $store_permission,
            $store_role,
            $store_user,
            $store_user_alert,
        ];
        foreach ($requests_to_delete as $request) {
            if (file_exists($request)) {
                unlink($request);
                $this->info('Deleted Request: ' . $request);
                $this->newLine();
            } else {
                $this->warn('Request Not Found: ' . $request);
                $this->error($this->not_found_error_msg);
                $this->newLine();
            }
        }

        $this->newLine();

        $views_path = resource_path('views');
        $auth_views_dir = $views_path . '/auth';
        $this->removeDirectory($auth_views_dir, 'Auth View');

        $perrmissions_view_dir = $views_path . '/admin/permissions';
        $this->removeDirectory($perrmissions_view_dir, 'Permissions View');

        $roles_view_dir = $views_path . '/admin/roles';
        $this->removeDirectory($roles_view_dir, 'Roles View');

        $users_view_dir = $views_path . '/admin/users';
        $this->removeDirectory($users_view_dir, 'Users View');

        $user_alerts_view_dir = $views_path . '/admin/userAlerts';
        $this->removeDirectory($user_alerts_view_dir, 'User Alerts View');

        $this->newLine();

        $this->info('Running Migration to drop all Auth Tables');
        Artisan::call('module:migrate-refresh SsoClient');
        $this->warn('Dropped Auth Tables');

        $this->newLine();

        $this->info('END');
    }

    private function removeDirectory(String $dir, String $target_name = '')
    {
        if (file_exists($dir) && is_dir($dir)) {
            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir . '/' . $object) == 'dir') {
                        $this->removeDirectory($dir . '/' . $object, $object);
                    } else {
                        unlink($dir . '/' . $object);
                        $this->info('Deleted ' . $target_name . ': ' . $dir . '/' . $object);
                        $this->newLine();
                    }
                }
            }

            reset($objects);
            rmdir($dir);
            $this->info('Deleted ' . $target_name . ' Directory: ' . $dir);
            $this->newLine();
        } else {
            $this->warn($target_name . ' Directory Not Found: ' . $dir);
            $this->error($this->not_found_error_msg);
            $this->newLine();
        }
    }
}
