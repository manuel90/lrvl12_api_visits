<?php


namespace App\Models\Traits;

use DateTimeInterface;

trait DateTimeSerialize {
    
    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format($this->getDateFormat());
    }
}