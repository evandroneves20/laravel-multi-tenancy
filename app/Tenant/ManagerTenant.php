<?php

namespace App\Tenant;

use App\Models\Master\Company;
use Illuminate\Support\Facades\DB;

class ManagerTenant
{
    public function setConnection(?Company $company, $master = false)
    {
        if ($master) {
            $db_master = config('tenant.db_master');
            config()->set('database.connections.mysql.database', $db_master);
        } else {
            config()->set('database.connections.mysql.database', $company->bd_database);
        }

        DB::purge('mysql');

        DB::connection('mysql');
    }

    public function domainIsMaster()
    {
        return request()->getHost() === config('tenant.domain_master');
    }
}
