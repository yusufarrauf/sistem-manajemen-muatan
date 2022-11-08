<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\VendorKendaraan;
use Illuminate\Support\Facades\Hash;

class VendorKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VendorKendaraan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50|unique:vendor_kendaraans',
            'username' => 'required|max:20|unique:vendor_kendaraans',
            'password' => 'required|min:6',
        ]);
        VendorKendaraan::create([
            'nama' => strtoupper($request['nama']),
            'alamat' => $request['alamat'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);
        return User::create([
            'username' => strtolower($request['username']),
            'name' => $request['nama'],
            'level' => 'GUEST',
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vendor = VendorKendaraan::findOrFail($id);
        $user = User::where('username', '=', $vendor->username)->first();
        $this->validate($request, [
            'nama' => 'required|max:50|unique:vendor_kendaraans,nama,'.$vendor->id,
            'username' => 'required|max:20|unique:vendor_kendaraans,username,'.$vendor->id,
            'password' => 'required|min:6',
        ]);
        $vendor->update([
            'nama' => strtoupper($request['nama']),
            'alamat' => $request['alamat'],
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);
        $user->update([
            'username' => strtolower($request['username']),
            'name' => $request['nama'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = VendorKendaraan::findOrFail($id);
        $user = User::where('name', '=', $vendor->nama)->first();
        $vendor->delete();
        $user->delete();
    }
}
