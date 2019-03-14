<?php //echo "<pre>"; print_r($inventory);die; ?>
<input type="hidden" id="inventoryFilterDate" value="<?php echo date('d-M-Y', strtotime($startDate)) . ' to ' . date('d-M-Y', strtotime($endDate)); ?>">

        <div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>
        <table id="datatable">
          <?php
            $totalInven = 0;
            switch ($searchType) {
                case 'Day':
                    ?>
                    <thead>
                        <tr>
                            <th></th>

                            <th>ebay</th>
                            <th>Amazon</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <th>
                              <?php
                              if (isset($inventory->addedOn)) {
                                $date = new \DateTime($inventory->startTimeEbay);
                                  echo date('d-M-Y', strtotime($addedOn));
                              } else {
                                  echo date('d-M-Y', strtotime($startDate));
                              }
                              ?>
                          </th>
                            <td>
                                <?php
                                if (isset($inventory->quantityEbay)) {
                                    echo $inventory->quantityEbay;
                                    $totalInven = $inventory->quantityEbay;
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($Amazoninventory->quantity)) {
                                    echo $Amazoninventory->quantity;
                                    $totalInven = $Amazoninventory->quantity;
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                    break;
                case 'Days':
                    //echo "<pre>";print_r($Amazoninventory);die;
                    ?>
                    <thead>
                        <tr>
                            <th></th>
                            <th>ebay</th>
                            <th>Amazon</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $begin = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    $th = '<th></th>';
                    $td = '<th>Inventory</th>';
                    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {

                    ?>
                        <tr>
                          <th><?php echo $i->format('Y-m-d'); ?></th>
                          <?php
                          if (isset($inventory[$i->format('Y-m-d')])) {
                              $totalInven +=$inventory[$i->format($i->format('Y-m-d'))]->quantityEbay;
                              echo  '<td>' . $inventory[$i->format($i->format('Y-m-d'))]->quantityEbay . '</td>';
                          } else {
                              echo '<td>0</td>';
                          }
                          if (isset($Amazoninventory[$i->format('Y-m-d')])) {
                              $totalInven +=$Amazoninventory[$i->format($i->format('Y-m-d'))]->quantity;
                              echo  '<td>' . $Amazoninventory[$i->format($i->format('Y-m-d'))]->quantity . '</td>';
                          } else {
                              echo '<td>0</td>';
                            }
                           ?>

                            ?>

                        </tr>
                      <?php } ?>
                    </tbody>
                    <?php
                    break;
                case 'Months':
                    $th = '<th></th>';
                    $td = '<th>Inventory</th>';
                    foreach ($months as $month) {
                        $th .= '<th>' . $month . '</th>';
                        if (isset($inventory[$month])) {
                            $totalInven +=$inventory[$month]->quantityEbay;
                            $td .= '<td>' . $inventory[$month]->quantityEbay . '</td>';
                        } else {
                            $td .= '<td>0</td>';
                        }
                    }
                    ?>

                    <thead>
                        <tr>
                            <th></th>
                            <th>ebay</th>
                            <th>Amazon</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php   foreach ($months as $month) { ?>
                        <tr>
                          <th><?php echo $month ?></th>
                          <?php
                          if (isset($inventory[$month])) {
                              $totalInven +=$inventory[$month]->quantityEbay;
                              echo '<td>' . $inventory[$month]->quantityEbay . '</td>';
                          } else {
                              echo '<td>0</td>';
                          }
                           ?>
                           <?php
                           if (isset($Amazoninventory[$month])) {
                               $totalInven +=$Amazoninventory[$month]->quantity;
                               echo '<td>' . $Amazoninventory[$month]->quantity . '</td>';
                           } else {
                               echo '<td>0</td>';
                           }
                            ?>

                        </tr>
                      <?php } ?>
                    </tbody>
                    <?php
                    break;
            }
            ?>
        </table>
        </table>
</div>
