<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Services\VisitorService;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * GET /api/visitors
     * Return all the visitors.
     * */
    public function index(Request $request, VisitorService $myVisitorService)
    {
        return $myVisitorService->getAll();
    }
    
    /**
     * POST /api/visitors
     * Creates a visitor.
     * */
    public function create(Request $request, VisitorService $myVisitorService)
    {

        # Creating a Visit.
        $fields = $request->only([
           'fullname', 
           'email', 
           'phone', 
        ]);
        $myVisitorService->create($fields);

        return $this->ok(__("Created."));
    }
    
    /**
     * PUT /api/visitors
     * Creates a visitor.
     * */
    public function update(Request $request, Visitor $id, VisitorService $myVisitorService)
    {

        # Updating a Visit.
        $fields = $request->only([
           'fullname', 
           'email', 
           'phone', 
        ]);
        $myVisitorService->update($id, $fields);

        return $this->ok(__("updated."));
    }
    
    /**
     * GET /api/visitors/{id}
     * Returns a visitor.
     * */
    public function get(Request $request, Visitor $id)
    {
        return $id;
    }
    
    /**
     * DELETE /api/visitors/{id}
     * Deletes a visitor.
     * */
    public function destroy(Request $request, Visitor $id, VisitorService $myVisitorService)
    {
        $myVisitorService->destroy($id);
        
        return $this->ok(__("Deleted."));
    }
}
