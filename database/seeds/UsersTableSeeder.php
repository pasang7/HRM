<?php

use App\Models\EmployeeId;
use App\Models\Gender;
use App\Models\Role;
use App\Models\ContractType;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create base data
        EmployeeId::create(['employee_id' => '0']);
        Gender::insert([
            ['name' => 'Male', 'value' => true],
            ['name' => 'Female', 'value' => false],
        ]);

        // Admin
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
            'dob' => Carbon::now()->subYears(30),
            'interview_date' => Carbon::now()->subMonths(6),
            'joined' => Carbon::now()->subMonths(5),
        ]);

        $contractTypes = ContractType::pluck('id')->toArray();
        $designationIds = Designation::pluck('id')->toArray();
        $departments = Department::all();
        $topLevel = Department::where('name', 'Top Level Management')->first();
        $userIndex = 1;

        $faker = Faker::create();

        // Create CEO user and store
        $ceoUser = null;
        $hrUser = null;
        $lineManagers = [];

        // Helper function to create user with details, including approval logic
        $createUserWithDetails = function ($overrides = [], $assignApproval = true) use (
            &$userIndex,
            $contractTypes,
            $designationIds,
            $faker,
            &$ceoUser,
            &$hrUser,
            &$lineManagers
        ) {
            $interviewDate = Carbon::now()->subMonths(rand(1, 12));
            $joinedDate = $interviewDate->copy()->addWeeks(rand(1, 4));
            $name = $overrides['name'] ?? $faker->name;
            $department_id = $overrides['department_id'] ?? null;

            // Default approvals
            $firstApprovalId = null;
            $secApprovalId = null;

            if ($assignApproval) {
                // second approval always CEO
                $secApprovalId = $ceoUser ? $ceoUser->id : null;

                // for office driver or office support names assign HR as first approval
                $officeRolesNames = ['Office Driver', 'Office Support'];

                if (in_array($name, $officeRolesNames)) {
                    $firstApprovalId = $hrUser ? $hrUser->id : null;
                } elseif ($department_id && isset($lineManagers[$department_id])) {
                    $firstApprovalId = $lineManagers[$department_id]->id;
                } else {
                    $firstApprovalId = $hrUser ? $hrUser->id : null;
                }
            }

            $userData = array_merge([
                'employee_id' => ++$userIndex,
                'name' => $name,
                'slug' => Str::slug($name),
                'gender' => rand(0, 1),
                'is_married' => rand(0, 1),
                'province' => rand(1, 7),
                'district' => rand(1, 77),
                'blood_group' => rand(1, 8),
                'religion' => rand(1, 6),
                'dob' => Carbon::now()->subYears(rand(22, 40)),
                'interview_date' => $interviewDate,
                'joined' => $joinedDate,
                'designation' => Arr::random($designationIds),
                'password' => Hash::make('password'),
                'pin' => Hash::make('1234'),
                'is_head' => $overrides['is_head'] ?? 'no',
                'sec_approval_id' => $secApprovalId,
                'first_approval_id' => $firstApprovalId,
            ], $overrides);

            // Laravel 6 factory call:
            $user = factory(User::class)->create($userData);

            DB::table('pivot_user_contracts')->insert([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'contract_id' => Arr::random($contractTypes),
                'start_date' => $user->joined->format('Y-m-d'),
                'expiry_date' => Carbon::parse($user->joined)->addYear()->format('Y-m-d'),
                'renew_date' => Carbon::parse($user->joined)->addYears(2)->format('Y-m-d'),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('salaries')->insert([
                'user_id' => $user->id,
                'salary' => rand(30000, 100000),
                'from' => $user->joined->format('Y-m-d'),
                'to' => null,
                'is_active' => 1,
                'is_upgraded' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return $user;
        };

        // Create CEO first and store the user
        $ceoUser = $createUserWithDetails([
            'name' => 'CEO',
            'email' => 'ceo@hr.com',
            'role' => 2,
            'department_id' => $topLevel->id,
            'is_head' => 'yes',
        ]);

        // Create HR first and store the user
        $hrUser = $createUserWithDetails([
            'name' => 'HR',
            'email' => 'hr@hr.com',
            'role' => 3,
            'department_id' => $topLevel->id,
            'is_head' => 'yes',
        ]);

        // Create Line Manager for every department (except Top Level)
        foreach ($departments->where('id', '!=', $topLevel->id) as $department) {
            $lineManagers[$department->id] = $createUserWithDetails([
                'role' => 4,
                'department_id' => $department->id,
                'is_head' => 'yes',
                'name' => 'Line Manager ' . $department->name,
                'email' => 'manager_' . Str::slug($department->name) . '@hr.com',
            ]);
        }

        // Create Staff (5 per department)
        foreach ($departments->where('id', '!=', $topLevel->id) as $department) {
            for ($i = 1; $i <= 5; $i++) {
                $createUserWithDetails([
                    'role' => 5,
                    'department_id' => $department->id,
                    'is_head' => 'no',
                    'name' => 'Staff ' . $department->name . ' #' . $i,
                ]);
            }

            // Add Office Driver and Office Support for each department
            $createUserWithDetails([
                'role' => 6, // Set correct role ID for Office Driver
                'department_id' => $department->id,
                'is_head' => 'no',
                'name' => 'Office Driver',
                'email' => 'officedriver_' . Str::slug($department->name) . '@hr.com',
            ]);

            $createUserWithDetails([
                'role' => 7, // Set correct role ID for Office Support
                'department_id' => $department->id,
                'is_head' => 'no',
                'name' => 'Office Support',
                'email' => 'officesupport_' . Str::slug($department->name) . '@hr.com',
            ]);
        }
    }
}
