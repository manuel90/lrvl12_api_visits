<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\Visit;
use App\Models\Visitor;

class VisitRepository
{
    /**
     * Returns all the visits.
     */
    public function query()
    {
        return Visit::query();
    }
    
    /**
     * Returns all the visits.
     */
    public function all()
    {
        return Visit::all();
    }
    
    /**
     * Creates a visit.
     */
    public function create($fields): Visit
    {
        DB::beginTransaction();

        $myVisit = new Visit();

        $myVisit->start_date = $fields['start_date'];
        $myVisit->end_date = $fields['end_date'];
        $myVisit->description = $fields['description'];
        $myVisit->status = $fields['status'] ?? Visit::STATUS_PENDING;

        $myVisit->saveOrFail();
        
        DB::commit();

        return $myVisit;
    }
    
    
    /**
     * Updates a visit.
     */
    public function update(Visit $myVisit, $fields): Visit
    {
        DB::beginTransaction();

        if (isset($fields['start_date']) && $fields['start_date']) {
            $myVisit->start_date = $fields['start_date'];
        }
        if (isset($fields['end_date']) && $fields['end_date']) {
            $myVisit->end_date = $fields['end_date'];
        }
        if (isset($fields['description']) && $fields['description']) {
            $myVisit->description = $fields['description'];
        }
        if (isset($fields['status']) && $fields['status']) {
            $myVisit->status = $fields['status'];
        }

        $myVisit->saveOrFail();
        
        DB::commit();

        return $myVisit;
    }
    
    /**
     * Deletes a visit.
     */
    public function destroy(Visit $myVisit) {
        DB::beginTransaction();
        $myVisit->deleteOrFail();
        DB::commit();
        return true;
    }
    
    /**
     * Add a visitor to a visit.
     */
    public function addVisitor(Visit $visit, Visitor $visitor): bool
    {
        DB::beginTransaction();
        $foundVisitor = $visit->visitors()->find($visitor->id);
        if (!$foundVisitor) {
            $visit->visitors()->attach($visitor->id);
        }
        DB::commit();
        return true;
    }
}