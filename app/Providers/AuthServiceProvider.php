<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Pen;
use App\Models\Team;
use App\Policies\CommentPolicy;
use App\Policies\PenPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Comment::class  => CommentPolicy::class,
        Pen::class  => PenPolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
