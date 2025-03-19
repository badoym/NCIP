<?php

namespace App\Http\Controllers;

use App\Models\IndigenousGroup;
use App\Models\Region;
use App\Models\UserInformation;
use Illuminate\Http\Request;

class UserInformationController extends Controller
{
    public function index()
    {
        $indigenous_group = IndigenousGroup::get();
        $regions = Region::get();
        $user = Auth()->user();

        return view('webusers.profileinformation', compact('indigenous_group', 'regions', 'user'));
    }
    public function show()
    {
        $user = Auth()->user();
        $data = UserInformation::where('user_id', $user->id)->first();
        return response()->json(['data' => $data], 200);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'birthday' => 'required',
            'phone_number' => 'required',
            'indigenous_group_id' => 'required',
            'region_id' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'barangay_id' => 'required',
            'email_address' => 'email',


            'tribe_name' => 'required',
            'ethno_group' => 'required',
            'settlement_name' => 'required',
            'ind_region_id' => 'required',
            'ind_province_id' => 'required',
            'ind_city_id' => 'required',
            'ind_barangay_id' => 'required',
            'fatherName' => 'required',
            'motherName' => 'required',
            'communityRole' => 'required',
            'livelihood' => 'required',
            'education' => 'required',
            'skills' => 'required',
        ], [], [
            'name' => 'name',
            'gender' => 'gender',
            'age' => 'age',
            'birthday' => 'birthday',
            'phone_number' => 'phone number',
            'indigenous_group_id' => 'indigenous group',
            'region_id' => 'region',
            'province_id' => 'province',
            'city_id' => 'city',
            'barangay_id' => 'barangay',
            'email_address' => 'Email Address',

            'tribe_name' => 'Indigenous Group/Tribe',
            'ethno_group' => 'Ethnolinguistic Group',
            'settlement_name' => 'required',
            'ind_region_id' => 'required',
            'ind_province_id' => 'required',
            'ind_city_id' => 'required',
            'ind_barangay_id' => 'required',
            'fatherName' => 'required',
            'fatherIndigenous' => 'required',
            'motherName' => 'required',
            'motherIndigenous' => 'required',
            'spouseName' => 'required',
            'communityRole' => 'required',
            'livelihood' => 'required',
            'education' => 'required',
            'skills' => 'required',
        ]);

        $data = $request->id != null ?  UserInformation::where('id', $request->id)->first() : new UserInformation();
        $data->user_id = $request->user_id;
        $data->gender = $request->gender;
        $data->age = $request->age;
        $data->birthday = $request->birthday;
        $data->phone_number = $request->phone_number;
        $data->indigenous_group_id = $request->indigenous_group_id;
        $data->region_id  = $request->region_id;
        $data->province_id = $request->province_id;
        $data->city_id    = $request->city_id;
        $data->barangay_id = $request->barangay_id;
        $data->address1 = $request->address1;
        $data->address2  = $request->address2;
        $data->tribe_name = $request->tribe_name;
        $data->ethno_group = $request->ethno_group;
        $data->settlement_name = $request->settlement_name;
        $data->ind_region_id = $request->ind_region_id;
        $data->ind_province_id = $request->ind_province_id;
        $data->ind_city_id = $request->ind_city_id;
        $data->ind_barangay_id = $request->ind_barangay_id;
        $data->fatherName = $request->fatherName;
        $data->fatherIndigenous = $request->fatherIndigenous;
        $data->motherName = $request->motherName;
        $data->motherIndigenous = $request->motherIndigenous;
        $data->spouseName = $request->spouseName;
        $data->communityRole = $request->communityRole;
        $data->livelihood = $request->livelihood;
        $data->education = $request->education;
        $data->skills = $request->skills;
        $data->full_name = $request->name;


        $data->ipOrganization = $request->ipOrganization;
        $data->governmentAssistance = $request->governmentAssistance;
        $data->ipmrStatus = $request->ipmrStatus;
        $data->organizationAffiliation = $request->organizationAffiliation;
        $data->traditionalPractices = $request->traditionalPractices;
        $data->landmark = $request->landmark;
        $data->email_address = $request->email_address;
        $data->traditional_name = $request->traditional_name;
        $data->alias = $request->alias;
        $data->civil_status = $request->civil_status;
        $data->save();

        return response()->json(['message' => 'success'], 200);
    }
}
