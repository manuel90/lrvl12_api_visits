<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Services\VisitorService;
use App\Services\VisitService;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    /**
     * GET /api/visits
     * Return all the visits.
     * */
    public function index(Request $request, VisitService $myVisitService)
    {
        $relations = $request->query('relations', '');
        return $myVisitService->getAll($relations);
    }
    
    /**
     * POST /api/visits
     * Creates a visit.
     * */
    public function create(Request $request, VisitService $myVisitService)
    {

        # Creating a Visit.
        $fields = $request->only([
           'start_date', 
           'end_date', 
           'description', 
           'status', 
        ]);
        return $myVisitService->create($fields);
    }
    
    /**
     * PUT /api/visits
     * Creates a visit.
     * */
    public function update(Request $request, Visit $id, VisitService $myVisitService)
    {

        # Updating a Visit.
        $fields = $request->only([
           'start_date', 
           'end_date', 
           'description', 
           'status', 
        ]);
        return $myVisitService->update($id, $fields);
    }
    
    /**
     * GET /api/visits/{id}
     * Returns a visit.
     * */
    public function get(Request $request, Visit $id)
    {
        return $id;
    }
    
    /**
     * DELETE /api/visits/{id}
     * Deletes a visit.
     * */
    public function destroy(Request $request, Visit $id, VisitService $myVisitService)
    {
        $myVisitService->destroy($id);
        
        return $this->ok(__("Deleted."));
    }
    
    /**
     * POST /api/visits/{id}/visitors
     */
    public function createVisitor(Request $request, Visit $id, VisitService $myVisitService,  VisitorService $myVisitorService) {
        
        # 0 - Creates/Update a visitor
        $fields = $request->only([
            'fullname',
            'email',
            'phone',
        ]);
        $visitor = $myVisitorService->createOrUpdate($fields);
        
        # 1 - Add the visitor to the visit
        $myVisitService->addVisitor($id, $visitor);
        
        return $this->ok(__("Added."));
    }
}
