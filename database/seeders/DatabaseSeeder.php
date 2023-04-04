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
        $this->call(ApprovalCategorySeeder::class);
        \App\Models\User::factory(10)->create();
        $this->call(ReportCategorySeeder::class);
        $this->call(ReasonCategorySeeder::class);
    }
}
