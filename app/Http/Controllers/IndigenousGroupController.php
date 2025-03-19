<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\IndigenousGroup;

class IndigenousGroupController extends Controller
{
    public function index(){
        return view('masterdata.indigenousgroup');
    }
    public function show()
    {
        $data = IndigenousGroup::all();
        return response()->json(['data' => $data], 200);
    }

    public function filterData(Request $request) {
        $date_from = $request->input('date_from', Carbon::now()->startOfMonth()->toDateString());
        $date_to = $request->input('date_to', Carbon::now()->toDateString());
        $name = $request->input('name');

        $query = IndigenousGroup::whereBetween('created_at', [
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
            'name' => 'required|unique:indigenous_groups,name',
        ], [], [
            'name' => 'Indigenous Group'
        ]);

        $data = new IndigenousGroup();
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Indigenous group saved successfully!'], 200);
    }

    public function edit($id)
    {
        $indigenous_groups = IndigenousGroup::find($id);
        return response()->json(['indigenous_groups' => $indigenous_groups], 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|unique:indigenous_groups,name,' . $id,
        ], [], [
            'name' => 'Indigenous Group Name',
        ]);

        $data = IndigenousGroup::where('id', $id)->first();
        $data->name = $request->name;
        $data->save();

        return response()->json(['message' => 'Indigenous group updated successfully!']);
    }

    public function destroy($id)
    {
        $data = IndigenousGroup::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => 'Indigenous group deleted successfully!']);
    }
}
