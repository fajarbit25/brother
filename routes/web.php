<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperationalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\ToolsController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function(){
    Route::get('/', 'index')->middleware('auth')->name('home');
    Route::get('/home', 'index')->middleware('auth')->name('main');
    Route::get('/teknisi', 'teknisi')->middleware('auth')->name('dashboard.teknisi');
    Route::get('/dashboard', 'index')->middleware('auth')->name('dashboard');
    Route::get('/dashboad/table', 'table')->middleware('auth')->name('dashboard.table');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->middleware('guest')->name('login');
    Route::post('/login', 'authenticate')->middleware('guest')->name('auth');
    Route::post('/user/logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(InventoryController::class)->group(function(){
    /**Master */
    Route::get('/inventory/master', 'master')->middleware('auth')->name('inventory.master');
    Route::get('/inventory/tableSatuan', 'tableSatuan')->middleware('auth')->name('inventory.tableSatuan');
    Route::get('/inventory/tableCatergory', 'tableCatergory')->middleware('auth')->name('inventory.tableCatergory');
    Route::post('/inventory/storeSatuan', 'storeSatuan')->middleware('auth')->name('inventory.storeSatuan');
    Route::post('/inventory/storeCategory', 'storeCategory')->middleware('auth')->name('inventory.storeCategory');
    Route::post('/inventory/updateSatuan', 'updateSatuan')->middleware('auth')->name('inventory.updateSatuan');
    Route::post('/inventory/updateCategory', 'updateCategory')->middleware('auth')->name('inventory.updateCategory');

    Route::get('/inventory/products', 'products')->middleware('auth')->name('inventory.products');
    Route::get('/inventory/{id}/mutasi', 'mutasi')->middleware('auth')->name('inventory.mutasi');
    Route::get('/inventory/reservasi', 'reservasi')->middleware('auth')->name('inventory.reservasi');
    Route::get('/inventory/inbound', 'inbound')->middleware('auth')->name('inventory.inbound');
    Route::get('/inventory/inbound/new', 'inboundNew')->middleware('auth')->name('inventory.inboundNew');
    Route::post('/inventory/inbound/create', 'inboundcreate')->middleware('auth')->name('inventory.inboundcreate');
    Route::get('/inventory/{id}/inbound', 'inboundShow')->middleware('auth')->name('inventory.inboundShow');
    Route::get('/inventory/outbound', 'outbound')->middleware('auth')->name('inventory.outbound');
    Route::get('/inventory/{id}/outbound', 'outboundShow')->middleware('auth')->name('inventory.outboundShow');
    Route::get('/inventory/supplier', 'supplier')->middleware('auth')->name('inventory.supplier');
    Route::get('/invemtoty/table/inbound', 'tableInbound')->middleware('auth')->name('inventory.tableInbound');
    Route::get('/invemtoty/table/{id}/inboundForm', 'tableInboundForm')->middleware('auth')->name('inventory.tableInboundForm');
    Route::post('/inventory/inbound/additem', 'additem')->middleware('auth')->name('inventory.additem');
    Route::post('/inventory/inbound/deleteItem', 'deleteItem')->middleware('auth')->name('inventory.deleteItem');
    Route::post('/inventory/inbound/updateStatus', 'updateStatus')->middleware('auth')->name('inventory.updateStatus');
    Route::post('/inventory/inbound/updateDo', 'updateDo')->middleware('auth')->name('inventory.updateDo');
    Route::post('/inventory/inbound/inboundApproved', 'inboundApproved')->middleware('auth')->name('inventory.inboundApproved');
    Route::post('/inventory/inbound/inboundCancel', 'inboundCancel')->middleware('auth')->name('inventory.inboundCancel');
    Route::get('/inventory/inbound/report', 'InboundReport')->middleware('auth')->name('inventory.InboundReport');
    Route::get('/inventory/inbound/{start}/{end}/report', 'InboundTableReport')->middleware('auth')->name('inventory.InboundTableReport');
    Route::get('/inventory/inbound/{start}/{end}/export', 'export')->middleware('auth')->name('inventory.InboundTableExport');
    Route::get('/inventory/{id}/tableMutasi', 'tableMutasi')->middleware('auth')->name('inventory.tableMutasi');

    /**Transaksi antar cabang */
    Route::get('/inventory/outbound/branch', 'outboundBranch')->middleware('auth')->name('inventory.outboundBranch');
    Route::get('/inventory/outbound/branch/table', 'outboundBranchTable')->middleware('auth')->name('inventory.outboundBranchTable');
    Route::get('/inventory/outbound/branch/tableReceived', 'outboundBranchTableRec')->middleware('auth')->name('inventory.outboundBranchTableRec');
    Route::get('/inventory/outbound/branch/received', 'outboundBranchReceived')->middleware('auth')->name('inventory.outboundBranchReceived');
    Route::post('/inventory/outbound/branchForm', 'outboundBranchForm')->middleware('auth')->name('inventory.outboundBranchForm');
    Route::post('/inventory/outbound/approveBranch', 'approveBranch')->middleware('auth')->name('inventory.approveBranch');
    Route::post('/inventory/outbound/deleteBranch', 'deleteBranch')->middleware('auth')->name('inventory.deleteBranch');

    /**Return */
    Route::get('/inventory/return', 'return')->middleware('auth')->name('inventory.return');
    Route::post('/inventory/return/approve', 'approveReturn')->middleware('auth')->name('inventory.approveReturn');
    Route::post('/inventory/return/delete', 'deleteRetur')->middleware('auth')->name('inventory.deleteRetur');
    Route::get('/inventory/return/table', 'tableReturn')->middleware('auth')->name('inventory.tableReturn');

    /**Ajax url supplier*/
    Route::get('/inventory/table', 'tableInventory')->middleware('auth')->name('inventory.tableInventory');
    Route::get('/supplier/table', 'tableSupplier')->middleware('auth')->name('inventory.tableSupplier');
    Route::post('/supplier', 'storeSupplier')->middleware('auth')->name('inventory.storeSupplier');
    Route::post('/supplier/update', 'updateSupplier')->middleware('auth')->name('inventory.updateSupplier');
    Route::post('/supplier/delete', 'deleteSupplier')->middleware('auth')->name('inventory.deleteSupplier');
    Route::get('/supplier/{id}/json', 'supplierJson')->middleware('auth')->name('inventory.supplierJson');

    /**Ajax url produk*/
    Route::get('/produk/table', 'tableProduct')->middleware('auth')->name('produk.table');
    Route::get('/produk/stok', 'stockProduct')->middleware('auth')->name('produk.stok');
    Route::post('/produk/update', 'updateProduct')->middleware('auth')->name('produk.update');
    Route::post('/produk/delete', 'deleteProduct')->middleware('auth')->name('produk.delete');
    Route::post('/produk', 'productStore')->middleware('auth')->name('produk.store');
    Route::get('/produk/{id}/search', 'productSearch')->middleware('auth')->name('produk.search');
    Route::get('/produk/{id}/json', 'productJson')->middleware('auth')->name('produk.json');
    Route::get('/produk/{id}/stockJson', 'stockById')->middleware('auth')->name('produk.stockById');

    /**Ajax url reservasi*/
    Route::get('/reservasi/{id}/table', 'tableReservasi')->middleware('auth')->name('reservasi.table');
    Route::post('/reservasi/add', 'reservasiAdd')->middleware('auth')->name('reservasi.reservasiAdd');
    Route::post('/reservasi/delete', 'reservasiDelete')->middleware('auth')->name('reservasi.reservasiDelete');
    Route::post('/reservasi/submit', 'reservasiSubmit')->middleware('auth')->name('reservasi.reservasiSubmit');

    /**Ajax url outbound */
    Route::get('/outbound/table', 'outboundTable')->middleware('auth')->name('outbound.outboundTable');
    Route::get('/outbound/{start}/{end}/filter', 'filterOutbound')->middleware('auth')->name('outbound.filterOutbound');
    Route::get('/outbound/{start}/{end}/{key}/filter', 'filterOutboundSearch')->middleware('auth')->name('outbound.filterOutboundSearch');
    
    Route::get('/produk/singkron-user', 'singkronUser')->middleware('auth')->name('produk.singkron');
    Route::post('/produk/singkron-user', 'singkronUserProses')->middleware('auth')->name('produk.singkronProses');

    /**Update v.2 */
    Route::get('/inventory/pos', 'pos')->middleware('auth')->name('inventory.pos');
    Route::get('/inventory/pos-report', 'posReport')->middleware('auth')->name('inventory.posReport');

    /**update v.3 */
    Route::get('/inventory/get-item-order/{id}', 'getItemOrder')->middleware('auth')->name('inventory.getITemOrder');

});

