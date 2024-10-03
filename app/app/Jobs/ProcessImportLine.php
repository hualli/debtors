<?php

namespace App\Jobs;

use App\Models\Debtor;
use App\Models\Entity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessImportLine implements ShouldQueue
{
    use Queueable;

    public $line;

    /**
     * Create a new job instance.
     */
    public function __construct($line)
    {
        $this->line = $line;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $entity_code = substr($this->line, 0, 5);
        $identification_number = substr($this->line, 13, 11);
        $situation = (int) substr($this->line, 27, 2);
        $loan = (float) substr($this->line, 29, 12);

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
