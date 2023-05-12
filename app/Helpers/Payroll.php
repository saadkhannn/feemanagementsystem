<?php

function taxCalculation($employee_id, $year, $month, $payable){
    $employee = \Modules\Peoples\Entities\Employee::find($employee_id);

    $starter = 0;
    $tax_id = 0;
    $tax_rule_id = 0;
    $taxable = 0;
    $tax_percentage = 0;
    $tax = 0;

    $taxRules = \Modules\Setups\Entities\Tax::where('status',1)
                    ->where('date','<=',date('Y-m-01',strtotime($year.'-'.$month)))
                    ->orderBy('date','desc')
                    ->first();
    if(isset($taxRules->id)){
        $tax_id = $taxRules->id;
        $starter = $taxRules->starter;
        if($employee->gender == 0){
            $starter = $taxRules->starter_for_female;
        }elseif($employee->gender == 1){
            $starter = $taxRules->starter_for_male;
        }

        if(($payable*12) > $starter){
            $rules = collect($taxRules->rules);
            $rule = $rules->where('amount_from','<=',($payable*12))->where('amount_to','>=',($payable*12))->first();
            if(isset($rule->id)){
                $tax_rule_id = $rule->id;
                $taxable = ($payable*12)-$starter;
                $tax_percentage = $rule->tax_percentage;
                if($rule->tax_percentage > 0){
                    $tax = $taxable*($rule->tax_percentage/100);
                }
            }
        }
    }

    $taxable = $taxable>0 ? $taxable/12 : 0;
    $tax = $tax>0 ? $tax/12 : 0;
    return array(
        'taxable' => decimal($taxable),
        'tax_id' => $tax_id,
        'tax_rule_id' => $tax_rule_id,
        'tax_percentage' => decimal($tax_percentage),
        'tax' => decimal($tax),
    );
}

function dailySalary($employee, $year, $month)
{
    $gross = 0;
    $basic = 0;

    $salaries = $employee->salaries->where('date', '<=', date('Y-m-01', strtotime($year.'-'.$month)))->sortByDesc('date');
    if($salaries->count() > 0){
        $salary = $salaries->first();
        $gross = $salary->gross_amount;
        
        $salaryHeads = collect($salary->salaryHeads);
        if(isset($salaryHeads[0])){
            foreach ($salaryHeads as $key => $head) {
                if($head->salaryHead->basic == 1){
                    $basic = $head->amount;
                }
            }
        }
    }

    $start_date = date('Y-m-01',strtotime($year.'-'.$month));
    $end_date = date('Y-m-t',strtotime($year.'-'.$month));
    $dateRange = dateRange($start_date,$end_date);

    $gross = $gross > 0 ? decimal($gross/count($dateRange)) : 0;
    $basic = $basic > 0 ? decimal($basic/count($dateRange)) : 0;

    return array(
        'gross' => $gross,
        'basic' => $basic,
    );
}