Route::controller(OrderController::class)->group(function(){
    Route::get('/order', 'index')->middleware('auth')->name('order');
    Route::get('/order/{id}/show', 'show')->middleware('auth')->name('order.show');
    Route::get('/order/{id}/edit', 'edit')->middleware('auth')->name('order.edit');
    Route::get('/order/jadwal', 'jadwal')->middleware('auth')->name('order.jadwal');

    /**Ajax Link */
    Route::post('/order', 'store')->middleware('auth')->name('order.store');
    Route::get('/order/{any}/loadForm', 'loadForm')->middleware('auth')->name('order.loadForm');
    Route::post('/order/add', 'orderAdd')->middleware('auth')->name('order.add');
    Route::post('/order/itemDelete', 'itemDelete')->middleware('auth')->name('order.itemDelete');
    Route::get('/order/table', 'table')->middleware('auth')->name('order.table');
    Route::get('/order/{id}/cekJadwalTeknisi', 'cekJadwalTeknisi')->middleware('auth')->name('order.cekJadwalTeknisi');
    Route::post('/order/submit', 'submit')->middleware('auth')->name('submit');
    Route::get('/order/tableJadwal', 'tableJadwal')->middleware('auth')->name('order.tableJadwal');
    Route::post('/order/submit/jadwal', 'submitJadwal')->middleware('auth')->name('order.submitJadwal');
    Route::post('/order/cekJadwal', 'cekJadwal')->middleware('auth')->name('order.checkJadwal');
    Route::post('/order/approve/nota', 'approveNota')->middleware('auth')->name('order.approveNota');
    Route::post('/order/reject/nota', 'rejectNota')->middleware('auth')->name('order.rejectNota');
    Route::post('/order/proses/payment', 'prosesPayment')->middleware('auth')->name('order.prosesPayment');
    Route::post('/order/cancel', 'cancel')->middleware('auth')->name('order.cancel');
    Route::get('/order/report', 'report')->middleware('auth')->name('order.report');
    Route::get('/order/{start}/{end}/{branch}/report', 'tableByDate')->middleware('auth')->name('order.tableByDate');
    Route::get('/order/{start}/{end}/{branch}/{key}/search', 'tableByDateSearch')->middleware('auth')->name('order.tableByDateSearch');
    Route::get('/order/{start}/{end}/{branch}/export', 'export')->middleware('auth')->name('order.export');
    Route::get('/order/{start}/{end}/{branch}/{teknisi}/tableByDateTeknisi', 'tableByDateTeknisi')->middleware('auth')->name('order.tableByDateTeknisi');

    Route::get('/order/master', 'master')->middleware('auth')->name('order.master');
    Route::get('/order/tableItem', 'tableItem')->middleware('auth')->name('order.tableItem');
    Route::get('/order/tableMerk', 'tableMerk')->middleware('auth')->name('order.tableMerk');
    Route::post('/order/addMerk', 'addMerk')->middleware('auth')->name('order.addMerk');
    Route::post('/order/deleteMerk', 'deleteMerk')->middleware('auth')->name('order.deleteMerk');
    Route::post('/order/addItem', 'addItem')->middleware('auth')->name('order.addItem');
    Route::post('/order/deleteItem', 'deleteItem')->middleware('auth')->name('order.deleteItem');
    Route::post('/order/addTax', 'addTax')->middleware('auth')->name('order.addTax');
    
    /**update */
    Route::get('/order/jadwal-order', 'jadwalOrder')->middleware('auth')->name('order.jadwalOrder');
    Route::get('/order/jadwal-order-table', 'jadwalOrderTable')->middleware('auth')->name('order.jadwalOrderTable');
    Route::post('/order/buat-jadwal', 'buatJadwal')->middleware('auth')->name('order.buatJadwal');

    /**update V.2 */
    Route::get('/order/pekerjaan-jasa', 'pekerjaanJasa')->middleware('auth')->name('order.pekerjaanJasa');
    Route::get('/order/nomor-nota', 'nomorNota')->middleware('auth')->name('order.nomorNota');
    Route::post('/order/recall', 'recall')->middleware('auth')->name('order.recall');

});

