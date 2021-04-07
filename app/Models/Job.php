<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $table = 'jobs';


    public function getDurationAsString()
    {
        $years = floor($this->months / 12);
        $extraMonths = $this->months % 12;

        if ($extraMonths != 0 && $years != 0) {
            return "Job duration: $years years $extraMonths months";
        } elseif ($extraMonths == 0) {
            return "Job duration: $years years ";
        } elseif ($years == 0) {
            return "Job duration: $extraMonths months";
        }
    }

    public function getDescription()
    {
        return $this->description;
    }
}
