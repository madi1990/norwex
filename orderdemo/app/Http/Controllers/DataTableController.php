<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Customer;
use App\Http\Models\CustomerStatus;
use Illuminate\Support\Facades\DB;

class DataTableController extends Controller
{
    public function __construct(){
    }

    private function emptyResponse(){
		return response()->json(['data'=>'','options'=>'','files'=>'','draw'=>'1','recordsTotal'=>'0','recordsFiltered'=>'0']);exit();
    }
    
    public function getData(Request $request, $dataset){
        switch($dataset){
            case 'orderOverview':
                return $this->orderOverview($request);
                break;
            default:
                return $this->emptyResponse();
        }
    }

    private function orderOverview(Request $request){
        $pageSize = (!empty($request->input('length')) ? $request->input('length') : 10);
        $start = (!empty($request->input('start')) ? $request->input('start') : 0);
        $draw = $request->input('draw');
        //order by parameters
        $orderFieldId = (!empty($request->input('order')[0]) ? $request->input('order')[0]['column'] : '0');
        $orderDir = (!empty($request->input('order')[0]) ? $request->input('order')[0]['dir'] : 'desc');
        $orderField = $request->input('columns')[$orderFieldId]['data'];
        $order = '';
        if(!empty($orderField)) $order = "ORDER BY $orderField $orderDir";

        $data = DB::select("SELECT SQL_CALC_FOUND_ROWS * FROM Customer $order LIMIT $start, $pageSize");
        $orangeData = array();
        $greenData = array();
        $recordsTotal = DB::select("SELECT FOUND_ROWS() AS total")[0]->total;

		if(!empty($data)){
            // Active customers who have not placed any orders during the last 12 months
            $currentDate = new \DateTime();
            $lastYear = $currentDate->sub(new \DateInterval('P1Y'))->format('Y-m-d');            
            $orangeQuery = "SELECT c.CustomerId FROM Customer c
				INNER JOIN CustomerStatus cs ON c.CustomerStatusId = cs.CustomerStatusId
				WHERE c.CustomerId NOT IN 
                (SELECT distinct(CustomerId) FROM `Order` WHERE CreatedDateTime >= '". $lastYear ."') 
                AND cs.Code = 'AC';";
            $queryData = DB::select($orangeQuery);
            foreach($queryData as $element){
                $orangeData[$element->CustomerId] = $element;
            }

            // Active customers who have placed a minimum of AUD200.00 in sales over the last 3 months
            $currentDate = new \DateTime();
            $threeMonthsAgo = $currentDate->sub(new \DateInterval('P3M'))->format('Y-m-d');            
            $greenQuery = "SELECT c.CustomerId, sum(o.OrderTotal) AS sum, count(*) AS count FROM Customer c
				INNER JOIN CustomerStatus cs ON c.CustomerStatusId = cs.CustomerStatusId
                LEFT JOIN `Order` o ON c.CustomerId = o.CustomerId
				WHERE o.CreatedDateTime >= '". $threeMonthsAgo ."'
                AND cs.Code = 'AC' 
                GROUP BY o.CustomerId;";
            $queryData = DB::select($greenQuery);
            foreach($queryData as $element){
                $greenData[$element->CustomerId] = $element;
            }
		}
		$response['draw'] = $draw;
		$response['recordsTotal'] = (string)$recordsTotal;
		$response['recordsFiltered'] = (string)$recordsTotal;
		$response['data'] = array();
		$i = 1;
        if(empty($data)){return $this->emptyResponse();}
        $customerStatus = CustomerStatus::get()->toArray();
		foreach($data as $row){
			$response['data'][] = array('DT_RowId'=>"row_$i",'Customer' => $row, 'CustomerStatus' => $customerStatus, 'greenData' => $greenData, 'orangeData' => $orangeData);
			$i++;
		}
	    return json_encode($response); 
    }
}
