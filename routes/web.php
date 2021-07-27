<?php
use Illuminate\Support\Facades\App;
App::setLocale('es');


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ResumeController;

Auth::routes();
Route::get('/', function () { //valida si el usuario esta auth,
  if (Auth::check()) {
    if (Auth::user()->hasRoles(['1']) || Auth::user()->hasRoles(['2'])) {
        return redirect('/resumen');
    } else {
        return redirect('/pedidos');
    }
  } else {
    return redirect('login');
}
});

Route::middleware(['auth'])->group(function () {
//Rutas de inicio
  Route::get('/home', [HomeController::class, 'index'])->name('home');//Entrea a Home pagina principal
// Rutas de empleado
    Route::group(['middleware' => 'role'], function () {
      Route::get('/empleados', [UserController::class, 'index'])->name('employees.index');//llama a la vista de empleado
      Route::get('/empleados/crear', [UserController::class, 'create'])->name('employees.create');//llama a la vista de crear empleado
      Route::get('/empleados/{user}/editar', [UserController::class, 'edit'])->name('employees.edit');//llama a la vista de editar empleado
      Route::get('/empleados/{id}', [UserController::class, 'show']);//muestra info de empleado
      Route::post('/empleados/create', [UserController::class, 'store']);//crear empleado
      Route::put('/empleados/{id}/update', [UserController::class, 'update']);//aactualizar empleado
      Route::delete('/empleados/{id}/{name}/delete', [UserController::class, 'destroy']);//Eliminar empleado
//Rutas de los productos
      Route::get('/productos/crear', [ProductController::class, 'create'])->name('products.create');//llama a la vista de crear producto
      Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');//llama a la vista de editar producto
      Route::post('/productos/create', [ProductController::class, 'store']);//crear producto
      Route::put('/productos/{id}/update', [ProductController::class, 'update']);//aactualizar producto
      Route::post('/productos/saveImage', [ProductController::class, 'saveImage']);//guarda imagen del producto
      Route::post('/productos/updateImage', [ProductController::class, 'updateImage']);//actualiza la imagen del producto
      Route::delete('/productos/{id}/{name}/delete', [ProductController::class, 'destroy']);//Eliminar producto
// Rutas del calendario
      Route::get('/calendario', [CalendarController::class, 'index'])->name('calendar.index');//llama a la vista calendario
// Rutas para el resumen
      Route::get('/resumen', [ResumeController::class, 'index'])->name('resume.index');//llama a la vista resumen
      Route::get('/resumen/sales', [ResumeController::class, 'salesTable'])->name('resume.index');
    });

    Route::group(['middleware' => 'logistic'], function () {
      Route::get('/productos', [ProductController::class, 'index'])->name('products.index');//llama a la vista de productos
      Route::get('/productos/{id}', [ProductController::class, 'show']);//muestra info de los producto
    });
 // Rutas para actualizar perfil
      Route::get('/profile/{id}', [UserController::class, 'editProfile']);//Muestra modal de actualizar perfil
      Route::put('/profile/{id}/update', [UserController::class, 'updateProfile']);//actualiza perfil
      Route::post('/profile/updateImageProfile', [UserController::class, 'updateImageProfile']);//actualiza la imagen de perfil

//Rutas de pedidos
      Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');//llama a la vista de los pedidos
      Route::get('/pedidos/proceso', [OrderController::class, 'progress'])->name('orders.tables.in-progress');//vista de los pedidos en proceso
      Route::get('/pedidos/entregados', [OrderController::class, 'delivered'])->name('orders.tables.delivered');//vista de los pedidos entregados
      Route::get('/pedidos/cancelados', [OrderController::class, 'canceled'])->name('orders.tables.canceled');//vista de los pedidos cancelados
      Route::get('/pedidos/pendientes', [OrderController::class, 'pending'])->name('orders.tables.pending');//vista de los pedidos pendientes
      Route::get('/pedidos/{id}/search', [OrderController::class, 'search']);//consulta si el cliente existe y si exite rellena los campos
      Route::get('/pedidos/mostrar/{id}', [OrderController::class, 'show']);//llama a el modal de crear pedido
      Route::get('/pedidos/{id}', [OrderController::class, 'create']);//llama a el modal de crear pedido
      Route::post('/pedidos/create', [OrderController::class, 'store']);//crea un pedido nuevo
      Route::get('/pedidos/{id}/editar', [OrderController::class, 'edit'])->name('orders.edit');//crea un pedido nuevo
      Route::post('/order/saveImage', [OrderController::class, 'saveImage']);//guarda imagen del pedido
      Route::put('/pedidos/aprobados/{id}', [OrderController::class, 'passedOrder']);//Aprueba las ordenes con pago tipo deposito
      Route::put('/pedidos/proceso/{id}', [OrderController::class, 'processOrder']);//pone en proceso las ordenes con pago tipo deposito
      Route::put('/pedidos/entregados/{id}', [OrderController::class, 'deliveredOrder']);//pone en proceso las ordenes con pago tipo deposito
      Route::put('/pedidos/{id}/{note}/delete', [OrderController::class, 'destroy']);//Cancelar producto
// Rutas para filtrar ciudades y estados
      Route::get('/optionState/city/{state_code}', [CityController::class, 'allCities']);
      Route::get('/optionCountry/state/{country_code}', [StateController::class, 'allStates']);
});
