<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();

        $message    = ['message' => [__('User list')]];
        $status     = 'success';
        $data       = $user;

        return response([
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only([
            'first_name',
            'last_name',
            'email',
        ]);

        $validation = Validator::make($credentials,[
            'email'             => 'required|max:250|email|unique:users,email',
            'first_name'        => 'required|max:150|min:3|string',
            'last_name'         => 'sometimes|required|max:150|min:3|string',
        ]);


        if (!$validation->fails()) {

            $credentials['password']    = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $credentials['email_verified_at'] = Carbon::now();

            $user = User::create($credentials);

            $message    = ['message' => [__('User created')]];
            $status     = 'success';
            $data       = true;
        }else{
            $message    = $validation->messages();
            $status     = 'warning';
            $data       = false;
        }

        return response([
            'data'          => $data,
            'status'        => $status,
            'message'       => $message
        ],200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