Route::controller(CostumerController::class)->group(function(){
    Route::get('/costumers', 'index')->middleware('auth')->name('costumer');
    Route::post('/costumers', 'store')->middleware('auth')->name('costumer.store');

    /**Load Ajax */
    Route::get('/costumer/ajax/table', 'ajaxTable')->middleware('auth')->name('costumer.ajax-table');
    Route::get('/costumer/{any}/search', 'ajaxSearch')->middleware('auth')->name('costumer.ajax-search');
    Route::get('/costumer/{id}/edit', 'edit')->middleware('auth')->name('costumer.ajax-edit');
    Route::post('/costumer/update', 'update')->middleware('auth')->name('costumer.ajax-update');
    Route::post('/costumer/delete', 'destroy')->middleware('auth')->name('costumer.ajax-delete');
});

Route::controller(OperationalController::class)->group(function(){
    Route::get('/operational', 'index')->middleware('auth')->name('operational');
    Route::get('/operational/saldo/json', 'saldoJson')->middleware('auth')->name('operational.saldoJson');
    Route::get('/operational/pengeluaran', 'pengeluaran')->middleware('auth')->name('operational.pengeluaran');
    Route::post('/operational/mutasi/delete', 'deleteMutasi')->middleware('auth')->name('operational.deleteMutasi');
    Route::post('/operational/storePengeluaran', 'storePengeluaran')->middleware('auth')->name('operational.storePengeluaran');
    Route::get('/opx/cashbon', 'cashbon')->middleware('auth')->name('opx.cashbon');
    Route::post('/opx/cashbon', 'storeCashbon')->middleware('auth')->name('opx.storeCashbon');
    Route::get('/cashbon/{month}/table', 'tableCashbon')->middleware('auth')->name('opx.tableCashbon');
    Route::get('/cashbon/{karyawan}/{bulan}/filter', 'filterCashbon')->middleware('auth')->name('opx.filterCashbon');
    Route::get('/operational/tableops', 'tableOps')->middleware('auth')->name('opx.tableOps');
    Route::get('/operational/tableopsUot', 'tableOpsUot')->middleware('auth')->name('opx.tableOpsUot');
    Route::get('/operational/{start}/{end}/history', 'tableHistory')->middleware('auth')->name('opx.tableHistory');
    Route::get('/operational/history', 'history')->middleware('auth')->name('opx.history');
    Route::post('/ops', 'store')->middleware('auth')->name('opx.store');
    
    Route::get('/operational/master', 'master')->middleware('auth')->name('opx.master');
    Route::get('/operational/tableItem', 'tableItem')->middleware('auth')->name('opx.tableItem');
    Route::post('/operational/newItem', 'newItem')->middleware('auth')->name('opx.newItem');
    Route::post('/operational/updateItem', 'updateItem')->middleware('auth')->name('opx.updateItem');
    Route::post('/operational/deleItem', 'deleItem')->middleware('auth')->name('opx.deleItem');
    
    Route::get('/operational/cashbon', 'userCashbon')->middleware('auth')->name('opx.userCashbon');
    Route::post('/operational/approveCashbon', 'approveCashbon')->middleware('auth')->name('opx.approveCashbon');
    Route::post('/operational/deleteCashbon', 'deleteCashbon')->middleware('auth')->name('opx.deleteCashbon');
});
Route::controller(EmployeeController::class)->group(function(){
    Route::get('/employee', 'index')->middleware('auth')->name('employee');
    Route::get('/employee/{id}/profile', 'profile')->middleware('auth')->name('employee.profile');
    Route::get('/employee/absensi', 'absensi')->middleware('auth')->name('employee.absensi');
    Route::get('/absensi/report', 'reportAbsen')->middleware('auth')->name('absensi.report');
    Route::post('/profile/gantiPassword', 'gantiPassword')->middleware('auth')->name('absensi.gantiPassword');

    /**Ajax url */
    Route::get('/employee/ajax/table', 'ajaxTable')->middleware('auth')->name('employee.ajax-table');
    Route::post('/employee', 'store')->middleware('auth')->name('employee.store');
    Route::get('/employee/{id}/userCard', 'userCard')->middleware('auth')->name('employee.userCard');
    Route::get('/employee/{id}/general', 'general')->middleware('auth')->name('employee.general');
    Route::get('/employee/{nik}/loadForm', 'loadForm')->middleware('auth')->name('employee.loadForm');
    Route::post('/employee/update', 'update')->middleware('auth')->name('employee.update');
    Route::get('/employee/{any}/search', 'search')->middleware('auth')->name('employee.search');

    Route::post('/absensi/new', 'newAbsen')->middleware('auth')->name('absensi.new');
    Route::get('/absen/option_user', 'option_user')->middleware('auth')->name('absen.option_user');
    Route::get('/absen/data_table', 'data_table')->middleware('auth')->name('absen.data_table');
    Route::post('/absensi/post', 'absenPost')->middleware('auth')->name('absen.post');
    Route::post('/absensi/pulang', 'absenPulang')->middleware('auth')->name('absen.pulang');
    Route::post('/absen/lembur/update', 'addLembur')->middleware('auth')->name('absen.addLembur');
    Route::post('/absen/delete', 'deleteAbsen')->middleware('auth')->name('absen.deleteAbsen');
    Route::get('/absen/{start}/report', 'tablereportAbsen')->middleware('auth')->name('tablereportAbsen');

    /**Url Payroll */
    Route::get('/employee/payroll', 'payroll')->middleware('auth')->name('employee.payroll');
    Route::get('/employee/payroll/table', 'payrollTable')->middleware('auth')->name('employee.payrollTable');
    Route::get('/employee/{id}/payroll', 'payrollDetail')->middleware('auth')->name('employee.payrollDetail');
    Route::post('/employee/payroll/update', 'updatePayroll')->middleware('auth')->name('employee.updateParyroll');
    Route::post('/employee/payroll/proses', 'prosesPayroll')->middleware('auth')->name('employee.prosesParyroll');
    Route::post('/employee/payroll/reset', 'resetPayroll')->middleware('auth')->name('employee.resetParyroll');

    /**Role */
    Route::get('/employee/role', 'role')->middleware('auth')->name('employee.role');
    Route::get('/employee/tableRole', 'tableRole')->middleware('auth')->name('employee.tableRole');
    Route::post('/employee/updateRole', 'updateRole')->middleware('auth')->name('employee.updateRole');
    Route::post('/employee/uploadFoto', 'uploadFoto')->middleware('auth')->name('employee.uploadFoto');

    /**Kantor Cabang */
    Route::get('/branch', 'branch')->middleware('auth')->name('employee.branch');
    Route::get('/tableBranch', 'tableBranch')->middleware('auth')->name('employee.tableBranch');
    Route::post('/updateBranch', 'updateBranch')->middleware('auth')->name('employee.updateBranch');
});

