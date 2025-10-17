<?php

namespace App\Services;

use App\Models\QuizResult;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CsvExportService
{
    /**
     * Append a single quiz result to CSV
     */
    public static function appendToCsv(QuizResult $quiz): void
    {
        try {
            $csvPath = 'exports/quiz_emails.csv';
            
            // Initialize CSV if it doesn't exist
            if (!Storage::exists($csvPath)) {
                $headers = "ID,Email,Result Type,Source,Submitted At\n";
                Storage::put($csvPath, $headers);
            }
            
            // Prepare new row
            $row = sprintf(
                "%s,%s,%s,%s,%s\n",
                $quiz->id,
                $quiz->email,
                $quiz->result_type,
                $quiz->source,
                $quiz->created_at->format('Y-m-d H:i:s')
            );
            
            // Append to file
            Storage::append($csvPath, $row);
            
        } catch (\Exception $e) {
            Log::error('CSV Export Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Export all quiz results to CSV
     */
    public static function exportAll(): string
    {
        $csvPath = 'exports/quiz_emails_full_' . now()->format('Y-m-d_His') . '.csv';
        
        // Start with headers
        $csv = "ID,Email,Result Type,Source,Submitted At\n";
        
        // Add all records
        QuizResult::chunk(100, function ($results) use (&$csv) {
            foreach ($results as $result) {
                $csv .= sprintf(
                    "%s,%s,%s,%s,%s\n",
                    $result->id,
                    $result->email,
                    $result->result_type,
                    $result->source,
                    $result->created_at->format('Y-m-d H:i:s')
                );
            }
        });
        
        Storage::put($csvPath, $csv);
        
        return $csvPath;
    }
}