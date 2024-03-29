<?php

namespace App\Http\Controllers\Backend;

use App\Http\Helpers\AppHelper;
use App\Role;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\map;

class AdministratorController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userIndex()
    {

        $users = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->select('users.*','roles.name as role')
            ->get();

        return view('backend.administrator.user.list', compact('users'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCreate()
    {
        $user = null;
        return view('backend.administrator.user.add', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userStore(Request $request)
    {

        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email',
                'username' => 'required|min:5|max:255|unique:users,username',
                'password' => 'required|min:6|max:50',

            ]
        );

        $data = $request->all();


        DB::beginTransaction();
        try {
            //now create user
            $user = User::create(
                [
                    'name' => $data['name'],
                    'username' => $request->get('username'),
                    'email' => $data['email'],
                    'password' => bcrypt($request->get('password')),
                    'remember_token' => null,
                ]
            );
            //now assign the user to role
            UserRole::create(
                [
                    'user_id' => $user->id,
                    'role_id' => AppHelper::USER_ADMIN
                ]
            );

            DB::commit();

            return redirect()->route('administrator.user_create')->with('success', 'System User added!');


        }
        catch(\Exception $e){
            DB::rollback();
            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
            return $message;
            return redirect()->route('administrator.user_create')->with("error",$message);
        }

        return redirect()->route('administrator.user_create');


    }

    public function useredit($id)
    {

        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }


        return view('backend.administrator.user.add', compact('user'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::rightJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('user_roles.role_id', '=', AppHelper::USER_ADMIN)
            ->where('users.id', $id)
            ->select('users.*','user_roles.role_id')
            ->first();

        if(!$user){
            abort(404);
        }
        //validate form
        $this->validate(
            $request, [
                'name' => 'required|min:5|max:255',
                'email' => 'email|max:255|unique:users,email,'.$user->id,
            ]
        );


        $data['name'] = $request->get('name');
        $data['email'] = $request->get('email');
        $user->fill($data);
        $user->save();

        return redirect()->route('administrator.user_index')->with('success', 'System User updated!');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function userDestroy($id)
    {

        $user =  User::findOrFail($id);
        $userRole = UserRole::where('user_id', $user->id)->first();

        if(!$userRole){
            return redirect()->route('administrator.user_index')->with('error', 'Don not mess with the system');

        }

        //check if have any other system user or not
        $systemUsers = UserRole::where('role_id', AppHelper::USER_ADMIN)->count();
        if($systemUsers < 2){
            return redirect()->route('administrator.user_index')->with('error', 'System has only one admin user, you can\'t delete it!');
        }

        $user->delete();
        return redirect()->route('administrator.user_index')->with('success', 'Admin user deleted.');

    }

    /**
     * status change
     * @return mixed
     */
    public function userChangeStatus(Request $request, $id=0)
    {

        $user =  User::findOrFail($id);

        if(!$user){
            return [
                'success' => false,
                'message' => 'Record not found!'
            ];
        }

        $status = (string)$request->get('status');

        if($status == '0') {
            //check if have any other system user or not
            $systemUsers = UserRole::where('role_id', AppHelper::USER_ADMIN)->get();
            $ids = $systemUsers->map(function ($ur) use ($systemUsers) {
                return $ur->user_id;
            });
            $users = User::where('status', '1')->whereIn('id', $ids)->count();
            if ($users < 2) {
                return [
                    'success' => false,
                    'message' => 'System has only one admin user, you can\'t disable it!'
                ];
            }
        }

        $user->status = $status;
        $user->force_logout = (int)$status ? 0 : 1;
        $user->save();

        return [
            'success' => true,
            'message' => 'Status updated.'
        ];

    }


    /* Handle an user password change
    *
    * @return Response
    */
    public function userResetPassword(Request $request)
    {

        if ($request->isMethod('post')) {

            $user = User::findOrFail($request->get('user_id'));
            //validate form
            $this->validate($request, [
                'password' => 'required|confirmed|min:6|max:50',
            ]);

            $user->password = bcrypt($request->get('password'));
            $user->force_logout = 1;
            $user->save();

            return redirect()->route('administrator.user_password_reset')->with('success', 'Password successfully changed.');

        }

        $users = User::select(DB::raw("CONCAT(name,'[',username,']') AS name"),'id')->where('status', '1')->pluck('name','id');

        return view('backend.administrator.user.change_password', compact('users'));
    }

}
