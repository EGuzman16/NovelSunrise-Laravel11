<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])
    ->name('home');

Route::get('/nosotros', function() {
    return view('about');
})
    ->name('about');

// Authentication routes.
Route::get('/iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginForm'])
    ->name('auth.login.form');
Route::post('/iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginProcess'])
    ->name('auth.login.process');
Route::post('/cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'logoutProcess'])
    ->name('auth.logout.process')
    ->middleware('auth');

Route::get('/registrarse', [\App\Http\Controllers\AuthController::class, 'registerForm'])
    ->name('auth.register.form');
Route::post('/registrarse', [\App\Http\Controllers\AuthController::class, 'registerProcess'])
    ->name('auth.register.process');

// Novels routes
Route::middleware(['auth'])->group(function () {
    Route::get('/novelas', [\App\Http\Controllers\NovelsController::class, 'index'])
        ->name('novels.index');

    Route::middleware([CheckAdmin::class])->group(function () {
        Route::get('/admin/novelas', [\App\Http\Controllers\NovelsController::class, 'panel'])
            ->name('novels.panel');
        Route::get('novelas/nueva', [\App\Http\Controllers\NovelsController::class, 'createForm'])
            ->name('novels.create.form');
        Route::post('novelas/nueva', [\App\Http\Controllers\NovelsController::class, 'createProcess'])
            ->name('novels.create.process');

        Route::get('novelas/{id}/editar', [\App\Http\Controllers\NovelsController::class, 'editForm'])
            ->name('novels.edit.form');
        Route::post('novelas/{id}/editar', [\App\Http\Controllers\NovelsController::class, 'editProcess'])
            ->name('novels.edit.process');

        Route::get('novelas/{id}/eliminar', [\App\Http\Controllers\NovelsController::class, 'deleteForm'])
            ->name('novels.delete.form');
        Route::post('novelas/{id}/eliminar', [\App\Http\Controllers\NovelsController::class, 'deleteProcess'])
            ->name('novels.delete.process');
    });

    Route::get('novelas/{id}', [\App\Http\Controllers\NovelsController::class, 'view'])
        ->name('novels.view')
        ->middleware('ageOver18')
        ->whereNumber('id');

    Route::get('novelas/{id}/verificar-edad', [\App\Http\Controllers\AgeVerificationController::class, 'ageVerificationForm'])
        ->name('novels.age-verification.form');
    Route::post('novelas/{id}/verificar-edad', [\App\Http\Controllers\AgeVerificationController::class, 'ageVerificationProcess'])
        ->name('novels.age-verification.process');
});

// Blogs routes
Route::middleware(['auth'])->group(function () {
    Route::get('/publicaciones', [\App\Http\Controllers\BlogsController::class, 'index'])
        ->name('blogs.index');

    Route::middleware([CheckAdmin::class])->group(function () {
        Route::get('/admin/publicaciones', [\App\Http\Controllers\BlogsController::class, 'panel'])
            ->name('blogs.panel');
        Route::get('publicaciones/nueva', [\App\Http\Controllers\BlogsController::class, 'createForm'])
            ->name('blogs.create.form');
        Route::post('publicaciones/nueva', [\App\Http\Controllers\BlogsController::class, 'createProcess'])
            ->name('blogs.create.process');

        Route::get('publicaciones/{id}/editar', [\App\Http\Controllers\BlogsController::class, 'editForm'])
            ->name('blogs.edit.form');
        Route::post('publicaciones/{id}/editar', [\App\Http\Controllers\BlogsController::class, 'editProcess'])
            ->name('blogs.edit.process');

        Route::get('publicaciones/{id}/eliminar', [\App\Http\Controllers\BlogsController::class, 'deleteForm'])
            ->name('blogs.delete.form');
        Route::post('publicaciones/{id}/eliminar', [\App\Http\Controllers\BlogsController::class, 'deleteProcess'])
            ->name('blogs.delete.process');
    });

    Route::get('publicaciones/{id}', [\App\Http\Controllers\BlogsController::class, 'view'])
        ->name('blogs.view')
        ->whereNumber('id');
});

// Perfil de Usuario
Route::middleware(['auth'])->group(function () {
    Route::get('perfil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('perfil', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Proceso de Pago
Route::post('/procesar-pago', [\App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/pago-exitoso', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
Route::get('/pago-fallido', [\App\Http\Controllers\PaymentController::class, 'failure'])->name('payment.failure');
Route::get('/pago-pendiente', [\App\Http\Controllers\PaymentController::class, 'pending'])->name('payment.pending');

// Carrito de Compras
Route::get('carrito', [\App\Http\Controllers\CartController::class, 'show'])
    ->name('cart.show');
Route::post('carrito/agregar', [\App\Http\Controllers\CartController::class, 'add'])
    ->name('cart.add');
Route::post('carrito/eliminar', [\App\Http\Controllers\CartController::class, 'remove'])
    ->name('cart.remove');
Route::post('carrito/vaciar', [\App\Http\Controllers\CartController::class, 'clear'])
    ->name('cart.clear');

// Mercado Pago
Route::get('test/mercadopago', [\App\Http\Controllers\MercadoPagoController::class, 'show'])
    ->name('test.mercadopago.show');
Route::get('test/mercadopago/v2', [\App\Http\Controllers\MercadoPagoController::class, 'showV2'])
    ->name('test.mercadopago.show.v2');
Route::get('test/mercadopago/success', [\App\Http\Controllers\MercadoPagoController::class, 'successProcess'])
    ->name('test.mercadopago.successProcess');
Route::get('test/mercadopago/pending', [\App\Http\Controllers\MercadoPagoController::class, 'pendingProcess'])
    ->name('test.mercadopago.pendingProcess');
Route::get('test/mercadopago/failure', [\App\Http\Controllers\MercadoPagoController::class, 'failureProcess'])
    ->name('test.mercadopago.failureProcess');

// Admin routes
Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\AdminPurchaseController::class, 'index'])->name('admin.index');
    Route::put('/admin/purchase/{id}', [\App\Http\Controllers\AdminPurchaseController::class, 'update'])->name('admin.purchase.update');

    Route::get('/admin/novelas', [\App\Http\Controllers\NovelsController::class, 'panel'])->name('novels.panel');
    Route::get('/admin/publicaciones', [\App\Http\Controllers\BlogsController::class, 'panel'])->name('blogs.panel');
    Route::get('/admin/usuarios', [\App\Http\Controllers\AuthController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/usuarios/nuevo', [\App\Http\Controllers\AuthController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/usuarios', [\App\Http\Controllers\AuthController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/usuarios/{id}/editar', [\App\Http\Controllers\AuthController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/usuarios/{id}', [\App\Http\Controllers\AuthController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/usuarios/{id}', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('admin.users.destroy');
});