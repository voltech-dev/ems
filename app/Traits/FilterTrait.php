<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

error_reporting(0);
trait FilterTrait
{
    public function filterOperation($params, $query)
    {

        $filter_rowcount = (count($params)) / 3;
        $start = 0;
        $cond = 1;
        for ($i = 0; $i < $filter_rowcount; $i++) {
           
            for ($j = $start; $j < $cond; $j++) {
               
                if (!is_null($params[$j]['value'])) {
                    $array_value = array_filter(explode(',', $params[$j]['value']));
                    // Relatuional table value
                    if (count($array_value) > 2) {
                        $Relationalfield = $array_value['4'];
                        $RelationalModel = DB::table($array_value['2'])->where($array_value['3'], $params[$j + 2]['value'])->first();
                        $searchValue = $RelationalModel->$Relationalfield;                       
                    } else {
                         $searchValue = $params[$j + 2]['value'];
                    }
                   
                    // datetime and date process

                    // conditonal operation
                   if ($params[$j + 1]['value'] == 'like') {
                        $query->where($array_value['0'], $params[$j + 1]['value'], '%' . $searchValue . '%');
                    } else if ($params[$j + 1]['value'] == 'between' && ($array_value[1] == 'datetime' || $array_value[1] == 'date')) {
                        if ($array_value[1] == 'datetime') {
                            $date_array = array_map('trim', explode('-', $params[$j + 2]['value']));
                            $startdate = explode('/', $date_array['0']);
                            $enddate = explode('/', $date_array['1']);                          
                            $start = Carbon::createMidnightDate($startdate['2'], $startdate['1'], $startdate['0'], 'Asia/Kolkata');
                            $end = Carbon::create($enddate['2'], $enddate['1'], $enddate['0'], 23, 59, 59, 'Asia/Kolkata');
                        } else if ($array_value[1] == 'date') {
                            $date_array = array_map('trim', explode('-', $params[$j + 2]['value']));
                            $startdate = explode('/', $date_array['0']);
                            $enddate = explode('/', $date_array['1']);
                            $start = Carbon::create($startdate['2'], $startdate['1'], $startdate['0'], 0, 0, 0, 'Asia/Kolkata')->format('Y-m-d');
                            $end = Carbon::create($enddate['2'], $enddate['1'], $enddate['0'], 0, 0, 0, 'Asia/Kolkata')->format('Y-m-d');
                        }
                        $query->whereBetween($array_value['0'], [$start, $end]);
                    } else if ($params[$j + 1]['value'] != 'between' && ($array_value[1] == 'datetime' || $array_value[1] == 'date')) {
                        if ($array_value[1] == 'datetime') {                           
                            $searchDate =  date('Y-m-d H:i:s',strtotime($params[$j + 2]['value']));
                        } else if ($array_value[1] == 'date') {                        
                            $searchDate =  date('Y-m-d',strtotime($params[$j + 2]['value']));                       
                        }
                        $query->where($array_value['0'], $params[$j + 1]['value'], $searchDate);
                    } else {
                        $query->where($array_value['0'], $params[$j + 1]['value'], $searchValue);
                    } 
                   
                }
            }  
             
            $start = $j + 2;
            $cond = $cond + 3;
        }
       
        
        
    }
}
