<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        View::composer('pages.*', function ($view) {
            if (Auth::check()) {
                $view->with('authUser', Auth::user());
            }
        });

        Gate::define('user', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->user_view : 0;
            $auth = $action == 'add' ? $user->privilege->user_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->user_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->user_delete : $auth;

            return $auth;
        });

        Gate::define('supplier', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->supplier_view : 0;
            $auth = $action == 'add' ? $user->privilege->supplier_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->supplier_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->supplier_delete : $auth;

            return $auth;
        });

        Gate::define('delivery', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->delivery_view : 0;
            $auth = $action == 'add' ? $user->privilege->delivery_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->delivery_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->delivery_delete : $auth;
            $auth = $action == 'item' ? $user->privilege->delivery_item : $auth;

            return $auth;
        });

        Gate::define('item', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->item_view : 0;
            $auth = $action == 'add' ? $user->privilege->item_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->item_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->item_delete : $auth;
            $auth = $action == 'item' ? $user->privilege->delivery_item : $auth;
            $auth = $action == 'print' ? $user->privilege->item_print : $auth;

            return $auth;
        });

        Gate::define('ptr', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->ptr_view : 0;
            $auth = $action == 'add' ? $user->privilege->ptr_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->ptr_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->ptr_delete : $auth;
            $auth = $action == 'print' ? $user->privilege->ptr_print : $auth;

            return $auth;
        });

        Gate::define('article', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->article_view : 0;
            $auth = $action == 'add' ? $user->privilege->article_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->article_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->article_delete : $auth;

            return $auth;
        });

        Gate::define('category', function(User $user, string $action) {

            $auth = $action == 'view' ? $user->privilege->category_view : 0;
            $auth = $action == 'add' ? $user->privilege->category_add : $auth;
            $auth = $action == 'edit' ? $user->privilege->category_edit : $auth;
            $auth = $action == 'delete' ? $user->privilege->category_delete : $auth;

            return $auth;
        });
    }
}
