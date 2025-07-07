<?php    
use App\Models\EmployeeId;
use App\Models\Gender;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Arr;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        EmployeeId::create(['employee_id' => '0']);

        Gender::create(['name' => 'Male', 'value' => true]);
        Gender::create(['name' => 'Female', 'value' => false]);

        User::create([
            'employee_id' => '0',
            'name' => 'Admin',
            'gender' => 1,
            'role' => 1,
            'department_id' => 1,
            'designation' => 1,
            'is_married' => false,
            'province' => 3,
            'district' => 27,
            'blood_group' => 1,
            'religion' => 1,
            'email' => 'admin@hr.com',
            'password' => Hash::make('password'),
            'pin' => Hash::make('1111'),
            'dob' => Carbon::now(),
            'interview_date' => Carbon::now()->subYear(),
            'joined' => Carbon::now()->subYear(),
        ]);

        // Fake users
        $departments = Department::all();
        $designationIds = Designation::pluck('id')->toArray();

        foreach ($departments as $department) {
            // 2 Line Managers
            factory(User::class, 2)->create([
                'role' => 4,
                'department_id' => $department->id,
                'designation' => Arr::random($designationIds),
            ]);

            // 8 Staff
            factory(User::class, 8)->create([
                'role' => 5,
                'department_id' => $department->id,
                'designation' => Arr::random($designationIds),
            ]);
        }
    }
}