Route::controller(FinanceController::class)->group(function(){
    Route::get('/finance/order', 'index')->middleware('auth')->name('finance');
    Route::get('/finance/invoice', 'invoice')->middleware('auth')->name('finance.invoice');
    Route::get('/salary/report', 'salaryReport')->middleware('auth')->name('finance.salaryReport');
    Route::get('/salary/{id}/tableReport', 'tableReportSalary')->middleware('auth')->name('finance.tableReportSalary');
    Route::get('/finance/khas', 'khas')->middleware('auth')->name('finance.khas');
    Route::post('/finance/khas/store', 'khasStore')->middleware('auth')->name('finance.khasStore');
    Route::get('/finance/tableKhas', 'tableKhas')->middleware('auth')->name('finance.tableKhas');
    Route::get('/finance/asset', 'asset')->middleware('auth')->name('finance.asset');
    Route::get('/finance/table/asset', 'tableAsset')->middleware('auth')->name('finance.tableAsset');
    Route::get('/finance/table/angsuran', 'tableAngsuran')->middleware('auth')->name('finance.tableAngsuran');
    Route::get('/finance/table/{id}/form', 'tableForm')->middleware('auth')->name('finance.tableForm');
    Route::post('/finance/asset/store', 'storeAsset')->middleware('auth')->name('finance.storeAsset');
    Route::post('/finance/asset/update', 'updateAsset')->middleware('auth')->name('finance.updateAsset');
    Route::get('/finance/asset/payment', 'paymentAsset')->middleware('auth')->name('finance.paymentAsset');
    Route::get('/asset/{id}/payment', 'cicilanAsset')->middleware('auth')->name('finance.cicilanAsset');
    Route::post('/asset/form/store', 'storeForm')->middleware('auth')->name('finance.storeForm');
    Route::post('/asset/form/update', 'updateForm')->middleware('auth')->name('finance.updateForm');
    Route::post('/asset/form/setBayar', 'setBayar')->middleware('auth')->name('finance.setBayar');
    Route::post('/asset/form/saveForm', 'saveForm')->middleware('auth')->name('finance.saveForm');
    Route::post('/asset/form/deleteForm', 'deleteForm')->middleware('auth')->name('finance.deleteForm');
    Route::post('/asset/form/bayarAngsuran', 'bayarAngsuran')->middleware('auth')->name('finance.bayarAngsuran');
    
    Route::get('/finance/inbound/payment', 'inboundPayment')->middleware('auth')->name('finance.inboundPayment');
    Route::get('/finance/inbound/table', 'inboundTable')->middleware('auth')->name('finance.inboundTable');
    Route::post('/finance/inbound/prosesPayment', 'prosesPayment')->middleware('auth')->name('finance.prosesPayment');

});


