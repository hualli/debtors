<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Services\ImportService;

class ImportController extends Controller
{
    private ImportService $importService;

    public function __construct(ImportService $importService){
        $this->importService = $importService;
    }

    /**
     * Import data from a file uploaded in the request
     *
     * @param \App\Http\Requests\ImportRequest $request
     * @return \Illuminate\Http\JsonResponse JSON
     */
    public function import(ImportRequest $request){

        try {
            $lines = $this->importService->getLines($request);

            foreach ($lines as $line) {
                $this->importService->processLine($line);
            }

            return response()->json([
                'message' => 'Import completed'
            ],200);

        }catch (\Exception $e){
            return response()->json([
                'message' => 'Error processing file',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
