<?php

use App\Http\Controllers\Admin\BranchController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;


//Route::get('dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('home');


Route::group(['middleware' => ['admin', 'setLocalization'], 'prefix' => 'admin'], function (){

    /** Logout */
    Route::match(['get', 'post'], '/logout', [App\Http\Controllers\Admin\HomeController::class, 'logout'] )->name('logout');

    /** Home */
    Route::get('dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'dashboard'])->name('home');
    Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index'])->name('lang');


    Route::post('easySaleItem/update', [\App\Http\Controllers\Admin\EasySaleItemController::class, 'easySaleUpdate'])->name('easySaleItem.update');

    Route::post('sale/addCartSaleItem', [App\Http\Controllers\Admin\SaleController::class, 'addCartSaleItem'] )->name('sale.addCartSaleItem');

    Route::post('sale/addCartSaleItemBarcode', [App\Http\Controllers\Admin\SaleController::class, 'addCartSaleItemBarcode'] )->name('sale.addCartSaleItemBarcode');
    Route::post('sale/addCartOtherSaleItem', [App\Http\Controllers\Admin\SaleController::class, 'addCartOtherSaleItem'] )->name('sale.addCartOtherSaleItem');
    Route::post('sale/removeCartSaleItem', [App\Http\Controllers\Admin\SaleController::class, 'removeCartSaleItem'] )->name('sale.removeCartSaleItem');
    Route::post('sale/deleteAllCartSaleItem', [App\Http\Controllers\Admin\SaleController::class, 'deleteAllCartSaleItem'] )->name('sale.deleteAllCartSaleItem');
    Route::post('sale/updateCartSaleItemName', [App\Http\Controllers\Admin\SaleController::class, 'updateCartSaleItemName'] )->name('sale.updateCartSaleItemName');
    Route::post('sale/updateCartSaleItemPrice', [App\Http\Controllers\Admin\SaleController::class, 'updateCartSaleItemPrice'] )->name('sale.updateCartSaleItemPrice');
    Route::post('sale/updateCartSaleItemQuantity', [App\Http\Controllers\Admin\SaleController::class, 'updateCartSaleItemQuantity'] )->name('sale.updateCartSaleItemQuantity');
    Route::post('sale/updateCartSaleItemAmount', [App\Http\Controllers\Admin\SaleController::class, 'updateCartSaleItemAmount'] )->name('sale.updateCartSaleItemAmount');
    Route::post('sale/store', [App\Http\Controllers\Admin\SaleController::class, 'store'] )->name('sale.store');
    Route::get('sale/{sale}/salePrint/{type?}', [App\Http\Controllers\Admin\SaleController::class, 'salePrint'] )->name('sale.salePrint');
    Route::post('sale/printPreview', [App\Http\Controllers\Admin\SaleController::class, 'printPreview'] )->name('sale.printPreview');
    Route::post('sale/printPreviewPrint', [App\Http\Controllers\Admin\SaleController::class, 'printPreviewPrint'] )->name('sale.printPreviewPrint');
    Route::post('sale/searchBill', [App\Http\Controllers\Admin\SaleController::class, 'searchBill'] )->name('sale.searchBill');

    Route::get('sale/{sale}/view', [App\Http\Controllers\Admin\SaleController::class, 'view'] )->name('sale.view');

    Route::post('sale/{sale}/returnSale', [App\Http\Controllers\Admin\SaleReturnController::class, 'returnSale'] )->name('sale.returnSale');
    Route::post('sale/{sale}/returnSaleConfirm', [App\Http\Controllers\Admin\SaleReturnController::class, 'returnSaleConfirm'] )->name('sale.returnSaleConfirm');

    Route::get('sale/list', [App\Http\Controllers\Admin\SaleController::class, 'list'] )->name('sale.list');
    Route::get('sale/getList', [App\Http\Controllers\Admin\SaleController::class, 'getList'] )->name('sale.getList');
    Route::post('sale/printAll', [App\Http\Controllers\Admin\SaleController::class, 'printAll'] )->name('sale.printAll');



    /** Application/Global Theme Setting */
    Route::resource('application', App\Http\Controllers\Admin\ApplicationController::class);
 
    // branch 
    Route::get('branch', [BranchController::class, 'index'])->name('branches.index');
    Route::get('branch/getdata', [BranchController::class, 'getdata'])->name('branches.getdata');
    Route::post('branch/store', [BranchController::class, 'store'])->name('branches.store');
    Route::delete('branch/distroy/{id}', [BranchController::class, 'distroy'])->name('branches.distroy');
    Route::get('branch/edit/{id}', [BranchController::class, 'edit'])->name('branches.edit');
    Route::put('branch/update/{id}', [BranchController::class, 'update'])->name('branches.update');

    Route::post('branch/updateStatus', [BranchController::class, 'updateStatus'] )->name('branches.updateStatus');

    /** Admin User */
    Route::get('admin/getAdmins', [App\Http\Controllers\Admin\AdminController::class, 'getAdmins'] )->name('admin.getAdmins');
    Route::post('admin/updateStatus', [App\Http\Controllers\Admin\AdminController::class, 'updateStatus'] )->name('admin.updateStatus');
    Route::delete('admin/delete', [App\Http\Controllers\Admin\AdminController::class, 'delete'] )->name('admin.delete');
    Route::resource('admin', App\Http\Controllers\Admin\AdminController::class);

    /** Role */
    Route::get('role/getRoles', [App\Http\Controllers\Admin\RoleController::class, 'getRoles'] )->name('role.getRoles');
    Route::post('role/updateStatus', [App\Http\Controllers\Admin\RoleController::class, 'updateStatus'] )->name('role.updateStatus');
    Route::delete('role/delete', [App\Http\Controllers\Admin\RoleController::class, 'delete'] )->name('role.delete');
    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);


    /** Role */
    Route::get('item/getItems', [App\Http\Controllers\Admin\ItemController::class, 'getItems'] )->name('item.getItems');
    Route::post('item/updateStatus', [App\Http\Controllers\Admin\ItemController::class, 'updateStatus'] )->name('item.updateStatus');
    Route::delete('item/delete', [App\Http\Controllers\Admin\ItemController::class, 'delete'] )->name('item.delete');
    Route::resource('item', App\Http\Controllers\Admin\ItemController::class);
    Route::get('item/barcode-print/{id}', [App\Http\Controllers\Admin\ItemController::class, 'barcode'] )->name('item.barcode-print');

    /** Customer  */
    Route::get('shop/getCustomers', [App\Http\Controllers\Admin\CustomerController::class, 'getCustomers'] )->name('customer.getCustomers');
    Route::post('customer/updateStatus', [App\Http\Controllers\Admin\CustomerController::class, 'updateStatus'] )->name('customer.updateStatus');
    Route::delete('customer/delete', [App\Http\Controllers\Admin\CustomerController::class, 'delete'] )->name('customer.delete');
    Route::resource('customer', App\Http\Controllers\Admin\CustomerController::class);


    Route::get('supplier/getSuppliers', [App\Http\Controllers\Admin\SupplierController::class, 'getSuppliers'] )->name('supplier.getSuppliers');
    Route::post('supplier/updateStatus', [App\Http\Controllers\Admin\SupplierController::class, 'updateStatus'] )->name('supplier.updateStatus');
    Route::delete('supplier/delete', [App\Http\Controllers\Admin\SupplierController::class, 'delete'] )->name('supplier.delete');
    Route::resource('supplier', App\Http\Controllers\Admin\SupplierController::class);




    Route::get('purchase/getPurchases', [App\Http\Controllers\Admin\PurchaseController::class, 'getPurchases'] )->name('purchase.getPurchases');
    Route::delete('purchase/delete', [App\Http\Controllers\Admin\PurchaseController::class, 'delete'] )->name('purchase.delete');
    Route::post('purchase/returnPurchaseItem', [App\Http\Controllers\Admin\PurchaseController::class, 'returnPurchaseItem'] )->name('purchase.returnPurchaseItem');
    Route::post('purchase/purchaseItemAddCart', [App\Http\Controllers\Admin\PurchaseController::class, 'purchaseItemAddCart'] )->name('purchase.purchaseItemAddCart');
    Route::post('purchase/purchaseItemDeleteCart', [App\Http\Controllers\Admin\PurchaseController::class, 'purchaseItemDeleteCart'] )->name('purchase.purchaseItemDeleteCart');
    Route::post('purchase/purchaseItemQtyUpdateCart', [App\Http\Controllers\Admin\PurchaseController::class, 'purchaseItemQtyUpdateCart'] )->name('purchase.purchaseItemQtyUpdateCart');
    Route::post('purchase/purchaseItemPriceUpdateCart', [App\Http\Controllers\Admin\PurchaseController::class, 'purchaseItemPriceUpdateCart'] )->name('purchase.purchaseItemPriceUpdateCart');

    Route::get('purchase/purchaseList', [App\Http\Controllers\Admin\PurchaseController::class, 'purchaseList'] )->name('purchase.purchaseList');
    Route::get('purchase/getPurchaseList', [App\Http\Controllers\Admin\PurchaseController::class, 'getPurchaseList'] )->name('purchase.getPurchaseList');

    Route::resource('purchase', App\Http\Controllers\Admin\PurchaseController::class);



    Route::get('stockItem', [App\Http\Controllers\Admin\StockItemController::class, 'index'] )->name('stockItem.index');
    Route::get('stockItem/getStockItem', [App\Http\Controllers\Admin\StockItemController::class, 'getStockItem'] )->name('stockItem.getStockItem');
    Route::post('stockItem/printAll', [App\Http\Controllers\Admin\StockItemController::class, 'printAll'] )->name('stockItem.printAll');

    //Expense Head
    Route::resource('expense-head', App\Http\Controllers\Admin\ExpenseHeadController::class);
    Route::resource('expense', App\Http\Controllers\Admin\ExpenseController::class);
    Route::get('expensegetList', [App\Http\Controllers\Admin\ExpenseController::class, 'expenseGetList'] )->name('expense.getList');
    Route::post('expense/print', [App\Http\Controllers\Admin\ExpenseController::class, 'expensePrint'] )->name('expense.print');
    Route::resource('buy-product-entry', App\Http\Controllers\Admin\BuyProductController::class);
    Route::get('buy-product/getBuyProductList', [App\Http\Controllers\Admin\BuyProductController::class, 'getBuyProductList'] )->name('buy-product.getList');
    Route::get('buy-product/print/{id}', [App\Http\Controllers\Admin\BuyProductController::class, 'buyproductPrint'] )->name('buyproduct.Print');
    Route::post('buy_product/print/', [App\Http\Controllers\Admin\BuyProductController::class, 'buy_product_print'] )->name('buy-product.print');


});
