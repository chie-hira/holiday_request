<?php

namespace Database\Seeders;

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
        $this->call(DepartmentCategorySeeder::class);
        $this->call(FactoryCategorySeeder::class);
        $this->call(GroupCategorySeeder::class);
        $this->call(CalenderCategorySeeder::class);
        $this->call(DateCategorySeeder::class);
        $this->call(CalenderSeeder::class);
        $this->call(AffiliationSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ApprovalCategorySeeder::class);
        $this->call(ApprovalSeeder::class);
        $this->call(AcquisitionFormSeeder::class);
        $this->call(ReportCategorySeeder::class);
        $this->call(SubReportCategorySeeder::class);
        $this->call(ReasonCategorySeeder::class);
        $this->call(ReasonSeeder::class);
        $this->call(AcquisitionDaySeeder::class);
        $this->call(ShiftCategorySeeder::class);
        $this->call(ReportSeeder::class);
    }
}
