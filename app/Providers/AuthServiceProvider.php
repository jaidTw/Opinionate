<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        
        $gate->define('delete-topic', function ($user, $topic) {
            return $user->id === $topic->user_id;
        });
        
        $gate->define('update-topic', function ($user, $topic) {
            return $user->id === $topic->user_id && Carbon::now('Asia/Taipei') < (Carbon::parse($topic->close_at, 'Asia/Taipei'));
        });

        $gate->define('vote', function ($user, $topic) {
            return Carbon::now('Asia/Taipei') < (Carbon::parse($topic->close_at, 'Asia/Taipei'));
        });
    }
}
