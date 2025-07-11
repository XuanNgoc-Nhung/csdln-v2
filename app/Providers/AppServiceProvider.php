<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $redirect = config('app.redirect_https');
        if($redirect)
        {
            //$url->forceSchema('https');
            \URL::forceScheme('https');
        }

        view()->composer('*', function ($view)
        {
            $view->with('lch', $this->getListCapHoc() );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
    public function getListCapHoc(){
        return json_encode(Session::get('listCapHoc',[]),JSON_UNESCAPED_UNICODE );
    }
}
