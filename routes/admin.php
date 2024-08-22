<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OptionSetController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\AppDownloadController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReservationTimeController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\AdminManagementController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    /** Profile Routes */
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /** Slider Routes */
    Route::resource('slider', SliderController::class);

    /** Daily Offer Routes */
    Route::get('daily-offer/search-product', [DailyOfferController::class, 'searchProduct'])->name('daily-offer.search-product');
    Route::put('daily-offer-title-update', [DailyOfferController::class, 'updateTitle'])->name('daily-offer-title-update');
    Route::resource('daily-offer', DailyOfferController::class);

    /** Why choose us Routes */
    Route::put('why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title.update');
    Route::resource('why-choose-us', WhyChooseUsController::class);

    /** Banner Routes */
    Route::resource('banner', BannerController::class);

    /** Category Routes */
    Route::resource('category', CategoryController::class);

    /** Product Routes */
    Route::resource('product', ProductController::class);

    /** Product Gallery Routes */
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
    Route::resource('product-gallery', ProductGalleryController::class);

    /** Product Options Routes */
    Route::resource('option', OptionController::class);

    /** Product Options Set Routes */
    Route::get('option-set/{option}', [OptionSetController::class, 'index'])->name('option-set.show-index');
    Route::resource('option-set', OptionSetController::class);

    /** Product Reviews Routes */
    Route::get('product-reviews', [ProductReviewController::class, 'index'])->name('product-reviews.index');
    Route::post('product-reviews', [ProductReviewController::class, 'updateStatus'])->name('product-reviews.update');
    Route::delete('product-reviews/{id}', [ProductReviewController::class, 'destroy'])->name('product-reviews.destroy');

    /** Setting Routes */
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
    Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
    Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
    Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
    Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
    Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');

    /** Coupons Routes */
    Route::resource('coupon', CouponController::class);

    /** Delivery Routes */
    Route::resource('delivery', DeliveryController::class);

    /** Admin management Routes */
    Route::resource('admin-management', AdminManagementController::class);

    /** Payment Gateway Setting Routes */
    Route::get('/payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
    Route::put('/paypal-setting', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal-setting.update');
    Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');
    Route::put('/razorpay-setting', [PaymentGatewaySettingController::class, 'razorpaySettingUpdate'])->name('razorpay-setting.update');

    /** Orders Routes */
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('pending-orders', [OrderController::class, 'pendingOrderIndex'])->name('pending-orders');
    Route::get('inprocess-orders', [OrderController::class, 'inProcessOrderIndex'])->name('inprocess-orders');
    Route::get('delivered-orders', [OrderController::class, 'deliveredOrderIndex'])->name('delivered-orders');
    Route::get('declined-orders', [OrderController::class, 'declinedOrderIndex'])->name('declined-orders');

    Route::get('orders/status/{id}', [OrderController::class, 'getOrderStatus'])->name('orders.status');
    Route::put('orders/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('orders.status-update');

    /** Order Notification Routes */
    Route::get('clear-notification',[AdminDashboardController::class, 'clearNotification'])->name('clear-notification');

    /** Chat Routes */
    Route::get('chat',[ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/get-conversation/{senderId}',[ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

    /** Chef Routes */
    Route::put('chefs-title-update', [ChefController::class, 'updateTitle'])->name('chefs-title-update');
    Route::resource('chefs', ChefController::class);

    /** App Download Routes */
    Route::get('app-download', [AppDownloadController::class, 'index'])->name('app-download.index');
    Route::post('app-download', [AppDownloadController::class, 'store'])->name('app-download.store');

    /** Feedback Routes */
    Route::put('feedbacks-title-update', [FeedbackController::class, 'updateTitle'])->name('feedbacks-title-update');
    Route::resource('feedbacks', FeedbackController::class);

    /** Counter Routes */
    Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
    Route::put('counter', [CounterController::class, 'update'])->name('counter.update');

    /** Blogs Category Routes */
    Route::resource('blog-category', BlogCategoryController::class);

    /** Blogs Routes */
    Route::get('blog/comments', [BlogController::class, 'blogComment'])->name('blog.comments.index');
    Route::get('blog/comments/{id}', [BlogController::class, 'commentStatusUpdate'])->name('blog.comments.update');
    Route::delete('blog/comments/{id}', [BlogController::class, 'commentDestroy'])->name('blog.comments.destroy');

    Route::resource('blog', BlogController::class);

    /** About Routes */
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');

    /** privacy policy Routes */
    Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::put('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

    /** Contact Routes */
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [ContactController::class, 'update'])->name('contact.update');

    /** Reservation Routes */
    Route::resource('reservation-time', ReservationTimeController::class);
    Route::get('reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::post('reservation', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    /** Subscribe Routes */
    Route::get('subscribe', [SubscribeController::class, 'index'])->name('subscribe.index');
    Route::post('subscribe', [SubscribeController::class, 'sendEmail'])->name('subscribe.send');

    /** Social Links Routes */
    Route::resource('social-link', SocialLinkController::class);

    /** Menu builder Routes */
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');

});
