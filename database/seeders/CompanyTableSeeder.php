<?php

namespace Database\Seeders;

use App\Models\Master\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Tenant1',
            'domain' => 'post_tenant1',
            'bd_database' => 'db_tenant1'
        ]);

        Company::create([
            'name' => 'Tenant2',
            'domain' => 'post_tenant2',
            'bd_database' => 'db_tenant2'
        ]);
    }
}
