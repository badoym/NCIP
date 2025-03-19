<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GovernmentProgram;

class GovernmentProgramController extends Controller
{
    public function index(){
        return view('masterdata.governmentprogram');
    }
    public function show(){
        
        $data = GovernmentProgram::where('status', '!=', 2)->get();
        return response()->json(['data' => $data], 200);
    }

    public function filterData(Request $request) {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $name = $request->input('name');

        $query = GovernmentProgram::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);

        if (!empty($name)) {
            $query->where('name',  'like', '%' . $name . '%');
        }
        $data = $query->get();
        return response()->json(['data'=> $data], 200);
    }
    
    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:government_programs,name',
            // 'start_date'  => 'required',
            // 'end_date' => 'required',
        
        ], [], [
            'name' => 'Program',
            // 'start_date'  => 'Start Date',
            // 'end_date' => 'End Date',
        ]);

        $obj = [
            'name' => $request->name,
            'description' => $request->description,
            // 'start_date' => $request->start_date,
            // 'end_date' => $request->end_date,
            'created_by' => Auth()->user()->id,
            'status' => 1,
        ];

        GovernmentProgram::create($obj);
        return response()->json(['message' => 'Data successfully saved'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:government_programs,name,' . $id,
            // 'start_date'  => 'required',
            // 'end_date' => 'required',
        ], [], [
            'name' => 'Program',
            // 'start_date'  => 'Start Date',
            // 'end_date' => 'End Date',
        ]);

        $data = GovernmentProgram::find($id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->status = $request->status;
        // $data->start_date = $request->start_date;
        // $data->end_date = $request->end_date;
        $data->updated_by = Auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'Program updated successfully!']);
    }

    public function destroy($id)
    {
        $data = GovernmentProgram::where('id', $id)->first();
        $data->status = 2;
        $data->save();

        return response()->json(['message' => 'Program deleted successfully!']);
    }
}
