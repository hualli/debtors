<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Jobs\ProcessImportLine;

class ImportService
{
    /**
     * Get the lines from the uploaded file
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function getLines(Request $request){
        $file = $request->file('file')->openFile();
        $lines = [];
        while (!$file->eof()) {
            $lines[] = $file->fgets();
        }
        return $lines;
    }

    /**
     * Process a single line from the file
     *
     * @param string $line
     * @return void
     */
    public function processLine($line){
        ProcessImportLine::dispatch($line);
    }
}
