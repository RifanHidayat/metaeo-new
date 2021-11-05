<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPurchaseOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\EstimationController;
use App\Http\Controllers\FinanceAccountController;
use App\Http\Controllers\FinanceTransactionController;
use App\Http\Controllers\FobItemController;
use App\Http\Controllers\GoodsCategoryController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InOutTransactionController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PicPoController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseReceiveController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\PurchaseTransactionController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\v2\JobOrderController;
use App\Http\Controllers\v2\QuotationController as V2QuotationController;
use App\Http\Controllers\v2\SalesOrderController as V2SalesOrderController;
use App\Http\Controllers\WarehouseController;
use App\Models\DeliveryOrder;
use App\Models\PurchaseReturn;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/create', [UserController::class, 'create']);
        Route::get('/edit/{id}', [UserController::class, 'edit']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/action/update-account/{id}', [UserController::class, 'updateAccount']);
        Route::post('/action/update-info/{id}', [UserController::class, 'updateUserInfo']);
        Route::patch('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('/group')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::get('/create', [GroupController::class, 'create']);
        Route::get('/edit/{id}', [GroupController::class, 'edit']);
        Route::post('/', [GroupController::class, 'store']);
        Route::patch('/{id}', [GroupController::class, 'update']);
        Route::delete('/{id}', [GroupController::class, 'destroy']);
    });

    Route::prefix('/customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('/create', [CustomerController::class, 'create']);
        Route::get('/edit/{id}', [CustomerController::class, 'edit']);
        Route::get('/payment/{id}', [CustomerController::class, 'payment']);
        Route::get('/warehouse/{id}', [CustomerController::class, 'warehouse']);
        Route::get('/transaction/{id}/create', [CustomerController::class, 'createTransaction']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::patch('/{id}', [CustomerController::class, 'update']);
        Route::delete('/{id}', [CustomerController::class, 'destroy']);
    });

    Route::prefix('/supplier')->group(function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/create', [SupplierController::class, 'create']);
        Route::get('/edit/{id}', [SupplierController::class, 'edit']);
        Route::post('/', [SupplierController::class, 'store']);
        // Route::post('/', [SupplierController::class, 'kode']);
        Route::patch('/{id}', [SupplierController::class, 'update']);
        Route::delete('/{id}', [SupplierController::class, 'destroy']);
    });

    Route::prefix('/shipment')->group(function () {
        Route::get('/', [ShipmentController::class, 'index']);
        Route::get('/create', [ShipmentController::class, 'create']);
        Route::get('/edit/{id}', [ShipmentController::class, 'edit']);
        Route::post('/', [ShipmentController::class, 'store']);
        Route::patch('/{id}', [ShipmentController::class, 'update']);
        Route::delete('/{id}', [ShipmentController::class, 'destroy']);
    });

    Route::prefix('/fob-item')->group(function () {
        Route::get('/', [FobItemController::class, 'index']);
        Route::get('/create', [FobItemController::class, 'create']);
        Route::get('/edit/{id}', [FobItemController::class, 'edit']);
        Route::post('/', [FobItemController::class, 'store']);
        Route::patch('/{id}', [FobItemController::class, 'update']);
        Route::delete('/{id}', [FobItemController::class, 'destroy']);
    });

    Route::prefix('/goods')->group(function () {
        Route::get('/', [GoodsController::class, 'index']);
        Route::get('/create', [GoodsController::class, 'create']);
        Route::get('/edit/{id}', [GoodsController::class, 'edit']);
        Route::post('/', [GoodsController::class, 'store']);
        Route::patch('/{id}', [GoodsController::class, 'update']);
        Route::delete('/{id}', [GoodsController::class, 'destroy']);
    });

    Route::prefix('/goods-category')->group(function () {
        Route::get('/', [GoodsCategoryController::class, 'index']);
        Route::get('/create', [GoodsCategoryController::class, 'create']);
        Route::get('/edit/{id}', [GoodsCategoryController::class, 'edit']);
        Route::post('/', [GoodsCategoryController::class, 'store']);
        Route::patch('/{id}', [GoodsCategoryController::class, 'update']);
        Route::delete('/{id}', [GoodsCategoryController::class, 'destroy']);
    });

    Route::prefix('/purchase-order')->group(function () {
        Route::get('/', [PurchaseOrderController::class, 'index']);
        Route::get('/create', [PurchaseOrderController::class, 'create']);
        Route::get('/edit/{id}', [PurchaseOrderController::class, 'edit']);
        Route::get('/receive/{id}', [PurchaseOrderController::class, 'receive']);
        Route::get('/return/{id}', [PurchaseOrderController::class, 'return']);
        Route::post('/', [PurchaseOrderController::class, 'store']);
        Route::patch('/{id}', [PurchaseOrderController::class, 'update']);
        Route::delete('/{id}', [PurchaseOrderController::class, 'destroy']);
    });

    Route::prefix('/purchase-receive')->group(function () {
        Route::get('/', [PurchaseReceiveController::class, 'index']);
        Route::get('/create', [PurchaseReceiveController::class, 'create']);
        Route::get('/edit/{id}', [PurchaseReceiveController::class, 'edit']);
        Route::post('/', [PurchaseReceiveController::class, 'store']);
        Route::patch('/{id}', [PurchaseReceiveController::class, 'update']);
        Route::delete('/{id}', [PurchaseReceiveController::class, 'destroy']);
    });

    Route::prefix('/purchase-return')->group(function () {
        Route::get('/', [PurchaseReturnController::class, 'index']);
        Route::get('/create', [PurchaseReturnController::class, 'create']);
        Route::get('/edit/{id}', [PurchaseReturnController::class, 'edit']);
        Route::post('/', [PurchaseReturnController::class, 'store']);
        Route::patch('/{id}', [PurchaseReturnController::class, 'update']);
        Route::delete('/{id}', [PurchaseReturnController::class, 'destroy']);
    });

    Route::prefix('/purchase-transaction')->group(function () {
        Route::get('/', [PurchaseTransactionController::class, 'index']);
        Route::get('/create', [PurchaseTransactionController::class, 'create']);
        Route::get('/edit/{id}', [PurchaseTransactionController::class, 'edit']);
        Route::post('/', [PurchaseTransactionController::class, 'store']);
        Route::patch('/{id}', [PurchaseTransactionController::class, 'update']);
        Route::delete('/{id}', [PurchaseTransactionController::class, 'destroy']);
    });

    Route::prefix('/customer-purchase-order')->group(function () {
        Route::get('/', [CustomerPurchaseOrderController::class, 'index']);
        Route::get('/create', [CustomerPurchaseOrderController::class, 'create']);
        Route::get('/edit/{id}', [CustomerPurchaseOrderController::class, 'edit']);
        Route::post('/', [CustomerPurchaseOrderController::class, 'store']);
        Route::patch('/{id}', [CustomerPurchaseOrderController::class, 'update']);
        Route::delete('/{id}', [CustomerPurchaseOrderController::class, 'destroy']);
    });

    Route::prefix('/pic-po')->group(function () {
        Route::get('/', [PicPoController::class, 'index']);
        Route::get('/create', [PicPoController::class, 'create']);
        Route::get('/edit/{id}', [PicPoController::class, 'edit']);
        Route::post('/', [PicPoController::class, 'store']);
        Route::patch('/{id}', [PicPoController::class, 'update']);
        Route::delete('/{id}', [PicPoController::class, 'destroy']);
    });

    Route::prefix('/estimation')->group(function () {
        Route::get('/', [EstimationController::class, 'index']);
        Route::get('/create', [EstimationController::class, 'create']);
        Route::get('/edit/{id}', [EstimationController::class, 'edit']);
        Route::get('/print/{id}', [EstimationController::class, 'print']);
        Route::get('/duplicate/{id}', [EstimationController::class, 'duplicate']);
        Route::post('/', [EstimationController::class, 'store']);
        Route::post('/{id}', [EstimationController::class, 'update']);
        Route::delete('/{id}', [EstimationController::class, 'destroy']);
    });

    Route::prefix('/quotation')->group(function () {
        Route::get('/', [V2QuotationController::class, 'index']);
        Route::get('/create', [V2QuotationController::class, 'create']);
        Route::get('/edit/{id}', [V2QuotationController::class, 'edit']);
        Route::get('/print/{id}', [V2QuotationController::class, 'print']);
        Route::post('/', [V2QuotationController::class, 'store']);
        Route::patch('/{id}', [V2QuotationController::class, 'update']);
        Route::delete('/{id}', [V2QuotationController::class, 'destroy']);
    });

    Route::prefix('/sales-order')->group(function () {
        Route::get('/', [V2SalesOrderController::class, 'index']);
        Route::get('/create', [V2SalesOrderController::class, 'create']);
        Route::get('/edit/{id}', [V2SalesOrderController::class, 'edit']);
        Route::post('/', [V2SalesOrderController::class, 'store']);
        Route::post('/upload-file', [V2SalesOrderController::class, 'uploadFile']);
        Route::post('/{id}', [V2SalesOrderController::class, 'update']);
        Route::delete('/{id}', [V2SalesOrderController::class, 'destroy']);
    });

    Route::prefix('/spk')->group(function () {
        Route::get('/', [SpkController::class, 'index']);
        Route::get('/create', [SpkController::class, 'create']);
        Route::get('/edit/{id}', [SpkController::class, 'edit']);
        Route::get('/print/{id}', [SpkController::class, 'print']);
        Route::post('/', [SpkController::class, 'store']);
        Route::patch('/{id}', [SpkController::class, 'update']);
        Route::delete('/{id}', [SpkController::class, 'destroy']);
    });

    Route::prefix('/job-order')->group(function () {
        Route::get('/', [JobOrderController::class, 'index']);
        Route::get('/create', [JobOrderController::class, 'create']);
        Route::get('/edit/{id}', [JobOrderController::class, 'edit']);
        Route::get('/print/{id}', [JobOrderController::class, 'print']);
        Route::post('/', [JobOrderController::class, 'store']);
        Route::patch('/{id}', [JobOrderController::class, 'update']);
        Route::delete('/{id}', [JobOrderController::class, 'destroy']);
    });

    Route::prefix('/delivery-order')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'index']);
        Route::get('/create', [DeliveryOrderController::class, 'createV2']);
        Route::get('/edit/{id}', [DeliveryOrderController::class, 'edit']);
        Route::get('/print/{id}', [DeliveryOrderController::class, 'print']);
        Route::post('/', [DeliveryOrderController::class, 'storeV2']);
        Route::patch('/{id}', [DeliveryOrderController::class, 'update']);
        Route::delete('/{id}', [DeliveryOrderController::class, 'destroy']);
    });

    Route::prefix('/invoice')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::get('/create', [InvoiceController::class, 'create']);
        Route::get('/detail/{id}', [InvoiceController::class, 'show']);
        Route::get('/edit/{id}', [InvoiceController::class, 'edit']);
        Route::get('/print/{id}', [InvoiceController::class, 'print']);
        Route::get('/print-v2/{id}', [InvoiceController::class, 'printByDeliveryOrder']);
        Route::post('/', [InvoiceController::class, 'storeV2']);
        Route::patch('/{id}', [InvoiceController::class, 'update']);
        Route::delete('/{id}', [InvoiceController::class, 'destroy']);
    });

    Route::prefix('/finance/account')->group(function () {
        Route::get('/', [FinanceAccountController::class, 'index']);
        Route::get('/create', [FinanceAccountController::class, 'create']);
        Route::get('/edit/{id}', [FinanceAccountController::class, 'edit']);
        Route::get('/transaction/{id}', [FinanceAccountController::class, 'transaction']);
        Route::post('/', [FinanceAccountController::class, 'store']);
        Route::patch('/{id}', [FinanceAccountController::class, 'update']);
        Route::delete('/{id}', [FinanceAccountController::class, 'destroy']);
    });

    Route::prefix('/finance/transaction')->group(function () {
        Route::get('/', [FinanceTransactionController::class, 'index']);
        Route::get('/create', [FinanceTransactionController::class, 'create']);
        Route::get('/edit/{id}', [FinanceTransactionController::class, 'edit']);
        Route::post('/', [FinanceTransactionController::class, 'store']);
        Route::patch('/{id}', [FinanceTransactionController::class, 'update']);
        Route::delete('/{id}', [FinanceTransactionController::class, 'destroy']);
    });

    Route::prefix('/transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/create', [TransactionController::class, 'create']);
        Route::get('/detail/{id}', [TransactionController::class, 'show']);
        Route::get('/edit/{id}', [TransactionController::class, 'edit']);
        Route::get('/print/{id}', [TransactionController::class, 'print']);
        Route::post('/', [TransactionController::class, 'store']);
        Route::patch('/{id}', [TransactionController::class, 'update']);
        Route::delete('/{id}', [TransactionController::class, 'destroy']);
    });

    Route::prefix('/in-out-transaction')->group(function () {
        Route::get('/', [InOutTransactionController::class, 'index']);
        Route::get('/create', [InOutTransactionController::class, 'create']);
        Route::get('/detail/{id}', [InOutTransactionController::class, 'show']);
        Route::get('/edit/{id}', [InOutTransactionController::class, 'edit']);
        Route::post('/', [InOutTransactionController::class, 'store']);
        Route::patch('/{id}', [InOutTransactionController::class, 'update']);
        Route::delete('/{id}', [InOutTransactionController::class, 'destroy']);
    });

    Route::prefix('/warehouse')->group(function () {
        Route::get('/', [WarehouseController::class, 'index']);
        Route::get('/create', [WarehouseController::class, 'create']);
        // Route::get('/detail/{id}', [WarehouseController::class, 'show']);
        Route::get('/edit/{id}', [WarehouseController::class, 'edit']);
        Route::post('/', [WarehouseController::class, 'store']);
        Route::patch('/{id}', [WarehouseController::class, 'update']);
        Route::delete('/{id}', [WarehouseController::class, 'destroy']);
    });

    Route::prefix('/setting')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::get('/account', [SettingController::class, 'account']);
        Route::get('/company', [SettingController::class, 'company']);
        // Route::get('/create', [WarehouseController::class, 'create']);
        // Route::get('/edit/{id}', [WarehouseController::class, 'edit']);
        // Route::post('/', [WarehouseController::class, 'store']);
        // Route::patch('/{id}', [WarehouseController::class, 'update']);
        // Route::delete('/{id}', [WarehouseController::class, 'destroy']);
    });

    Route::prefix('/company')->group(function () {
        // Route::get('/', [SettingController::class, 'index']);
        // Route::get('/create', [WarehouseController::class, 'create']);
        // Route::get('/edit/{id}', [WarehouseController::class, 'edit']);
        // Route::post('/', [WarehouseController::class, 'store']);
        Route::post('/{id}', [CompanyController::class, 'update']);
        // Route::delete('/{id}', [WarehouseController::class, 'destroy']);
    });

    Route::prefix('/report')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::prefix('/estimation')->group(function () {
            Route::get('/', [ReportController::class, 'estimation']);
            Route::get('/sheet', [ReportController::class, 'estimationSheet']);
            Route::get('/pdf', [ReportController::class, 'estimationPdf']);
        });
        Route::prefix('/quotation')->group(function () {
            Route::get('/', [ReportController::class, 'quotation']);
            Route::get('/sheet', [ReportController::class, 'quotationSheet']);
            Route::get('/pdf', [ReportController::class, 'quotationPdf']);
        });
        Route::prefix('/sales-order')->group(function () {
            Route::get('/', [ReportController::class, 'salesOrder']);
            Route::get('/sheet', [ReportController::class, 'salesOrderSheet']);
            Route::get('/pdf', [ReportController::class, 'salesOrderPdf']);
        });
        Route::prefix('/spk')->group(function () {
            Route::get('/', [ReportController::class, 'spk']);
            Route::get('/sheet', [ReportController::class, 'spkSheet']);
            Route::get('/pdf', [ReportController::class, 'spkPdf']);
        });
        Route::prefix('/delivery-order')->group(function () {
            Route::get('/', [ReportController::class, 'deliveryOrder']);
            Route::get('/sheet', [ReportController::class, 'deliveryOrderSheet']);
            Route::get('/pdf', [ReportController::class, 'deliveryOrderPdf']);
        });
        Route::prefix('/invoice')->group(function () {
            Route::get('/', [ReportController::class, 'invoice']);
            Route::get('/sheet', [ReportController::class, 'invoiceSheet']);
            Route::get('/pdf', [ReportController::class, 'invoicePdf']);
        });
        Route::prefix('/transaction')->group(function () {
            Route::get('/', [ReportController::class, 'transaction']);
            Route::get('/sheet', [ReportController::class, 'transactionSheet']);
            Route::get('/pdf', [ReportController::class, 'transactionPdf']);
        });
    });
});

