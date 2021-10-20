<?php

/**
 * Created by PhpStorm.
 * User: Napster
 * Date: 6/2/2020
 * Time: 1:13 PM
 */

// Dashboard
Route::group(['prefix' => 'dashboard', 'middleware' => 'dashboard'], function () {

    Route::get('/', 'Dashboard\DashboardController@index')->name('dashboard_admin.index');
    Route::get('/user_das', 'Dashboard\DashboardController@user_das')->name('dashboard_admin.user_das');
    Route::get('/send_email', 'Dashboard\DashboardController@send_email')->name('dashboard_send_email.index');
    Route::post('/send_email_send', 'Dashboard\DashboardController@send_email_send')->name('dashboard_send_email.send');
    // Route::post('/post_data', 'Dashboard\AdvertisementotherController@post_data')->name('dashboard_advertisementother.post_data');

    //Dashboard dashboard_advertisementother
    Route::group(['prefix' => '/advertisement'], function () {
        Route::get('', 'Dashboard\AdvertisementotherController@index')->name('dashboard_advertisementother.index');
        Route::get('/add_edit/{id?}', 'Dashboard\AdvertisementotherController@add_edit')->name('dashboard_advertisementother.add_edit');
        Route::post('/post_data', 'Dashboard\AdvertisementotherController@post_data')->name('dashboard_advertisementother.post_data');
        Route::get('/view_project/{id?}', 'Dashboard\AdvertisementotherController@view_project')->name('dashboard_advertisementother.view_project');
        Route::get('/get_data_by_id', 'Dashboard\AdvertisementotherController@get_data_by_id')->name('dashboard_advertisementother.get_data_by_id');
        Route::get('/get_data_by_iddata', 'Dashboard\AdvertisementotherController@get_data_by_iddata')->name('dashboard_advertisementother.get_data_by_iddata');
        Route::get('/deleted', 'Dashboard\AdvertisementotherController@deleted')->name('dashboard_advertisementother.deleted');
        Route::post('/get_data', 'Dashboard\AdvertisementotherController@get_data')->name('dashboard_advertisementother.get_data');
        Route::get('/confirm_email', 'Dashboard\AdvertisementotherController@confirm_email')->name('dashboard_advertisementother.confirm_email');
        Route::get('/deleted_all', 'Dashboard\AdvertisementotherController@deleted_all')->name('dashboard_advertisementother.deleted_all');
    });
    //Dashboard dashboard_draws
    Route::group(['prefix' => '/draws'], function () {
        Route::get('', 'Dashboard\DrawController@index')->name('dashboard_draws.index');
        Route::get('/add_edit/{id?}', 'Dashboard\DrawController@add_edit')->name('dashboard_draws.add_edit');
        Route::post('/post_data', 'Dashboard\DrawController@post_data')->name('dashboard_draws.post_data');
        Route::get('/view_project/{id?}', 'Dashboard\DrawController@view_project')->name('dashboard_draws.view_project');
        Route::get('/get_data_by_id', 'Dashboard\DrawController@get_data_by_id')->name('dashboard_draws.get_data_by_id');
        Route::get('/get_data_by_iddata', 'Dashboard\DrawController@get_data_by_iddata')->name('dashboard_draws.get_data_by_iddata');
        Route::get('/deleted', 'Dashboard\DrawController@deleted')->name('dashboard_draws.deleted');
        Route::post('/get_data', 'Dashboard\DrawController@get_data')->name('dashboard_draws.get_data');
        Route::get('/confirm_email', 'Dashboard\DrawController@confirm_email')->name('dashboard_draws.confirm_email');
        Route::get('/deleted_all', 'Dashboard\DrawController@deleted_all')->name('dashboard_draws.deleted_all');
    });
    //Dashboard dashboard_discount
    Route::group(['prefix' => '/discount'], function () {
        Route::get('', 'Dashboard\DiscountController@index')->name('dashboard_discount.index');
        Route::get('/add_edit/{id?}', 'Dashboard\DiscountController@add_edit')->name('dashboard_discount.add_edit');
        Route::post('/post_data', 'Dashboard\DiscountController@post_data')->name('dashboard_discount.post_data');
        Route::get('/view_project/{id?}', 'Dashboard\DiscountController@view_project')->name('dashboard_discount.view_project');
        Route::get('/get_data_by_id', 'Dashboard\DiscountController@get_data_by_id')->name('dashboard_discount.get_data_by_id');
        Route::get('/deleted', 'Dashboard\DiscountController@deleted')->name('dashboard_discount.deleted');
        Route::post('/get_data', 'Dashboard\DiscountController@get_data')->name('dashboard_discount.get_data');
        Route::get('/deleted_all', 'Dashboard\DiscountController@deleted_all')->name('dashboard_discount.deleted_all');
    });
    //Dashboard dashboard_registereduser
    Route::group(['prefix' => '/register'], function () {
        Route::get('', 'Dashboard\RegisteruserController@index')->name('dashboard_registereduser.index');
        Route::get('/add_edit/{id?}', 'Dashboard\RegisteruserController@add_edit')->name('dashboard_registereduser.add_edit');
        Route::post('/post_data', 'Dashboard\RegisteruserController@post_data')->name('dashboard_registereduser.post_data');
        Route::get('/view_project/{id?}', 'Dashboard\RegisteruserController@view_project')->name('dashboard_registereduser.view_project');
        Route::get('/get_data_by_id', 'Dashboard\RegisteruserController@get_data_by_id')->name('dashboard_registereduser.get_data_by_id');
        Route::get('/deleted', 'Dashboard\RegisteruserController@deleted')->name('dashboard_registereduser.deleted');
        Route::post('/get_data', 'Dashboard\RegisteruserController@get_data')->name('dashboard_registereduser.get_data');
        Route::get('/confirm_email', 'Dashboard\RegisteruserController@confirm_email')->name('dashboard_registereduser.confirm_email');
        Route::get('/deleted_all', 'Dashboard\RegisteruserController@deleted_all')->name('dashboard_registereduser.deleted_all');
    });
    // Dashboard email_setting
    Route::group(['prefix' => '/email_setting'], function () {
        Route::get('', 'Dashboard\EmailSettingController@index')->name('dashboard_email_setting.index');
        Route::post('/post_data', 'Dashboard\EmailSettingController@post_data')->name('dashboard_email_setting.post_data');
        Route::get('/get_data_by_id', 'Dashboard\EmailSettingController@get_data_by_id')->name('dashboard_email_setting.get_data_by_id');
    });

    // Dashboard users
    Route::group(['prefix' => '/users'], function () {
        Route::get('', 'Dashboard\UsersController@index')->name('dashboard_users.index');
        Route::get('/add_edit/{id?}', 'Dashboard\UsersController@add_edit')->name('dashboard_users.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\UsersController@get_data_by_id')->name('dashboard_users.get_data_by_id');
        Route::get('/deleted', 'Dashboard\UsersController@deleted')->name('dashboard_users.deleted');
        Route::post('/get_data', 'Dashboard\UsersController@get_data')->name('dashboard_users.get_data');
        Route::post('/post_data', 'Dashboard\UsersController@post_data')->name('dashboard_users.post_data');
        Route::get('/confirm_email', 'Dashboard\UsersController@confirm_email')->name('dashboard_users.confirm_email');
        Route::get('/deleted_all', 'Dashboard\UsersController@deleted_all')->name('dashboard_users.deleted_all');
    });

    // Dashboard setting
    Route::group(['prefix' => '/setting'], function () {
        Route::get('', 'Dashboard\SettingController@index')->name('dashboard_setting.index');
        Route::post('/post_data', 'Dashboard\SettingController@post_data')->name('dashboard_setting.post_data');
        Route::get('/get_data_by_id', 'Dashboard\SettingController@get_data_by_id')->name('dashboard_setting.get_data_by_id');
    });

    // Dashboard join_us
    Route::group(['prefix' => '/join_us'], function () {
        Route::get('', 'Dashboard\JoinUSController@index')->name('dashboard_join_us.index');
        Route::post('/post_data', 'Dashboard\JoinUSController@post_data')->name('dashboard_join_us.post_data');
        Route::get('/get_data_by_id', 'Dashboard\JoinUSController@get_data_by_id')->name('dashboard_join_us.get_data_by_id');
    });

    // Dashboard video
    Route::group(['prefix' => '/video'], function () {
        Route::get('', 'Dashboard\VideoController@index')->name('dashboard_video.index');
        Route::post('/post_data', 'Dashboard\VideoController@post_data')->name('dashboard_video.post_data');
        Route::get('/get_data_by_id', 'Dashboard\VideoController@get_data_by_id')->name('dashboard_video.get_data_by_id');
    });

    // Dashboard posts
    Route::group(['prefix' => '/posts'], function () {
        Route::get('', 'Dashboard\PostsController@index')->name('dashboard_posts.index');
        Route::get('/add_edit/{id?}', 'Dashboard\PostsController@add_edit')->name('dashboard_posts.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\PostsController@get_data_by_id')->name('dashboard_posts.get_data_by_id');
        Route::get('/deleted', 'Dashboard\PostsController@deleted')->name('dashboard_posts.deleted');
        Route::get('/deleted_all', 'Dashboard\PostsController@deleted_all')->name('dashboard_posts.deleted_all');
        Route::post('/post_data', 'Dashboard\PostsController@post_data')->name('dashboard_posts.post_data');
        Route::get('/featured', 'Dashboard\PostsController@featured')->name('dashboard_posts.featured');
    });

    // Dashboard category
    Route::group(['prefix' => '/category'], function () {
        Route::get('', 'Dashboard\CategoryController@index')->name('dashboard_category.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CategoryController@add_edit')->name('dashboard_category.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CategoryController@get_data_by_id')->name('dashboard_category.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CategoryController@deleted')->name('dashboard_category.deleted');
        Route::get('/deleted_all', 'Dashboard\CategoryController@deleted_all')->name('dashboard_category.deleted_all');
        Route::post('/get_data', 'Dashboard\CategoryController@get_data')->name('dashboard_category.get_data');
        Route::post('/post_data', 'Dashboard\CategoryController@post_data')->name('dashboard_category.post_data');
        Route::get('/featured', 'Dashboard\CategoryController@featured')->name('dashboard_category.featured');
        Route::get('/trending', 'Dashboard\CategoryController@trending')->name('dashboard_category.trending');

        Route::get('/active_home', 'Dashboard\CategoryController@active_home')->name('dashboard_category.active_home');
        Route::get('/select_page', 'Dashboard\CategoryController@select_page')->name('dashboard_category.select_page');
        Route::get('/order', 'Dashboard\CategoryController@order')->name('dashboard_category.order');
    });

    // Dashboard newsletter
    Route::group(['prefix' => '/newsletter'], function () {
        Route::get('', 'Dashboard\NewsletterController@index')->name('dashboard_newsletter.index');
        Route::get('/deleted', 'Dashboard\NewsletterController@deleted')->name('dashboard_newsletter.deleted');
        Route::post('/get_data', 'Dashboard\NewsletterController@get_data')->name('dashboard_newsletter.get_data');
    });

    // Dashboard contact_us
    Route::group(['prefix' => '/contact_us'], function () {
        Route::get('', 'Dashboard\ContactUSController@index')->name('dashboard_contact_us.index');
        Route::get('/deleted', 'Dashboard\ContactUSController@deleted')->name('dashboard_contact_us.deleted');
        Route::get('/details', 'Dashboard\ContactUSController@details')->name('dashboard_contact_us.details');
        Route::post('/get_data', 'Dashboard\ContactUSController@get_data')->name('dashboard_contact_us.get_data');
    });

    // Dashboard hp_contact_us
    Route::group(['prefix' => '/hp_contact_us'], function () {
        Route::get('', 'Dashboard\HPContactUSController@index')->name('dashboard_hp_contact_us.index');
        Route::post('/post_data', 'Dashboard\HPContactUSController@post_data')->name('dashboard_hp_contact_us.post_data');
        Route::get('/get_data_by_id', 'Dashboard\HPContactUSController@get_data_by_id')->name('dashboard_hp_contact_us.get_data_by_id');
    });

    // Dashboard slider
    Route::group(['prefix' => '/slider'], function () {
        Route::get('', 'Dashboard\SliderController@index')->name('dashboard_slider.index');
        Route::get('/add_edit/{id?}', 'Dashboard\SliderController@add_edit')->name('dashboard_slider.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\SliderController@get_data_by_id')->name('dashboard_slider.get_data_by_id');
        Route::get('/deleted', 'Dashboard\SliderController@deleted')->name('dashboard_slider.deleted');
        Route::get('/deleted_all', 'Dashboard\SliderController@deleted_all')->name('dashboard_slider.deleted_all');
        Route::get('/featured', 'Dashboard\SliderController@featured')->name('dashboard_slider.featured');
        Route::post('/post_data', 'Dashboard\SliderController@post_data')->name('dashboard_slider.post_data');
    });

    // Dashboard splash
    Route::group(['prefix' => '/social_media'], function () {
        Route::get('', 'Dashboard\SMController@index')->name('dashboard_social_media.index');
        Route::get('/add_edit/{id?}', 'Dashboard\SMController@add_edit')->name('dashboard_social_media.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\SMController@get_data_by_id')->name('dashboard_social_media.get_data_by_id');
        Route::get('/deleted', 'Dashboard\SMController@deleted')->name('dashboard_social_media.deleted');
        Route::get('/deleted_all', 'Dashboard\SMController@deleted_all')->name('dashboard_social_media.deleted_all');
        Route::get('/featured', 'Dashboard\SMController@featured')->name('dashboard_social_media.featured');
        Route::post('/post_data', 'Dashboard\SMController@post_data')->name('dashboard_social_media.post_data');
    });

    // Dashboard contact_page
    Route::group(['prefix' => '/contact_page'], function () {
        Route::get('', 'Dashboard\Contact_pageController@index')->name('dashboard_contact_page.index');
        Route::post('/post_data', 'Dashboard\Contact_pageController@post_data')->name('dashboard_contact_page.post_data');
        Route::get('/get_data_by_id', 'Dashboard\Contact_pageController@get_data_by_id')->name('dashboard_contact_page.get_data_by_id');
    });

    // Dashboard users
    Route::group(['prefix' => '/city'], function () {
        Route::get('', 'Dashboard\CityController@index')->name('dashboard_city.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CityController@add_edit')->name('dashboard_city.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CityController@get_data_by_id')->name('dashboard_city.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CityController@deleted')->name('dashboard_city.deleted');
        Route::post('/get_data', 'Dashboard\CityController@get_data')->name('dashboard_city.get_data');
        Route::post('/post_data', 'Dashboard\CityController@post_data')->name('dashboard_city.post_data');
        Route::get('/confirm_email', 'Dashboard\CityController@confirm_email')->name('dashboard_city.confirm_email');
        Route::get('/deleted_all', 'Dashboard\CityController@deleted_all')->name('dashboard_city.deleted_all');
        Route::get('/priority', 'Dashboard\CityController@priority')->name('dashboard_city.priority');
    });

    // Dashboard users
    Route::group(['prefix' => '/category'], function () {
        Route::get('', 'Dashboard\CategoryController@index')->name('dashboard_category.index');
        Route::get('/add_edit/{id?}', 'Dashboard\CategoryController@add_edit')->name('dashboard_category.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CategoryController@get_data_by_id')->name('dashboard_category.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CategoryController@deleted')->name('dashboard_category.deleted');
        Route::post('/get_data', 'Dashboard\CategoryController@get_data')->name('dashboard_category.get_data');
        Route::post('/post_data', 'Dashboard\CategoryController@post_data')->name('dashboard_category.post_data');
        Route::get('/confirm_email', 'Dashboard\CategoryController@confirm_email')->name('dashboard_category.confirm_email');
        Route::get('/deleted_all', 'Dashboard\CategoryController@deleted_all')->name('dashboard_category.deleted_all');
    });
  // Dashboard restaurant
    Route::group(['prefix' => '/restaurant'], function () {
    Route::get('', 'Dashboard\RestaurantController@index')->name('dashboard_restaurant.index');
    Route::post('/export', 'Dashboard\RestaurantController@export')->name('dashboard_restaurant.export');
    Route::get('/add_edit/{id?}', 'Dashboard\RestaurantController@add_edit')->name('dashboard_restaurant.add_edit');
    Route::get('/get_data_by_id', 'Dashboard\RestaurantController@get_data_by_id')->name('dashboard_restaurant.get_data_by_id');
    Route::get('/deleted', 'Dashboard\RestaurantController@deleted')->name('dashboard_restaurant.deleted');
    Route::post('/get_data', 'Dashboard\RestaurantController@get_data')->name('dashboard_restaurant.get_data');
    Route::post('/post_data', 'Dashboard\RestaurantController@post_data')->name('dashboard_restaurant.post_data');
    Route::post('/get_restaurant_by_cat_city', 'Dashboard\RestaurantController@get_restaurant_by_cat_city')->name('dashboard_restaurant.get_by_cat_city');
    Route::post('/get_sub_cat_by_res', 'Dashboard\RestaurantController@get_sub_cat_by_res')->name('dashboard_restaurant.get_sub_cat_by_res');
    Route::post('/get_pro_cat_by_sub_res', 'Dashboard\RestaurantController@get_pro_cat_by_sub_res')->name('dashboard_restaurant.get_pro_cat_by_sub_res');
    // Route::post('/update_data', 'Dashboard\RestaurantController@update_data')->name('dashboard_restaurant.update_data');
    Route::get('/featured', 'Dashboard\RestaurantController@featured')->name('dashboard_restaurant.featured');
    Route::get('/priority', 'Dashboard\RestaurantController@priority')->name('dashboard_restaurant.priority');
    Route::get('/deleted_all', 'Dashboard\RestaurantController@deleted_all')->name('dashboard_restaurant.deleted_all');
    Route::get('test', function () {
        event(new App\Events\StatusLiked('Someone'));
            return "Event has been sent!";
        });
    });
    // Dashboard users
    Route::group(['prefix' => '/sub_category'], function () {
        Route::get('', 'Dashboard\SubCategoryController@index')->name('dashboard_sub_category.index');
        Route::get('/add_edit/{id?}', 'Dashboard\SubCategoryController@add_edit')->name('dashboard_sub_category.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\SubCategoryController@get_data_by_id')->name('dashboard_sub_category.get_data_by_id');
        Route::get('/deleted', 'Dashboard\SubCategoryController@deleted')->name('dashboard_sub_category.deleted');
        Route::post('/get_data', 'Dashboard\SubCategoryController@get_data')->name('dashboard_sub_category.get_data');
        Route::post('/post_data', 'Dashboard\SubCategoryController@post_data')->name('dashboard_sub_category.post_data');
        Route::get('/confirm_email', 'Dashboard\SubCategoryController@confirm_email')->name('dashboard_sub_category.confirm_email');
        Route::get('/deleted_all', 'Dashboard\SubCategoryController@deleted_all')->name('dashboard_sub_category.deleted_all');
        Route::get('/priority', 'Dashboard\SubCategoryController@priority')->name('dashboard_sub_category.priority');
        Route::post('/active/{id}', 'Dashboard\SubCategoryController@updateActive')->name('dashboard_sub_category.active');
    });

    // Dashboard advertisement
    // Route::group(['prefix' => '/advertisement'], function () {
    //     Route::get('', 'Dashboard\advertisementController@index')->name('dashboard_advertisement.index');
    //     Route::post('/export', 'Dashboard\advertisementController@export')->name('dashboard_advertisement.export');
    //     Route::get('/add_edit/{id?}', 'Dashboard\advertisementController@add_edit')->name('dashboard_advertisement.add_edit');
    //     Route::get('/get_data_by_id', 'Dashboard\advertisementController@get_data_by_id')->name('dashboard_advertisement.get_data_by_id');
    //     Route::get('/deleted', 'Dashboard\advertisementController@deleted')->name('dashboard_advertisement.deleted');
    //     Route::post('/get_data', 'Dashboard\advertisementController@get_data')->name('dashboard_advertisement.get_data');
    //     Route::post('/post_data', 'Dashboard\advertisementController@post_data')->name('dashboard_advertisement.post_data');
    //     Route::post('/get_advertisement_by_cat_city', 'Dashboard\advertisementController@get_advertisement_by_cat_city')->name('dashboard_advertisement.get_by_cat_city');
    //     Route::post('/get_sub_cat_by_res', 'Dashboard\advertisementController@get_sub_cat_by_res')->name('dashboard_advertisement.get_sub_cat_by_res');
    //     Route::post('/get_pro_cat_by_sub_res', 'Dashboard\advertisementController@get_pro_cat_by_sub_res')->name('dashboard_advertisement.get_pro_cat_by_sub_res');
    //     // Route::post('/update_data', 'Dashboard\advertisementController@update_data')->name('dashboard_advertisement.update_data');
    //     Route::get('/featured', 'Dashboard\advertisementController@featured')->name('dashboard_advertisement.featured');
    //     Route::get('/priority', 'Dashboard\advertisementController@priority')->name('dashboard_advertisement.priority');
    //     Route::get('/deleted_all', 'Dashboard\advertisementController@deleted_all')->name('dashboard_advertisement.deleted_all');
    //     Route::get('test', function () {
    //         event(new App\Events\StatusLiked('Someone'));
    //         return "Event has been sent!";
    //     });
    // });

    // Dashboard offers
    Route::group(['prefix' => '/offers'], function () {
        Route::get('', 'Dashboard\OffersController@index')->name('dashboard_offers.index');
        Route::get('/add_edit/{id?}', 'Dashboard\OffersController@add_edit')->name('dashboard_offers.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\OffersController@get_data_by_id')->name('dashboard_offers.get_data_by_id');
        Route::get('/deleted', 'Dashboard\OffersController@deleted')->name('dashboard_offers.deleted');
        Route::post('/get_data', 'Dashboard\OffersController@get_data')->name('dashboard_offers.get_data');
        Route::post('/post_data', 'Dashboard\OffersController@post_data')->name('dashboard_offers.post_data');
        Route::get('/featured', 'Dashboard\OffersController@featured')->name('dashboard_offers.featured');
        Route::get('/priority', 'Dashboard\OffersController@priority')->name('dashboard_offers.priority');
        Route::get('/deleted_all', 'Dashboard\OffersController@deleted_all')->name('dashboard_offers.deleted_all');
    });

    // Dashboard products
    Route::group(['prefix' => '/products'], function () {
        Route::get('', 'Dashboard\ProductsController@index')->name('dashboard_products.index');
        Route::get('/add_edit/{id?}', 'Dashboard\ProductsController@add_edit')->name('dashboard_products.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\ProductsController@get_data_by_id')->name('dashboard_products.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ProductsController@deleted')->name('dashboard_products.deleted');
        Route::post('/get_data', 'Dashboard\ProductsController@get_data')->name('dashboard_products.get_data');
        Route::post('/post_data', 'Dashboard\ProductsController@post_data')->name('dashboard_products.post_data');
        Route::get('/featured', 'Dashboard\ProductsController@featured')->name('dashboard_products.featured');
        Route::get('/deleted_all', 'Dashboard\ProductsController@deleted_all')->name('dashboard_products.deleted_all');
        Route::post('/export', 'Dashboard\ProductsController@export')->name('dashboard_products.export');
        Route::get('/priority', 'Dashboard\ProductsController@priority')->name('dashboard_products.priority');
        Route::post('/active/{id}', 'Dashboard\ProductsController@updateActive')->name('dashboard_products.active');
    });

    // Dashboard comments
    Route::group(['prefix' => '/comments'], function () {
        Route::get('', 'Dashboard\CommentsController@index')->name('dashboard_comments.index');
        Route::get('/view/{id?}', 'Dashboard\CommentsController@view')->name('dashboard_comments.view');
        Route::get('/add_edit/{id?}', 'Dashboard\CommentsController@add_edit')->name('dashboard_comments.add_edit');
        Route::get('/get_data_by_id', 'Dashboard\CommentsController@get_data_by_id')->name('dashboard_comments.get_data_by_id');
        Route::get('/deleted', 'Dashboard\CommentsController@deleted')->name('dashboard_comments.deleted');
        Route::post('/get_data', 'Dashboard\CommentsController@get_data')->name('dashboard_comments.get_data');
        Route::post('/post_data', 'Dashboard\CommentsController@post_data')->name('dashboard_comments.post_data');
        Route::get('/featured', 'Dashboard\CommentsController@featured')->name('dashboard_comments.featured');
        Route::get('/deleted_all', 'Dashboard\CommentsController@deleted_all')->name('dashboard_comments.deleted_all');
        Route::post('/export', 'Dashboard\CommentsController@export')->name('dashboard_comments.export');
    });

    // Dashboard Topproject
    Route::group(['prefix' => '/topprojects'], function () {
        Route::get('', 'Dashboard\ProjectsController@index')->name('dashboard_topprojects.index');
        Route::post('/export', 'Dashboard\ProjectsController@export')->name('dashboard_topprojects.export');
        Route::get('/add_edit/{id?}', 'Dashboard\ProjectsController@add_edit')->name('dashboard_topprojects.add_edit');
        Route::get('/view_project/{id?}', 'Dashboard\ProjectsController@view_project')->name('dashboard_topprojects.view_project');
        Route::get('/get_data_by_id', 'Dashboard\ProjectsController@get_data_by_id')->name('dashboard_topprojects.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ProjectsController@deleted')->name('dashboard_topprojects.deleted');
        Route::get('/selectdata', 'Dashboard\ProjectsController@selectdata')->name('dashboard_topprojects.selectdata');
        Route::post('/get_data', 'Dashboard\ProjectsController@get_data')->name('dashboard_topprojects.get_data');
        Route::post('/topget_data', 'Dashboard\ProjectsController@topget_data')->name('dashboard_topprojects.topget_data');
        Route::post('/post_data', 'Dashboard\ProjectsController@post_data')->name('dashboard_topprojects.post_data');
        Route::get('/confirm_email', 'Dashboard\ProjectsController@confirm_email')->name('dashboard_topprojects.confirm_email');
        Route::get('/deleted_all', 'Dashboard\ProjectsController@deleted_all')->name('dashboard_topprojects.deleted_all');
    });
    // Dashboard Projects
    Route::group(['prefix' => '/projects'], function () {
        Route::get('', 'Dashboard\ProjectsOtherController@index')->name('dashboard_otherprojects.index');
        Route::get('/add_edit/{id?}', 'Dashboard\ProjectsOtherController@add_edit')->name('dashboard_otherprojects.add_edit');
        Route::get('/view_project/{id?}', 'Dashboard\ProjectsOtherController@view_project')->name('dashboard_otherprojects.view_project');
        Route::get('/get_data_by_id', 'Dashboard\ProjectsOtherController@get_data_by_id')->name('dashboard_otherprojects.get_data_by_id');
        Route::get('/get_data_by_iddata', 'Dashboard\ProjectsOtherController@get_data_by_iddata')->name('dashboard_otherprojects.get_data_by_iddata');
        Route::get('/deleted', 'Dashboard\ProjectsOtherController@deleted')->name('dashboard_otherprojects.deleted');
        Route::post('/get_data', 'Dashboard\ProjectsOtherController@get_data')->name('dashboard_otherprojects.get_data');
        Route::post('/post_data', 'Dashboard\ProjectsOtherController@post_data')->name('dashboard_otherprojects.post_data');
        Route::post('/postdata', 'Dashboard\ProjectsOtherController@postdata')->name('dashboard_otherprojects.postadversiment');
        Route::get('/confirm_email', 'Dashboard\ProjectsOtherController@confirm_email')->name('dashboard_otherprojects.confirm_email');
        Route::get('/deleted_all', 'Dashboard\ProjectsOtherController@deleted_all')->name('dashboard_otherprojects.deleted_all');
    });
 
    // Dashboard clients
    Route::group(['prefix' => '/clients'], function () {
        Route::get('', 'Dashboard\ClientsController@index')->name('dashboard_clients.index');
        Route::post('/export', 'Dashboard\ClientsController@export')->name('dashboard_clients.export');
        Route::get('/add_edit/{id?}', 'Dashboard\ClientsController@add_edit')->name('dashboard_clients.add_edit');
        Route::get('/view_project/{id?}', 'Dashboard\ClientsController@view_project')->name('dashboard_clients.view_project');
        Route::get('/get_data_by_id', 'Dashboard\ClientsController@get_data_by_id')->name('dashboard_clients.get_data_by_id');
        Route::get('/deleted', 'Dashboard\ClientsController@deleted')->name('dashboard_clients.deleted');
        Route::post('/get_data', 'Dashboard\ClientsController@get_data')->name('dashboard_clients.get_data');
        Route::post('/post_data', 'Dashboard\ClientsController@post_data')->name('dashboard_clients.post_data');
        Route::get('/confirm_email', 'Dashboard\ClientsController@confirm_email')->name('dashboard_clients.confirm_email');
        Route::get('/deleted_all', 'Dashboard\ClientsController@deleted_all')->name('dashboard_clients.deleted_all');
    });

    // Dashboard Riders
    Route::group(['prefix' => '/riders'], function () {
        Route::get('', 'Dashboard\RidersController@index')->name('dashboard_riders.index');
        Route::post('get_data', 'Dashboard\RidersController@get_data')->name('dashboard_riders.get_data');
        Route::get('/add_edit/{id?}', 'Dashboard\RidersController@add_edit')->name('dashboard_riders.add_edit');
        Route::post('post_data', 'Dashboard\RidersController@post_data')->name('dashboard_riders.post_data');
        Route::get('/get_data_by_id', 'Dashboard\RidersController@get_data_by_id')->name('dashboard_riders.get_data_by_id');
        Route::get('/deleted', 'Dashboard\RidersController@deleted')->name('dashboard_riders.deleted');
        Route::get('/deleted_all', 'Dashboard\RidersController@deleted_all')->name('dashboard_riders.deleted_all');
    });

    // Dashboard Register your advertisement
    Route::group(['prefix' => '/ownadvertisement'], function () {
        Route::get('', 'Dashboard\UseradvertisementController@index')->name('dashboard_ownadvertisement.index');
        Route::post('get_data', 'Dashboard\UseradvertisementController@get_data')->name('dashboard_ownadvertisement.get_data');
        Route::get('/add_edit/{id?}', 'Dashboard\UseradvertisementController@add_edit')->name('dashboard_ownadvertisement.add_edit');
        Route::post('post_data', 'Dashboard\UseradvertisementController@post_data')->name('dashboard_ownadvertisement.post_data');
        Route::get('/get_data_by_id', 'Dashboard\UseradvertisementCont
        roller@get_data_by_id')->name('dashboard_ownadvertisement.get_data_by_id');
        Route::get('/deleted', 'Dashboard\UseradvertisementController@deleted')->name('dashboard_ownadvertisement.deleted');
        Route::get('/deleted_all', 'Dashboard\UseradvertisementController@deleted_all')->name('dashboard_ownadvertisement.deleted_all');
    });
});