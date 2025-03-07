<?php

namespace App\Services;

use App\Models\Visit;
use App\Models\Visitor;
use App\Repositories\VisitRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class VisitService
{

    protected $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }
    
    /**
     * Returns all the visits.
     */
    public function getAll($relations = '')
    {
        
        // 0 - Perform validations.
        $validator = Validator::make([
        'relations' => $relations,
        ], [
        'relations' => 'nullable|string',
        ]);
        $validator->validate();
        
        // 1 - Parse the relations string into an array.
        $relations = explode(',', $relations);
        $relations = array_map('trim', $relations);
        $relations = array_filter($relations);
        $relations = array_unique($relations);
        
        // 2 - Include the relations in the query
        $query = $this->visitRepository->query();
        
        if(in_array('visitors', $relations)) {
            $query->with(['visitors']);
        }
        // 3 - Return query result 
        return $query->get();
    }

    /**
     * Creates a visit.
     */
    public function create($fields): Visit
    {
        // 0 - Performs validations
        $validator = Validator::make($fields, [
            'start_date' => 'required|date:Y-m-d H:i:s',
            'end_date' => 'required|date:Y-m-d H:i:s',
            'description' => 'required|string|max:200',
            'status' => [
                'nullable',
                Rule::in(Visit::STATUS_ALLOWS),
            ],
        ]);

        $validator->validate();

        return $this->visitRepository->create($fields);
    }

    /**
     * Updates a visit.
     */
    public function update(Visit $myVisit, $fields): Visit
    {
        // 0 - Performs validations
        $validator = Validator::make($fields, [
            'start_date' => 'nullable|date:Y-m-d H:i:s',
            'end_date' => 'nullable|date:Y-m-d H:i:s',
            'description' => 'nullable|string|max:200',
            'status' => [
                'nullable',
                Rule::in(Visit::STATUS_ALLOWS),
            ],
        ]);

        $validator->validate();

        return $this->visitRepository->update($myVisit, $fields);
    }
    
    /**
     * Deletes a visit.
     */
    public function destroy(Visit $myVisit) {
        return $this->visitRepository->destroy($myVisit);
    }

    /**
     * Add a visitor to a visit.
     */
    public function addVisitor(Visit $visit, Visitor $visitor): bool
    {
        return $this->visitRepository->addVisitor($visit, $visitor);
    }
}
