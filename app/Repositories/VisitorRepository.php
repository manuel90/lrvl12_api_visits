<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Models\Visitor;

class VisitorRepository
{
    /**
     * Get all visitors.
     */
    public function getAll()
    {
        return Visitor::all();
    }

    /**
     * Find a visitor by their ID.
     */
    public function find($id) : Visitor
    {
        return Visitor::find($id);
    }
    
    /**
     * Find a visitor by their email.
     */
    public function findByEmail($email) : Visitor | null
    {
        return Visitor::where('email', $email)->first();
    }

    /**
     * Create a new visitor record.
     */
    public function create(array $fields) : Visitor
    {
        DB::beginTransaction();

        $myVisitor = new Visitor();

        $myVisitor->name = $fields['fullname'];
        $myVisitor->email = $fields['email'];
        $myVisitor->phone = $fields['phone'] ?? null;

        $myVisitor->saveOrFail();
        
        DB::commit();

        return $myVisitor;
    }
    
    /**
     * Updates a visit.
     */
    public function update(Visitor $myVisitor, $fields): Visitor
    {
        DB::beginTransaction();

        if (isset($fields['fullname']) && $fields['fullname']) {
            $myVisitor->name = $fields['fullname'];
        }
        if (isset($fields['email']) && $fields['email']) {
            $myVisitor->email = $fields['email'];
        }
        if (isset($fields['phone']) && $fields['phone']) {
            $myVisitor->phone = $fields['phone'];
        }

        $myVisitor->saveOrFail();
        
        DB::commit();

        return $myVisitor;
    }
    
    /**
     * Deletes a visitor.
     */
    public function destroy(Visitor $myVisitor) {
        DB::beginTransaction();
        $myVisitor->deleteOrFail();
        DB::commit();
        return true;
    }
}