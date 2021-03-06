<?php
use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('markdown', MarkdownController::class);
    $router->resource('member-users', MemberUsersController::class);
    $router->resource('member-coupon-template', MemberCouponTemplateController::class);
});
