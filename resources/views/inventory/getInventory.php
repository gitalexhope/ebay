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
					<p class="pull-left">Inventory</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Inventory List</p>
				</div>
      <ul class="nav nav-tabs col-md-6" style="border-bottom:none !important">
				<li class="active"><a rel="matching" data-toggle="tab" href="#matching">Matched Inventory</a></li>
        <li class=""><a rel="ebay" data-toggle="tab" href="#ebay">Ebay Inventory</a></li>
        <li class=""><a rel="amazon" data-toggle="tab" href="#amazon">Amazon Inventory</a></li>
      </ul>
      <div class="search_boxs pull-right">
        <button class="btn btn-primary pull-right" onclick="location.href = 'add-inventory'">Add Inventory  +</button>
      </div>
      <div class="clearfix"></div>
      <br>
      <div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchInventoryList" id="searchCustomer" placeholder="Search by Name , Seller SKU">
        <i class="fa fa-search" aria-hidden="true"></i>
        <img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
      </div>
			<div class="content_sec" >
        <div class="detail-recents clearfix pull-left tab-content" style="padding:0" id="allRecords">
					<div id="matching" class="tab-pane fade active in">
	          <table class="table table-bordered table-responsive">
	            <thead class="thead-inverse">
	              <tr>
									<th>SKU</th>
									<th>Ebay Pro Name</th>
									<th>Ebay Qty</th>
									<th>Ebay Price</th>
									<th>Amazon Pro Name</th>
									<th>Amazon Qty</th>
									<th>Amazon Price</th>
	              </tr>
	            </thead>
	            <tbody>
	              <?php if(count($matchingList)){
	                foreach($matchingList as $detail){
	                  ?>
	                  <tr>
											<?php
												if($detail->varEbayProName!=""){
													$ebayProName = $detail->varEbayProName;
													$ebayQty = $detail->varEbayQty;
													$ebayPrice = $detail->varEbayPrice;
												}else{
													$ebayProName = $detail->ebayProName;
													$ebayQty = $detail->ebayQty;
													$ebayPrice = $detail->ebayPrice;
												}
											 ?>
											<td><?php echo $detail->sellerSku;?></td>
	                    <td><?php echo $ebayProName; ?></td>
											<td><?php echo $ebayQty;?></td>
											<td><?php echo $ebayPrice;?></td>
											<td><?php echo $detail->amazonProName ; ?></td>
	                    <td><?php echo $detail->amazonQty;?></td>
											<td><?php echo $detail->amazonPrice;?></td>
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
	          <div class="inventoryList"><?php  echo $matchingList->links(); ?></div>
	        </div>
				<div id="ebay" class="tab-pane fade">
          <table class="table table-bordered table-responsive">
            <thead class="thead-inverse">
              <tr>
                <th width="330px">Product Name</th>
                <th>SKU</th>
                <th>Sale Price</th>
                <th>Quantity</th>
                <th>Country</th>
                <th>Sold On</th>
                <th>Start Date Of Listing</th>
                <th>End Date Of Listing</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($inventoryList)){
                foreach($inventoryList as $detail){
                  ?>
                  <tr>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->titleName ; ?></span><!--(<span id="modelName<?php echo $detail->productRef; ?>"><?php echo $detail->modelName ; ?> </span>)--></td>
                    <td id="SKU<?php echo $detail->productSKU; ?>"><?php echo $detail->productSKU;?></td>
                    <td id="totalCost<?php echo $detail->productRef; ?>">$<?php echo number_format($detail->price,2);?></td>
                    <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->quantityEbay;?></td>
                    <td id="country<?php echo $detail->productRef; ?>"><?php echo $detail->country;?></td>
                    <td><?php $soldOn = Helper::soldOn($detail->ebayItemRef); if(!empty($soldOn['soldOn'])) echo "<b> eBay </b>";?></td>
                    <td id="createdDate<?php echo $detail->productRef; ?>"><?php if(trim($detail->startTimeEbay)!="") {$date=date_create($detail->startTimeEbay);echo date_format($date,"d/m/Y");} else echo date('d/m/Y',strtotime($detail->addedOn)); ?></td>
                    <td id="createdDate<?php echo $detail->productRef; ?>"><?php  $date=date_create($detail->endTimeEbay);echo date_format($date,"d/m/Y");?></td>
                    <td>
              					<a href="javascript:void(0)" class="updateInventory" data-to="ebay" data-ref="<?php echo $detail->ebayItemRef; ?>">
                          <i class="fa fa-pencil" aria-hidden="true"></i></a>
              					</a>
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
          <div class="inventoryList"><?php  echo $inventoryList->links(); ?></div>
        </div>
        <div id="amazon" class="tab-pane fade">
          <table class="table table-bordered table-responsive">
            <thead class="thead-inverse">
              <tr>
                <th width="330px">Product Name</th>
                <!-- <th>IMEI/MEID</th> -->
                <th>ASIN</th>
                <th>Seller SKU</th>
                <th>Sale Price</th>
                <th>Quantity</th>
                <!-- <th>Sold On</th> -->
                <th>Date Of Listing</th>
                <!-- <th>End Date Of Listing</th> -->
                <th width="25px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($amazonInventoryList)){
                foreach($amazonInventoryList as $detail){
                  ?>
                  <tr>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->itemName ; ?></span></td>
                    <!-- <td id="imeNum<?php echo $detail->productRef; ?>"></td> -->
                    <td id="imeNum<?php echo $detail->productRef; ?>"><?php echo $detail->ASIN; ?></td>
                    <td id="imeNum<?php echo $detail->productRef; ?>"><?php echo $detail->sellerSku; ?></td>
                    <td id="totalCost<?php echo $detail->productRef; ?>">$<?php echo number_format($detail->price,2);?></td>
                    <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->quantity;?></td>
                    <!-- <td id="quantity<?php echo $detail->productRef; ?>"></td> -->
                    <!-- <td></td> -->
                    <td id="createdDate<?php echo $detail->productRef; ?>"><?php  echo date('Y/m/d',strtotime($detail->openDate));?></td>
                    <td>
              					<a href="javascript:void(0)" class="updateInventory" data-to="amazon" data-ref="<?php echo $detail->sellerSku; ?>">
                          <i class="fa fa-pencil" aria-hidden="true"></i></a>
              					</a>
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
          <div class="inventoryList"><?php echo $amazonInventoryList->links();?></div>
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
