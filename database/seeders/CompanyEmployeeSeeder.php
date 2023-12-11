<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Seed Companies
        $companies = [
            ['name' => 'Company A', 'email' => 'companyA@example.com', 'website' => 'www.companyA.com', 'slug' => 'company-a'],
            ['name' => 'Company B', 'email' => 'companyB@example.com', 'website' => 'www.companyB.com', 'slug' => 'company-b'],
            ['name' => 'Company C', 'email' => 'companyC@example.com', 'website' => 'www.companyC.com', 'slug' => 'company-c'],
        ];

        foreach ($companies as &$companyData) {
            $company = new Company($companyData);
            $company->save();
        }
        // / Use $company->id in the creation of employees
            $this->createEmployees($company->id);
    }

    /**
     * Create employees for a specific company.
     *
     * @param int $companyId
     */
    private function createEmployees(int $companyId): void
    {
        $employees = [
            ['fname' => 'John', 'lname' => 'Doe', 'email' => 'johna@example.com', 'phone' => '+923021254567', 'slug' => 'john-doe'],
            ['fname' => 'Jane', 'lname' => 'Smith', 'email' => 'janeb@example.com', 'phone' => '+923045234877', 'slug' => 'jane-smith'],
            ['fname' => 'Bob', 'lname' => 'Johnson', 'email' => 'bobc@example.com', 'phone' => '+923034234597', 'slug' => 'bob-johnson'],
        ];

        foreach ($employees as $employeeData) {
            $employeeData['company_id'] = $companyId;
            $employees = new Employee($employeeData);
            $employees->save();
            // Employee::create($employeeData);
        }
    }
}