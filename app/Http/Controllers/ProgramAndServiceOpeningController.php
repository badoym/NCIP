<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Models\GovernmentProgram;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramServicesPool;
use App\Models\UserApplication;

class ProgramAndServiceOpeningController extends Controller
{
    public function index()
    {
        return view('main.programandservicesopening');
    }
    public function onchangeOpening($id)
    {
        $data = [];
        switch ($id) {
            case 1:
                $data = GovernmentProgram::where('status', 1)->get();
                break;
            case 2:
                $data = Services::where('status', 1)->get();
                break;
        }
        return response()->json(['data' => $data], 200);
    }
    public function filter(Request $request)
    {

        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        // $name = $request->input('name');
        $opening_type = $request->input('filter_opening_type');


        $query = ProgramServicesPool::leftJoin('government_programs', 'program_services_pools.government_program_id', 'government_programs.id')
            ->leftJoin('services', 'program_services_pools.service_id', 'services.id')
            ->select('program_services_pools.*', DB::raw("COALESCE(services.name, government_programs.name) as name"), DB::raw("COALESCE(services.description, government_programs.description) as description"), DB::raw("DATEDIFF(program_services_pools.start_date, NOW()) as remaining_days"))
            ->orderBy('name')
            ->orderBy('program_services_pools.start_date')
            ->where('cancelled', 0)
            ->whereBetween('program_services_pools.created_at', [
                Carbon::parse($date_from)->startOfDay(),
                Carbon::parse($date_to)->endOfDay()
            ]);

        switch ($opening_type) {
            case 1:
                $query->whereNotNull('program_services_pools.government_program_id');
                break;
            case 2:
                $query->whereNotNull('program_services_pools.service_id');
                break;
        }
        // if (!empty($name)) {
        //     $query->where('name',  'like', '%' . $name . '%');
        // }
        $data = $query->get()
            ->map(function ($item) {
                $item->total_applications = UserApplication::where('program_services_pool_id', $item->id)->count();
                return $item;
            });
        return response()->json(['data' => $data], 200);
    }
    public function show()
    {

        $data = ProgramServicesPool::leftJoin('government_programs', 'program_services_pools.government_program_id', 'government_programs.id')
            ->leftJoin('services', 'program_services_pools.service_id', 'services.id')
            ->select('program_services_pools.*', DB::raw("COALESCE(services.name, government_programs.name) as name"), DB::raw("COALESCE(services.description, government_programs.description) as description"), DB::raw("DATEDIFF(program_services_pools.start_date, NOW()) as remaining_days"))
            ->orderBy('name')
            ->where('cancelled', 0)
            ->get()
            ->map(function ($item) {
                $item->total_applications = UserApplication::where('program_services_pool_id', $item->id)->count();
                return $item;
            });


        return response()->json(['data' => $data], 200);
    }
    public function store(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ], [], [
            'id' => 'Program/Services',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ]);


        try {

            DB::beginTransaction();


            switch ($request->opening_type) {
                case 1:
                    $data = new ProgramServicesPool();
                    $data->government_program_id  = $request->id;

                    break;
                case 2:
                    $data = new ProgramServicesPool();
                    $data->service_id   = $request->id;
                    break;
            }

            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            $data->created_by = Auth()->user()->id;
            $data->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'error', 'err_mess' => $e], 500);
        }

        return response()->json(['message' => 'success'], 200);
    }
    public function applicants($id)
    {
        $data = UserApplication::where('program_services_pool_id', $id)
            ->leftJoin('users', 'user_applications.user_id', 'users.id')
            ->leftJoin('user_information', 'users.id', 'user_information.user_id')
            ->leftJoin('indigenous_groups', 'indigenous_groups.id', 'user_information.indigenous_group_id')
            ->leftJoin('regions', 'regions.id', 'user_information.region_id')
            ->leftJoin('provinces', 'provinces.id', 'user_information.province_id')
            ->leftJoin('cities', 'cities.id', 'user_information.city_id')
            ->leftJoin('barangays', 'barangays.id', 'user_information.barangay_id')
            ->select(
                'user_applications.*',
                'users.name',
                'indigenous_groups.name as group',
                DB::raw("
                    CONCAT(
                        COALESCE(address1, address2, ''), ' ',
                        COALESCE(barangays.name, '') , ', ',
                        COALESCE(cities.name, ''), ', ',
                        COALESCE(provinces.name, ''), ', ',
                        COALESCE(regions.name, '')
                        ) 
                        as address")
            )
            ->get();

        return response()->json(['data' => $data], 200);
    }
    public function cancelProgram($id)
    {

        $data = ProgramServicesPool::where('id',  $id)->first();
        $data->cancelled =  1;
        $data->cancelled_by = Auth()->user()->id;
        $data->save();

        return response()->json(['message' => 'success'], 200);
    }
}
