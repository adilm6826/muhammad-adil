<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';

    // Begin: Function to define the realtionship of employee with company. One employee can have one company
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }
    // End: Function to define the realtionship of employee with company. One employee can have one company
}
