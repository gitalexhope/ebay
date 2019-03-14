<div id="header">
<div class="col-md-2">
	<div class="logo_sec">
		<img src="<?php echo URL::asset('/assets/images/logo.png');?>">
	</div>
</div>
<div class="col-md-10">
<?php echo view('commonfiles/searchHeader');?>
</div>
</div>
<div class="col-md-12" id="wrapper_panel">
	<div class="row dashboard-amazon">
		<?php echo view('commonfiles/sidebar');?>
		<div class="col-md-10 main_content">
				<div class="breadcrumbs">
					<p class="pull-left">Dashboard</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Dashboard</p>
				</div>
			<div class="content_sec clearfix">
				<div class="row">
				<div class="dashbord_box">
						<div class="col-md-4 col-xs-12">
							<a href="<?php echo URL('inventory-list');?>">
							<div style="background:#7986cb" class="number_box">
								<div class="col-md-12">
									<p class="pull-right">No. of <b>Inventory</b> items</p>
									<img src="<?php echo URL::asset('/assets/images/no_match.png');?>">
									<b><?php echo $InventoryItem ?></b>
								</div>
							</div>
						</a>
						</div>
						<div class="col-md-4 col-xs-12">
							<a href="<?php echo URL('order-list');?>">
							<div class="number_box blue_box">
								<div class="col-md-12">
									<img src="<?php echo URL::asset('/assets/images/match.png');?>">
									<p class="pull-right">No. of <b>ebay</b> orders</p>
									<b class="pull-right" ><?php echo $ebayOrders ?></b>
								</div>
							</div>
						</a>
						</div>
						<div class="col-md-4 col-xs-12">
							<a href="<?php echo URL('amazon-order-list');?>">
							<div style="background:#009688" class="number_box">
								<div class="col-md-12">
									<p class="pull-right">No. of <b>Amazon</b> orders</p>
									<img src="<?php echo URL::asset('/assets/images/no_match.png');?>">
									<b><?php echo $amazonOrders ?></b>
								</div>
							</div>
						</a>
						</div>
				</div>
				</div>
<?php
$yesterday 					= date("Y-m-d", strtotime('-1 days'));
$lastSeven 					= date("Y-m-d", strtotime('-7 days'));
$lastThirty 				= date("Y-m-d", strtotime('-30 days'));
$monthStart 				= date('Y-m-d', strtotime('first day of this month'));
$monthEnd 					= date('Y-m-d', strtotime('last day of this month'));
$lastMonthStart 		= date('Y-m-d', strtotime('first day of last month'));
$lastMonthEnd 			= date('Y-m-d', strtotime('last day of last month'));
$yearStart 					= date('Y-01-01');
$yearEnd 						= date('Y-12-31');

?>
			<div class="row">
				<div class="col-md-6 clearfix" style="margin-top:30px">
					<div class="dropdown pull-left">
									<button  style="background: #009688; color:#fafafa" class="btn dropdown-toggle" id="menu1" type="button" data-toggle="dropdown"><span id="customerFilter"><?php echo date('d-M-Y') . ' to ' . date('d-M-Y'); ?></span>
                        <span class="caret"></span>
									</button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="width:100%">
                        <li role="presentation" class="inventory-filter-graph active" startdate="<?php echo date('Y-m-d'); ?>" enddate="<?php echo date('Y-m-d'); ?>" searchtype="Day"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Today</a></li>
                        <!-- <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $yesterday; ?>"		  enddate="<?php echo $yesterday; ?>" searchtype="Day"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Yesterday</a></li> -->
                        <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $lastSeven; ?>" 			enddate="<?php echo $yesterday; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Last 7 Days</a></li>
                        <!-- <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $lastThirty; ?>" 		enddate="<?php echo $yesterday; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Last 30 Days</a></li> -->
                        <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $monthStart; ?>" 		enddate="<?php echo $monthEnd; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">This Month</a></li>
                        <!-- <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $lastMonthStart; ?>" enddate="<?php echo $lastMonthEnd; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Last Month</a></li> -->
                        <li role="presentation" class="inventory-filter-graph" startdate="<?php echo $yearStart; ?>" 			enddate="<?php echo $yearEnd; ?>" searchtype="Year"><a role="menuitem" tabindex="-1" href="javascript:void(0)">This Year</a></li>
                        <!-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Custom Range</a></li>
                        <li role="presentation" class="divider"></li> -->
                    </ul>
                </div>
								<br>
					<div id="detail" style="margin-top:30px">

						<div id="container">
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<br><div class="dropdown pull-left" style="margin:13px 13px 13px 0">
									<button  style="background: #009688; color:#fafafa" class="btn dropdown-toggle" id="menu1" type="button" data-toggle="dropdown"><span id="customerFilterProfit"><?php echo date('d-M-Y') . ' to ' . date('d-M-Y'); ?></span>
                        <span class="caret"></span>
									</button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="width:100%">
                        <li role="presentation" class="inventory-profit-graph active" startdate="<?php echo $yesterday; ?>" enddate="<?php echo date('Y-m-d'); ?>" searchtype="Day"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Today</a></li>
                        <li role="presentation" class="inventory-profit-graph" startdate="<?php echo $yesterday; ?>"		  enddate="<?php echo $yesterday; ?>" searchtype="Day"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Yesterday</a></li>
                        <li role="presentation" class="inventory-profit-graph" startdate="<?php echo $lastSeven; ?>" 			enddate="<?php echo $yesterday; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Last 7 Days</a></li>
                        <li role="presentation" class="inventory-profit-graph" startdate="<?php echo $lastMonthStart; ?>" enddate="<?php echo $lastMonthEnd; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Last Month</a></li>
												<li role="presentation" class="inventory-profit-graph" startdate="<?php echo $monthStart; ?>" 		enddate="<?php echo $monthEnd; ?>" searchtype="Days"><a role="menuitem" tabindex="-1" href="javascript:void(0)">This Month</a></li>
                        <li role="presentation" class="inventory-profit-graph" startdate="" 			enddate="" searchtype="overall"><a role="menuitem" tabindex="-1" href="javascript:void(0)">Over All Profit</a></li>
                    </ul>
                </div>
						<br>
					<div id="piecontainer"></div>
				</div>
			</div>
			</div>

			</div>
			<div class="clearfix"></div>
			<div class="" id="footer">
				<div class="footer_sec">
					<p>Copyright © XYZ. All Rights Reserved.</p>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<div class="tableDataCell hide">

		</div>
	</div>
