<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Http\Requests\Lead\StoreFormRequest;
use App\Http\Requests\Lead\UpdateFormRequest;
use Illuminate\Support\Facades\Validator;

class LeadController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lead = Lead::paginate(10);
        $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "List",
            'data' => $lead
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {        
              $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "Created",
            'data' =>  Lead::create(request()->input())
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {        
        $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "data",
            'data' =>   $lead
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Lead $lead)
    {
    
        $lead->update(request()->input());
        $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "Updated",
            'data' => $lead
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
            $lead->is_deleted = 1;
            $lead->save();
            
            $response = [
                'type' => 'success',
                'code' => 200,
                'message' => "Deleted Successfully",
            ];
            return response()->json($response, 200);
        
    }
       
}
