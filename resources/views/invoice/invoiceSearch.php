<?php if (isset($_GET['ebay'])){?>
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
        <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="amazon" class="downloadInvoice"><i class="fa fa-file"></i> Download Invoice</a></td>
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
<?php } elseif (isset($_GET['amazon'])) { ?>
  <div id="ebay" class="tab-pane fade">
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
        <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="ebay" class="downloadInvoice"> <?php echo $detail->invoiceName;?></a></td>
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
  <div id="amazon" class="tab-pane fade  active in">
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
        <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="amazon" class="downloadInvoice"> <?php echo $detail->invoiceName;?></a></td>
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
<?php } else {?>
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
        <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="ebay" class="downloadInvoice"> <?php echo $detail->invoiceName;?></a></td>
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
        <td id="invoiceName<?php echo $detail->invoiceRef; ?>"><a href="javascript:void(0);" data-ref="<?php echo $detail->invoiceNum;?>" data-to="amazon" class="downloadInvoice"> <?php echo $detail->invoiceName;?></a></td>
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
<?php } ?>
