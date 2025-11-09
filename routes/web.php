<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Services\CsvExportService;

// Default Laravel welcome page
Route::get('/', function () {
    return view('welcome');
});


// // Download the live CSV file
// Route::get('/admin/download-csv', function () {
//     $csvPath = 'exports/quiz_emails.csv';
    
//     if (!Storage::exists($csvPath)) {
//         return response()->json(['error' => 'No data yet'], 404);
//     }
    
//     return Storage::download($csvPath, 'quiz_emails.csv');
// });

// Export all data to a new CSV
Route::get('/admin/export-all', function () {
    $csvPath = CsvExportService::exportAll();
    
    return Storage::download($csvPath);
});