Route::prefix('/login')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::post('/', [AuthController::class, 'authenticate']);
    Route::get('/action/logout', [AuthController::class, 'logout']);
});

Route::prefix('/datatables')->group(function () {
    Route::prefix('/estimations')->group(function () {
        Route::get('/', [EstimationController::class, 'indexData']);
    });
    Route::prefix('/quotations')->group(function () {
        Route::get('/', [QuotationController::class, 'indexData']);
        Route::get('/estimations', [QuotationController::class, 'datatablesEstimations']);
    });
    Route::prefix('/sales-orders')->group(function () {
        Route::get('/', [SalesOrderController::class, 'indexData']);
        Route::get('/quotations', [SalesOrderController::class, 'datatablesQuotations']);
        Route::get('/quotations-unfiltered', [SalesOrderController::class, 'datatablesQuotationsUnfiltered']);
    });
    Route::prefix('/v2')->group(function () {
        Route::prefix('/sales-orders')->group(function () {
            Route::get('/', [V2SalesOrderController::class, 'indexData']);
            Route::get('/quotations', [V2SalesOrderController::class, 'datatablesQuotations']);
            Route::get('/customer-purchase-orders', [V2SalesOrderController::class, 'datatablesCustomerPurchaseOrders']);
        });
        Route::prefix('/job-orders')->group(function () {
            Route::get('/', [JobOrderController::class, 'indexData']);
            Route::get('/sales-orders', [JobOrderController::class, 'datatablesSalesOrders']);
        });
        Route::prefix('/delivery-orders')->group(function () {
            Route::get('/', [DeliveryOrderController::class, 'indexData']);
            Route::get('/sales-orders', [DeliveryOrderController::class, 'datatablesSalesOrders']);
        });
        Route::prefix('/invoices')->group(function () {
            Route::get('/', [InvoiceController::class, 'indexData']);
            Route::get('/sales-orders', [InvoiceController::class, 'datatablesSalesOrders']);
        });
        Route::prefix('/quotations')->group(function () {
            Route::get('/', [V2QuotationController::class, 'indexData']);
        });
        Route::prefix('/customer-purchase-orders')->group(function () {
            Route::get('/', [CustomerPurchaseOrderController::class, 'indexData']);
        });
    });
    Route::prefix('/spk')->group(function () {
        Route::get('/', [SpkController::class, 'indexData']);
    });
    Route::prefix('/delivery-orders')->group(function () {
        Route::get('/', [DeliveryOrderController::class, 'indexData']);
    });
    Route::prefix('/invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'indexData']);
    });
    Route::prefix('/transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'indexData']);
    });
    Route::prefix('/reports')->group(function () {
        Route::get('/estimations', [ReportController::class, 'estimationData']);
        Route::get('/quotations', [ReportController::class, 'quotationData']);
        Route::get('/sales-orders', [ReportController::class, 'salesOrderData']);
        Route::get('/spk', [ReportController::class, 'spkData']);
        Route::get('/delivery-orders', [ReportController::class, 'deliveryOrderData']);
        Route::get('/invoices', [ReportController::class, 'invoiceData']);
        Route::get('/transactions', [ReportController::class, 'transactionData']);
    });
});
