<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [ //3 bảng user, role, user_role
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        Gate::define('managers', function(User $user) {
            return in_array('admin', $user->roles()) || in_array('manager', $user->roles()) ? true : false;
        });

        Gate::define('employees', function(User $user) {
            return in_array('admin', $user->roles()) || in_array('manager', $user->roles()) || in_array('employee', $user->roles()) ? true : false;
        });

        Gate::define('product-attendances', function(User $user) {
            return in_array('admin', $user->roles()) || in_array('manager', $user->roles()) || in_array('employee', $user->roles()) || in_array('product', $user->roles()) ? true : false;
        });
    }
}
