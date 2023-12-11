<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';

    // Begin: Function to define the realtionship of company with employee. One company can have many employee
    public function employees(){
        return $this->hasMany(Employee::class,'company_id');
    }
    // End: Function to define the realtionship of company with employee. One company can have many employee
}
