<?php
function age($date){
	$interval = date_diff(date_create(), date_create($date));
    $years = $interval->format("%Y");
    $months = $interval->format("%M");
    $days = $interval->format("%d");
    
    return array(
    	'years' => $years,
    	'months' => $months,
    	'days' => $days,
    );
}

function ageInText($date){
	$age=age($date);
	return $age['years'].' Years '.$age['months'].' Months '.$age['days'].' days';
}

function timeToSeconds($time) {
    return strtotime($time) - strtotime('00:00:00');
}

function is_save($object,$message){
	if($object){
		success($message);
		return redirect()->back();
	}

	whoops();
	return redirect()->back();
}

function employeeName($employee)
{
	return $employee ? $employee->first_name.' '.$employee->last_name : '';
}

function employeeNameUID($employee)
{
	return $employee ? $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name.' ('.$employee->uid.')' : '';
}

function leaveBalances($employee, $year, $type_id = false){
    $balances = [];

    $leaves = \Modules\Leave\Entities\Leave::where('employee_id', $employee->id)
		            			->where(\DB::raw('substr(`from`, 1, 10)'), $year)
		            			->get();
	$leaves = collect($leaves);	            		

    $types = \Modules\Setups\Entities\LeaveType::where('status',1)
    		->when($type_id, function($query) use($type_id){
    			return $query->where('id', $type_id);
    		})
    		->get();
    if(isset($types[0])){
        foreach ($types as $key => $type) {
            $enabled = true;
            if($type->gender_oriented == 1 && $type->gender != $employee->gender){
                $enabled = false;
            }

            if($enabled){
            	$balances[$type->id] = array(
            		'type' => $type,
            		'applied' => $leaves->where([
                        'leave_type_id' => $type->id,
                    ])->count(),
            		'approved' => $leaves->where([
                        'leave_type_id' => $type->id,
                        'status' => 1
                    ])->count(),
            		'denied' => $leaves->where([
                        'leave_type_id' => $type->id,
                        'status' => 2
                    ])->count(),
            		'pending' => $leaves->where([
                        'leave_type_id' => $type->id,
                        'status' => 0
                    ])->count(),
            		'balance' => $type->balance - $leaves->where([
                        'leave_type_id' => $type->id,
                        ['status', '!=', 2]
                    ])->count(),
            	);
            }
        }
    }

    if($type_id && array_key_exists($type_id,$balances)){
    	return $balances[$type_id];
    }

    return $balances;
}

function success($message='Your operation has been done successfully'){
	session()->flash('success',$message);
}

function whoops($message='Whoops! Something went Wrong!'){
	session()->flash('danger',$message);
}

function redirectWithSuccess($message='Your operation has been done successfully'){
    session()->flash('success', $message);
    return redirect()->back();
}

function redirectWithError($message='Whoops! Something went Wrong!'){
    session()->flash('danger', $message);
    return redirect()->back();
}

function timeToHours($time){
    $seconds=0;
    $h=0;
    $m=0;
    $s=0;
    $explode = explode(':', $time);
    if(isset($explode[0]) && $explode[0]>0){
        $h = $explode[0];
    }
    if(isset($explode[1]) && $explode[1]>0){
        $m = $explode[1];
    }
    if(isset($explode[2]) && $explode[2]>0){
        $s = $explode[2];
    }
    
    if (isset($explode[0]) && isset($explode[1]) && isset($explode[2])) {
        $seconds += $h * 3600 + $m * 60 + $s;
    }
    if($seconds <= 0){
        $hours=0;
    }else{
        $hours = $seconds/3600;
    }
    return number_format((float)$hours, 2, '.', '');
}

