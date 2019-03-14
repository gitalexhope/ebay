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
			<div class="inventoryListDetail">
				<div class="breadcrumbs">
					<p class="pull-left">Return Orders</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Return Orders List</p>
				</div>
      <ul class="nav nav-tabs col-md-6" style="border-bottom:none !important">
        <li class="active"><a rel="ebay" data-toggle="tab" href="#ebay">Ebay Return</a></li>
        <li class=""><a rel="amazon" data-toggle="tab" href="#amazon">Amazon Return</a></li>
      </ul>
      <div class="clearfix"></div>
      <br>
      <div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchReturnList" id="searchCustomer" placeholder="Search by Order ID">
        <i class="fa fa-search" aria-hidden="true"></i>
        <img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
      </div>
			<div class="content_sec" >
        <div class="detail-recents clearfix pull-left tab-content" style="padding:0" id="allRecords">
        <div id="ebay" class="tab-pane fade active in">
          <table class="table table-bordered table-responsive">
					  <thead class="thead-inverse">
						<tr>
						  <th width="200px">Order Number</th>
						  <th width="190px">IMEI Number</th>
							<th>Status</th>
							<th  width="50px">Qty</th>
							<th width="98px">Total Paid</th>
						  <th width="92px">Total Price</th>
						  <th width="144px" >Tracking Number</th>
						  <th>Sale Date</th>
						  <th>Order Status</th>
						  <th>Action</th>
						</tr>
					  </thead>
					  <tbody>
							<?php if(count($EbayList))
							{

									foreach($EbayList as $detail)
									{
							?>
						<tr class="tr<?php echo $detail->orderRef;?>">
						  <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
						  <td align="center"><span id="ImeNum<?php echo $detail->orderRef; ?>">
							<?php 	/*if(trim($detail->ImeNum)!='')
												{
													echo "$detail->ImeNum";

												}
											else*/ if(trim($detail->IMEINumber)!='')
												echo "<a href='javascript:void(0)' data-ref='".$detail->orderRef."' data-to='ebay' class='currentIEMI".$detail->orderRef." ImeNum'> ".$detail->IMEINumber." </a>";
												else  echo "<button data-ref='".$detail->orderRef."' data-to='ebay' class='btn btn-success currentIEMI".$detail->orderRef." ImeNum'> Add IMEI NO. </button>";
								 ?>
							</td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->checkoutStatus;?></td>
						  <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->totalItemPurchased;?></td>
							<td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->amountPaid,2);?></td>
							<td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->totalAmt,2);?></td>
							<td class="text-left trackingNum<?php echo $detail->orderRef; ?>"><?php if($detail->trackingNumber == '') { ?><button class="btn btn-success trackNumber" rel="<?php echo $detail->orderRef; ?>">Add</button><?php } else { echo $detail->trackingNumber ; }?></td>
						  <td id="createdDate<?php echo $detail->orderRef; ?>"><?php  $date=date_create($detail->lastModifiedDate);echo date_format($date,"d/m/Y");?></td>
						  <td class="StatusTd"><?php echo $detail->orderAction; ?></td>
							<td class="text-left">
										<div class="btn-group">
											<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
											<ul class="dropdown-menu panel-dropdown pull-right" role="menu">
													<li><a href="javascript:void(0)" class="viewOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
													<li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='orderDetail' data-for="Active"   href="javascript:void(0)">Active</a></li>
											</ul>
										</div>

						 </td>
						</tr>
						<?php
								}
						}
						else
								{
								echo '<tr><td colspan="10">No record found.</td></tr>';
								}
							?>
					  </tbody>
					</table>
					<div class="inventoryList">
						<?php echo $EbayList->links();?>
					</div>
        </div>
        <div id="amazon" class="tab-pane fade">
          <table class="table table-bordered table-responsive">
					  <thead class="thead-inverse">
						<tr>
						  <th width="190px" >Order Number</th>
							<th>Status</th>
							<th>Total Shipped</th>
							<th>Total Unshipped</th>
							<th>Total Price</th>
						  <th width="70px" >IMEI Number</th>
						  <th>Sale Date</th>
						  <th>Buyer Name</th>
						  <th>Order Status</th>
						  <th>Action</th>
						</tr>
					  </thead>
					  <tbody>
							<?php if(count($AmazonList)){
									foreach($AmazonList as $detail){
							?>
						<tr class="tr<?php echo $detail->orderRef;?>">
						  <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->orderStatus;?></td>
						  <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsShipped;?></td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsUnshipped;?></td>
							<td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->totalAmount,2);?></td>
							<td align="center"><span id="ImeNum<?php echo $detail->orderRef; ?>">
								<?php if(trim($detail->IMEINumber)!='')
												echo "<a href='javascript:void(0)' data-ref='".$detail->orderRef."' data-to='amazon' class='currentIEMI".$detail->orderRef." ImeNum'> ".$detail->IMEINumber." </a>";
												else  echo "<button data-ref='".$detail->orderRef."' data-to='amazon' class='btn btn-success currentIEMI".$detail->orderRef." ImeNum'> Add IMEI NO. </button>";
								 ?>
							</td>
							<!-- <td class="text-right trackingNum<?php echo $detail->orderRef; ?>"><?php if($detail->trackingNumber == '') { ?><button class="btn btn-success trackNumber" rel="<?php echo $detail->orderRef; ?>">Add</button><?php } else { echo $detail->trackingNumber ; }?></td> -->
						  <td id="createdDate<?php echo $detail->orderRef; ?>"><?php  $date=date_create($detail->purchaseDate);echo date_format($date,"d/m/Y");?></td>
						  <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo $detail->buyerName;?></td>
							<td class="StatusTd"><?php echo $detail->orderAction; ?></td>
							<td class="text-left">

									<div class="btn-group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
									<ul class="dropdown-menu panel-dropdown pull-right" role="menu">
										<li><a href="javascript:void(0)" class="amazoneOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
                    <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='amazonOrder' data-for="Active"   href="javascript:void(0)">Active</a></li>
									</ul>
									</div>
							</td>
						</tr>
						<?php
								}
							}
							else{
								echo '<tr><td colspan="10">No record found.</td></tr>';
							}
							?>
					  </tbody>
					</table>
					<div class="inventoryList">
						<?php echo $AmazonList->links();?>
					</div>
        </div>
      </div>
      </div>
		</div>
			<div id="editDetails"></div>
			

		</div>
<div class="clearfix"></div>
			<div class="" id="footer">
				<div class="footer_sec">
					<p>Copyright © XYZ. All Rights Reserved.</p>
					<div class="clearfix"></div>
				</div>
			</div>

	</div>
</div>

<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
