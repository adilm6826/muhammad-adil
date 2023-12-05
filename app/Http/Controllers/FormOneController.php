<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FormOneController extends Controller
{
    //
    public function index(){
        return view('task-0.subtask_first-from');
    }
    public function remove_space(Request $request){
        
        $rules=[
            'message'=>'required|string'
        ];
        $this->validate($request,$rules);

        // Remove white spaces before and after the message
        // $cleanedMessageBeforeAfter = trim($request->input('message'));

        // Remove white spaces from the message
        $cleanedMessage = str_replace(' ', '', $request->message);


        // Redirect back with the remove_space
        return redirect()->back()->with([
            'cleanedMessage'=> $cleanedMessage,
            'originalMessage'=> $request->message,
        ]);

    }
}
