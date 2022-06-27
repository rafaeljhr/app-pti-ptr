<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArmazensController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BasesController;
use App\Http\Controllers\VeiculosController;
use App\Http\Controllers\EncomendaController;

// ##############
// NAVBAR ROUTES
// ##############

Route::get('/', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('home');
})->name('home-url');

Route::get('/about', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('about');
})->name('about-url');

Route::get('/contact', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('contact');
})->name('contact-url');

Route::get('/signin', function () {
    return view('signin');
})->name('signin-url');

Route::get('/register', function () {
    return view('register');
})->name('register-url');

Route::get('/profile', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('profile');
})->name('profile-url'); 

Route::get('/checkout', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    ProductsController::distanceToStorage();
    return view('checkout');
})->name('checkout-url'); 

Route::post('/checkout-submit', [EncomendaController::class, 'registerEncomenda'])->name('submit-nova-encomenda');

Route::get('/api-documentacao', function () {
    return view('api_documentacao');
})->name('api-documentacao'); 

Route::get('/storage', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    ArmazensController::getAllArmazens();
    return view('storage');
})->name('storage');

Route::get('/inventory', function () {
    NotificationController::obter_notificacoes_do_utilizador();

    if(session()->has('all_fornecedor_produtos')){

        return view('inventory');

    } else {

        ProductsController::rebuild_fornecedor_session();
        return view('inventory'); 

    }

    
})->name('inventory');


Route::get('/prodCreate', function () {
    
    
    return view('createProduct');

    
});


Route::get('/armazemCreate', function () {
    
    
    return view('createArmazem');

    
});


Route::get('/baseCreate', function () {
    
    
    return view('createBase');

    
});


Route::get('/veiculoCreate', function () {
    
    
    return view('createVeiculo');

    
});


Route::get('/eventoLogisticoCreate', function () {
    
    
    return view('criar_evento_logistico');

    
});


Route::get('/cadeia', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    
    return view('cadeia');

    
})->name('cadeia');


Route::get('/cadeias/{id}/', [ProductsController::class, "cadeiaPage"]);

Route::get('/products', [ProductsController::class, "allProducts"])->name('products');


Route::get('/bases', function () {
    NotificationController::obter_notificacoes_do_utilizador();

    if(session()->has('bases')){

        return view('bases');

    } else {

        BasesController::rebuild_transportadora_session();
        return view('bases');

    }
})->name('bases');

Route::get('/veiculos', function () {
    NotificationController::obter_notificacoes_do_utilizador();

    if(session()->has('veiculos')){

        return view('veiculos');

    } else {

        BasesController::rebuild_transportadora_session();
        return view('veiculos');

    }
})->name('veiculos');



// ##############################################
// GOOGLE ROUTES
// ##############################################
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth/google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth/google/callback');



// ##############################################
// PRODUCTS RELATED ROUTES
// ##############################################

Route::get('/produtosEdit/{id}/', [ProductsController::class, "productInfo"]);



Route::get('/products-edit', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('informacoes_produto');
})->name('info_produto');

Route::get('/campos-extra-edit', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('alterar_cat');
})->name('campos_extra');

Route::get('/comparar-prods', function () {
    return view('compare_prods');
})->name('comparar_prods');

Route::post('/update-campos-extra', [ProductsController::class, 'alterarCamposExtras'])->name('product-edit-campos-extra');

Route::post('/compare-products', [ProductsController::class, 'compareProds'])->name('compare-products');



Route::post('/update-imagem-produto-controller', [ProductsController::class, 'changeImgProd'])->name('update-imagem-produto-controller');

Route::post('/product-warning-controller', [ProductsController::class, "deleteWarning"])->name('product-delete-warning');

Route::post('/product-add-cadeia-controller', [ProductsController::class, "cadeiaPage"])->name('product-cadeia-page');

Route::post('/product-filter', [ProductsController::class, "filterProduct"])->name('product-filter');
Route::post('/cat-filter', [ProductsController::class, "searchCat"])->name('search-cat-controller');
Route::post('/product-categories', [ProductsController::class, "changeSub"])->name('product-changeSub');

Route::post('/product-register-controller', [ProductsController::class, "productRegister"])->name('product-register-controller');

Route::post('/product-remove', [ProductsController::class, "productRemove"])->name('product-remove');
Route::post('/product-edit-controller', [ProductsController::class, "productEdit"])->name('product-edit-controller');

Route::post('/product-add-event-controller', [ProductsController::class, "productAddEvent"])->name('product-add-event-controller');
Route::post('/product-edit-event-controller', [ProductsController::class, "productEditEvent"])->name('product-edit-event-controller');


Route::post('/product-add-del-carrinho', [ProductsController::class, "productAddDelCarrinho"])->name('Add-Del-Carrinho');

Route::get('/cadeiaInfo/{id}/', [ProductsController::class, "cadeiaInfo"]);

Route::get('/produtoDetalhes/{id}/', [ProductsController::class, "prodInfo"]);

Route::get('/cadeia-edit', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('informacoes_cadeia');
})->name('cadeia_info');

Route::get('/produto-detalhes', function () {
    
    return view('produtos_detalhes');
});

Route::post('/produtosFav', [ProductsController::class, "AddDelFav"])->name('Add-Del-Fav');

Route::post('/cadeia-edit-controller', [ProductsController::class, "cadeiaEdit"])->name('cadeia-edit-controller');

