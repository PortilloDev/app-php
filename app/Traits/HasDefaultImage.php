<?php

namespace App\Traits;


trait HasDefaultImage
{
    public function getImage($altText)
    {
        if(!$this->file) {
            return "https://ui-avatars.com/api/?name=$altText&size=50";
        }else {

            return $this->file;
        }
    }
}
