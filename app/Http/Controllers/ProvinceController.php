<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        $provinces = Province::all();
        return view('masterdata.provinces', compact('regions', 'provinces'));
    }

    public function show()
    {
        $data = Province::with('region')->get()
            ->map(function ($item) {
                $item->region_name = $item->region->name;
                return $item;
            });

        return response()->json(['data' => $data], 200);
    }

    public function filterData(Request $request)
    {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $region_id = $request->input('region_id');
        $name = $request->input('name');

        $query = Province::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);

        if (!empty($region_id)) {
            $query->where('region_id', $region_id);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $data = $query->with('region')->get()
            ->map(function ($item) {
                $item->region_name = $item->region->name;
                return $item;
            });

        return response()->json(['data' => $data]);
    }

    public function onChangeProvinces($id)
    {
        $provinces = Province::where('region_id', $id)->get();

        return response()->json(['data' => $provinces]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required',
            'name' => 'required|unique:provinces,name',
        ], [], [
            'region_id' => 'Region',
            'name' => 'Province'
        ]);

        $data = new Province();
        $data->region_id = $request->region_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Province saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = Province::find($id);
        if (!$data) {
            return response()->json(['message' => 'Province not found!'], 404);
        }

        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'region_id' => 'required',
            'name' => 'required|unique:provinces,name,' . $id,
        ], [], [
            'region_id' => 'Region',
            'name' => 'Province'
        ]);

        $data = Province::find($id);
        if (!$data) {
            return response()->json(['message' => 'Province not found!'], 404);
        }

        $data->region_id = $request->region_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Province updated successfully!'], 200);
    }

    public function destroy($id)
    {
        $data = Province::find($id);
        if (!$data) {
            return response()->json(['message' => 'Province not found!'], 404);
        }

        $data->delete();
        return response()->json(['message' => 'Province deleted successfully!'], 200);
    }
}
