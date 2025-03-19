<?php

namespace App\Http\Controllers;

use App\Models\IndigenousGroup;
use App\Models\Region;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use Illuminate\Support\Facades\DB;

class IndigenousPeopleMasterlistController extends Controller
{

    public function index()
    {

        return view('main.indigenouspeoplemasterlist');
    }

    public function show()
    {
        $indigenous_group = IndigenousGroup::get();
        $data = User::where('user_type', 1)
            ->leftJoin('user_information', 'user_information.user_id', 'users.id')
            ->select('users.*', 'user_information.is_verified', 'user_information.id as user_information_id')
            ->get();
        $regions = Region::get();
        return response()->json(['data' => $data, 'indigenous_group' => $indigenous_group, 'regions' => $regions], 200);
    }
    public function filter(Request $request)
    {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $name = $request->input('name');

        $query = User::whereBetween('created_at', [
            Carbon::parse($date_from)->startOfDay(),
            Carbon::parse($date_to)->endOfDay()
        ]);
        if (!empty($name)) {
            $query->where('name',  'like', '%' . $name . '%');
        }

        $data = $query->get();
        return response()->json(['data' => $data], 200);
    }
    public function view($id)
    {
        $data = UserInformation::where('user_information.user_id', $id)
            ->leftJoin('users', 'users.id', 'user_information.user_id')
            ->leftJoin('regions', 'regions.id', 'user_information.region_id')
            ->leftJoin('provinces', 'provinces.id', 'user_information.province_id')
            ->leftJoin('cities', 'cities.id', 'user_information.city_id')
            ->leftJoin('barangays', 'barangays.id', 'user_information.barangay_id')
            ->leftJoin('indigenous_groups', 'indigenous_groups.id', 'user_information.indigenous_group_id')
            ->select('user_information.*', 'users.name', DB::raw('CONCAT(COALESCE(address1,address2), barangays.name, cities.name, provinces.name, regions.name)'))
            ->first();

        return response()->json(['data' => $data], 200);
    }
    public function action($id, $val)
    {
        $data = UserInformation::where('id', $id)->first();
        $data->is_verified = $val;
        $data->save();

        return response()->json(['message' => 'Status Updated'], 200);
    }
}