function inWord($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'System only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . inWord(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . inWord($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = inWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= inWord($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function hoursToTime($time)
{
    return gmdate('H:i:s', floor($time * 3600));
}

function decimal($value){
    return number_format((float)$value, 2, '.', '');
}

function roundedDecimal($value){
    return round(number_format((float)$value, 2, '.', ''));
}

function halfDay($employee_id, $date){
    if(strtotime($date)){
        $shift = \Modules\Peoples\Entities\EmployeeShift::where([
            'employee_id' => $employee_id,
            'status' => 1,
            ['from','<=',date('Y-m-d',strtotime($date))],
        ])
        ->whereHas('shift',function($query){
            return $query->where('status',1);
        })
        ->orderBy('id','desc')
        ->first();

        if(isset($shift->id)){
            $shift->shift->type==0 ? $halfDayHours='4 hours' : $halfDayHours='4 hours 30 minutes';

            $full_day = array(
                            'start' => date('g:i A',strtotime($shift->shift->from)),
                            'end' => date('g:i A',strtotime($shift->shift->to)),
                        );
            $first_half =   array(
                                'start' => date('g:i A',strtotime($shift->shift->from)),
                                'end' => date('g:i A',strtotime("+$halfDayHours", strtotime($shift->shift->from))),
                            );
            $second_half =  array(
                                'start' => date('g:i A',strtotime("+$halfDayHours", strtotime($shift->shift->from))),
                                'end' => date('g:i A',strtotime($shift->shift->to)),
                            );
            return [
                'success' => true,
                'times' =>  array($full_day,$first_half,$second_half)
            ];
        }

        return [
            'success' => false
        ];
    }else{
        return [
            'success' => false
        ];
    }
}


function reportEmployees(){
    return \Modules\Peoples\Entities\Employee::where('status',1)->orderBy('first_name','asc')
    ->when(request()->has('function_id') && request()->get('function_id') > 0, function($query){
        return $query->where('function_id', request()->get('function_id'));
    })
    ->when(request()->has('sub_function_id') && request()->get('sub_function_id') > 0, function($query){
        return $query->where('sub_function_id', request()->get('sub_function_id'));
    })
    ->when(request()->has('team_id') && request()->get('team_id') > 0, function($query){
        return $query->where('team_id', request()->get('team_id'));
    })
    ->when(request()->has('job_level_id') && request()->get('job_level_id') > 0, function($query){
        return $query->where('job_level_id', request()->get('job_level_id'));
    })
    ->when(request()->has('shift_id') && request()->get('shift_id') > 0, function($query){
        return $query->whereHas('shifts', function($query){
            return $query->where('shift_id', request()->get('shift_id'));
        });
    })
    ->when(request()->has('job_location_id') && request()->get('job_location_id') > 0, function($query){
        return $query->where('job_location_id', request()->get('job_location_id'));
    })
    ->when(request()->has('gender') && request()->get('gender') >= 0, function($query){
        return $query->where('gender', request()->get('gender'));
    })
    ->when(request()->has('religion_id') && request()->get('religion_id') > 0, function($query){
        return $query->where('religion_id', request()->get('religion_id'));
    })
    ->when(request()->has('designation_id') && request()->get('designation_id') > 0, function($query){
        return $query->where('designation_id', request()->get('designation_id'));
    })
    ->when(request()->has('category_id') && request()->get('category_id') > 0, function($query){
        return $query->where('category_id', request()->get('category_id'));
    })
    ->when(request()->has('brand_id') && request()->get('brand_id') > 0, function($query){
        return $query->where('brand_id', request()->get('brand_id'));
    })
    ->when(request()->has('legal_entity_id') && request()->get('legal_entity_id') > 0, function($query){
        return $query->where('legal_entity_id', request()->get('legal_entity_id'));
    })
    ->when(request()->has('uid') && !empty(request()->get('uid')), function($query){
        return $query->where('uid', 'LIKE', '%'.request()->get('uid').'%');
    })
    ->pluck('id')->toArray();
}

function humanReadableTime($time){
    $explode = explode(':', $time);
    return (isset($explode[0]) && $explode[0] > 0 ? ' '.(int)($explode[0]).'h' : '').(isset($explode[1]) && $explode[1] > 0 ? ' '.(int)($explode[1]).'m' : '').(isset($explode[2]) && $explode[2] > 0 ? ' '.(int)($explode[2]).'s' : '');
}
