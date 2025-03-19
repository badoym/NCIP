<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return view('masterdata.regions');
    }

    public function show()
    {
        $data = Region::all();
        return response()->json(['data' => $data], 200);
    }

    public function filterData(Request $request) {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $name = $request->input('name');

        $query = Region::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);

        if (!empty($name)) {
            $query->where('name',  'like', '%' . $name . '%');
        }

        $data = $query->get();

        return response()->json(['data'=> $data], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:regions,name',
        ], [], [
            'name' => 'Region'
        ]);

        $data = new Region();
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Region saved successfully!'], 200);
    }

    public function edit($id)
    {
        $regions = Region::find($id);
        return response()->json(['regions' => $regions], 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|unique:regions,name,' . $id,
        ], [], [
            'name' => 'Region Name',
        ]);

        $data = Region::where('id', $id)->first();
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Region updated successfully!']);
    }

    public function destroy($id)
    {
        $data = Region::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Region deleted successfully!']);
    }
}
