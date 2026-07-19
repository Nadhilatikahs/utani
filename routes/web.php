<?php
//masterdata
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\UptController;
use App\Http\Controllers\BppController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KelompoktaniController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\AnggotataniController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\BebanController;
use App\Http\Controllers\KategoriController;
//transaksi
use App\Http\Controllers\TanamController;
use App\Http\Controllers\BebantanamController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\LaporanController;
// cluster
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\Clustering2Controller;
use App\Http\Controllers\ClusteringWilayahController;


//fitur
use App\Http\Controllers\MapsController;
use App\Http\Controllers\GrafikController;

//arus kas
use App\Http\Controllers\ArusKasController;

//tambah
use App\Http\Controllers\JournalController;

use App\Http\Controllers\TransactionController;

use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\COAController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\JenisTransaksiController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginaction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
Route::middleware('auth')->group(function () {
    // Route::get('dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [GrafikController::class, 'index'])->name('dashboard');



    //master data
    Route::controller(ProvinsiController::class)->prefix('provinsis')->group(function () {
        Route::get('', 'index')->name('provinsis.index');
        Route::get('create', 'create')->name('provinsis.create');
        Route::post('store', 'store')->name('provinsis.store');
        Route::get('edit/{id}', 'edit')->name('provinsis.edit');
        Route::put('edit/{id}', 'update')->name('provinsis.update');
        Route::delete('destroy/{id}', 'destroy')->name('provinsis.destroy');
    });

    Route::controller(KabupatenController::class)->prefix('kabupatens')->group(function () {
        Route::get('', 'index')->name('kabupatens.index');
        Route::get('create', 'create')->name('kabupatens.create');
        Route::post('store', 'store')->name('kabupatens.store');
        Route::get('edit/{id}', 'edit')->name('kabupatens.edit');
        Route::put('edit/{id}', 'update')->name('kabupatens.update');
        Route::delete('destroy/{id}', 'destroy')->name('kabupatens.destroy');
    });


    Route::controller(DinasController::class)->prefix('dinas')->group(function () {
        Route::get('', 'index')->name('dinas.index');
        Route::get('create', 'create')->name('dinas.create');
        Route::post('store', 'store')->name('dinas.store');
        Route::get('edit/{id}', 'edit')->name('dinas.edit');
        Route::put('edit/{id}', 'update')->name('dinas.update');
        Route::delete('destroy/{id}', 'destroy')->name('dinas.destroy');
    });

    Route::controller(UptController::class)->prefix('upts')->group(function () {
        Route::get('', 'index')->name('upts.index');
        Route::get('create', 'create')->name('upts.create');
        Route::post('store', 'store')->name('upts.store');
        Route::get('edit/{id}', 'edit')->name('upts.edit');
        Route::put('edit/{id}', 'update')->name('upts.update');
        Route::delete('destroy/{id}', 'destroy')->name('upts.destroy');
    });

    Route::controller(BppController::class)->prefix('bpps')->group(function () {
        Route::get('', 'index')->name('bpps.index');
        Route::get('create', 'create')->name('bpps.create');
        Route::post('store', 'store')->name('bpps.store');
        Route::get('edit/{id}', 'edit')->name('bpps.edit');
        Route::put('edit/{id}', 'update')->name('bpps.update');
        Route::delete('destroy/{id}', 'destroy')->name('bpps.destroy');
    });

    Route::controller(DesaController::class)->prefix('desas')->group(function () {
        Route::get('', 'index')->name('desas.index');
        Route::get('create', 'create')->name('desas.create');
        Route::post('store', 'store')->name('desas.store');
        Route::get('edit/{id}', 'edit')->name('desas.edit');
        Route::put('edit/{id}', 'update')->name('desas.update');
        Route::delete('destroy/{id}', 'destroy')->name('desas.destroy');
    });

    Route::controller(KelompokTaniController::class)->prefix('keltanis')->group(function () {
        Route::get('', 'index')->name('keltanis.index');
        Route::get('create', 'create')->name('keltanis.create');
        Route::post('store', 'store')->name('keltanis.store');
        Route::get('edit/{id}', 'edit')->name('keltanis.edit');
        Route::put('edit/{id}', 'update')->name('keltanis.update');
        Route::delete('destroy/{id}', 'destroy')->name('keltanis.destroy');
    });

    Route::controller(KomoditasController::class)->prefix('komoditas')->group(function () {
        Route::get('', 'index')->name('komoditas.index');
        Route::get('create', 'create')->name('komoditas.create');
        Route::post('store', 'store')->name('komoditas.store');
        Route::get('edit/{id}', 'edit')->name('komoditas.edit');
        Route::put('edit/{id}', 'update')->name('komoditas.update');
        Route::delete('destroy/{id}', 'destroy')->name('komoditas.destroy');
    });

    Route::controller(AnggotaTaniController::class)->prefix('anggotatanis')->group(function () {
        Route::get('', 'index')->name('anggotatanis.index');
        Route::get('create', 'create')->name('anggotatanis.create');
        Route::post('store', 'store')->name('anggotatanis.store');
        Route::get('edit/{id}', 'edit')->name('anggotatanis.edit');
        Route::put('edit/{id}', 'update')->name('anggotatanis.update');
        Route::delete('destroy/{id}', 'destroy')->name('anggotatanis.destroy');
        Route::get('/import', 'import')->name('anggotatanis.import');
        Route::post('/import', 'import_proses')->name('anggotatanis.import_proses');
        Route::get('/export', 'export')->name('anggotatanis.export');
    });

    Route::controller(LahanController::class)->prefix('lahans')->group(function () {
        Route::get('', 'index')->name('lahans.index');
        Route::get('create', 'create')->name('lahans.create');
        Route::post('store', 'store')->name('lahans.store');
        Route::get('edit/{id}', 'edit')->name('lahans.edit');
        Route::put('edit/{id}', 'update')->name('lahans.update');
        Route::delete('destroy/{id}', 'destroy')->name('lahans.destroy');
    });

    Route::controller(BebanController::class)->prefix('bebans')->group(function () {
        Route::get('', 'index')->name('bebans.index');
        Route::get('create', 'create')->name('bebans.create');
        Route::post('store', 'store')->name('bebans.store');
        Route::get('edit/{id}', 'edit')->name('bebans.edit');
        Route::put('edit/{id}', 'update')->name('bebans.update');
        Route::delete('destroy/{id}', 'destroy')->name('bebans.destroy');
    });
    Route::controller(KategoriController::class)->prefix('kategori')->group(function () {
        Route::get('', 'index')->name('kategori.index');
        Route::get('create', 'create')->name('kategori.create');
        Route::post('store', 'store')->name('kategori.store');
        Route::get('edit/{id}', 'edit')->name('kategori.edit');
        Route::put('edit/{id}', 'update')->name('kategori.update');
        Route::delete('destroy/{id}', 'destroy')->name('kategori.destroy');
    });



    //transaksi
    Route::controller(TanamController::class)->prefix('tanams')->group(function () {
        Route::get('', 'index')->name('tanams.index');
        Route::get('create', 'create')->name('tanams.create');
        Route::post('store', 'store')->name('tanams.store');
        Route::get('edit/{id}', 'edit')->name('tanams.edit');
        Route::put('edit/{id}', 'update')->name('tanams.update');
        Route::delete('destroy/{id}', 'destroy')->name('tanams.destroy');
    });
    Route::get('/update-beban-variabel', [TanamController::class, 'updateBebanVariabel']);

    Route::controller(BebantanamController::class)->prefix('bebantanam')->group(function () {
        Route::get('', 'index')->name('bebantanam.index');
        Route::get('create', 'create')->name('bebantanam.create');
        Route::post('store', 'store')->name('bebantanam.store');
        Route::get('edit/{id}', 'edit')->name('bebantanam.edit');
        Route::put('edit/{id}', 'update')->name('bebantanam.update');
        Route::delete('destroy/{id}', 'destroy')->name('bebantanam.destroy');
    });

    Route::controller(PanenController::class)->prefix('panen')->group(function () {
        Route::get('', 'index')->name('panen.index');
        Route::get('create', 'create')->name('panen.create');
        Route::post('store', 'store')->name('panen.store');
        Route::get('edit/{id}', 'edit')->name('panen.edit');
        Route::put('edit/{id}', 'update')->name('panen.update');
        Route::delete('destroy/{id}', 'destroy')->name('panen.destroy');
    });




    //Laporan
    Route::controller(\App\Http\Controllers\LaporanController::class)
    ->prefix('laporan')
    ->group(function () {
        Route::get('index', 'index')->name('laporan.index');
        Route::get('by-commodity', 'byCommodity')->name('laporan.byCommodity');
        Route::get('show', 'show')->name('laporan.show');  // pakai ?tanam_id=
        Route::get('print', 'print')->name('laporan.print');
        Route::get('preview/{tanam_id}', 'preview')->name('laporan.preview');
    });


    //dashbooard grafik
    Route::controller(GrafikController::class)->prefix('grafik')->group(function () {
        Route::get('index', 'index')->name('grafik.index');
        Route::get('pilihtahunbatang/{tahun}', 'pilihtahunbatang')->name('grafik.pilihtahunbatang');
        Route::get('viewDataPenjualanSelectOption/{tahun}', 'viewDataPenjualanSelectOption')->name('grafik.viewDataPenjualanSelectOption');
        Route::get('viewJmlPenjualan/{tahun}', 'viewJmlPenjualan')->name('grafik.viewJmlPenjualan');
        Route::get('viewJmlPenjualanJson/{tahun}', 'viewJmlPenjualanJson')->name('grafik.viewJmlPenjualanJson');
        // piekelompoktani.blade.php
        Route::get('viewJmlPendapatanKelompokTani/{tahun}', 'viewJmlPendapatanKelompokTani')->name('grafik.viewJmlPendapatanKelompokTani');
        Route::get('viewJmlPendapatanKelompokTaniJson/{tahun}', 'viewJmlPendapatanKelompokTaniJson')->name('grafik.viewJmlPendapatanKelompokTaniJson');
    });

    // cluster
    Route::controller(ClusterController::class)->prefix('cluster')->group(function () {
        Route::get('coba', 'coba')->name('cluster.coba');
        Route::get('cobacluster', 'cobacluster')->name('cluster.cobacluster'); //clusterbiaya
        Route::get('clusterbiaya', 'clusterbiaya')->name('cluster.clusterbiaya');
    });

    //fitur
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::controller(MapsController::class)->prefix('maps')->group(function () {
        Route::get('', 'map')->name('maps.map');
    });

    //Aruskas
    Route::controller(ArusKasController::class)->prefix('arus-kas')->group(function () {
        Route::get('/', 'index')->name('aruskas.index'); // Halaman utama Arus Kas
        Route::get('/show', 'show')->name('aruskas.show'); // Halaman detail
        Route::get('/arus-kas/detail/{type}', [ArusKasController::class, 'detail'])->name('aruskas.detail');
        Route::get('/arus-kas/create', [ArusKasController::class, 'create'])->name('aruskas.create');
        Route::post('/arus-kas/store', [ArusKasController::class, 'store'])->name('aruskas.store');
    });


    //journal
    Route::get('journal', [JournalController::class, 'index'])->name('journal.index'); // Menampilkan daftar jurnal
    Route::get('journal/create', [JournalController::class, 'create'])->name('journal.create'); // Form untuk membuat jurnal baru
    Route::post('journal', [JournalController::class, 'store'])->name('journal.store'); // Menyimpan jurnal baru
    Route::get('journal/{id}', [JournalController::class, 'show'])->name('journal.show'); // Melihat detail jurnal
    Route::get('journal/{id}/edit', [JournalController::class, 'edit'])->name('journal.edit'); // Form untuk mengedit jurnal
    Route::put('journal/{id}', [JournalController::class, 'update'])->name('journal.update'); // Mengupdate jurnal
    Route::delete('journal/{id}', [JournalController::class, 'destroy'])->name('journal.destroy'); // Menghapus jurnal

    //transaksi
    // Route::get('/transactions', function () {
    //     return view('transactions');
    // });

    // Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    // Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    Route::prefix('coa')->group(function () {
        Route::get('/', [COAController::class, 'index']);
        Route::post('simpan', [COAController::class, 'store']);
        Route::put('update/{id}', [COAController::class, 'update']);
        Route::delete('delete/{id}', [COAController::class, 'destroy']);
    });

    Route::prefix('detail-jenis-transaksi')->group(function () {
        Route::get('/', [DetailTransaksiController::class, 'index']);
        Route::post('simpan', [DetailTransaksiController::class, 'store']);
        Route::put('update/{id}', [DetailTransaksiController::class, 'update']);
        Route::delete('delete/{id}', [DetailTransaksiController::class, 'destroy']);
    });

    Route::prefix('jenis-transaksi')->group(function () {
        Route::get('/', [JenisTransaksiController::class, 'index']);
        Route::post('simpan', [JenisTransaksiController::class, 'store']);
        Route::put('update/{id}', [JenisTransaksiController::class, 'update']);
        Route::delete('delete/{id}', [JenisTransaksiController::class, 'destroy']);
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('list-detail-transaksi', [TransactionController::class, 'getDetailTransaksi']);
        Route::get('form', [TransactionController::class, 'formArusKas']);
        Route::post('simpan', [TransactionController::class, 'store']);
    });
    // auth insert input transaksi bebantanam
    Route::get('/bebantanam/by-tanam/{id_tanam}', [BebantanamController::class, 'indexByTanam'])
        ->name('bebantanam.byTanam');

    Route::post('/bebantanam/store-batch/{id_tanam}', [BebantanamController::class, 'storeBatch'])
        ->name('bebantanam.storeBatch');

    Route::get('/bebantanam/create-batch/{id_tanam}', [BebantanamController::class, 'createBatch'])
        ->name('bebantanam.createBatch');
    

});

//

Route::post('/cash-transactions', [CashTransactionController::class, 'store']);
Route::resource('cashtransactions', CashTransactionController::class);

//

Route::get('/reports', [ReportController::class, 'index']);
//Route::resource('journal', JournalController::class);
Route::resource('report', ReportController::class);

Route::get('/tora', function () {
    return 'ini halaman tora';
});

Route::get('/clustering/kelompok-tani', [Clustering2Controller::class, 'index']);

Route::get('/clustering', [ClusteringWilayahController::class, 'index'])
     ->name('clustering.show');