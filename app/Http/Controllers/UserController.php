<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('masterdata.user');
    }

    public function show()
    {
        $data = User::where('user_type', 0)->get();
        return response()->json(['data' => $data], 200);
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

    public function store(Request $request)
    {
 
        $isUpdate = isset($request->id);

        $rule = [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id), // Ignore the current user ID during update
            ],
            'password' => $isUpdate ? 'nullable' : 'required|min:8|confirmed',
        ];
        $validated = $request->validate(
            $rule,
            [
                'name.required' => 'Full Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email is invalid.',
                'email.unique' => 'Email is already used.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Passwords do not match.',
            ]
        );

        if (isset($request->id)) {
            $user = User::find($request->id);
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'user_type' => 0,
            ]);
        }
        return response()->json(['message' => 'New User Created!'], 200);
    }
    public function destroy($id)
    {
        $destroy = User::where('id', $id)->delete();

        if ($destroy) {
            return response()->json(['message' => 'User Succesfully Deleted!'], 200);
        }
    }
    public function changePassword(Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = User::where('id', $request->id)->first();
        $data->password = bcrypt($request->password);
        $data->save();

        return response()->json(['message' => 'Password Updated!'], 200);
    }
}
