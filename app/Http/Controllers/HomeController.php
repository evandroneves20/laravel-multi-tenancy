<?php

namespace App\Http\Controllers;

use App\Models\Master\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //
    public function index()
    {
        if (app(ManagerTenant::class)->domainIsMaster()) {
            $companies = Company::all();
            return view('master', ['companies' => $companies]);
        }else{
            $company = Session::get('company');
            ////lista de posts etc...
            return view('tenant', ['company' => $company]);
        }
    }

    public function companyNotFound()
    {
        return view('errors.404-company');
    }
}
