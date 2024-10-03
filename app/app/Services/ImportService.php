<?php

namespace App\Services;

use App\Models\Debtor;
use App\Models\Entity;
use Illuminate\Http\Request;

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

        $entity_code = substr($line, 0, 5);
        $identification_number = substr($line, 13, 11);
        $situation = (int) substr($line, 27, 2);
        $loan = (float) substr($line, 29, 12);

        $entity = Entity::where('entity_code', $entity_code)->first();

        if(!$entity){
            Entity::create([
                'entity_code' => $entity_code,
                'sum_of_loans' => $loan
            ]);
        }else{
            $entity->sum_of_loans += $loan;
            $entity->save();
        }

        $debtor = Debtor::where('identification_number', $identification_number)
            ->where('entity_code', $entity_code)
            ->first();

        if (!$debtor) {
            Debtor::create([
                'identification_number' => $identification_number,
                'situation' => $situation,
                'sum_of_loans' => $loan,
                'entity_code' => $entity_code
            ]);
        } else {
            $debtor->sum_of_loans += $loan;
            $debtor->situation = max($debtor->situation, $situation);
            $debtor->save();
        }
    }

}
