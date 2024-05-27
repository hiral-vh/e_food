<?php

namespace App\Providers;

use App\Interfaces\admin\BookTableRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\admin\LoginRepositoryInterface;
use App\Interfaces\admin\CountryRepositoryInterface;
use App\Interfaces\admin\UserRepositoryInterface;
use App\Interfaces\admin\FoodcategotyRepositoryInterface;
use App\Interfaces\admin\RecentlyvisitrestaurantRepositoryInterface;
use App\Interfaces\admin\SaveRestaurantRepositoryInterface;
use App\Interfaces\admin\CuisineRepositoryInterface;
use App\Interfaces\admin\UserbooktableRepositoryInterface;
use App\Interfaces\admin\FoodmenucategoryRepositoryInterface;
use App\Interfaces\admin\FoodmenusubcategoryRepositoryInterface;
use App\Interfaces\admin\UsercartRepositoryInterface;
use App\Interfaces\admin\OrdermasterRepositoryInterface;
use App\Interfaces\admin\OrderitemmasterRepositoryInterface;
use App\Interfaces\admin\NotificationRepositoryInterface;
use App\Interfaces\admin\MenuRepositoryInterface;
use App\Interfaces\admin\ProfileRepositoryInterface;
use App\Interfaces\admin\DeliveryPersonRepositoryInterface;
use App\Interfaces\admin\CalendarRepositoryInterface;
use App\Interfaces\admin\DiscountRepositoryInterface;
use App\Interfaces\admin\MenuCategoryRepositoryInterface;
use App\Interfaces\admin\SubcriptionRepositoryInterface;
use App\Interfaces\admin\FoodVideoRepositoryInterface;
use App\Repositories\admin\BookTableRepository;
use App\Repositories\admin\LoginRepository;
use App\Repositories\admin\CountryRepository;
use App\Repositories\admin\UserRepository;
use App\Repositories\admin\FoodcategotyRepository;
use App\Repositories\admin\RecentlyvisitrestaurantRepository;
use App\Repositories\admin\SaveRestaurantRepository;
use App\Repositories\admin\CuisineRepository;
use App\Repositories\admin\UserbooktableRepository;
use App\Repositories\admin\FoodmenusubcategoryRepository;
use App\Repositories\admin\FoodmenucategoryRepository;
use App\Repositories\admin\MenuRepository;
use App\Repositories\admin\UsercartRepository;
use App\Repositories\admin\OrdermasterRepository;
use App\Repositories\admin\OrderitemmasterRepository;
use App\Repositories\admin\NotificationRepository;
use App\Repositories\admin\ProfileRepository;
use App\Repositories\admin\DeliveryPersonRepository;
use App\Repositories\admin\CalendarRepository;
use App\Repositories\admin\DiscountRepository;
use App\Repositories\admin\MenuCategoryRepository;
use App\Repositories\admin\SubcriptionRepository;
use App\Repositories\admin\FoodVideoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoginRepositoryInterface::class, function ($app) {
            return $app->make(LoginRepository::class);
        });

        $this->app->bind(CountryRepositoryInterface::class, function ($app) {
            return $app->make(CountryRepository::class);
        });

        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            return $app->make(UserRepository::class);
        });

        $this->app->bind(FoodcategotyRepositoryInterface::class, function ($app) {
            return $app->make(FoodcategotyRepository::class);
        });

        $this->app->bind(RecentlyvisitrestaurantRepositoryInterface::class, function ($app) {
            return $app->make(RecentlyvisitrestaurantRepository::class);
        });

        $this->app->bind(SaveRestaurantRepositoryInterface::class, function ($app) {
            return $app->make(SaveRestaurantRepository::class);
        });

        $this->app->bind(CuisineRepositoryInterface::class, function ($app) {
            return $app->make(CuisineRepository::class);
        });

        $this->app->bind(BookTableRepositoryInterface::class, function ($app) {
            return $app->make(BookTableRepository::class);
        });

        $this->app->bind(UserbooktableRepositoryInterface::class, function ($app) {
            return $app->make(UserbooktableRepository::class);
        });

        $this->app->bind(FoodmenucategoryRepositoryInterface::class, function ($app) {
            return $app->make(FoodmenucategoryRepository::class);
        });

        $this->app->bind(FoodmenusubcategoryRepositoryInterface::class, function ($app) {
            return $app->make(FoodmenusubcategoryRepository::class);
        });

        $this->app->bind(MenuRepositoryInterface::class, function ($app) {
            return $app->make(MenuRepository::class);
        });

        $this->app->bind(UsercartRepositoryInterface::class, function ($app) {
            return $app->make(UsercartRepository::class);
        });

        $this->app->bind(OrdermasterRepositoryInterface::class, function ($app) {
            return $app->make(OrdermasterRepository::class);
        });

        $this->app->bind(OrderitemmasterRepositoryInterface::class, function ($app) {
            return $app->make(OrderitemmasterRepository::class);
        });

        $this->app->bind(NotificationRepositoryInterface::class, function ($app) {
            return $app->make(NotificationRepository::class);
        });

        $this->app->bind(ProfileRepositoryInterface::class, function ($app) {
            return $app->make(ProfileRepository::class);
        });

        $this->app->bind(DeliveryPersonRepositoryInterface::class, function ($app) {
            return $app->make(DeliveryPersonRepository::class);
        });

        $this->app->bind(CalendarRepositoryInterface::class, function ($app) {
            return $app->make(CalendarRepository::class);
        });

        $this->app->bind(DiscountRepositoryInterface::class, function ($app) {
            return $app->make(DiscountRepository::class);
        });

        $this->app->bind(SubcriptionRepositoryInterface::class, function ($app) {
            return $app->make(SubcriptionRepository::class);
        });

        $this->app->bind(MenuCategoryRepositoryInterface::class, function ($app) {
            return $app->make(MenuCategoryRepository::class);
        });

        $this->app->bind(FoodVideoRepositoryInterface::class, function ($app) {
            return $app->make(FoodVideoRepository::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
}
