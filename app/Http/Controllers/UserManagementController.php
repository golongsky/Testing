<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.usermanagement');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $allDetails = $request->all();        
        $detContainer=  array();
        parse_str($allDetails['formdata'], $detContainer);

        $user = new User;
        $user->name = $detContainer['fullname'];
        $user->call_sign = $detContainer['callsign'];
        $user->email  = $detContainer['email'];
        $user->password = Hash::make("admin12345");
        $user->access_level  = $detContainer['accesslevel'];
        $user->position  = $detContainer['position'];
        $user->user_group  = $detContainer['location'];
        $user->sub_group  = $detContainer['group'];
        $user->hire_date  = $detContainer['hiredate'];
        $user->tl_id  = $detContainer['teamlead'];
        $user->sm_id  = $detContainer['manager'];
        $user->is_active  = $detContainer['status'];
        $user->is_email  = $detContainer['emailsupport'];
        $user->save();

        $res['data'] = true;
        $res['validator'] = 'create';
        return response($res, 200);
    }

    /**
     * Display a listing of the user data.
     *
     * @return \Illuminate\Http\Response
     */
    public function pulldata(Request $request)
    {
        $alldata = $request->all();
        // var_dump($alldata);
        // echo "<br>";
        $allDatas = DB::table('users')->where('id', $alldata['tId'])->first();
        // var_dump($allDatas);
        $res['data'] = $allDatas;
        return response($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $accessLevel = DB::table('role')->where('id','!=',5)->get();
        $position = DB::table('position')->get();
        $location = DB::table('group_names')->get();
        $group = DB::table('subgroup_names')->get();
        $teamlead = DB::table('users')->where('access_level', 4)->get();
        $manager  = DB::table('users')->where('access_level', 1)->get();

        $res['role'] = $accessLevel;
        $res['post'] = $position;
        $res['loct'] = $location;
        $res['grp'] = $group;
        $res['tls'] = $teamlead;
        $res['mng'] = $manager;
        return response($res, 200);

    }

    public function storegroup(Request $request)
    {

        $group = DB::table('subgroup_names')->where('group_names_id', $request->locationId)->get();
        $res['grp']  = $group;
        return response($res, 200);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $allUsers = DB::table('users')
                    ->leftJoin('group_names',  'group_names.id', '=', 'users.user_group')
                    ->leftJoin('subgroup_names',  'subgroup_names.id', '=', 'users.sub_group')
                    ->select('users.*','group_names.group_name',
                        'subgroup_names.subgroup_name')     
                    ->where('is_active', 1)
                    ->get();
        $res['data'] = $allUsers;
        return response($res, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $allDetails = $request->all();        
        $detContainer=  array();
        parse_str($allDetails['formdata'], $detContainer);

        $user = User::findOrFail($detContainer['activeId']);

        $user->name = $detContainer['fullname'];
        $user->call_sign = $detContainer['callsign'];
        $user->email  = $detContainer['email'];
        $user->access_level  = $detContainer['accesslevel'];
        $user->position  = $detContainer['position'];
        $user->user_group  = $detContainer['location'];
        $user->sub_group  = $detContainer['group'];
        $user->hire_date  = $detContainer['hiredate'];
        $user->tl_id  = $detContainer['teamlead'];
        $user->sm_id  = $detContainer['manager'];
        $user->is_active  = $detContainer['status'];
        $user->is_email  = $detContainer['emailsupport'];
        $query = $user->save();

        if(!$query) {
            $res['data'] = false;
            $res['validator'] = 'error';
        } else {
            $res['data'] = true;
            $res['validator'] = 'update';
        }

        return response($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $group = DB::table('users')
                ->where('id', $request->tId)
                ->update(['is_active' => 0]);
        $res['status']  = true;
        return response($res, 200); 
    }
}
