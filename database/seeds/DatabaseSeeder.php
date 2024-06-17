<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContractTypeTableSeeder::class);
        $this->call(CompanySettingSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(EngMonthSeeder::class);
        $this->call(IncomeTaxesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(BloodGroupAndReligionSeeder::class);
        $this->call(LeaveTypesSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
