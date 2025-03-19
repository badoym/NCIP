<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('masterdata.cities', compact('regions'));
    }

    public function getProvincesByRegion($id)
    {
        $provinces = Province::where('region_id', $id)->get();
        return response()->json(['provinces' => $provinces],200);
    }

    public function show()
    {
        $data = City::with(['province.region'])
        ->get()
        ->map(function ($item) {
            $item->region_name = $item->Province->Region->name ?? null;
            $item->province_name = $item->Province->name ?? null;
            return $item;
        });

        return response()->json(['data' => $data], 200);
    }

    public function filterData(Request $request) {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $region_id = $request->input('region_id');
        $province_id = $request->input('province_id');
        $name = $request->input('name');

        $query = City::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);

        if (!empty($region_id)) {
            $query->where('region_id', $region_id);
        }
        if (!empty($province_id)) {
            $query->where('province_id', $province_id);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $data = $query->with('province.region')->get()
            ->map(function ($item) {
                $item->region_name = $item->province->region->name;
                $item->province_name = $item->province->name;
                return $item;
            });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'province_id' => 'required|exists:provinces,id',
            'name' => [
                'required',
                Rule::unique('cities', 'name')
                    ->where('province_id', $request->province_id)
                    ->where('region_id', $request->region_id),
            ],
        ], [], [
            'region_id' => 'Region',
            'province_id' => 'Province',
            'name' => 'City'
        ]);

        $data = new City();
        $data->region_id = $request->region_id;
        $data->province_id = $request->province_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'City/Municipality saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = City::with(['Province.Region'])->where('id', $id)->first();
        // dd($data);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id) {
        $request -> validate([
            'region_id' => 'required',
            'province_id' => 'required',
            'name' => [
                'required',
                Rule::unique('cities', 'name')
                    ->where('province_id', $request->province_id)
                    ->where('region_id', $request->region_id)
                    ->ignore($id),
            ],
        ], [], [
            'region_id' => 'Region',
            'province_id' => 'Province',
            'name' => 'City/Municipality',
        ]);

        $data = City::find($id);
        $data -> region_id = $request -> region_id;
        $data -> province_id = $request -> province_id;
        $data -> name = $request -> name;
        $data -> save();

        return response()->json(['message' => 'City/Municipality updated successfully!'], 200);
    }

    public function destroy($id) {
        $data = City::find($id);
        if (!$data) {
            return response()->json(['message' => 'City/Municipality not found!'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'City/Municipality deleted successfully!'], 200);
    }
}
