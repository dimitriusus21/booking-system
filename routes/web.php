<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ClientController,
    OrganizationController,
    ServiceController,
    BookingController,
    NotificationController,
    ReviewController,
    AdminController
};
use App\Http\Controllers\Api\TimeSlotController as ApiTimeSlotController;

/*
|--------------------------------------------------------------------------
| Публичные маршруты
|--------------------------------------------------------------------------
*/
Route::get('/', [ClientController::class, 'index'])->name('home');
Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

// API для получения слотов (AJAX)
Route::prefix('api')->group(function () {
    Route::get('/services/{service}/slots', [ApiTimeSlotController::class, 'getAvailableSlots']);
});

/*
|--------------------------------------------------------------------------
| Аутентификация
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Личный кабинет (Защищённые маршруты)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- КЛИЕНТ ---
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::post('/bookings/{service}/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/waiting-list', [ClientController::class, 'waitingList'])->name('waiting-list');
    Route::post('/waitlist/join', [ClientController::class, 'joinWaitlist'])->name('waitlist.join');

    // Отзывы клиента
    Route::get('/my-reviews', [ReviewController::class, 'index'])->name('my-reviews');
    Route::get('/reviews/create/{booking}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/store/{booking}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // --- УВЕДОМЛЕНИЯ ---
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // --- ОРГАНИЗАЦИЯ ---
    Route::get('/organization/dashboard', [OrganizationController::class, 'dashboard'])->name('organization.dashboard');
    Route::get('/organization/profile/create', [OrganizationController::class, 'showProfileForm'])->name('organization.profile.create');
    Route::post('/organization/profile/store', [OrganizationController::class, 'storeProfile'])->name('organization.profile.store');

    // Услуги и Расписание
    Route::get('/organization/services', [OrganizationController::class, 'simpleIndex'])->name('organization.services.index');
    Route::get('/organization/services/create', [OrganizationController::class, 'simpleCreateService'])->name('organization.services.create');
    Route::post('/organization/services', [OrganizationController::class, 'simpleStoreService'])->name('organization.services.store');
    Route::get('/organization/services/{id}/edit', [OrganizationController::class, 'editService'])->name('organization.services.edit');
    Route::put('/organization/services/{id}', [OrganizationController::class, 'updateService'])->name('organization.services.update');
    Route::delete('/organization/services/{id}', [OrganizationController::class, 'destroyService'])->name('organization.services.destroy');

    Route::get('/organization/schedule/{serviceId}', [OrganizationController::class, 'scheduleIndex'])->name('organization.schedule.index');
    Route::post('/organization/schedule/{serviceId}', [OrganizationController::class, 'scheduleStore'])->name('organization.schedule.store');
    Route::delete('/organization/schedule/{serviceId}/{dayOfWeek}', [OrganizationController::class, 'scheduleDestroy'])->name('organization.schedule.destroy');

    // Управление слотами
    Route::post('/organization/generate-slots/{serviceId}', [OrganizationController::class, 'generateSlots'])->name('organization.slots.generate');
    Route::get('/organization/slots/{serviceId}', [OrganizationController::class, 'slotsIndex'])->name('organization.slots.index');
    Route::put('/organization/slots/{slotId}', [OrganizationController::class, 'updateSlot'])->name('organization.slots.update');
    Route::delete('/organization/slots/{slotId}', [OrganizationController::class, 'destroySlot'])->name('organization.slots.destroy');
    Route::delete('/organization/slots/{serviceId}/delete-day/{date}', [OrganizationController::class, 'destroyDaySlots'])->name('organization.slots.destroyDay');

    // Работа с записями и отзывы для организации
    Route::put('/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('bookings.accept');
    Route::put('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    Route::put('/bookings/{booking}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    Route::get('/organization/reviews', [OrganizationController::class, 'reviews'])->name('organization.reviews.index');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

    /*
    |--------------------------------------------------------------------------
    | Панель Администратора
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

        Route::get('/organizations', [AdminController::class, 'organizations'])->name('admin.organizations');
        Route::put('/organizations/{organization}/verify', [AdminController::class, 'verifyOrganization'])->name('admin.organizations.verify');
        Route::delete('/organizations/{organization}', [AdminController::class, 'deleteOrganization'])->name('admin.organizations.delete');

        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    });
});
