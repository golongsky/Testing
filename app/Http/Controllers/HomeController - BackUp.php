<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Emailtickets;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cur_start = date("Y-m-d")." 00:00:00";
        $cur_end   = date("Y-m-d")." 23:59:59";

        $prod = DB::table('transaction_type')
                ->leftJoin('transaction', 'transaction.transaction_type_id', '=', 'transaction_type.id')
                ->select(DB::raw('count(transaction.transaction_type_id) as user_count, transaction_type.transaction_name'))
                ->where('transaction_type', 'Prod')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('start_datetime', array($cur_start, $cur_end))
                ->groupBy('transaction_type.transaction_name')
                ->get();

        $nonprod = DB::table('transaction_type')
                ->leftJoin('transaction', 'transaction.transaction_type_id', '=', 'transaction_type.id')
                ->select(DB::raw('count(transaction.transaction_type_id) as user_count, transaction_type.transaction_name'))
                ->where('transaction_type', 'Non-prod')
                ->where('user_id', Auth::user()->id)
                ->whereBetween('start_datetime', array($cur_start, $cur_end))
                ->groupBy('transaction_type.transaction_name')
                ->get();

        if (Auth::user()->access_level == 2) {
            $cardNumber = \DB::select("SELECT * FROM (
                (
                    SELECT count(a.transaction_type_id) as NonProd 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    WHERE b.transaction_type = 'Non-prod'
                    AND a.user_id = ?
                    AND start_datetime BETWEEN ? and ?) AS T1, 
                    
                    (SELECT count(a.transaction_type_id) as Prod 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    WHERE b.transaction_type = 'Prod'
                    AND a.user_id = ?
                    AND start_datetime BETWEEN ? and ?) AS T2)", 
                    [
                        Auth::user()->id,
                        $cur_start,
                        $cur_end,
                        Auth::user()->id,
                        $cur_start,
                        $cur_end
                    ]);
        }elseif (Auth::user()->access_level == 4) {
            $cardNumber = \DB::select("SELECT * FROM (
                (
                    SELECT count(a.transaction_type_id) as NonProd 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    INNER JOIN users c
                    ON a.user_id = c.id
                    WHERE b.transaction_type = 'Non-prod'
                    AND c.tl_id = ?
                    -- AND a.user_id = ?
                    AND start_datetime BETWEEN ? and ?) AS T1, 
                    
                    (SELECT count(a.transaction_type_id) as Prod 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    INNER JOIN users c
                    ON a.user_id = c.id
                    WHERE b.transaction_type = 'Prod'
                    AND c.tl_id = ?
                    -- AND a.user_id = ?
                    AND start_datetime BETWEEN ? and ?) AS T2)", 
                    [
                        Auth::user()->id,
                        $cur_start,
                        $cur_end,
                        Auth::user()->id,
                        $cur_start,
                        $cur_end
                    ]);
        }else{
            $cardNumber = \DB::select("SELECT * FROM (
                (
                    SELECT count(a.transaction_type_id) as NonProd 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    WHERE b.transaction_type = 'Non-prod'
                    AND start_datetime BETWEEN ? and ?) AS T1, 
                    
                    (SELECT count(a.transaction_type_id) as Prod 
                    FROM transaction a
                    LEFT JOIN transaction_type b
                    ON a.transaction_type_id = b.id
                    WHERE b.transaction_type = 'Prod'
                    AND start_datetime BETWEEN ? and ?) AS T2)", 
                    [
                        $cur_start,
                        $cur_end,
                        $cur_start,
                        $cur_end
                    ]);
        }

        //ROI Added 2/18/2022
        $myTeam = DB::table('users')->where('tl_id',Auth::user()->id)->count();
        $activeMem = DB::table('users')->where('tl_id',Auth::user()->id)->where('is_logged_in', 1)->count();
        
        return view('home', ['prod' => $prod, 'nonprod' => $nonprod, 'card_num_prod' => $cardNumber, 'myTeam' => $myTeam, 'activeMem' => $activeMem]);

        
        return view('home', ['prod' => $prod, 'nonprod' => $nonprod, 'card_num_prod' => $cardNumber]);
    }

    public function chartData(){
        $previousts = strtotime('00:00:00');
        $timestamp = strtotime('00:00:00') + 60*60;
        $start_ts = date('Y-m-d H:i:s', $previousts);
        $end_ts = date('Y-m-d H:i:s', $timestamp);
        $counter = 24;
        $prod_set = [];
        $nprod_set = [];

        while ($counter > 0) {

            $start_ts = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($start_ts)));
            $end_ts = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($end_ts)));
            
            $counter = $counter - 1;

            $prods = $cardNumber = \DB::select(
                "SELECT count(a.transaction_type_id) as Prod 
                FROM transaction a
                LEFT JOIN transaction_type b
                ON a.transaction_type_id = b.id
                WHERE b.transaction_type = 'Prod'
                AND start_datetime BETWEEN '$start_ts' and '$end_ts'"
            );
            array_push($prod_set,$prods[0]->Prod);

            $nprods = $cardNumber = \DB::select(
                "SELECT count(a.transaction_type_id) as NProd 
                FROM transaction a
                LEFT JOIN transaction_type b
                ON a.transaction_type_id = b.id
                WHERE b.transaction_type = 'Non-prod'
                AND start_datetime BETWEEN '$start_ts' and '$end_ts'"
            );
            array_push($nprod_set,$nprods[0]->NProd);
        }

        $res['pdata'] = $prod_set;
        $res['ndata'] = $nprod_set;
        return response($res, 200);
    }


    public function tlData(){
        $cur_start = date("Y-m-d")." 00:00:00";
        $cur_end   = date("Y-m-d")." 23:59:59";
        $agents = [];
        $prd_count = [];
        $nprd_count = [];

        $myAgents = DB::table('users')->where('tl_id',Auth::user()->id)->get();

        foreach ($myAgents as $myagent) {
            array_push($agents,$myagent->call_sign);

            $trxProd = DB::table('transaction')
                        ->join('transaction_type', 'transaction.transaction_type_id', '=', 'transaction_type.id')
                        ->where('transaction.user_id', $myagent->id)
                        ->where('transaction_type.transaction_type', 'Prod')
                        ->whereBetween('end_datetime', array($cur_start, $cur_end))
                        ->count();
            
            $trxNProd = DB::table('transaction')
                        ->join('transaction_type', 'transaction.transaction_type_id', '=', 'transaction_type.id')
                        ->where('transaction.user_id', $myagent->id)
                        ->where('transaction_type.transaction_type', 'Non-prod')
                        ->whereBetween('end_datetime', array($cur_start, $cur_end))
                        ->count();
            
            array_push($prd_count,$trxProd);
            array_push($nprd_count,$trxNProd);            
        }

        $res['ag_prod'] = $prd_count;
        $res['ag_nprod'] = $nprd_count;
        $res['myagents'] = $agents;
        return response($res, 200);
        // var_dump($agents);
        // die();
    }

    public function loadknobs(){
        $l_4_tech  = 0;
        $l_8_tech  = 0;
        $l_12_tech = 0;
        $l_24_tech = 0;
        $m_24_tech = 0;
        $techOpen  = 0;
        $techNew   = 0;

        $l_4_non_tech  = 0;
        $l_8_non_tech  = 0;
        $l_12_non_tech = 0;
        $l_24_non_tech = 0;
        $m_24_non_tech = 0;
        $nontechOpen = 0;
        $nontechNew  = 0;


        $emailTickets = Emailtickets::all();

        foreach ($emailTickets as $tickets) {

            
            
            $specification = DB::table('email_specification')->where('details','LIKE','%'.$tickets['queue'].'%')->first('specification');
            $time_st = strtotime($tickets['create_dt']);
            $time_ed = strtotime($tickets['close_dt']);
            
            $timeDiff = round(abs($time_ed - $time_st)/(60*60), 0);

            switch ($specification->specification) {
                case 'Non-Tech':
                    if ($timeDiff <= 4) {
                        $l_4_non_tech++;
                    }elseif ($timeDiff > 4 && $timeDiff <= 8) {
                        $l_8_non_tech++;
                    }elseif ($timeDiff > 8 && $timeDiff <= 12) {
                        $l_12_non_tech++;
                    }elseif ($timeDiff > 12 && $timeDiff <= 24) {
                        $l_24_non_tech++;
                    }else{
                        $m_24_non_tech++;
                    }

                    if ($tickets['state'] == 'open') {
                        $techOpen++;
                    }else{
                        $techNew++;
                    }
                    break;
                case 'Tech':
                    if ($timeDiff <= 4) {
                        $l_4_tech++;
                    }elseif ($timeDiff > 4 && $timeDiff <= 8) {
                        $l_8_tech++;
                    }elseif ($timeDiff > 8 && $timeDiff <= 12) {
                        $l_12_tech++;
                    }elseif ($timeDiff > 12 && $timeDiff <= 24) {
                        $l_24_tech++;
                    }else{
                        $m_24_tech++;
                    }

                    if ($tickets['state'] == 'open') {
                        $nontechOpen++;
                    }else{
                        $nontechNew++;
                    }
                    break;
                default:
                    
                    break;
            }
        }

        $res['l4t'] = $l_4_tech;
        $res['l8t'] = $l_8_tech;
        $res['l12t'] = $l_12_tech;
        $res['l24t'] = $l_24_tech;
        $res['m24t'] = $m_24_tech;
        $res['l4nt'] = $l_4_non_tech;
        $res['l8nt'] = $l_8_non_tech;
        $res['l12nt'] = $l_12_non_tech;
        $res['l24nt'] = $l_24_non_tech;
        $res['m24nt'] = $m_24_non_tech;
        
        $res['techNew'] = $techNew;
        $res['techOpen'] = $techOpen;
        $res['nontechNew'] = $nontechNew;
        $res['nontechOpen'] = $nontechOpen;

        return response($res, 200);
    }

    //added Roi 2/18/2022
    public function logout(Request $request) {
        DB::table('users')->update(['is_logged_in' => 0]);
        Auth::logout();
        return redirect('/login');
    }

    //added Roi 2/18/2022
    public function myteamTicket(){
        $myTeamTickets = \DB::select(
            " SELECT a.ticket_code, b.transaction_type_id, b.total_tat, u.name, u.call_sign, a.queue, e.specification
            FROM email_tickets a
            LEFt JOIN transaction b
            ON a.ticket_code = b.email_tickets_meta
            LEFT JOIN users u
            ON a.agent = u.id
            LEFT JOIN email_specification e
            ON a.queue = e.details
            WHERE a.dt_locked IS NOT null and a.status = 0
            "
        );

        $activeMem = DB::table('users')->where('tl_id',Auth::user()->id)->where('is_logged_in', 1)->count();
        $totalTix  = DB::table('email_tickets')->count();
        $waitingTix= DB::table('email_tickets')->where('agent',0)->where('status',0)->count();
        $processTix= DB::table('email_tickets')->where('agent', '>', 0)->where('status',0)->count();
        $closedTix = DB::table('email_tickets')->where('agent', '>', 0)->where('status',1)->count();
        // var_dump($myTeamTickets);
        // var_dump($activeMem);
        // die();

        $res['data'] = $myTeamTickets;
        $res['activeCount'] = $activeMem;
        $res['totalTicket'] = $totalTix;
        $res['waitingTixs'] = $waitingTix;
        $res['processTixs'] = $processTix;
        $res['closedTix'] = $closedTix;
        return response($res, 200);

    }
}