Route::post('/cadeia-delete-controller', [ProductsController::class, "cadeiaDelete"])->name('cadeia-delete-controller');


Route::post('/product/filter', [ProductsController::class, "ProductFilter"])->name('ProductFilter');

Route::post('/product/SubCategoria', [ProductsController::class, "SubCategoriasHtml"])->name('HtmlSubCategoria');

// ##############################################
// ARMAZENS RELATED ROUTES
// ##############################################

Route::post('/armazem-info-controller', [ArmazensController::class, "storageInfo"])->name('storage-info');

Route::post('/armazem-warning-controller', [ArmazensController::class, "deleteWarning"])->name('armazem-delete-warning');

Route::post('/armazem-edit-controller', [ArmazensController::class, "armazemEdit"])->name('armazem-edit-controller');

Route::post('/update-imagem-armazem-controller', [ArmazensController::class, 'changeImg'])->name('update-imagem-armazem-controller');

Route::post('/armazem-register-controller', [ArmazensController::class, "armazemRegister"])->name('armazem-register-controller');
Route::post('/armazem-edit-controller', [ArmazensController::class, "armazemEdit"])->name('armazem-edit-controller');
Route::post('/armazem-delete-controller', [ArmazensController::class, "armazemDelete"])->name('armazem-delete-controller');

Route::get('/storage/{id}/', [ArmazensController::class, "storageInfo"]);



Route::get('/storage-edit', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('informacoes_armazem');
})->name('info_armazem');

// ##############################################
// BASES RELATED ROUTES
// ##############################################

Route::post('/base-register-controller', [BasesController::class, "baseRegister"])->name('base-register-controller');
Route::post('/base-edit-controller', [BasesController::class, "baseEdit"])->name('base-edit-controller');
Route::post('/base-delete-controller', [BasesController::class, "baseDelete"])->name('base-delete-controller');
Route::post('/update-imagem-base-controller', [BasesController::class, 'changeImagem'])->name('update-imagem-base-controller');

Route::get('/base/{id}/', [BasesController::class, "baseInformacoes"]);

Route::get('/base', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('informacoes_base');
})->name('base');


// ##############################################
// VEICULOS RELATED ROUTES
// ##############################################

Route::post('/veiculo-register-controller', [VeiculosController::class, "veiculoRegister"])->name('veiculo-register-controller');
Route::post('/veiculo-edit-controller', [VeiculosController::class, "veiculoEdit"])->name('veiculo-edit-controller');
Route::post('/veiculo-delete-controller', [VeiculosController::class, "veiculoDelete"])->name('veiculo-delete-controller');
Route::post('/update-imagem-veiculo-controller', [VeiculosController::class, 'changeImagem'])->name('update-imagem-veiculo-controller');

Route::get('/veiculo/{id}/', [VeiculosController::class, "veiculoInformacoes"]);

Route::get('/veiculo', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('informacoes_veiculo');
})->name('veiculo');



// ##############################################
// USERS RELATED ROUTES
// ##############################################

Route::post('/register-etapa1-controller', [UserController::class, 'register_etapa1'])->name('register-etapa1-controller');


Route::post('/register-controller', [UserController::class, 'register'])->name('register-controller');
Route::get('/logout-controller', [UserController::class, 'logout'])->name('logout-controller');
Route::post('/login-controller', [UserController::class, 'login'])->name('login-controller');
Route::post('/edit-profile-controller', [UserController::class, 'update'])->name('edit-profile-controller');
Route::post('/delete-profile-controller', [UserController::class, 'delete'])->name('delete-profile-controller');
Route::post('/update-password-controller', [UserController::class, 'changePassword'])->name('update-password-controller');
Route::post('/update-avatar-controller', [UserController::class, 'changeAvatar'])->name('update-avatar-controller');


// ##############################################
// ROUTES TO HANDLE SESSION STUFF
// ##############################################

Route::get('/forget-google-user', function () {
    session()->forget('user_email');
    session()->forget('user_path_imagem');
    session()->forget('user_nome');
    session()->forget('user_google_id');
    return "ok";
})->name('forget-google-user');


// ##############################################
// ROUTES TO HANDLE NOTIFICATIONS
// ##############################################

Route::post('/delete-notification', [NotificationController::class, 'hideNotification'])->name('delete-notification');

Route::post('/delete-all-notifications', [NotificationController::class, 'hideAllNotification'])->name('delete-all-notifications');



// ##############################################
// ROUTES TO HANDLE ENCOMENDAS
// ##############################################

Route::get('/encomendas', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    EncomendaController::atualizar_encomendas_que_ja_nao_podem_ser_canceladas();
    EncomendaController::encomendasDoUtilizador();
    return view('todas_encomendas');
})->name('encomendas');

Route::post('/cancelar-encomenda', [EncomendaController::class, 'cancelar_encomenda'])->name('cancelar-encomenda');

Route::post('/update-estado-encomenda', [EncomendaController::class, 'alterar_estado_encomenda'])->name('update-estado-encomenda');

Route::get('/encomenda/{id}/', [EncomendaController::class, "encomenda_infos"]);

Route::get('/encomenda/json/{id}/', [EncomendaController::class, "JSONdownload"]);


Route::get('/encomenda', function () {
    NotificationController::obter_notificacoes_do_utilizador();
    return view('encomenda');
})->name('encomenda');