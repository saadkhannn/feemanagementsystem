<?php

function shift($employee, $date, $shift){
	$search = $employee->shifts->where('from', '<=', $date)->sortByDesc('from');
	return isset($search[0]) ? $search->first()->shift : $shift;
}

function nightShift($shift){
    return (isset($shift->from) && date('H', strtotime($shift->from)) >= 20);
}

function late($shift, $in){
	return strtotime($in) && new \DateTime(date('H:i:s', strtotime($in))) > new \DateTime($shift->from) ? timeDifference(date('H:i:s', strtotime($in)), $shift->from) : false;
}

function early($shift,$out){
	return strtotime($out) && new \DateTime(date('H:i:s', strtotime($out))) < new \DateTime($shift->to) ? timeDifference($shift->to, date('H:i:s', strtotime($out))) : false;
}

function checkWeekend($date,$weekends){
	$weekend = false;

	$weekends = json_decode($weekends,true);
	if(isset($weekends[0])){
		if(in_array(date('N', strtotime($date)), $weekends)){
			$weekend = true;
		}
	}

	return $weekend;
}

function checkHoliday($date, $holidays){
	return $holidays->where('date', $date)->count() > 0;
}

function checkLeave($date, $employee, $leaves){
	return $leaves->where('employee_id', $employee->id)->count() > 0 ? $leaves->where('employee_id', $employee->id)->first()->id : 0;
}

function onSpecialDuty($date, $employee, $onSpecialDuties){
	$duties = $onSpecialDuties->where('employee_id', $employee->id)->where('date', $date);
	$seconds = 0;
	if($duties->count() > 0){
		foreach($duties as $key => $duty){
			$seconds += timeToSeconds($duty->twh);
		}
	}

	return $seconds > 0 ? gmdate("H:i:s", $seconds) : false;
}

function workingFromHome($date,$employee, $workingFromHomes){
	$homes = $workingFromHomes->where('employee_id', $employee->id)->where('date', $date);
	$seconds = 0;
	if($homes->count() > 0){
		foreach($homes as $key => $home){
			$seconds += timeToSeconds($home->twh);
		}
	}

	return $seconds > 0 ? gmdate("H:i:s", $seconds) : false;
}

function calculateOvertime($date, $employee, $otApplications, $shift, $twh){
	$ot = false;

	$ots = $otApplications->where('employee_id', $employee->id)->where('date', $date);
	$seconds = 0;
	if($ots->count() > 0){
		foreach($ots as $key => $otHour){
			$seconds += timeToSeconds($otHour->ot);
		}
	}

	$permittedOT = gmdate("H:i:s", $seconds);
	$hours = timeDifference($shift->from, $shift->to);

	if($seconds > 0){
		if(new \DateTime($twh) > new \DateTime($hours)){
			$ot = timeDifference($twh,$hours);
			if(new \DateTime($ot) > new \DateTime($permittedOT)){
				$ot = $permittedOT;
			}
		}
	}

	return $ot;
}

function timeDifference($from,$to)
{
	if(strtotime($from) && strtotime($to)){
		$start_date = new DateTime($from);
	    $diff = $start_date->diff(new DateTime($to));

	    return date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s));
	}

	return false;
    
}

function attendanceStatus($attendance){
	$status = '';

	if($attendance->present == 1){
		$status .= '<a class="btn btn-sm btn-success text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Present">&nbsp;P&nbsp;</a>';
	}else{
		if($attendance->weekend == 0 && $attendance->holiday == 0 && !$attendance->leaveApplication){
			$status .= '<a class="btn btn-sm btn-danger text-white mr-1" style="padding: 1px 3px !important" title="Absent">&nbsp;A&nbsp;</a>';
		}
	}

	$status .= $attendance->weekend == 1 ? '<a class="btn btn-sm btn-danger text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Weekend">&nbsp;W&nbsp;</a>' : '';
	$status .= $attendance->holiday == 1 ? '<a class="btn btn-sm btn-success text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Holiday">&nbsp;H&nbsp;</a>' : '';
	$status .= strtotime($attendance->late) ? '<a class="btn btn-sm btn-danger text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Late">&nbsp;L&nbsp;</a>' : '';
	$status .= strtotime($attendance->early) ? '<a class="btn btn-sm btn-danger text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Early Exit">&nbsp;E&nbsp;</a>' : '';
	$status .= strtotime($attendance->on_special_duty) ? '<a class="btn btn-sm btn-success text-white mr-1 mb-1" style="padding: 1px 3px !important" title="On Special Duty">&nbsp;OSD&nbsp;</a>' : '';
	$status .= strtotime($attendance->working_from_home) ? '<a class="btn btn-sm btn-success text-white mr-1 mb-1" style="padding: 1px 3px !important" title="Working from Home">&nbsp;WFH&nbsp;</a>' : '';
	$status .= $attendance->leaveApplication ? '<a class="btn btn-sm btn-success text-white mr-1 mb-1" style="padding: 1px 3px !important" title="'.$attendance->leaveApplication->leaveType->name.'">&nbsp;Leave&nbsp;</a>' : '';


	return $status;
}