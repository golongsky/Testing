<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use Validator;
use Importer;
use App\Emailtickets;

class ImportExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);

        if ($validator->passes()) {
            $upload_id = mt_rand();
            $dataTime = date('Ymd_His');
            $file = $request->file('file');
            $fileName = $dataTime . '-' . $file->getClientOriginalName();
            $savePath = public_path('/upload/');
            $file->move($savePath, $fileName);
            

            $excel = Importer::make('Excel');
            $excel->load($savePath.$fileName);
            $collection = $excel->getCollection();

            if (sizeof($collection[1]) == 6) {
                for ($row=1; $row<sizeof($collection); $row++) { 
                    try {
                        
                        $emailTicket = new Emailtickets;

                        $emailTicket->ticket_code = $collection[$row][0];
                        $emailTicket->age         = $collection[$row][1];
                        $emailTicket->create_dt   = $collection[$row][2];
                        $emailTicket->close_dt    = $collection[$row][3];
                        $emailTicket->state       = $collection[$row][4];
                        $emailTicket->queue       = $collection[$row][5];
                        $emailTicket->upload_id   = $upload_id;

                        $emailTicket->save();
                    } catch (\Throwable $th) {
                        return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
                    }
                }
                
            }else{
                return redirect()->back()->with(['errors' => [0 => 'Please provide correct Data!']]);
            }

            DB::table('email_upload')->insert([
                'upload_id' => $upload_id
            ]);
            $res['uploadId'] = $upload_id;
            $res['data'] = 'success';
            $res['success'] = 'File Uploaded successfully!';
            return response($res, 200); 

        }else{
            return redirect()->back()->with(['errors'=>$validator->errors()->all()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $lastuploadId = DB::table('email_upload')
                        ->orderBy('created_on', 'desc')
                        ->pluck('upload_id')
                        ->first();

        $res['data'] = $lastuploadId;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $details = $request->all();

        DB::table('email_tickets')->where('upload_id', $details['uploadId'])->delete();
        DB::table('email_upload')->where('upload_id', $details['uploadId'])->delete();

        $res['data'] = 'success';
        return response($res, 200);
    }
}
