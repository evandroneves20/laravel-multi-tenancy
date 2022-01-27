<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Master\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $manager = app(ManagerTenant::class);

        if ($manager->domainIsMaster()) {
            return $next($request);
        }

        $company = $this->getCompany($request->getHost());

        if (!$company && $request->url() != route('404.company')) {
            return redirect()->route('404.company');
        } elseif ($company && $request->url() != route('404.company') && !$manager->domainIsMaster()) {
            $manager->setConnection($company);

            Session::put('company', $company);
        }

        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)
            ->orWhere('domain', "www.{$host}")->first();
    }
}
