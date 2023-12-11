<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    //
    // Begin: Function to show the post-companies.blade.php
    public function index(){
        return view('admin.company.post-company');
    }
    // End: Function to show the post-companies.blade.php

    // Begin: Function to show the list-companies.blade.php
    public function list_companies(Request $request){
        try{
            // 
            if($request->ajax()){
                // dd("yes ajax reques");
                $data = Company::latest()->get();
                // $data = Company::orderBy('created_at', 'desc')->get();
                // dd($data->toArray());
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }else{
                return view('admin.company.list-company');
            }
        }
        catch(Exception $e){
            return redirect()->route('home.companies.list_companies')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to show the list-companies.blade.php


    // Begin: Function to show the edi-companies.blade.php
    public function edit_company($id){
        try{
            // 
            $companies = Company::find($id);
            if(!$companies){
                return redirect()->route('home.companies.list_companies')->with('error','You are accessing the invalid data. Kindly access the valid one');
            }
            return view('admin.company.edit-company')->with(['companies' => $companies]);
        }
        catch(Exception $e){
            return redirect()->route('home.companies.list_companies')
                ->with('error', "Your Exception is: ".$e->getMessage());
        }
    }
    // End: Function to show the edi-companies.blade.php

    // Begin: Function to update the companies
    public function update_company(Request $request){
        try{
            // 
            // dd($request->toArray());
            $companies = Company::find($request->company_id);
            if(!$companies){
                return redirect()->route('home.companies.list_companies')->with('error','You are accessing the invalid data. Kindly access the valid one');
            }
            if( ($companies->name==$request->name) && ($companies->email == $request->email) && ($companies->website==$request->website)){
                return redirect()->route('home.companies.list_companies')->with('success','Company record updated. Successfully');
            }
            if(!($companies->name == $request->name)){
                $rules['name']= 'required|string|max:255|min:3|unique:companies,name';
                // return "yes";
                $this->validate($request,$rules);
            }
            if(!($companies->email == $request->email)){
                $rules['email']= 'required|email|unique:companies,email';
                $this->validate($request,$rules);
            }
            if(!empty($request->website)){
                $rules['website'] = 'required|url';
                $this->validate($request,$rules);
            }
            if(!($companies->name == $request->name)){
                // Generate the initial slug from the title
                $slug = Str::slug($request->name);

                // Make the slug unique
                $uniqueSlug = $this->makeSlugUnique($slug);
                $companies->name = $request->name;
                $companies->slug = $uniqueSlug;
            }
            if(!($companies->email == $request->email)){
                $companies->email = $request->email;
            }
            if(!empty($request->website)){
                $companies->website = $request->website;
            }
            DB::beginTransaction();     //Starts here
            $results = $companies->save();
            if(!$results){
                DB::rollBack();
                return redirect()->route('home.companies.list_companies')->with('error','There is an error while updating the company. Kindly Try again');
            }
            DB::commit();
            return redirect()->route('home.companies.list_companies')->with('success','Company updated now. Successfully');
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()
                ->route('home.companies.list_companies')
                ->with('error', 'Exception occurred: ' . $e->getMessage());
        }
    }
    // End: Function to update the companies
    // 

    // Begin: Function to store the company record in the db
    public function store_company(Request $request){
        try{
            $rules =[
                'name' => 'required|string|max:255|min:3|unique:companies,name',
                'email' => 'required|email|unique:companies,email',
            ];
            if(!empty($request->website)){
                $rules['website'] = 'required|url';
            }
            $this->validate($request,$rules);
            // dd($request->toArray());
            DB::beginTransaction();     // Here we start the process
            // Generate the initial slug from the title
            $slug = Str::slug($request->name);
    
            // Make the slug unique
            $uniqueSlug = $this->makeSlugUnique($slug);
            
            $companies = new Company();
            $companies->name = $request->name;
            $companies->email = $request->email;
            if(!empty($request->website)){
                $companies->website = $request->website;
            }
            $companies->slug = $uniqueSlug;
            $results = $companies->save();
            if(!$results){
                DB::rollBack();
                return redirect()->route('home.companies.index')->with('error','There is an error while saving the company. Kindly Try again');
            }
            DB::commit(); // Commit the transaction
            return redirect()->route('home.companies.index')->with('success','Company save now. Successfully!');
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()
                ->route('home.companies.index')
                ->with('error', 'Exception occurred: ' . $e->getMessage());
        }
    }
    // End: Function to store the company record in the db

    // Begin: Function to the delete the company using company id
    public function delete_company($id){
        try{
            // 
            // dd("Yes");
            $companies = Company::find($id);
            if(!$companies){
                return "invalid";
            }
            DB::beginTransaction();
            $result = $companies->delete();
            if(!$result){
                DB::rollBack();
                return "error";
            }
            DB::commit();
            return "success";
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()
            ->route('home.companies.list_companies')
            ->with('error','Exception occured: '.$e->getMessage());
        }
    }
    // End: Function to the delete the company using company id

    // Begin: To make slug unique
    private function makeSlugUnique($slug, $counter = 1)
    {
        try{
            // 
            // Check if a record with the same slug already exists
            $existingNews = Company::where('slug', $slug)->first();
            DB::beginTransaction();

            // If a record with the same slug exists, modify the slug to make it unique
            if ($existingNews) {
                $modifiedSlug = $slug . '-' . $counter;
                DB::commit();
                // Recursive call to ensure the modified slug is also unique
                return $this->makeSlugUnique($modifiedSlug, $counter + 1);
            }

            DB::commit();
            // If the slug is already unique, return it
            return $slug;
        }
        catch (Exception $e){
            DB::rollBack();
            return "Exception is:".$e->getMessage();
        }
        
    }
    // End: To make slug unique

}
