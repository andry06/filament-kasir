<?php

use App\Exports\TemplateExport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/downloadTemplate', function() {
    return Excel::download(new TemplateExport, 'template.xlsx');
})->name('download-template');
