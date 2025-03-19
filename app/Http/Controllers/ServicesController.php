<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\GovernmentProgram;

class ServicesController extends Controller
{
    public function index()
    {
        $governmentprograms = GovernmentProgram::where('status', 1)->get();
        return view('masterdata.services', compact('governmentprograms'));
    }
    public function show()
    {
        $data = Services::with('governmentProgram')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'government_program' => $item->governmentProgram->name ?? 'N/A',
                    'government_program_id' => $item->governmentProgram->id ?? '',
                    'status' => $item->status,
                ];
            });

        return response()->json(['data' => $data], 200);
    }
    public function filterData(Request $request)
    {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $name = $request->input('name');

        $query = Services::with('governmentProgram')
            ->whereBetween('created_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);

        if (!empty($name)) {
            $query->where('name',  'like', '%' . $name . '%');
        }
        $data = $query->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'government_program' => $item->governmentProgram->name ?? '',
                    'government_program_id' => $item->governmentProgram->id ?? '',
                    'status' => $item->status,
                ];
            });
        return response()->json(['data' => $data], 200);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:services,name',
            'description' => 'required',
        ]);

        $obj = [
            'name' => $request->name,
            'description' => $request->description,
            'government_program_id' => $request->government_program_id,
            'status' => 1,
            'created_by' => Auth()->user()->id,
        ];

        Services::create($obj);

        return response()->json(['message' => 'suuccess'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:services,name,' . $id,
            'description' => 'required',
        ]);

        $obj = [
            'name' => $request->name,
            'description' => $request->description,
            'government_program_id' => $request->government_program_id,
            'status' => $request->status,
            'updated_by' => Auth()->user()->id,
        ];

        Services::where('id', $id)->update($obj);

        return response()->json(['message' => 'suuccess'], 200);
    }
}