</div>
<?php echo Helper::adminFooter(); ?>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () {
jQuery(document).on('click', '.inventory-profit-graph', function () {
        var startDate = jQuery(this).attr('startdate');
        var endDate = jQuery(this).attr('enddate');
        var searchType = jQuery(this).attr('searchtype');
        InventoryProfit(startDate, endDate, searchType);
        jQuery('.inventory-profit-graph').removeClass('active');
        jQuery(this).addClass('active');
				var SelectedDate = jQuery(this).children('a').text();
				jQuery('#customerFilterProfit').html(SelectedDate);
        setTimeout(function () {
            jQuery('#inventoryFilter').html(jQuery('#inventoryFilterDate').val());
        }, 1000);
    });

function InventoryProfit(startDate, endDate, searchType) {
        jQuery.ajax({
            type: "GET",
            url: site_url + "/profitChart",
            data: {
                'startDate': startDate,
                'endDate': endDate,
                'searchType': searchType,
								'ajax'			: 1,
            },
						dataType : "json",
            beforeSend: function () {
                jQuery('#wait').show();
            },
            complete: function () {
                jQuery('#wait').hide();
            },
            success: function (data) {
							var amazonFinalValue			=  	Math.abs(data.amazon[0].amazonFinalValue);
							var amazonReturnCharge		=  	data.amazon[0].amazonReturnCharge;
							var amazonTotalAmount 		=  	data.amazon[0].amazonTotalAmount;
							var ebayFinalValueFee 		=  	data.ebay[0].ebayFinalValueFee;
							var ebayReturnCharge			=  	data.ebay[0].ebayReturnCharge;
							var ebayPaypalAmount			=  	data.ebay[0].ebayPaypalAmount;
							var ebayAmountPaid			  =  	data.ebay[0].ebayAmountPaid;

							(amazonFinalValue 	=== null || isNaN(amazonFinalValue)) 		? amazonFinalValue 		= 0 :  amazonFinalValue;
							(amazonReturnCharge === null || isNaN(amazonReturnCharge)) 	? amazonReturnCharge 	= 0 :  amazonReturnCharge;
							(amazonTotalAmount 	=== null || isNaN(amazonTotalAmount)) 	? amazonTotalAmount 	= 0 :  amazonTotalAmount;
							(ebayFinalValueFee 	=== null || isNaN(ebayFinalValueFee)) 	? ebayFinalValueFee 	= 0 :  ebayFinalValueFee;
							(ebayReturnCharge	  === null || isNaN(ebayReturnCharge)) 		? ebayReturnCharge 		= 0 :  ebayReturnCharge;
							(ebayPaypalAmount		=== null || isNaN(ebayPaypalAmount)) 		? ebayPaypalAmount 		= 0 :  ebayPaypalAmount;
							(ebayAmountPaid		  === null || isNaN(ebayAmountPaid)) 			? ebayAmountPaid 		  = 0 :  ebayAmountPaid;

							var price 								= 	ebayAmountPaid;
							var totalCommission 			= 	ebayFinalValueFee;
							var totalEbayAmount 			= 	parseFloat(totalCommission) + parseFloat(ebayReturnCharge) + parseFloat(ebayPaypalAmount) ;

							totalEbayAmount 					= 	parseFloat(price) - parseFloat(totalEbayAmount);
							var amazonProfitValue 		= 	parseFloat(amazonTotalAmount) - parseFloat(amazonFinalValue);
							// Ebay
							(totalEbayAmount === null	 || isNaN(totalEbayAmount)) 			? totalEbayAmount 		= 0 :  totalEbayAmount;
							(totalCommission === null	 || isNaN(totalCommission)) 			? totalCommission 		= 0 :  totalCommission;
							// Amazon
							(amazonFinalValue === null	 || isNaN(amazonFinalValue)) 		? amazonFinalValue 		=	0 :  amazonFinalValue;
							(amazonReturnCharge === null || isNaN(amazonReturnCharge)) 	? amazonReturnCharge 	=	0 :  amazonReturnCharge;
							(amazonProfitValue === null	 || isNaN(amazonProfitValue)) 	? amazonProfitValue 	=	0 :  amazonProfitValue;

							 Highcharts.chart('piecontainer', {
								chart: {
								        plotBackgroundColor: null,
								        plotBorderWidth: null,
								        plotShadow: false,
								        type: 'pie'
								    },
							    title: {
							        text: 'Overall Profit And Commission'
							    },

									plotOptions: {
										 pie: {
												 allowPointSelect: true,
												 cursor: 'pointer',
												 dataLabels: {
														 enabled: true,
														 format: '<b>{point.name} </b>: ${point.y:,.1f}',
														 style: {
																 color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
														 }
												 }
										 }
								 },
							    series: [{
							        name: 'Amount',
											 colorByPoint: true,
							        data: [
												{
								            name: 'eBay Profit',
								            y: totalEbayAmount ,
							        	},
												{
								            name: 'eBay Commission',
								            y: totalCommission,
							        	},
												{
								            name: 'ebay Return Charges',
								            y: ebayReturnCharge,
							        	},
												{
								            name: 'ebay PayPal Charges',
								            y: ebayPaypalAmount,
							        	},
												{
								            name: 'Amazon Profit',
								            y: parseFloat(amazonProfitValue) - parseFloat(amazonReturnCharge),
							        	},
												{
								            name: 'Amazon Commission',
								            y: amazonFinalValue,
							        	},
												{
								            name: 'Amazon Return Charges',
								            y: amazonReturnCharge,
							        	}
										],
							        showInLegend: false,
							        dataLabels: {
							            enabled: true
							        }
							    }]
							});

    }
	})
}


jQuery(document).on('click', '.inventory-filter-graph', function () {
        var startDate = jQuery(this).attr('startdate');
        var endDate = jQuery(this).attr('enddate');
        var searchType = jQuery(this).attr('searchtype');
        InventoryGraph(startDate, endDate, searchType);
        jQuery('.inventory-filter-graph').removeClass('active');
        jQuery(this).addClass('active');
				var SelectedDate = jQuery(this).children('a').text();
				jQuery('#customerFilter').html(SelectedDate);
        setTimeout(function () {
            jQuery('#inventoryFilter').html(jQuery('#inventoryFilterDate').val());
        }, 1000);
    });
function InventoryGraph(startDate, endDate, searchType) {
        jQuery.ajax({
            type: "GET",
            url: site_url + "/InventoryGraph",
            data: {
                'startDate': startDate,
                'endDate': endDate,
                'searchType': searchType,
								'ajax'			: 1,
            },
            beforeSend: function () {
                jQuery('#wait').show();
            },
            complete: function () {
                jQuery('#wait').hide();
            },
            success: function (msg) {
							jQuery('.tableDataCell').html(msg);
                jQuery('#container').highcharts({
									data: {
							        table: 'datatable'
							    },
							    chart: {
							        type: 'column'
							    },
							    title: {
							        text: 'Inventory'
							    },
									legend: {
							        layout: 'horizontal',
							        align: 'center',
							        verticalAlign: 'bottom'
    							},
							    yAxis: {
							        allowDecimals: false,
							        title: {
							            text: 'No of items'
							        }
							    },
							    tooltip: {
							        formatter: function () {
												return Highcharts.dateFormat('%d/%m/%Y', new Date(this.series.name)) + '<br/>' + this.series.name+ ': ' + this.y;
							        }
							    }

        });
    }
	})
}

jQuery('.inventory-filter-graph:last-child').trigger('click');
jQuery('.inventory-profit-graph:nth-child(5)').trigger('click');
})
		</script>
