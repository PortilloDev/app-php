<?php


namespace App\Models;

use App\Traits\HasDefaultImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $table = 'jobs';

    use HasDefaultImage;
    use SoftDeletes;

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
