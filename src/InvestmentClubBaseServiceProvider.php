<?php

namespace adolfbagenda\InvestmentClub;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Route;

class InvestmentClubBaseServiceProvider extends ServiceProvider
{
    /**
     * bootstrap package.
     */
    public function boot(Dispatcher $events)
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->registerRoutes();
        $this->registerResources();
        //create menu
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $settings_menu = [
                //        [
                    'text'    => 'Settings',
                    'url'     => '#',
                    'icon'    => 'fa fa-cog',
                    'submenu' => [
                        [
                            'text' => 'General Settings',
                            'url'  => '#',
                            'icon' => 'fa fa-cog',

                        ],


                    ],

            ];
            $operations_menu = [
            'text'    => 'Operations',
            'url'     => '#',
            'icon'    => 'fa fa-cube',
            'submenu' => [
                [
                    'text' => 'Members',
                    'url'  => route('investmentclub.members'),
                    'icon' => 'fa fa-users',

                ],
                [
                    'text' => 'Accounts',
                    'url'  => route('investmentclub.accounts'),
                    'icon' => 'fa fa-list',

                ],
                [
                    'text' => 'Payments',
                    'url'  => route('investmentclub.payments'),
                    'icon' => 'fa fa-list',

                ],
                [
                    'text' => 'Savings',
                    'url'  => route('investmentclub.savings'),
                    'icon' => 'fa fa-list',

                ],



            ],

            ];
            $reports_menu = [
            'text'    => 'Reports',
            'url'     => '#',
            'icon'    => 'fa fa-list',
            'submenu' => [
                    [
                        'text' => 'Saving',
                        'url'  => '#',
                        'icon' => 'fa fa-money-bill',

                    ],

                ],

            ];
            $notice_menu = [

                        'text'    => 'Notifications',
                        'url'     => '#',
                        'icon'    => 'fas fa-fw fa-flag',
                        'submenu' => [
                            [
                                'text' => 'Messages',
                                'url'  => '#',
                                'icon' => 'fas fa-fw fa-flag',

                            ],

                        ],
            //        ]

                ];
                $users_menu = [

                            'text'    => 'User and Profile',
                            'url'     => '#',
                            'icon'    => 'fas fa-fw fa-users',
                            'submenu' => [
                                [
                                    'text' => 'Profile',
                                    'url'  => '#',
                                    'icon' => 'fas fa-fw fa-address-card',

                                ],
                                [
                                    'text'    => 'Users',
                                    'url'     => '#',
                                      'icon'  => 'fa fa-users',
                                    'submenu' => [
                                      [
                                          'text' => 'User Accounts',
                                          'url'  => '#',
                                          'icon' => 'fa fa-lock',

                                      ],
                                      [
                                          'text' => 'Roles',
                                          'url'  => route('investmentclub.users.roles'),
                                          'icon' => 'fa fa-lock',

                                      ],
                                      [
                                          'text' => 'Permissions',
                                          'url'  => route('investmentclub.users.permissions'),
                                          'icon' => 'fa fa-lock',

                                      ],
                                    ],
                                ],

                            ],
                //        ]

                    ];

            $event->menu->add($settings_menu);
            $event->menu->add($operations_menu);
            $event->menu->add($reports_menu);
            $event->menu->add($notice_menu);
            $event->menu->add($users_menu);
        });
    }

    /**
     * register package.
     */
    public function register()
    {
        $this->app->register('JeroenNoten\LaravelAdminLte\AdminLteServiceProvider');
        $this->app->register('Spatie\Permission\PermissionServiceProvider');
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'investmentclub');
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/investmentclub.php' => config_path('investmentclub.php'),
        ], 'investmentclub-config');
        $this->publishes([
            __DIR__.'/../assets' => public_path('vendor/adolfbagenda'),
        ], 'investmentclub-assets');
        $this->publishes([
        __DIR__.'/../database/test_migrations/' => database_path('migrations'),
    ], 'investmentclub-migrations');
        $this->publishes([
    __DIR__.'/../database/factories/' => database_path('factories'),
], 'investmentclub-factories');
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    private function routeConfiguration()
    {
        return [
            'prefix'    => config('investmentclub.path', 'club'),
            'namespace' => 'adolfbagenda\InvestmentClub\Http\Controllers',
        ];
    }
}
