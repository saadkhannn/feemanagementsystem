<?php
function systemInformation(){
    return \Modules\Setups\Entities\SystemInformation::find(1);
}

function userColumnVisibilities(){
    $columnVisibilities = \Modules\Setups\Entities\UserColumnVisibility::where([
        'user_id' => auth()->user()->id,
        'url' => request()->fullUrl()
    ])->first();
    if(isset($columnVisibilities->id)){
        $columns = (!empty($columnVisibilities->columns) && is_array(json_decode($columnVisibilities->columns, true)) ? json_decode($columnVisibilities->columns, true) : []);
        $hidden = [];
        if(isset($columns[0])){
            foreach ($columns as $key => $column) {
                if($column == "false"){
                    array_push($hidden, $key);
                }
            }
        }

        return $hidden;
    }

    return [];
}

function sendEmail($user, $subject, $message){
    \Mail::send('emails.notification', ['msg' => $message], function ($msg) use ($user, $subject){
        $msg
          ->to($user->email, $user->first_name.' '.$user->last_name)
          ->subject($subject);
    });
}

function genders(){
    return array(
        'Female',
        'Male',
        'Others',
    );
}

function maritalStatus(){
    return array(
        'Single',
        'Married',
        'Divorced',
    );
}

function bloodGroups(){
    return array(
        'N/A',
        'A+',
        'A-',
        'B+',
        'B-',
        'O+',
        'O-',
        'AB+',
        'AB-',
    );
}

function weekDays(){
    return array(
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday",
    );
}

function weekDaysIndex(){
    return array(
        "Monday" => 0,
        "Tuesday" => 1,
        "Wednesday" => 2,
        "Thursday" => 3,
        "Friday" => 4,
        "Saturday" => 5,
        "Sunday" => 6,
    );
}

function minutesDifference($from,$to)
{
    $start_date = new DateTime($from);
    $since_start = $start_date->diff(new DateTime($to));
    $minutes = $since_start->days * 24 * 60;
    $minutes += $since_start->h * 60;
    $minutes += $since_start->i;
    return $minutes;
}

function freeLinks()
{
    return \Modules\Setups\Entities\FreeLink::where('status',1)->pluck('route')->toArray();
}

function this_url(){
    return request()->route()->uri;
}

function getModule($url)
{
    $module=\Modules\Setups\Entities\Module::where('route', trim($url))->first();
    if(isset($module->id)){
        return $module;
    }
    return false;
}

function getMenu($url)
{
    $menu=\Modules\Setups\Entities\Menu::where('route', trim($url))->first();
    if(isset($menu->id)){
        return $menu;
    }
    return false;
}

function getSubmenu($url)
{
    $submenu=\Modules\Setups\Entities\Submenu::with([
        'menu'
    ])->where('route', trim($url))->first();
    if(isset($submenu->id)){
        return $submenu;
    }
    return false;
}

function checkPermission($needle,$haystack,$option){
    
    if(isset(json_decode($haystack,true)[$option])){
        $haystack=json_decode($haystack,true)[$option];
        if(isset($haystack[0])){
            if(in_array($needle, $haystack)){
                return true;
            }
        }
    }

    return false;
}

function shiftTypes($key=false){
    $types=array(
        '7 hours (+1 hour Lunch)',
        '8 hours (+1 hour Lunch)',
    );

    if($key){
        if(array_key_exists($key, $types)){
            return $types[$key];
        }
    }

    return $types;
}

function nameWithoutUID($employee){
    return $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name; 
}

function nameWithUID($employee){
    return $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' ('.$employee->uid.')'; 
}

function leaveTypes(){
    return array(
        "Full Day",
        "Half Day (First Half)",
        "Half Day (Second Half)",
    );
}

function dateRange($from, $to, $format = "Y-m-d")
{
    $range = [];
    if(strtotime($from) && strtotime($to)){
        $begin = new \DateTime($from);
        $end = new \DateTime($to);

        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($begin, $interval, $end);

        
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }
        array_push($range, date('Y-m-d',strtotime($to)));
    }

    return $range;
}

function timeDiff($from,$to)
{
    $start_date=new \DateTime($from);
    $end_date=new \DateTime($to);
    $difference=$end_date->diff($start_date);
    return json_decode(json_encode($difference),true);
}

function viewMPDF($view, $data, $title, $filename, $format = 'a4', $orientation = 'P'){
    \PDF::loadView($view, $data, [], [
      'title'      => $title,
      'margin_top' => 0,
      'showImageErrors' => true,
      'format' => $format,
      'orientation' => $orientation,
      //'show_watermark_image' => true,
      //'display_mode' => 'fullpage',
      //'watermark_image_path' => public_path('/assets/idcard/letterhead/mbm_letterhead.png'),
      //'watermark_image_size'       => 'D',
    ])->stream($filename.'.pdf');
}

