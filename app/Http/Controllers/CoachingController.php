<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\CoachingForm;
use App\UploadedForm;
use App\User;
use DB;
use DateTime;
use Auth;

class CoachingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->access_level == 2) {
            $agentList = DB::table('coaching_logs')
                        ->where('coaching_logs.agent_id', Auth::user()->id)->get();
        } elseif (Auth::user()->access_level == 3 || Auth::user()->access_level == 5 || Auth::user()->access_level == 1 ) {
            
            $agentList = DB::table('users as a')
                    ->join('users as b', 'a.id', '=', 'b.tl_id')
                    ->select('a.name as tl', 'b.name as agent', 'a.id as tl_id', 'b.id as agent_id')
                    ->get();
        } else {
           
            $agentList = DB::table('users as a')
                    ->join('users as b', 'a.id', '=', 'b.tl_id')
                    ->select('a.name as tl', 'b.name as agent', 'a.id as tl_id', 'b.id as agent_id')
                    ->where('b.access_level', 2)
                    ->where('b.tl_id', Auth::user()->id)
                    ->get();
        }
        return view('pages.coaching', ['agent_list' => $agentList]);
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
     * Create form survey.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createform(Request $request)
    {
        $validated = $request->validate([
            'form_name' => 'required',
            'form_type' => 'required',
            'form_control_id' => 'required',
            'form_description' => 'nullable',
            'form_control_id' => 'required|unique:coaching_form'
        ]);

        $details = $request->all();
        $details['form_created_by'] = Auth::user()->id;
        $form = new CoachingForm;
        $uploadedForm = new UploadedForm;

        $form->form_name              = $details['form_name'];
        $form->form_created_by        = $details['form_created_by'];
        $form->form_description       = $details['form_description'];
        $form->form_type              = $details['form_type'];
        $form->form_control_id        = $details['form_control_id'];

        $form->save();
        $formId = $form->id;

        $uploadedForm->form_id          = $formId;
        $uploadedForm->link             = $details['form_link'];

        $uploadedForm->save();


        return response($validated, 200);
    }

    /**
     * Create form goal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function creategoal(Request $request)
    {
        $details = $request->all();
        $details['goal_created_by'] = Auth::user()->id;
        $goal = new Goal;
        
        $goal->coaching_id            = $details['coaching_id'];
        $goal->title                  = $details['title'];
        $goal->description            = $details['description'];
        $goal->start_date             = date('Y/m/d', strtotime($details['start_date']));
        $goal->end_date               = date('Y/m/d', strtotime($details['end_date']));
        $goal->created_by             = $details['goal_created_by'];
        $goal->updated_by             = $details['goal_created_by'];
        $goal->is_active              = true;

        $goal->save();
        $goalId = $goal->id;
        $coaching = CoachingLog::find($details['coaching_id']);

        $coaching->goal_id                  = $goalId;
        // $uploadedForm->link             = $details['form_link'];

        $coaching->save();


        return response($goal, 200);
    }

    /**
     * Create form milestone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createmilestone(Request $request)
    {
        $details = $request->all();
        $details['milestone_created_by'] = Auth::user()->id;
        $milestone = new Milestone;
        
        $milestone->goal_id             = $details['goal_id'];
        $milestone->milestone_date      = date('Y/m/d', strtotime($details['start_date']));
        $milestone->remarks             = $details['remarks'];

        $milestone->save();


        return response($milestone, 200);
    }

    /**
     * Create form feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createfeedback(Request $request)
    {
        $details = $request->all();
        $details['feedback_created_by'] = Auth::user()->id;
        $feedback = new Feedback;
        
        $feedback->milestone_id             = $details['milestone_id'];
        $feedback->updated_by               = $details['feedback_created_by'];
        $feedback->remarks                  = $details['remarks'];

        $feedback->save();


        return response($feedback, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadform(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required',
        //     'form_type' => 'required',
        //     'form_description' => 'nullable',
        //     'control_id' => 'required|unique:coaching_form'
        // ]);

        $formDetails = $request->all();
        $file = $request->file('file');
        $dataTime = date('Ymd_His');
        $filename = $formDetails['title'] . ' - ' . $file->getClientOriginalName();
        $filepath = public_path('/upload/');
        $file->move($filepath, $filename);
        $form = new CoachingForm;
        $uploadedForm = new UploadedForm;
        $createdBy = Auth::user()->id;
        // $url = $filepath . $filename;
        $url = Storage::path($filename);

        $form->form_name              = $formDetails['title'];
        $form->form_created_by        = $createdBy;
        $form->form_description       = $formDetails['description'];
        $form->form_type              = $formDetails['form_type'];
        $form->form_control_id        = $formDetails['control_id'];

        $form->save();
        $formId = $form->id;

        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        $url = $root.'upload/'. $filename;

        $uploadedForm->form_id          = $formId;
        $uploadedForm->link             = $url;
        

        $uploadedForm->save();

        return response($url, 200);
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
    public function show(Request $request)
    {
        $agentBio = DB::table('users as a')
                ->join('subgroup_names as b', 'a.user_group', '=', 'b.id')
                ->join('group_names as c', 'b.group_names_id', '=', 'c.id')
                ->join('position as d', 'a.position', '=', 'd.id')
                ->select('a.*', 'b.*', 'c.group_name', 'd.position_name')
                ->where('a.id', $request->target_id)->get();

        $coachingDetails = $this->showCoaching($request->target_id);
        $myTl = DB::table('users')->where('id', $agentBio[0]->tl_id)->pluck('name')->first();
        $mySm = DB::table('users')->where('id', $agentBio[0]->sm_id)->pluck('name')->first();
        $myPosition = $agentBio[0]->position_name;

        $currentDate = new DateTime();
        $date1 = $currentDate->format($agentBio[0]->hire_date);
        $date2 = $currentDate->format('Y-m-d H:i:s');
        $d1=new DateTime($date2); 
        $d2=new DateTime($date1);                                  
        $Months = $d2->diff($d1); 
        $howeverManyMonths = (($Months->y) * 12) + ($Months->m);

        $res['coaching_logs'] = $coachingDetails;
        $res['data'] = $agentBio;
        $res['tl'] = $myTl;
        $res['sm'] = $mySm;
        $res['position'] = $myPosition;
        $res['tenure'] = $howeverManyMonths;

        return response($res, 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCoaching($userId)
    {
        $session = DB::table('users as a')
                ->join('coaching_logs as e', 'a.id', '=', 'e.agent_id')
                ->select('e.*')
                ->where('a.id', $userId)->get();

        
        return $session;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAssignedSession(Request $request)
    {
        $assignSession = DB::table('users as a')
                ->join('coaching_logs as e', 'a.id', '=', 'e.agent_id')
                ->select('e.*')
                ->where('a.id', $request->target_id)
                ->where('e.id', $request->coaching_id)
                ->get();

        $res['data'] = $assignSession;
  
        return response($res, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showform(Request $request)
    {
        $formDetails = DB::table('coaching_form as cForm')
                ->leftJoin('uploaded_form as uForm', 'uForm.form_id', '=', 'cForm.id')
                ->leftJoin('users', 'users.id', "=", 'cForm.form_created_by')
                ->select('cForm.*', 'uForm.*', 'users.name')
                ->where('cForm.form_type', $request->form_type)
                ->orderBy('cForm.id', 'asc')
                ->get();

        $res['data'] = $formDetails;
        return response($res, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showgoal(Request $request)
    {
        $goal = DB::table('goal')
                ->select('goal.*')
                ->where('goal.coaching_id', $request->target_id)
                ->where('goal.is_active', true)
                ->get();

        $res['data'] = $goal;
  
        return response($res, 200);
    }


    /**
     * Display the specified milestone.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showmilestone(Request $request)
    {
        $milestone = DB::table('milestone')
                ->select('milestone.*')
                ->where('milestone.goal_id', $request->id)->get();

        $res['data'] = $milestone;
  
        return response($res, 200);
    }

    /**
     * Display the specified milestone.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showselectedmilestone(Request $request)
    {
        $milestone = DB::table('milestone')
                ->select('milestone.*')
                ->where('milestone.id', $request->id)->get();

        $res['data'] = $milestone;
  
        return response($res, 200);
    }

    /**
     * Display the feedback.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showfeedback(Request $request)
    {
        $feedback = DB::table('feedback')
                ->join('users', 'feedback.updated_by', '=', 'users.id')
                ->select('feedback.*', 'users.name')
                ->where('feedback.milestone_id', $request->id)->get();

        $res['data'] = $feedback;
  
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updategoal(Request $request)
    {
        $requestDetails = $request->all();  
        $goal = Goal::find($requestDetails['id']);
        $updatedBy = Auth::user()->id;
        $goal->title                  = $requestDetails['title'];
        $goal->updated_by             = $updatedBy;
        $goal->description            = $requestDetails['description'];
        $goal->start_date             = date('Y/m/d', strtotime($requestDetails['start_date']));
        $goal->end_date               = date('Y/m/d', strtotime($requestDetails['end_date']));
        
        $goal->save();
        

        return response($goal, 200);
    }

    /**
     * acceptCoaching.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accepdeclinecoaching(Request $request)
    {
        $requestDetails = $request->all();  
        $coaching = CoachingLog::find($requestDetails['id']);
        $updatedBy = Auth::user()->id;
        $reason = gettype($request->reason);
        if ($reason != "NULL") {
            $coaching->status     = $requestDetails['status'];
            $coaching->reason     =  $requestDetails['reason'];
        } else {
            $coaching->status     = $requestDetails['status'];
        }

        
        $coaching->save();
        

        return response($coaching, 200);
    }


    /**
     * Update the milestone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatemilestone(Request $request)
    {
        $requestDetails = $request->all();  
        $milestone = Milestone::find($requestDetails['id']);
        $updatedBy = Auth::user()->id;
        $milestone->milestone_date         = date('Y/m/d', strtotime($requestDetails['milestone_date']));
        $milestone->remarks                = $requestDetails['remarks'];
        
        $milestone->save();
        

        return response($milestone, 200);
    }

    public function deletegoal(Request $request)
    {
        $requestDetails = $request->all();  
        $goal = Goal::find($requestDetails['id']);
        $updatedBy = Auth::user()->id;
        $goal->updated_by         = $updatedBy;
        $goal->is_active          = false;
        
        $goal->save();
        

        return response($goal, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadform(Request $request)
    {
        
        // $headers = array('Content-Type: application/xlxs',);
        $file = $request->path;
        $path = public_path('upload\\'. $file);

        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        $a = $root.'upload/'. $file;
        // $headers = [
        //     'HTTP/1.1 200 OK',
        //     'Pragma: public',
        //     'Content-Type: application/xlxs'
        // ];
        
        // return response()->download($root.'upload/'. $file);

        $res['data'] = $a;
        return response($res, 200);
        // return response($path, 200);
        // return Storage::download($path);
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
