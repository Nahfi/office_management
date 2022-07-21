<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::where('email','employee@example.com')->first();
        if(isNull($employee)){
           $employee =  Employee::create([
                'name' => 'Employee',
                'email' => 'employee@example.com',
                'phone' => '01515272338',
                'national_id' => '0123456789',
                'father_name' => 'FatherExample',
                'mother_name' => 'MotherExample',
                'guardian_phone' => '01515272338',
                'password' => Hash::make('123456789'),
                'address' => 'TestAddress',
                'salary' => '1000',
                'status' => 'Active',
                'created_by' => '1'  
            ]);
        }
    }
}
