<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormOneController extends Controller
{
    //
    public function index(){
        return view('subtask_first-from');
    }
    public function remove_space(Request $request){
        
        $rules=[
            'message'=>'required|string'
        ];
        $this->validate($request,$rules);

        // Remove white spaces before and after the message
        // $cleanedMessageBeforeAfter = trim($request->input('message'));

        
        // Remove white spaces from the message
        $cleanedMessage = str_replace(' ', '', $request->input('message'));

        // Additional processing if needed
        $cleanedSpaaceofMessage = $cleanedMessage;
        $cleanedMessageBeforeAfter = "Before: " . $request->input('message') . ", After: " . $cleanedMessage;

        // Pass the variables to the view
        return view('subtask_first-from', compact('cleanedSpaaceofMessage', 'cleanedMessageBeforeAfter'));
    }
}
