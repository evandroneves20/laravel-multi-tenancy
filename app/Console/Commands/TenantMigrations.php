<?php

namespace App\Console\Commands;

use App\Models\Master\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    private $tenant;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {domain?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executa as Migrations para os Clientes/Tenants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     *
     * @return void
     */
    public function handle()
    {
        $domain = $this->argument('domain');

        // executa a migration apenas na company passada como argumento.
        if ($domain) {
            $company = Company::where('domain', $domain)->first();

            if ($company) {
                $this->execCommand($company);
                exit();
            }

            $this->info("Company não encontrada");
            exit();
        }

        $companies = Company::all();

        foreach ($companies as $company) {
            $this->execCommand($company);
        }
    }

    /**
     * Executa a migration
     * @param Company $company
     * @return void
     */
    private function execCommand(Company $company)
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $this->tenant->setConnection($company);

        $this->info("Conectando Company {$company->name}");

        Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);

        $this->info("Fim conectando Company {$company->name}");
        $this->info("---------------------------------------");
    }
}