/**Teknisi */
Route::controller(TeknisiController::class)->group(function(){
    Route::get('/teknisi/order', 'order')->middleware('auth')->name('teknisi.order');
    Route::get('/teknisi/stock', 'stock')->middleware('auth')->name('teknisi.stock');
    Route::post('/teknisi/return', 'return')->middleware('auth')->name('teknisi.return');
    Route::get('/teknisi/return/data', 'dataReturn')->middleware('auth')->name('teknisi.dataReturn');
    Route::get('/teknisi/{id}/order', 'show')->middleware('auth')->name('teknisi.show');
    Route::get('/teknisi/material', 'material')->middleware('auth')->name('teknisi.material');
    Route::get('/teknisi/orderList', 'orderList')->middleware('auth')->name('teknisi.orderList');
    Route::post('/teknisi/pickup', 'pickup')->middleware('auth')->name('teknisi.pickup');
    Route::get('/teknisi/{id}/json', 'orderitemJson')->middleware('auth')->name('teknisi.orderitemJson');
    Route::post('/teknisi/update/order', 'updateOrder')->middleware('auth')->name('teknisi.updateOrder');
    Route::get('/teknisi/{id}/itemList', 'itemList')->middleware('auth')->name('teknisi.itemList');
    Route::post('/teknisi/orderitem/update', 'updateItem')->middleware('auth')->name('teknisi.updateItem');
    Route::post('/teknisi/material/approved', 'approveMaterial')->middleware('auth')->name('teknisi.approveMaterial');
    Route::get('/teknisi/{id}/productJson', 'productJson')->middleware('auth')->name('teknisi.productJson');
    Route::post('/teknisi/ordermaterials', 'ordermaterials')->middleware('auth')->name('teknisi.ordermaterials');
    Route::post('/teknisi/upload', 'upload')->middleware('auth')->name('teknisi.upload');
    Route::post('/teknisi/pending/order', 'pending')->middleware('auth')->name('teknisi.auth');
    Route::get('/teknisi/cashbon', 'cashbon')->middleware('auth')->name('teknisi.cashbon');
    Route::post('/teknisi/cashbon', 'approveCashbon')->middleware('auth')->name('teknisi.approveCashbon');
    
    Route::get('/teknisi/{id}/material/use', 'loadStokMaterialUse')->middleware('auth')->name('teknisi.loadStokMaterialUse');
    Route::post('/teknisi/continue/order', 'continueOrder')->middleware('auth')->name('teknisi.continueOrder');
    Route::get('teknisi/show/{id}/buttonFooter', 'buttonFooter')->middleware('auth')->name('teknisi.buttonFooter');

    Route::get('/sop', 'sop')->middleware('auth')->name('sop');
    Route::get('/tracking-unit', 'trackingUnit')->middleware('auth')->name('trackingUnit');
});

