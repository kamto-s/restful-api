<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::select('id', 'name', 'email', 'age')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new User;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'age' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data',
                'data' => $validator->errors(),
            ], 422);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->age = $request->age;
        $data->password = Hash::make('password');
        $data->save();

        $data = $data->only(['id', 'name', 'email', 'age']);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);

        if ($data) {
            $filterData = $data->only(['id', 'name', 'email', 'age']);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diambil',
                'data' => $filterData,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ]);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $data->id,
            'age' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah data',
                'data' => $validator->errors(),
            ], 422);
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->age = $request->age;
        $data->save();

        $data = $data->only(['id', 'name', 'email', 'age']);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ]);
        } else {
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
                'data' => null,
            ]);
        }
    }
}
