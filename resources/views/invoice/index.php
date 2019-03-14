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
					<p class="pull-left">Invoice List</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Invoice List</p>
				</div>
      <ul class="nav nav-tabs col-md-6" style="border-bottom:none !important">
        <li class="active"><a rel="ebay" data-toggle="tab" href="#ebay">Ebay Invoice</a></li>
        <li class=""><a rel="amazon" data-toggle="tab" href="#amazon">Amazon Invoice</a></li>
      </ul>
      <div class="clearfix"></div>
      <br>
      <div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="search-invoice" id="searchInvoiceBox" placeholder="Search by Order Number">
        <i class="fa fa-search" aria-hidden="true"></i>
        <img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
      </div>
			<div class="content_sec" >
        <div class="detail-recents clearfix pull-left tab-content" style="padding:0" id="allRecords">
        <div id="ebay" class="tab-pane fade active in">
          <table class="table table-bordered table-responsive">
					  <thead class="thead-inverse">
						<tr>
						  <th>Order Number</th>
						  <th>Invoice Name</th>
							<th>Status</th>
						  <th>Invoice Date</th>
						</tr>
					  </thead>
					  <tbody>
							<?php if(count($ebayInvoiceList))
							{
									foreach($ebayInvoiceList as $detail)
									{
							?>
						<tr class="tr<?php echo $detail->invoiceRef;?>">
							<td id="orderNum<?php echo $detail->invoiceRef; ?>"><?php echo $detail->invoiceNum;?></td>
						  <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="ebay" class="downloadInvoice"><i class="fa fa-file"></i> Download Invoice</a></td>
							<td id="status<?php echo $detail->invoiceRef; ?>"><?php $retVal = ($detail->status == 1) ? 'Active' : 'Inactive' ;echo $retVal;?></td>
							<td id="invoiceDate<?php echo $detail->invoiceRef; ?>"><?php echo date('Y-m-d',strtotime($detail->addedOn));?></td>
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
					<div class="invoiceListPagination">
						<?php echo $ebayInvoiceList->links();?>
					</div>
        </div>
        <div id="amazon" class="tab-pane fade">
          <table class="table table-bordered table-responsive">
            <thead class="thead-inverse">
            <tr>
              <th>Order Number</th>
              <th>Invoice Name</th>
              <th>Status</th>
              <th>Invoice Date</th>
            </tr>
            </thead>
            <tbody>
              <?php if(count($amazonInvoiceList))
              {
                  foreach($amazonInvoiceList as $detail)
                  {
              ?>
            <tr class="tr<?php echo $detail->invoiceRef;?>">
              <td id="orderNum<?php echo $detail->invoiceRef; ?>"><?php echo $detail->invoiceNum;?></td>
              <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="amazon" class="downloadInvoice"> <i class="fa fa-file"></i> Download Invoice</a></td>
              <td id="status<?php echo $detail->invoiceRef; ?>"><?php $retVal = ($detail->status == 1) ? 'Active' : 'Inactive' ;echo $retVal;?></td>
              <td id="invoiceDate<?php echo $detail->invoiceRef; ?>"><?php echo date('Y-m-d',strtotime($detail->addedOn));?></td>
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
					<div class="invoiceListPagination">
						<?php echo $amazonInvoiceList->links();?>
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
