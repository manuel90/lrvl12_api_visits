<?php

namespace App\Services;

use App\Models\Visitor;
use App\Repositories\VisitorRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class VisitorService
{
    
    protected $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }
    
    /**
     * Returns all the visitors.
     */
    public function getAll()
    {
        return Visitor::all();
    }

    /**
     * Creates a visit.
     */
    public function create($fields): Visitor
    {
        // 0 - Performs validations
        $validator = Validator::make($fields, [
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|max:180',
            'phone' => 'nullable|string|max:100',
        ]);

        $validator->validate();
        
        return $this->visitorRepository->create($fields);
    }

    /**
     * Updates a visit.
     */
    public function update(Visitor $myVisitor, $fields): Visitor
    {
        // 0 - Performs validations
        $validator = Validator::make($fields, [
            'fullname' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:180',
            'phone' => 'nullable|string|max:100',
        ]);

        $validator->validate();

        return $this->visitorRepository->update($myVisitor, $fields);
    }
    
    
    /**
     * Creates a visitor if there's no user with the email given, 
     * otherwise the visitor will be updated with the data given.
     */
    public function createOrUpdate($fields): Visitor
    {
        // 0 - Performs validations
        $validator = Validator::make($fields, [
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|max:180',
            'phone' => 'required|string|max:100',
        ]);

        $validator->validate();
        
        $myVisitor = $this->visitorRepository->findByEmail($fields['email']);
        if(!$myVisitor) {
            $myVisitor = $this->visitorRepository->create($fields);
        } else {
            $myVisitor = $this->visitorRepository->update($myVisitor, $fields);
        }
        return $myVisitor;
    }
    
    /**
     * Deletes a visitor.
     */
    public function destroy(Visitor $myVisitor) {
        return $this->visitorRepository->destroy($myVisitor);
    }

}
