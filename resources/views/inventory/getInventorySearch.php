<?php //echo '<pre>'; print_r($_GET); ?>
  <?php if(isset($_GET['matching'])){ ?>
<div id="matching" class="tab-pane fade active in">
  <table class="table table-bordered table-responsive">
    <thead class="thead-inverse">
      <tr>
        <th>SKU</th>
        <th width="330px">Ebay Pro Name</th>
        <th>Ebay Qty</th>
        <th>Ebay Price</th>
        <th width="330px">Amazon Pro Name</th>
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
            <td><?php echo  $ebayProName; ?></td>
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
  <div class="inventoryList">
    <?php  echo $matchingList->links(); ?>
  </div>
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
            <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->country;?></td>
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
  <div class="inventoryList">
    <?php  echo $inventoryList->links(); ?>
  </div>
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
  <div class="inventoryList">
    <?php echo $amazonInventoryList->links();?>
  </div>

</div>
<?php } elseif(isset($_GET['ebay'])){ ?>
<div id="matching" class="tab-pane fade">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th>SKU</th>
          <th width="330px">Ebay Pro Name</th>
          <th>Ebay Qty</th>
          <th>Ebay Price</th>
          <th width="330px">Amazon Pro Name</th>
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
              <td><?php echo  $ebayProName; ?></td>
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
    <div class="inventoryList">
      <?php  echo $matchingList->links(); ?>
    </div>
  </div>
<div id="ebay" class="tab-pane fade active in">
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
            <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->country;?></td>
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
  <div class="inventoryList">
    <?php  echo $inventoryList->links(); ?>
  </div>
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
  <div class="inventoryList">
    <?php echo $amazonInventoryList->links();?>
  </div>

</div>

<?php } elseif(isset($_GET['amazon'])) { ?>
  <div id="matching" class="tab-pane fade">
      <table class="table table-bordered table-responsive">
        <thead class="thead-inverse">
          <tr>
            <th>SKU</th>
            <th width="330px">Ebay Pro Name</th>
            <th>Ebay Qty</th>
            <th>Ebay Price</th>
            <th width="330px">Amazon Pro Name</th>
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
                <td><?php echo  $ebayProName; ?></td>
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
      <div class="inventoryList">
        <?php  echo $matchingList->links(); ?>
      </div>
    </div>
  <div id="ebay" class="tab-pane fade">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th width="330px">Product Name</th>
          <th>IMEI/MEID</th>
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
              <td id="imeNum<?php echo $detail->productRef; ?>"><?php echo $detail->ImeNum;?></td>
              <td id="totalCost<?php echo $detail->productRef; ?>">$<?php echo number_format($detail->price,2);?></td>
              <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->quantityEbay;?></td>
              <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->country;?></td>
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
    <div class="inventoryList">
      <?php  echo $inventoryList->links(); ?>
    </div>
  </div>
  <div id="amazon" class="tab-pane fade active in">
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
    <div class="inventoryList">
      <?php echo $amazonInventoryList->links();?>
    </div>

  </div>

<?php } ?>
