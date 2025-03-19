<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use App\Models\Barangay;
use App\Models\Province;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangayController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('masterdata.barangays', compact('regions'));
    }

    public function getProvincesByRegion($id)
    {
        $provinces = Province::where('region_id', $id)->get();
        return response()->json(['provinces' => $provinces], 200);
    }

    public function getCitiesByProvince($id)
    {
        $cities = City::where('province_id', $id)->get();
        return response()->json(['cities' => $cities], 200);
    }

    public function getBarangayByCities($id)
    {
        $barangays = Barangay::where('city_id', $id)->get();
        return response()->json(['barangays' => $barangays], 200);
    }

    public function show()
    {
        $data = Barangay::with(['City.Province.Region'])
            ->get()
            ->map(function ($item) {
                $item->region_name = $item->Province->Region->name ?? null;
                $item->province_name = $item->Province->name ?? null;
                $item->city_name = $item->City->name ?? null;
                return $item;
            });

        return response()->json(['data' => $data], 200);
    }
    public function filterData(Request $request)
    {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $region_id = $request->input('region_id');
        $province_id = $request->input('province_id');
        $city_id = $request->input('city_id');
        $name = $request->input('name');

        $query =  Barangay::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);

        if (!empty($region_id)) {
            $query->where('region_id', $region_id);
        }
        if (!empty($province_id)) {
            $query->where('province_id', $province_id);
        }
        if (!empty($city_id)) {
            $query->where('city_id', $city_id);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $data = $query->with('province.region')->get()
            ->map(function ($item) {
                $item->region_name = $item->province->region->name;
                $item->province_name = $item->province->name;
                $item->city_name = $item->city->name;
                return $item;
            });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'name' => [
                'required',
                Rule::unique('barangays', 'name')
                    ->where('city_id', $request->city_id)
                    ->where('province_id', $request->province_id)
                    ->where('region_id', $request->region_id),
            ],
        ], [], [
            'region_id' => 'Region',
            'province_id' => 'Province',
            'city_id' => 'City',
            'name' => 'Barangay'
        ]);

        $data = new Barangay();
        $data->region_id = $request->region_id;
        $data->province_id = $request->province_id;
        $data->city_id = $request->city_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Barangay saved successfully!']);
    }

    public function edit($id)
    {
        $data = Barangay::with(['City.Province.Region'])->where('id', $id)->first();
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'region_id' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'name' => [
                'required',
                Rule::unique('barangays', 'name')
                    ->where('city_id', $request->city_id)
                    ->where('province_id', $request->province_id)
                    ->where('region_id', $request->region_id)
                    ->ignore($id),
            ],
        ], [], [
            'region_id' => 'Region',
            'province_id' => 'Province',
            'city_id' => 'City',
            'name' => 'Barangay'
        ]);

        $data = Barangay::find($id);
        if (!$data) {
            return response()->json(['error' => 'Barangay not found.'], 404);
        }
        $data->region_id = $request->region_id;
        $data->province_id = $request->province_id;
        $data->city_id = $request->city_id;
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Barangay updated successfully!']);
    }

    public function destroy($id)
    {
        $data = Barangay::find($id);
        if (!$data) {
            return response()->json(['message' => 'Barangay not found!'], 404);
        }
        $data->delete();
        return response()->json(['message' => 'Barangay deleted successfully!']);
    }
}
