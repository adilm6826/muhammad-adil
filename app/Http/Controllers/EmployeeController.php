<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    //
    // Begin: Function to show the post-employee.blade.php file
    public function index(){
        try{
            // 
            $companies = Company::select('id','name')->get();
            return view('admin.employees.post-employees')->with(['companies'=>$companies]);
        }
        catch(Exception $e){
            return redirect()->route('home.employees.index')->with('error','Your Exception is:'.$e->getMessage());
        }
    }
    // End: Function to show the post-employee.blade.php file

    // Begin: Function to store the employee record
    public function store_employee(Request $request){
        try{
            // 
            // dd($request->toArray());
            $rules = [
                'fname' => 'required|string|max:255|min:3',
                'lname' => 'required|string|max:255|min:3',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'required|digits_between:9,9|unique:employees,phone',
                'company_id' => 'required|exists:companies,id'
            ];
            $this->validate($request,$rules);
            // Generate the initial slug from the title
            $slug = Str::slug((($request->fname).($request->lname)));
            // Make the slug unique
            $uniqueSlug = $this->makeSlugUnique($slug);

            $employees = new Employee();
            $employees->fname = $request->fname;
            $employees->lname = $request->lname;
            $employees->email = $request->email;
            $employees->phone = $request->phone;
            $employees->company_id = $request->company_id;
            $employees->slug = $uniqueSlug;
            DB::beginTransaction();
            $result = $employees->save();
            DB::commit();
            if(!($result)){
                DB::rollBack();
                return redirect()->route('home.employees.index')->with('error','There is an error while saving an employee record. Kindly try again.');
            }
            return redirect()->route('home.employees.index')->with('success','Employee record saved. Successfully!');
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->route('home.employees.index')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to store the employee record

    // Begin: Function to list the employee record
    public function list_employee(Request $request){
        try{
            // 
            if($request->ajax()){
                // $data = Employee::latest()->get();
                $data = Employee::with(['company' => function ($query) {
                    $query->select('id', 'name'); // Select only the necessary columns from the companies table
                }])->latest()->get();
                // dd($data->toArray());
                return Datatables::of($data)
                    ->addColumn('company_name', function ($row) {
                        return $row->company ? $row->company->name : 'N/A';
                    })
                    ->addIndexColumn()
                    ->make(true);
            }
            // Retrieve companies to populate the dropdown
            $companies = Company::all();
        
            return view('admin.employees.list-employees', compact('companies'));
        }
        catch(Exception $e){
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to list the employee record

    // Begin: Function to update the company of an employee using company id and employee id
    public function update_company_employee($company_id,$employee_id){
        try{
            // 
            $companies = Company::find($company_id);
            if(!$companies){
                return "invalid_company";
            }
            $employees = Employee::find($employee_id);
            if(!($employees)){
                return "invalid_employee";
            }
            DB::beginTransaction();
            $employees->company_id = $company_id;
            $result = $employees->save();
            DB::commit();
            if(!($result)){
                DB::rollBack();
                return "error";
            }
            return "success";
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to update the company of an employee using company id and employee id

    // Begin: Function to delete to employee record
    public function delete_employee($employee_id){
        try{
            // 
            $employees = Employee::find($employee_id);
            if(!($employees)){
                return "invalid";
            }
            DB::beginTransaction();
            $result = $employees->delete();
            DB::commit();
            if(!($result)){
                DB::rollBack();
                return "error";
            }
            return "success";
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to delete to employee record

    // Begin: Function to show the edit-employee.blade.php with employee records and companies with name and id also
    public function edit_employee($employee_id){
        try{
            // 
            $employees = Employee::find($employee_id);
            if(!($employees)){
                return redirect()->route('home.employees.list_employee')->with('error','You are accessing the invalid employee. Kindly access the valid employee');
            }
            $companies = Company::select('id','name')->get();
            return view('admin.employees.edit-employees')->with([
                'employees' => $employees,
                'companies' => $companies,
            ]);
        }
        catch(Exception $e){
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to show the edit-employee.blade.php with employee records and companies with name and id also

    // Begin: Function to update the employee record
    public function update_employee(Request $request){
        try{
            // 
            // dd($request->toArray());
            $employees = Employee::find($request->employee_id);
            if(!($employees)){
                return redirect()->route('home.employees.list_employee')->with('error','You are accessing the invalid employee. Kindly access the valid employee');
            }

            // Check if all attributes match
            if ($request->employee_id == $employees->id &&
                $request->fname == $employees->fname &&
                $request->lname == $employees->lname &&
                $request->email == $employees->email &&
                $request->phone == $employees->phone &&
                $request->company_id == $employees->company_id) {
                // The attributes match, indicating no changes were made
                return redirect()->route('home.employees.list_employee')->with('info', 'No changes were made to the employee record.');
            }
            // return "BB";
            $rules = [
                'fname' => 'required|string|max:255|min:3',
                'lname' => 'required|string|max:255|min:3',
                'company_id' => 'required|exists:companies,id'
            ];
            if(!($employees->email == $request->email)){
                $rules['email'] = "required|email|unique:employees,email";
            }
            if(!($employees->phone == $request->phone)){
                $rules['phone'] = "required|digits_between:9,9|unique:employees,phone";
            }
            $this->validate($request,$rules);
            // Generate the initial slug from the the first name and last name
            $slug = Str::slug((($request->fname).($request->lname)));
            // Make the slug unique
            $uniqueSlug = $this->makeSlugUnique($slug);
            $employees->fname = $request->fname;
            $employees->lname = $request->lname;
            if(!($employees->email == $request->email)){
                $employees->email = $request->email;
            }
            if(!($employees->phone == $request->phone)){
                $employees->phone = $request->phone;
            }
            $employees->company_id = $request->company_id;
            $employees->slug = $uniqueSlug;
            DB::beginTransaction();
            $result = $employees->save();
            DB::commit();
            if(!($result)){
                DB::rollBack();
                return redirect()->route('home.employees.list_employee')->with('error','There is an error while updating an employee record. Kindly try again.');
            }
            return redirect()->route('home.employees.list_employee')->with('success','Employee record updated. Successfully!');
        }
        catch(Exception $e){
            DB::rollBack();
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
    }
    // End: Function to update the employee record

    // Begin: To make slug unique
    private function makeSlugUnique($slug, $counter = 1)
    {
        try{
            // Check if a record with the same slug already exists
            $existingEmployee = Employee::where('slug', $slug)->first();

            // If a record with the same slug exists, modify the slug to make it unique
            if ($existingEmployee) {
                $modifiedSlug = $slug . '-' . $counter;
                // Recursive call to ensure the modified slug is also unique
                return $this->makeSlugUnique($modifiedSlug, $counter + 1);
            }

            // If the slug is already unique, return it
            return $slug;
        }
        catch(Exception $e){
            return redirect()->route('home.employees.list_employee')->with('error','Your Exception is: '.$e->getMessage());
        }
       
    }
    // End: To make slug unique
}
