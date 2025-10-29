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
            $csvPath = 'exports/quiz_results.csv';
            
            // Initialize CSV if it doesn't exist
            if (!Storage::exists($csvPath)) {
                $headers = "ID,Email,Result Type,Score,Answers,Source,Submitted At\n";
                Storage::put($csvPath, $headers);
            }
            
            // Prepare new row (escape commas in JSON)
            $answersJson = str_replace(',', ';', json_encode($quiz->answers));
            
            $row = sprintf(
                "%s,%s,%s,%s,%s,%s,%s\n",
                $quiz->id,
                $quiz->email,
                $quiz->result_type,
                $quiz->score ?? 'N/A',
                $answersJson,
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
        $csvPath = 'exports/quiz_results_full_' . now()->format('Y-m-d_His') . '.csv';
        
        // Start with headers
        $csv = "ID,Email,Result Type,Score,Answers,Source,Submitted At\n";
        
        // Add all records
        QuizResult::chunk(100, function ($results) use (&$csv) {
            foreach ($results as $result) {
                $answersJson = str_replace(',', ';', json_encode($result->answers));
                
                $csv .= sprintf(
                    "%s,%s,%s,%s,%s,%s,%s\n",
                    $result->id,
                    $result->email,
                    $result->result_type,
                    $result->score ?? 'N/A',
                    $answersJson,
                    $result->source,
                    $result->created_at->format('Y-m-d H:i:s')
                );
            }
        });
        
        Storage::put($csvPath, $csv);
        
        return $csvPath;
    }
}