function outputMPDF($view, $data, $title, $filename, $format = 'a4', $orientation = 'P'){
    return \PDF::loadView($view, $data, [], [
      'title'      => $title,
      'margin_top' => 0,
      'showImageErrors' => true,
      'format' => $format,
    ])->output();
}

function downloadMPDF($view, $data, $title, $filename, $format = 'a4', $orientation = 'P'){
    \PDF::loadView($view, $data, [], [
      'title'      => $title,
      'margin_top' => 0,
      'showImageErrors' => true,
      'orientation' => $orientation
    ])->download($filename.'_'.date('Y-m-d g:i a').'.pdf');
}

function getSidebar(){
    if(!session()->has('sidebar')){
        session()->put('sidebar', view('layouts.sidebar')->render());
    }

    return session()->get('sidebar');
}

function required(){
    return '<strong class="text-danger">*</strong>';
}

function datatableOrdering(){
    $order = false;
    if(isset(request()->order[0])){
        foreach(request()->order as $key => $ordering){
            if($ordering['column'] != 0){
                $order = $ordering;
            }
        }
    }

    return $order;
}

function pleaseSortMe($query, $order, $orderByQuery){
    return $query->when($order == 'asc', function($query) use($orderByQuery){
        return $query->orderBy($orderByQuery);
    })
    ->when($order == 'desc', function($query) use($orderByQuery){
        return $query->orderByDesc($orderByQuery);
    });
}

function downloadExcel($view, $data, $name, $type = 'xlsx'){
    return \Excel::download(new \App\Exports\Excel($view, $data), $name.'('.date('F j,Y g:i a').')'.'.'.$type);
}

function makeResourcePermissions($prefix){
    return [
        $prefix.'-index',
        $prefix.'-create',
        $prefix.'-edit',
        $prefix.'-delete',
    ];
}

function availablePersons(){
    $allPermissions = [
        'all-users',
        'my-team-users',
        'authorized-users',
        'function-users',
        'sub-function-users',
        'team-users',
        'category-users',
        'brand-users',
        'legal-entity-users',
        'religion-users',
        'country-users'
    ];

    $employee = \Modules\Peoples\Entities\Employee::findOrFail(auth()->user()->employee_id);
    return \Modules\Peoples\Entities\Employee::whereNotNull('id')
    ->when(!auth()->user()->anyPermissions($allPermissions), function($query) use($employee){
        return $query->where('id', $employee->id);
    })
    ->when(auth()->user()->anyPermissions($allPermissions), function($query) use($employee){
        return $query->when(auth()->user()->allPermissions(['my-team-users']), function($query) use($employee){
            return $query->orWhere('reporting_manager_id', $employee->id);
        })
        ->when(auth()->user()->allPermissions(['authorized-users']), function($query) use($employee){
            return $query->orWhere('authorized_person_id', $employee->id);
        })
        ->when(auth()->user()->allPermissions(['designation-users']), function($query) use($employee){
            return $query->orWhere('designation_id', $employee->designation_id);
        })
        ->when(auth()->user()->allPermissions(['function-users']), function($query) use($employee){
            return $query->orWhere('function_id', $employee->function_id);
        })
        ->when(auth()->user()->allPermissions(['sub-function-users']), function($query) use($employee){
            return $query->orWhere('sub_function_id', $employee->sub_function_id);
        })
        ->when(auth()->user()->allPermissions(['team-users']), function($query) use($employee){
            return $query->orWhere('team_id', $employee->team_id);
        })
        ->when(auth()->user()->allPermissions(['category-users']), function($query) use($employee){
            return $query->orWhere('category_id', $employee->category_id);
        })
        ->when(auth()->user()->allPermissions(['brand-users']), function($query) use($employee){
            return $query->orWhere('brand_id', $employee->brand_id);
        })
        ->when(auth()->user()->allPermissions(['legal-entity-users']), function($query) use($employee){
            return $query->orWhere('legal_entity_id', $employee->legal_entity_id);
        })
        ->when(auth()->user()->allPermissions(['religion-users']), function($query) use($employee){
            return $query->orWhere('religion_id', $employee->religion_id);
        })
        ->when(auth()->user()->allPermissions(['country-users']), function($query) use($employee){
            return $query->orWhere('country_id', $employee->country_id);
        })
        ->when(auth()->user()->allPermissions(['native-users']), function($query) use($employee){
            return $query->orWhere('id', $employee->id);
        });
    })->pluck('id')->toArray();
}

