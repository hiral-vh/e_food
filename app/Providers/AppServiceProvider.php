<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\admin\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Owner;
use Illuminate\Support\Facades\Session;
use Notification;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\TotalOrderNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    // protected $ProfileRepository = "";

    // public function __construct(ProfileRepositoryInterface $ProfileRepository)
    // {
    //     $this->ProfileRepository = $ProfileRepository;
    // }
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            if (isset(auth()->user()->id)) {
                $unreadNotification = auth()->user()->unreadNotifications->count();
                $view->with('unreadNotification', $unreadNotification);

                $notifications = auth()->user()->unreadNotifications;
                $view->with('notifications', $notifications);
            }
        });
    }
}
