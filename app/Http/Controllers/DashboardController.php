<?php

namespace App\Http\Controllers;
use Helper;
use Validator;
use Hash;
use Session;
use Redirect;
//use App\User;
//use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Login as Login;
use App\Http\Models\Reports as Reports;
use App\Services\ebay\getcommon;
use DOMDocument;
class DashboardController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
	public function __construct(){
	 $value = Session::get('amaEbaySessId');
		if($value == ''){
			Redirect::to('/')->send();
		}
	}
    public function dashboard()
    {

		$result['InventoryItem']	 	= 	Helper::getCountInventory();
		$result['ebayOrders'] 			=	 	Helper::getCountEbayOrder();
		$result['amazonOrders'] 		= 	Helper::getCountAmazonOrder();
		$result['inventory'] 				= 	Reports::getInventoryData();

		//$result['profitAndLost'] = Helper::getProfitAndLost();
		//echo "<pre>";print_r($result['profitAndLost']);die;
		// foreach ($result['inventory'] as $key => $value) {
		// 		echo $value->startTimeEbay."<br>";
		// }
		// die;
		echo Helper::adminHeader();
		return view('dashboard.index',$result) ;

    }
		public function InventoryGraph(request $request)
		{

			if ($_GET['ajax'])
			{
					$type = $request->get('searchType');
					switch ($type) {
							case 'Day':
									$data['searchType'] = "Day";
									$data['startDate']  =	$request->get('startDate');
									$data['endDate'] 		=	$request->get('endDate');
									$param = array(
											'date' =>	$request->get('startDate'),
											'searchType' => 'Day'
									);
									$data['inventory'] 			 = Reports::InventoryGraph($param);
									$data['Amazoninventory'] = Reports::amazonInventoryGraph($param);
									break;
							case 'Month':
									$data['searchType'] = "Days";
									$data['startDate'] 	=	$request->get('startDate');
									$data['endDate'] 		=	$request->get('endDate');
									$param = array(
											'startDate' 	=>	$request->get('startDate'),
											'endDate' 		=>	$request->get('endDate'),
											'searchType' 	=> 'Days'
									);
									$data['inventory'] = Reports::InventoryGraph($param);
									$data['Amazoninventory'] = Reports::amazonInventoryGraph($param);
									break;
							case 'Days':
									$startDate 		= date('Y-m-d', strtotime($request->get('startDate')));
									$endDate 			= date('Y-m-d', strtotime($request->get('endDate')));
									$start 				= new \DateTime($startDate);
									$start->modify('first day of this month');
									$end 					= new \DateTime($endDate);
									$end->modify('first day of next month');
									$interval 		= \DateInterval::createFromDateString('1 month');
									$period 			= new \DatePeriod($start, $interval, $end);
									$output 			= [];
									foreach ($period as $dt) {
											$output[] = $dt->format("F");
									}
									if (empty($output)) {
											$output[] = date("F", strtotime($startDate));
									}

									if (in_array("February", $output)) {
											$date1 = strtotime($startDate);
											$date2 = strtotime($endDate);
											$months = 0;
											while (strtotime('+1 MONTH', $date1) < $date2) {
													$months++;
													$date1 = strtotime('+1 MONTH', $date1);
											}
											$diff = $months;
											$days = ($date2 - $date1 ) / (60 * 60 * 24);
											$days = intval($days);
											if ($days == 30 || $days == 27 || $days == 28 || $days == 29 || $days == 31) {
													$diff = $diff + 1;
													$days = 0;
											}
									} else {
											$date1 = strtotime($startDate);
											$date2 = strtotime($endDate);
											$months = 0;
											while (strtotime('+1 MONTH', $date1) < $date2) {
													$months++;
													$date1 = strtotime('+1 MONTH', $date1);
											}
											$diff = $months;
											$days = ($date2 - $date1 ) / (60 * 60 * 24);
											$days = intval($days);
											if ($days == 30 || $days == 31 || $days == 29 || $days == 28) {
													$diff = $diff + 1;
													$days = 0;
											}
									}
									$data['months'] = $output;
									$data['startDate'] =	$request->get('startDate');
									$data['endDate'] =	$request->get('endDate');
									if (($diff == 1 && $days >= 1) || $diff >= 2) {
											$data['searchType'] = "Months";
											$param = array(
													'startDate' =>	$request->get('startDate'),
													'endDate' =>	$request->get('endDate'),
													'searchType' => 'Months'
											);
									} else {
											$data['searchType'] = "Days";
											$param = array(
													'startDate' =>	$request->get('startDate'),
													'endDate' =>	$request->get('endDate'),
													'searchType' => 'Days'
											);
									}

									$data['inventory'] = Reports::InventoryGraph($param);
									$data['Amazoninventory'] = Reports::amazonInventoryGraph($param);
									break;
							case 'Year':
									$data['searchType'] = "Months";
									$data['months'] = Helper::getMonthsName();
									$data['startDate'] =	$request->get('startDate');
									$data['endDate'] =	$request->get('endDate');
									$param = array(
											'startDate'  =>	$request->get('startDate'),
											'endDate' 	 =>	$request->get('endDate'),
											'searchType' => 'Months'
									);
									$data['inventory'] = Reports::InventoryGraph($param);
									$data['Amazoninventory'] = Reports::amazonInventoryGraph($param);
									break;
					};
					return view('dashboard/InventoryGraph', $data);
			}
		}
		public function profitChart(request $request)
		{
			if ($_GET['ajax'])
			{
					$param = array(
						'startDate' 	=>	$request->get('startDate'),
						'endDate' 		=>	$request->get('endDate'),
						'searchType' => $request->get('searchType'),
					);
					$data = Helper::getProfitAndLost($param);
					echo json_encode($data);
			}
		}
}
?>
