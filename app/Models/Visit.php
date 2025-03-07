<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Traits\DateTimeSerialize;

class Visit extends Model
{
    /** @use HasFactory<\Database\Factories\VisitFactory> */
    use HasFactory, DateTimeSerialize;

    const STATUS_ACTIVE = 'A';
    const STATUS_INACTIVE = 'I';
    const STATUS_PENDING = 'P';
    const STATUS_CANCELLED = 'C';

    const STATUS_ALLOWS = [
        'A',
        'I',
        'P',
        'C',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'description',
        'status',
    ];


    /**
     * The visitor that belong to the visit.
     */
    public function visitors(): BelongsToMany
    {
        return $this->belongsToMany(Visitor::class, 'visit_visitor')->withTimestamps();
    }
}
