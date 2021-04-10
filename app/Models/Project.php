<?php


namespace App\Models;

use App\Traits\HasDefaultImage;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    use HasDefaultImage;
    
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
}
