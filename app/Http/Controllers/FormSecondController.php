<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormSecondController extends Controller
{
    //
    // Begin: Function to Show the 2nd Form
    public function index(){
        return view('task-0.subtask_second-from');
    }
    // End: Function to Show the 2nd Form

    // Begin: Function to count the words from paragraph and display them.
    public function count_words(Request $request){
        $rules=[
            'word'=>'required|regex:/^\S*$/',
            'message'=>'required|string',
        ];
        $messages=['word.regex'=>'Kindly Provide One word to count'];
        $this->validate($request,$rules,$messages);
        $wordToCount = strtolower($request->input('word'));
        $paragraph = strtolower($request->input('message'));

        $wordCount = substr_count($paragraph, $wordToCount);

        // Redirect back with the word count
        return redirect()->back()->with([
            'wordCount'=> $wordCount,
            'word'=> $request->word,
            'message'=> $request->message,
        ]);
    }
    // End: Function to count the words from paragraph and display them.
}