Route::controller(InvoiceController::class)->group(function(){
    Route::get('/invoice', 'index')->middleware('auth')->name('invoice');
    Route::get('/invoice/table', 'table')->middleware('auth')->name('invoice.table');
    Route::post('/invoice', 'update')->middleware('auth')->name('invoice.update');
    Route::post('/invoice/upload', 'uploadFile')->middleware('auth')->name('invoice.uploadFile');
    Route::get('/invoice/{name}/viewPdf', 'viewPdf')->middleware('auth')->name('invoice.viewPdf');
    Route::post('/invoice/approve', 'approve')->middleware('auth')->name('invoice.approve');
    Route::post('/invoice/send', 'send')->middleware('auth')->name('invoice.send');
    Route::post('/invoice/paid', 'paid')->middleware('auth')->name('invoice.paid');
    Route::get('/invoice/report', 'report')->middleware('auth')->name('invoice.report');
    Route::get('/invoice/{start}/{end}/report', 'reportfilter')->middleware('auth')->name('invoice.reportfilter');
    Route::get('/invoice/{start}/{end}/export', 'export')->middleware('auth')->name('invoice.export');
});

Route::controller(ToolsController::class)->group(function(){
    Route::get('/tools', 'index')->middleware('auth')->name('tools.index');
    Route::get('/tools/master', 'master')->middleware('auth')->name('tools.master');
});

Route::controller(AccountingController::class)->group(function () {
    Route::get('/acc/approval', 'approval')->middleware('auth')->name('acc.approval');
    Route::get('/acc/arus-kas', 'arusKhas')->middleware('auth')->name('acc.arusKhas');
    Route::get('/acc/akun', 'akun')->middleware('auth')->name('acc.akun');
});

