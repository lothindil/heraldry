<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    public function admin_access()
    {
        return view('auth.admin');
    }
    public function admin_login(Request $request)
    {
        if(Hash::check($request->pass,'$2y$10$OD4SLRCeXJt2ejsC0D0ACeW5BDWIMc3OGv4ocwPTxEeorrAXrz.D6'))
        {
            $user=new User;
            $user->name="admin";
            $user->email="admin@admin.com";
            $user->password='d';
            Auth::login($user, $remember = true);
            return redirect()->route('new_meuble');
        }
        return redirect()->route('welcome');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
