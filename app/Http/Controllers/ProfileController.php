<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DateTime;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $my_profile = DB::table('users as a')
                    ->leftJoin('subgroup_names as b', 'a.user_group', '=', 'b.id')
                    ->leftJoin('group_names as c', 'b.group_names_id', '=', 'c.id')
                    ->leftJoin('position as d', 'a.position', '=', 'd.id')
                    ->select('a.*', 'b.*', 'c.group_name', 'd.position_name')
                    ->where('a.id', Auth::user()->id)->get();

        $myTl = DB::table('users')->where('id', $my_profile[0]->tl_id)->pluck('name')->first();
        $mySm = DB::table('users')->where('id', $my_profile[0]->sm_id)->pluck('name')->first();
        $myPosition = $my_profile[0]->position_name;

        $currentDate = new DateTime();
        $date1 = $currentDate->format($my_profile[0]->hire_date);
        $date2 = $currentDate->format('Y-m-d H:i:s');
        $d1=new DateTime($date2); 
        $d2=new DateTime($date1);                                  
        $Months = $d2->diff($d1); 
        $howeverManyMonths = (($Months->y) * 12) + ($Months->m);

        $res['data'] = $my_profile;
        $res['tl'] = $myTl;
        $res['sm'] = $mySm;
        $res['position'] =  $myPosition;
        $res['tenure'] = $howeverManyMonths;
        return response($res, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
