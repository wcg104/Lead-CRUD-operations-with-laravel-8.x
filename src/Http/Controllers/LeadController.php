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
        $lead = Lead::where('is_deleted',0)->get();
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
    public function store(Request $request)
    {
        
        $leadRequest = new StoreFormRequest();
        $validator = Validator::make(request()->all(), $leadRequest->rules(), $leadRequest->messages());

        if ($validator->fails()) {

            $response = [
                'type' => 'error',
                'code' => 422,
                'message' => "Server validation fail",
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
        }
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
    public function show($id)
    {
        $data = Lead::where('is_deleted',0)->where('id',$id)->firstOrFail();
        
        $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "data",
            'data' =>   $data
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
    public function update(Request $request, $id)
    {
        $leadRequest = new UpdateFormRequest();
        $validator = Validator::make(request()->all(), $leadRequest->rules($id), $leadRequest->messages());

        if ($validator->fails()) {

            $response = [
                'type' => 'error',
                'code' => 422,
                'message' => "Server validation fail",
                'errors' => $validator->errors()
            ];
            return response()->json($response, 422);
        }
        $data =  Lead::where('is_deleted',0)->where('id',$id)->firstOrFail();
        $data->update(request()->input());
        $response = [
            'type' => 'success',
            'code' => 200,
            'message' => "Updated",
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $remove =  Lead::where('is_deleted',0)->where('id',$id)->first();
        if($remove)
        {
            $remove->is_deleted = 1;
            $remove->save();
            
            $response = [
                'type' => 'success',
                'code' => 200,
                'message' => "Deleted Successfully",
            ];
            return response()->json($response, 200);
        }
        $response = [
            'type' => 'error',
            'code' => 500,
            'message' => "Deleted Fail",
        ];
        return response()->json($response, 500);
    }
       
}
