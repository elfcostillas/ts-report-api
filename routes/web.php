<?php

use App\Http\Controllers\StubsController;
use App\Http\Controllers\SummaryController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::prefix('stubs')->group(function(){

    // Route::get('list',[StubsController::class,'list']);
    Route::get('print/{id}',[StubsController::class,'print']);
    Route::get('print-summary',[StubsController::class,'printSummary']);

});

Route::prefix('summary')->group(function(){
    Route::get('print/{id}',[SummaryController::class,'print']);
});

Route::prefix('dr')->group(function(){

    // Route::get('list',[StubsController::class,'list']);
    Route::get('cancelled/{date_from}/{date_to}',[StubsController::class,'cancelled']);
});



Route::get('copy', function () {

    $qad_order = DB::connection('mysql')->table('qad_invoice')->orderBy('id','asc')
    ->where('doc_type',"!=","''" )
    ->where('doc_type',"!=",'0')
    ->where('doc_type',"!=",'')
    ->where('order_date','>=','2024-11-01')
    ->whereNotNull("doc_type")
    ->chunk(1000,function($rows){

        $tmp = [];

        foreach($rows as $row)
        {
            $arr = (array) $row;
            array_push($tmp, $arr);
        }

        DB::connection('mariadb')->table('qad_invoice')->insertOrIgnore($tmp);
    });

    $qad_order = DB::connection('mysql')->table('qad_order')->orderBy('order_id','asc')
    ->where('doc_type',"!=","''" )
    ->where('doc_type',"!=",'0')
    ->where('doc_type',"!=",'')
    ->where('order_date','>=','2024-11-01')
    ->whereNotNull("doc_type")
    ->chunk(1000,function($rows){

        $tmp = [];

        foreach($rows as $row)
        {
            $arr = (array) $row;
            array_push($tmp, $arr);
        }

        DB::connection('mariadb')->table('qad_order')->insertOrIgnore($tmp);
    });
});


/*
chunk(100, function (Collection $users) {
    foreach ($users as $user) {
        // ...
    }
});*/
