<?php

use Agenciamav\LaravelIfood\Http\Controllers\LaravelIfood;
use Agenciamav\LaravelIfood\Http\Controllers\Merchant\Merchant;
use Agenciamav\LaravelIfood\Http\Controllers\Merchant\Status;
use Agenciamav\LaravelIfood\Http\Controllers\Merchant\Interruption;
use Agenciamav\LaravelIfood\Http\Controllers\Catalog\Catalog;
use Agenciamav\LaravelIfood\Http\Controllers\Catalog\Category;
use Agenciamav\LaravelIfood\Http\Controllers\Order\Events;
use Illuminate\Support\Facades\Route;

Route::prefix('/api/ifood')->group(function () {
    Route::get('/', [Merchant::class, 'getAllMerchants'])->name('ifood.merchant.index');

    Route::prefix('/{merchantId}')->group(function () {
        Route::get('/', [Merchant::class, 'getMerchant'])->name('ifood.merchant.show');
        Route::get('/status', [Status::class, 'getAllStatusDetails'])->name('ifood.status.index');
        Route::get('/status/{operation}', [Status::class, 'getStatusDetails'])->name('ifood.status.show');
        
        Route::get('/catalogs', [Catalog::class, 'getCatalogs'])->name('ifood.catalogs.index');
        Route::get('/catalogs/{catalogId}', [Catalog::class, 'fetchChangelog'])->name('ifood.catalogs.changelog');
        Route::get('/catalogs/{catalogId}/changelog', [Catalog::class, 'fetchChangelog'])->name('ifood.catalogs.changelog');
        Route::get('/catalogs/{catalogId}/unsellableItems', [Catalog::class, 'listUnsellableItems'])->name('ifood.catalogs.unsellableItems');
        Route::get('/catalogs/{catalogId}/categories', [Category::class, 'getAllCategories'])->name('ifood.categories.index');
        Route::post('/catalogs/{catalogId}/categories', [Category::class, 'createCategory'])->name('ifood.categories.create');
        Route::get('/catalogs/{catalogId}/categories/{categoryId}', [Category::class, 'getCategory'])->name('ifood.categories.show');
    
        Route::get('/interruptions', [Interruption::class, 'getInterruption'])->name('ifood.interruptions.show');
        Route::post('/interruptions', [Interruption::class, 'postInterruption'])->name('ifood.interruptions.store');
        Route::delete('/interruptions/{interruptionId}', [Interruption::class, 'deleteInterruption'])->name('ifood.interruptions.delete');
    });
});
