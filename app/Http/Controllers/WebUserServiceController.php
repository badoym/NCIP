<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Models\UserInformation;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramServicesPool;

class WebUserServiceController extends Controller
{
    public function index()
    {
        return view('webusers.services');
    }
    public function show()
    {
        $data = ProgramServicesPool::leftJoin('government_programs', 'program_services_pools.government_program_id', 'government_programs.id')
            ->leftJoin('services', 'program_services_pools.service_id', 'services.id')
            ->whereNotIn('program_services_pools.id', UserApplication::where('user_id', Auth()->user()->id)->pluck('program_services_pool_id'))
            ->whereNotNull('program_services_pools.service_id')
            ->select('program_services_pools.*', DB::raw("COALESCE(services.name, government_programs.name) as name"), DB::raw("COALESCE(services.description, government_programs.description) as description"), DB::raw("DATEDIFF(program_services_pools.start_date, NOW()) as remaining_days"))
            ->orderBy('name')
            ->where('cancelled', 0)
            ->orderBy('program_services_pools.start_date')
            ->get();
        $has_personal_info = UserInformation::where('user_id', Auth()->user()->id)->exists();
        return response()->json(['data' => $data, 'has_personal_info' => $has_personal_info], 200);
    }
    public function apply($id)
    {
        $data = new UserApplication();
        $data->user_id = Auth()->user()->id;
        $data->program_services_pool_id  = $id;
        $data->date_applied = Carbon::now();
        $data->save();
        return response()->json(['message' => 'success'], 200);
    }
    public function servicesApplied(){

        $data = ProgramServicesPool::leftJoin('government_programs', 'program_services_pools.government_program_id', 'government_programs.id')
        ->leftJoin('services', 'program_services_pools.service_id', 'services.id')
        ->whereIn('program_services_pools.id', UserApplication::where('user_id', Auth()->user()->id)->pluck('program_services_pool_id'))
        ->whereNotNull('program_services_pools.service_id')
        ->select('program_services_pools.*',  DB::raw("COALESCE(services.name, government_programs.name) as name"), DB::raw("COALESCE(services.description, government_programs.description) as description"), DB::raw("DATEDIFF(program_services_pools.start_date, NOW()) as remaining_days"))
        ->orderBy('name')
        ->where('cancelled', 0)
        ->orderBy('program_services_pools.start_date')
        ->get();


        return response()->json(['data' => $data], 200);
    }
    public function cancelServicesApplied($id){

        UserApplication::where('program_services_pool_id', $id)->where('user_id', Auth()->user()->id )->delete();

        return response()->json(['messsage' => 'success'], 200);

    }
}
