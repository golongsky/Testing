<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactions;
use App\Emailtickets;
use App\EmailMeta;
use DB;
use Auth;

class EtrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cur_start = date("Y-m-d")." 00:00:00";
        $cur_end   = date("Y-m-d")." 23:59:59";
        if (Auth::user()->access_level == 2) {
            $cur_prod = DB::table('transaction')
                        ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                        ->join('users', 'transaction.user_id', '=', 'users.id')
                        ->select('users.name', 'transaction.*', 'transaction_type.transaction_code', 'transaction_type.transaction_name', 'transaction_type.transaction_type')
                        ->where('user_id', Auth::user()->id)
                        ->whereBetween('start_datetime', array($cur_start, $cur_end))
                        ->get();
        }else{
            $cur_prod = DB::table('transaction')
                        ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                        ->join('users', 'transaction.user_id', '=', 'users.id')
                        ->select('users.name', 'transaction.*', 'transaction_type.transaction_code', 'transaction_type.transaction_name', 'transaction_type.transaction_type')
                        ->whereBetween('start_datetime', array($cur_start, $cur_end))
                        ->get();
        }
        
        return view('pages.etr', ['cur_prod' => $cur_prod]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pullmytrx()
    {
        $cur_start = date("Y-m-d")." 00:00:00";
        $cur_end   = date("Y-m-d")." 23:59:59";

        $myAgents = DB::table('users')
                        ->where('tl_id', Auth::user()->id)->select('id')->get();
            
            $a=array();
            foreach ($myAgents as $agentId) {
                array_push($a,$agentId->id);
            }

            
        if (Auth::user()->access_level == 2) {
            
            $myTrx = DB::table('transaction')
                        ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                        ->leftJoin('email_tickets_meta',  'transaction.email_tickets_meta', '=', 'email_tickets_meta.ticket_id')
                        ->leftJoin('concern_type',  'email_tickets_meta.meta_type', '=', 'concern_type.id')
                        ->leftJoin('concern_sub_type',  'email_tickets_meta.meta_sub_type', '=', 'concern_sub_type.id')
                        ->select('transaction.*', 
                                 'transaction_type.transaction_code',
                                 'transaction_type.transaction_name',
                                 'transaction_type.transaction_type',
                                 'email_tickets_meta.meta_state', 'email_tickets_meta.meta_type', 'email_tickets_meta.meta_sub_type',
                                 'concern_type.name as cName',
                                 'concern_sub_type.name as cSName'
                                )
                        ->where('user_id', Auth::user()->id)
                        ->whereBetween('start_datetime', array($cur_start, $cur_end))
                        ->get();
        }elseif (Auth::user()->access_level == 4) {
            

            $myTrx = DB::table('transaction')
                        ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                        ->join('users', 'transaction.user_id', '=', 'users.id')
                        ->join('group_names',  'group_names.id', '=', 'users.user_group')
                        ->join('subgroup_names',  'subgroup_names.id', '=', 'users.sub_group')
                        ->leftJoin('email_tickets_meta',  'transaction.email_tickets_meta', '=', 'email_tickets_meta.ticket_id')
                        ->leftJoin('concern_type',  'email_tickets_meta.meta_type', '=', 'concern_type.id')
                        ->leftJoin('concern_sub_type',  'email_tickets_meta.meta_sub_type', '=', 'concern_sub_type.id')
                        ->select('users.name', 
                                 'transaction.*',
                                 'transaction_type.transaction_code',
                                 'transaction_type.transaction_name',
                                 'transaction_type.transaction_type',
                                 'group_names.group_name',
                                 'subgroup_names.subgroup_name',
                                 'email_tickets_meta.meta_state', 'email_tickets_meta.meta_type', 'email_tickets_meta.meta_sub_type',
                                 'concern_type.name as cName',
                                 'concern_sub_type.name as cSName')
                        ->whereIn('user_id', $a)
                        ->whereBetween('start_datetime', array($cur_start, $cur_end))
                        ->get();
        }else{

            $myTrx = DB::table('transaction')
                        ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                        ->join('users', 'transaction.user_id', '=', 'users.id')
                        ->join('group_names',  'group_names.id', '=', 'users.user_group')
                        ->join('subgroup_names',  'subgroup_names.id', '=', 'users.sub_group')
                        ->leftJoin('email_tickets_meta',  'transaction.email_tickets_meta', '=', 'email_tickets_meta.ticket_id')
                        ->leftJoin('concern_type',  'email_tickets_meta.meta_type', '=', 'concern_type.id')
                        ->leftJoin('concern_sub_type',  'email_tickets_meta.meta_sub_type', '=', 'concern_sub_type.id')
                        ->select('users.name', 
                                 'transaction.*',
                                 'transaction_type.transaction_code',
                                 'transaction_type.transaction_name',
                                 'transaction_type.transaction_type',
                                 'group_names.group_name',
                                 'subgroup_names.subgroup_name',
                                 'email_tickets_meta.meta_state', 'email_tickets_meta.meta_type', 'email_tickets_meta.meta_sub_type',
                                 'concern_type.name as cName',
                                 'concern_sub_type.name as cSName')
                        ->whereIn('user_id', $a)
                        ->whereBetween('start_datetime', array($cur_start, $cur_end))
                        ->get();
        }
        $res['last_id'] = DB::table('transaction')->orderBy('id', 'desc')->pluck('id')->first();
        $res['data'] = $myTrx;
        return response($res, 200);
    }

    public function lastId(){
        $res['last_id'] = DB::table('transaction')->orderBy('id', 'desc')->pluck('id')->first();
        return response($res, 200);
    }

    public function filteredrmytrx( Request $request ){
        if (Auth::user()->access_level == 1) {
            $filtereTrx = DB::table('transaction')
            ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
            ->join('users', 'transaction.user_id', '=', 'users.id')
            ->join('group_names',  'group_names.id', '=', 'users.user_group')
            ->join('subgroup_names',  'subgroup_names.id', '=', 'users.sub_group')
            ->leftJoin('email_tickets_meta',  'transaction.email_tickets_meta', '=', 'email_tickets_meta.ticket_id')
            ->leftJoin('concern_type',  'email_tickets_meta.meta_type', '=', 'concern_type.id')
            ->leftJoin('concern_sub_type',  'email_tickets_meta.meta_sub_type', '=', 'concern_sub_type.id')
            ->select('users.name', 
                     'transaction.*',
                     'transaction_type.transaction_code',
                     'transaction_type.transaction_name',
                     'transaction_type.transaction_type',
                     'group_names.group_name',
                     'subgroup_names.subgroup_name',
                     'email_tickets_meta.meta_state', 'email_tickets_meta.meta_type', 'email_tickets_meta.meta_sub_type',
                     'concern_type.name as cName',
                     'concern_sub_type.name as cSName')
                ->whereBetween('end_datetime', array($request->ts_start." 00:00:00", $request->ts_end." 23:59:59"))
                ->get();
        }else{
            $filtereTrx = DB::table('transaction')
            ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
            ->join('users', 'transaction.user_id', '=', 'users.id')
            ->join('group_names',  'group_names.id', '=', 'users.user_group')
            ->join('subgroup_names',  'subgroup_names.id', '=', 'users.sub_group')
            ->leftJoin('email_tickets_meta',  'transaction.email_tickets_meta', '=', 'email_tickets_meta.ticket_id')
            ->leftJoin('concern_type',  'email_tickets_meta.meta_type', '=', 'concern_type.id')
            ->leftJoin('concern_sub_type',  'email_tickets_meta.meta_sub_type', '=', 'concern_sub_type.id')
            ->select('users.name', 
                     'transaction.*',
                     'transaction_type.transaction_code',
                     'transaction_type.transaction_name',
                     'transaction_type.transaction_type',
                     'group_names.group_name',
                     'subgroup_names.subgroup_name',
                     'email_tickets_meta.meta_state', 'email_tickets_meta.meta_type', 'email_tickets_meta.meta_sub_type',
                     'concern_type.name as cName',
                     'concern_sub_type.name as cSName')
                ->where('users.tl_id', Auth::user()->id)
                ->whereBetween('end_datetime', array($request->ts_start." 00:00:00", $request->ts_end." 23:59:59"))
                ->get();
        }
        
        $res['data'] = $filtereTrx;
        return response($res, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function etrcontroller()
    {
        return view('pages.etrcontroller');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transtype()
    {
        $trans_type = DB::table('transaction_type')->get();
        $res['data'] = $trans_type;
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
        $details = $request->all();
        $trx = new Transactions;
        

        $trx->user_id              = Auth::user()->id;
        $trx->transaction_type_id  = $details['trans_type'];
        $trx->status               = "End";
        $trx->start_datetime       = $details['trans_str'];
        $trx->end_datetime         = $details['trans_end'];
        $trx->total_tat            = $details['trans_tat'];
        $trx->remarks              = $details['trans_rem'];

        $trx->save();
   

        $status['message'] = true;
        return $status;
    }

    // Email / Transaction Combincation 
    public function emailstore(Request $request)
    {
        $details = $request->all();
        $trx = new Transactions;
        
        $trx->email_tickets_meta   = $details['email_ticket_no'];
        $trx->user_id              = Auth::user()->id;
        $trx->transaction_type_id  = 7;
        $trx->status               = "End";
        $trx->start_datetime       = $details['trans_str'];
        $trx->end_datetime         = $details['trans_end'];
        $trx->total_tat            = $details['trans_tat'];
        $trx->remarks              = $details['trans_rem'];

        $trx->save();

        
        $emailTrx = new EmailMeta;
        $emailTrx->ticket_id     = $details['email_ticket_no'];
        $emailTrx->meta_state    = $details['email_state'];
        $emailTrx->meta_type     = $details['email_concern'];
        $emailTrx->meta_sub_type = $details['email_sub'];

        $emailTrx->save();

        Emailtickets::where('ticket_code', $details['email_ticket_no'])
        ->update(['status' => 1, 'agent' => Auth::user()->id, 'start_process_time' => date('Y-m-d H:i:s')]);

        $status['message'] = true;
        return $status;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $target = $request->all();

        if ($target['targetId'] == 1) {
            $ddList = DB::table('concern_type')->get();
        }elseif($target['targetId'] == 2){
            $ddList = DB::table('concern_sub_type')->where('concern_id', $target['filter'])->get();
        }

        $status['data'] = $ddList;
        return $status;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateislock(Request $request)
    {
        $details = $request->all();
        $ticket = Emailtickets::find($details['control_id']);
        $ticket -> is_lock = $details['is_lock'];
        $ticket->save();
        return response($ticket, 200);
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

    public function emailist(Request $request){
        if (Auth::user()->access_level == 2) {
            //Check if Active user has an Open Ticket
            $hasTicket = DB::table('email_tickets')
                ->where('agent', Auth::user()->id)
                ->where('status', 0)
                ->count();

            if ($hasTicket > 0) {
            //Has Open Ticket
            $randTicket = DB::table('email_tickets')
                ->where('agent', Auth::user()->id)
                ->where('status', 0)
                ->get();
                $res['data'] = $randTicket;
                return response($res, 200);
            }else{
            //No Open Ticket
            $randTicket = DB::table('email_tickets')
                ->oldest('create_dt')
                ->where('agent', 0)
                ->where('dt_locked', NULL)
                ->first();
            
                if ($randTicket != NULL) {
                    Emailtickets::where('ticket_code', $randTicket->ticket_code)
                                ->update(['agent' => Auth::user()->id, 'dt_locked' => date('Y-m-d H:i:s')]); 
                    $res['data'] = $randTicket;
                    return response($res, 200);
                }else{
                    $res['data'] = 0;
                    return response($res, 200);
                }
              
            }

            
            
        }else{
            $randTicket = DB::table('email_tickets')
                ->leftJoin('email_tickets_meta', 'email_tickets_meta.ticket_id', '=', 'email_tickets.ticket_code')
                ->leftJoin('users', 'users.id', '=', 'email_tickets.agent')
                ->leftJoin('concern_type', 'concern_type.id', '=', 'email_tickets_meta.meta_type')
                ->leftJoin('concern_sub_type', 'concern_sub_type.id', '=', 'email_tickets_meta.meta_sub_type')
                ->select('email_tickets.*', 'email_tickets_meta.meta_state', 'users.name as uName', 'concern_sub_type.name as csName', 'concern_type.name as cName')
                ->get();

            $res['data'] = $randTicket;
            return response($res, 200);
        }
        
        
    }

    public function ticketlock(Request $request){
        $details = $request->all();

        Emailtickets::where('ticket_code', $details['ticketNo'])
        ->update(['agent' => Auth::user()->id]);

        $res['data'] = 'success';
        return response($res, 200);
    }

    public function checkticket(Request $request){

        $details = $request->all();
        $returnStatus = Emailtickets::where('ticket_code', $details['ticketNo'])->pluck('agent')->first();

        $res['data'] = $returnStatus;
        return response($res, 200);

    }

    public function startProcess(Request $request){
        $details = $request->all();

        Emailtickets::where('ticket_code', $details['email_ticket_no'])
        ->update(['start_process_time' => date('Y-m-d H:i:s')]);

    }

    public function checkLock(Request $request){
        $details = $request->all();

        $isMine = DB::table('email_tickets')
                  ->where('ticket_code', $details['email_ticket_no'])
                  ->where('agent', Auth::user()->id)->count();

        if ($isMine == 1) {
            $res['data'] = true;
            return response($res, 200);
        }else{
            $res['data'] = false;
            return response($res, 200);
        }
    }

    public function release(Request $request){
        $details = $request->all();

        Emailtickets::where('ticket_code', $details['email_ticket_no'])
        ->update(['agent' => 0, 'dt_locked' => NULL]);

        $res['data'] = true;
        return response($res, 200);
    }
}
