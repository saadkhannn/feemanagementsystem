<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\Setups\Entities\Role;
use DB, DataTables;

class RoleReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        request()->merge([
            'anyPermissionArray' => [
                'role-report-index',
                'role-report-index-print',
                'role-report-index-pdf',
                'role-report-index-excel',
            ],
            'allPermissionArray' => []
        ]);
        $this->middleware('check_permission');
    }
    
    public function index()
    {
        $data = [
            'title' => 'Roles',
            'roles' => Role::all(),
        ];

        if(request()->get('type') == 'print'){
            // return view('report::roles.pdf', $data);
            return viewMPDF('report::roles.pdf', $data, $data['title'], $data['title'], 'a4', 'L');
        }

        if(request()->get('type') == 'pdf'){
            return downloadMPDF('report::roles.pdf', $data, $data['title'], $data['title'], 'a4', 'L');
        }

        if(request()->get('type') == 'excel'){
            return downloadExcel('report::roles.excel', $data, $data['title']);
        }

        return view('report::roles.index', $data);
    }
}
