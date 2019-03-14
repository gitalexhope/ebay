jQuery(document).ready(function() {
  jQuery('body').on('click', '.addInventory', function() {
    var inventory = jQuery('.upload_imgs img').length;
    if (inventory < 1) {
      jQuery('.updateclientdetails').show().addClass('alert-danger').removeClass('alert-success').fadeOut(5000);
      jQuery('.updateclientmessage').html(inventoryImg);
      jQuery("html, body").animate({
        scrollTop: 0
      }, "slow");
    }
    if (inventory > 12) {
      jQuery('.updateclientdetails').show().addClass('alert-danger').removeClass('alert-success').fadeOut(5000);
      jQuery('.updateclientmessage').html(inventoryImgCount);
      jQuery("html, body").animate({
        scrollTop: 0
      }, "slow");
    }
  });
  jQuery('.modal').on('hidden.bs.modal', function (e) {
          jQuery('.form-control').removeClass('forerror');
          var  id  = jQuery(this).attr('id');
          jQuery('.shipingMessageElement').hide();
          jQuery('#'+id).find('input[type="text"]').val('');
          jQuery('#'+id).find('input[type="hidden"]').val('');
      });
  jQuery('body').on('change', '.submitImg', function(e) {
    var currentVal = jQuery(this);
    var currentVal = jQuery(this).attr('id');
    var finalImg;
    if (currentVal == 'imgInp') {
      jQuery(this).closest('form').attr('action', site_url + '/add-image');
      var formId = jQuery(this).closest('form').attr('id');
      e.preventDefault();
      jQuery('#' + formId).ajaxForm({
        beforeSend: function() {
          $('#wait').show();
        },
        complete: function() {
          $('#wait').hide()
        },
        data: {},
        dataType: 'json',
        success: function(data) {
          try {
            var img = jQuery('.imagesName').val();
            if (data == true) {
              return false;
            }
            if (img != '') {
              finalImg = img + ',' + data;
            } else {
              finalImg = data;
            }
            jQuery('.imagesName').val(finalImg);
            jQuery(currentVal).closest('form').attr('action', site_url + '/add-inventory');
          } catch (e) {
            // alert('Exception while request..');
          }
        },
        error: function() {
          // alert('Error while request..');
        }
      }).submit();
    }
    return false;
  });
  jQuery('body').on('click', '.addInventory2', function(e) {

    e.preventDefault();
    var formClass = jQuery(this).closest('form').attr('id');
    //jQuery(this).closest('form').attr('action', site_url + '/add-inventory');
    var text = jQuery('.Editor-editor').html();
    jQuery('.description').val(text);
    var type = 'json';
    var returnAMt = ajaxFormHit1(type, formClass, 'addInv');
    window.setTimeout(function() {
      location.reload();
    }, 4000);
    return false;
  });
jQuery('body').on('click', '.listedEbayProduct', function(e) {
  var text = jQuery('.Editor-editor').html();
  jQuery('.description').val(text);
  });
  jQuery('body').on('blur', '.Editor-editor', function() {
    var text = jQuery('.Editor-editor').html();
    jQuery('.description').val(text);
  });
  jQuery('body').on('blur', '.meidNum', function() {
    var currentVal = jQuery(this).val();
    var url = site_url + '/checkMEIM/' + currentVal;
    var type = 'json';
    var currt = jQuery(this);
    var returnAMt = ajaxHit1(url, type);

    //if(returnAMt != ''){
    //jQuery('#wait').css('display','none');
    //}
    returnAMt.success(function(response) {
      if (response != null) {
        jQuery(currt).css('border', '1.8px solid #a94442');
        jQuery(currt).closest('form').find('input.checkform2').prop('disabled', true);
        jQuery('.updateclientdetails').show().addClass('alert-danger').removeClass('alert-success').fadeOut(4000);
        jQuery('.updateclientmessage').html(miemNum);
      } else {
        jQuery(currt).css('border', '1.8px solid #3c763d');
        jQuery(currt).closest('form').find('input.checkform2').prop('disabled', true);
      }
    });
  });
  jQuery(document).on('click', '.inventoryList a', function() {
    var url = jQuery(this).attr("href");
    var lowerCase = jQuery('#searchCustomer').val().toLowerCase();
    var upperCase = jQuery('#searchCustomer').val();
    url = url + '&' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase;
    jQuery('#wait').show();
    var type = 'html';
    var returnAMt = ajaxHit1(url, type);

    returnAMt.success(function(response) {
      jQuery("#allRecords").html(response);
      jQuery('#wait').hide();
    });
    return false;
  });
  jQuery(document).on('click change','.nav-tabs li a:first-child',function(){
      var dataTo = $.trim($(this).attr('rel'));
      jQuery('#searchCustomer').attr('data-to',dataTo);
      var inputRel = jQuery('#searchCustomer').attr('rel');

      if(dataTo == 'ebay' && inputRel =='searchInventoryList'){
        jQuery('#searchCustomer').attr('placeholder','Search by Name , Item Id ,IMEI');
      }
      else if(dataTo == 'amazon' && inputRel =='searchInventoryList')
      {
        jQuery('#searchCustomer').attr('placeholder','Search by Name, ASIN /  Seller SKU');
      }
      else if(dataTo == 'matching' && inputRel =='searchInventoryList')
      {
        jQuery('#searchCustomer').attr('placeholder','Search by Name, Seller SKU');
      }
      jQuery('#searchCustomer').attr('data-to',dataTo);
  });
  jQuery('#searchCustomer').attr('data-to','matching');
  jQuery('#searchCustomer').donetyping(function() {
    var lowerCase = jQuery.trim(jQuery(this).val().toLowerCase());
    var upperCase = jQuery.trim(jQuery(this).val());
    var pageName =  jQuery.trim(jQuery(this).attr('rel'));
    if(pageName == 'searchInventoryList' || pageName == 'searchReturnList')
    {
      var pageRef = jQuery(this).attr('data-to');
      pageName = site_url + '/' + pageName + '?' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase + '&'+pageRef+'='+'1';

    }
    else {

      pageName = site_url + '/' + pageName + '?' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase;
    }
    jQuery('.loadImage').show();
    var type = 'html';
    //  if (lowerCase != '' && upperCase != '') {
    var returnAMt = ajaxHit1(pageName, type);
    returnAMt.success(function(response) {
      jQuery("#allRecords").html(response);
      jQuery('.loadImage').hide();
    });

  });

  jQuery('#searchInvoiceBox').donetyping(function() {
    console.log(jQuery(this).parents('.inventoryListDetail .nav-tabs').find('.active').attr('rel'));
    var parentDiv  = jQuery(this).parents('.inventoryListDetail');
    var lowerCase = jQuery.trim(jQuery(this).val().toLowerCase());
    var upperCase = jQuery.trim(jQuery(this).val());
    var pageName =  jQuery.trim(jQuery(this).attr('rel'));
    var pageRef = jQuery.trim(jQuery(parentDiv).find('.nav-tabs .active > a').attr('rel'));
    pageName = site_url + '/' + pageName + '?' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase + '&'+pageRef+'='+'1';
    jQuery('.loadImage').show();
    var type = 'html';
    var returnAMt = ajaxHit1(pageName, type);
    returnAMt.success(function(response) {
      jQuery("#allRecords").html(response);
      jQuery('.loadImage').hide();
    });

  });

  jQuery(document).on('click', '.invoiceListPagination a', function() {
    var url = jQuery(this).attr("href");
    var lowerCase = jQuery('#searchInvoiceBox').val().toLowerCase();
    var upperCase = jQuery('#searchInvoiceBox').val();
    url = url + '&' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase;
    jQuery('#wait').show();
    var type = 'html';
    var returnAMt = ajaxHit1(url, type);

    returnAMt.success(function(response) {
      jQuery("#allRecords").html(response);
      jQuery('#wait').hide();
    });
    return false;
  });

  jQuery('body').on('click', '.editInventory', function() {
    var pageName = jQuery(this).attr('src');
    var inventoryInfo = jQuery(this).attr('rel');
    pageName = site_url + '/' + pageName + '?' + 'inventoryInfo=' + inventoryInfo;

    var type = 'html';
    //  if (lowerCase != '' && upperCase != '') {
    var returnAMt = ajaxHit(pageName, type);
    returnAMt.success(function(response) {
      jQuery("#editDetails").show().html(response);
      jQuery('.inventoryListDetail').hide();
      window.setTimeout(function() {
        jQuery("#txtEditor").Editor();
        var text = jQuery('.description').val();
        jQuery('.Editor-editor').html(text);
      }, 1000);


    });
  });
  jQuery('body').on('click', '.editInventoryDetail', function() {
    //e.preventDefault();
    var formClass = jQuery(this).closest('form').attr('id');
    jQuery(this).closest('form').attr('action', site_url + '/update-inventory');
    var text = jQuery('.Editor-editor').html();
    jQuery('.description').val(text);
    var type = 'json';
    ajaxFormHit1(type, formClass, 'editInv');

  });
  jQuery('body').on('click', '.addInventoryEbay', function() {
    //e.preventDefault();
    var count = 0;
    var count1 = 0;
    jQuery('.checkEbayList').each(function() {
      var currentVal = jQuery(this).val();
      text = currentVal.trim();
      if (text != '') {
        jQuery(this).css('border', '1.8px solid #3c763d');
      } else {
        jQuery(this).css('border', '1.8px solid #a94442');
        count1 = parseInt(count1) + parseInt(1);
      }
    });
    if (count1 > 0) {
      jQuery('#collapse1').addClass('in');
    }
    jQuery('.successEbay').each(function() {
      var currentVal = jQuery(this).val();
      text = currentVal.trim();
      if (text != '') {
        jQuery(this).css('border', '1.8px solid #3c763d');
      } else {
        jQuery(this).css('border', '1.8px solid #a94442');
        count = parseInt(count) + parseInt(1);
      }
    });
    if (count > 0) {
      return false;
    }
    var formClass = jQuery(this).closest('form').attr('id');
    var text = jQuery('.Editor-editor').html();
    jQuery('.description').val(text);
    var type = 'json';
    ajaxFormHit1(type, formClass, 'ebayInv');

  });
  jQuery('body').on('click', '.trackNumber', function() {
    var orderId = jQuery(this).attr('rel');
    jQuery('.orderIdTracking').val(orderId);
    jQuery('#myModalTrack').modal();
  });
  jQuery('body').on('click', '.addTrackingNumEbay', function() {
    jQuery(this).prev('input').removeClass('forerror');
    if (jQuery(this).prev('input').val() == '') {
      jQuery(this).prev('input').addClass('forerror');
      return false;
    } else {
      var orderId = jQuery('.orderIdTracking').val();
      var trackNum = jQuery('.trackNum').val();
      var src= site_url+'/add-tracking?order='+orderId+'&trackNum='+trackNum;
      var type="json";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {
          if (response == 2)
          { // Tracking number already exits
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html('Tracking Number already exits please try again with new entry.');
          }
          else if (response == 1)
          { // New Record added successfully
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html(trackingNum);
            jQuery('.trackingNum'+orderId).text(trackNum);
            window.setTimeout(function(){
              $('#myModalTrack').modal('hide');
              jQuery('.modal-backdrop.in').css('opacity','0');
            },4000);
          } else
          {
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html(trackingNum1);
          }
      });
    }
  });

  jQuery('body').on('click', '.ImeNum', function() {
    var orderId = jQuery(this).attr('data-ref');
    var dataTo = jQuery(this).attr('data-to');


    if (!$(this).hasClass("btn")) {
      jQuery('.imieNum').val($.trim($(this).text()))
    }

    jQuery('.orderIdIMEI').val(orderId);
    jQuery('.dataTo').val(dataTo);
    jQuery('#IMEINumber').modal();
  });

  jQuery('body').on('click', '.addIMEINumber', function() {
    jQuery(this).prev('input').removeClass('forerror');
    if (jQuery(this).prev('input').val() == '')
    {
      jQuery(this).prev('input').addClass('forerror');
      return false;
    } else {
      var orderId = jQuery('.orderIdIMEI').val();
      var imieNum = jQuery('.imieNum').val();
      var dataTo = jQuery('.dataTo').val();
      jQuery.ajax({
        type: "GET",
        url: site_url + "/add-imei-number",
        data :{'order' : orderId , 'imieNum' : imieNum,'channel':dataTo} ,
        async: true,
        beforeSend: function () {
          jQuery('#wait').show();
        },
        complete: function () {
          jQuery('#wait').hide();
        },
        success: function (response)
        {
          if (response == 2)
          { // Tracking number already exits
            jQuery('.EmiNumMsg').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.alertAjaxMsg').html('IMEI Number already exits please try again with new entry.');
          }
          else if (response == 1)
          { // New Record added successfully
            jQuery('.EmiNumMsg').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.alertAjaxMsg').html('IMEI Number updated successfully!.');
            jQuery('#ImeNum'+orderId).html("<a href='javascript:void(0)' data-ref="+orderId+" data-to="+dataTo+" class='currentIEMI"+orderId+" ImeNum'> "+imieNum+" </a>");
            window.setTimeout(function(){
              jQuery('#IMEINumber').modal('hide');
              jQuery('.modal-backdrop.in').css('opacity','0');
            },4000);
          } else
          {
            jQuery('.EmiNumMsg').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.alertAjaxMsg').html('IMEI number not added. Please try again.');
          }
      }
    });
  }
  });
  /*
  // jQuery('body').on('click', '.addTrackingNum', function() {
  //   if (jQuery(this).prev('input').val() == '') {
  //     jQuery(this).prev('input').addClass('forerror');
  //     return false;
  //   } else {
  //     var orderId = jQuery('.orderIdTracking').val();
  //     var trackNum = jQuery('.trackNum').val();
  //     var src= site_url+'/amazon-add-tracking?order='+orderId+'&trackNum='+trackNum;
  //     var type="json";
  //     var returnAMt = ajaxHit(src,type);
  //     returnAMt.success(function(response) {
  //         if (response == 2)
  //         { // Tracking number already exits
  //           jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
  //           jQuery('.trackingMsg').html('Tracking Number already exits please try again with new entry.');
  //         }
  //         else if (response == 1)
  //         { // New Record added successfully
  //           jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
  //           jQuery('.trackingMsg').html(trackingNum);
  //           jQuery('.trackingNum'+orderId).text(trackNum);
  //           window.setTimeout(function(){
  //             jQuery('#myModalTrack').hide();
  //             jQuery('.modal-backdrop.in').css('opacity','0');
  //           },4000);
  //         } else
  //         {
  //           jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
  //           jQuery('.trackingMsg').html(trackingNum1);
  //         }
  //     });
  //   }
  // });
*/
  jQuery('body').on('click', '.addTrackingNum', function() {
    jQuery(this).prev('input').removeClass('forerror');
    if (jQuery(this).prev('input').val() == '') {
      jQuery(this).prev('input').addClass('forerror');
      return false;
    } else {
      var orderId = jQuery('.orderIdTracking').val();
      var trackNum = jQuery('.trackNum').val();
      var src= site_url+'/amazon-add-tracking?order='+orderId+'&trackNum='+trackNum;
      var type="json";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {
          if (response == 2)
          { // Tracking number already exits
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html('Tracking Number already exits please try again with new entry.');
          }
          else if (response == 1)
          { // New Record added successfully
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html(trackingNum);
            jQuery('.trackingNum'+orderId).text(trackNum);
            window.setTimeout(function(){
              jQuery('#myModalTrack').hide();
              jQuery('.modal-backdrop.in').css('opacity','0');
            },4000);
          } else
          {
            jQuery('.trackingNum').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
            jQuery('.trackingMsg').html(trackingNum1);
          }
      });
    }
  });
  jQuery('body').on('click','.viewOrderDetails',function(){
    var orderId = jQuery(this).attr('rel');
    var src= site_url+'/get-order-detail?order='+orderId;
    var type="html";
    var returnAMt = ajaxHit(src,type);
    returnAMt.success(function(response) {
      jQuery('.inventoryListDetail').hide();
      jQuery('#editDetails').show().html(response);
    });
  });
  jQuery('.searchByName').donetyping(function(){
      jQuery('.loadImage').show();
      var currentVal = jQuery(this).val().toLowerCase();
      var currentVal1 = jQuery(this).val();
      if($.trim(currentVal1) !="")
      {
          var src= site_url+'/fetch-product?productlower='+currentVal+'&productup='+currentVal1;
          var type="html";
          var returnAMt = ajaxHit1(src,type);
          returnAMt.success(function(response) {
            jQuery('#clientList').show();
            jQuery('#clientUl').show().html(response);
            jQuery('.loadImage').hide();
          });
      }
      else
      {
        jQuery('#clientList').hide();
      }
  });

  jQuery('#clientList').hide();

  jQuery('body').on('click','.currentProduct',function(){
      var currentVal = jQuery(this).attr('rel');
      var currentText = jQuery(this).text();
      var src1 = jQuery(this).attr('src');
      var src= site_url+'/'+src1+'?productVal='+currentVal;
      var type="json";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {
        jQuery('.searchByName').val(currentText);
        jQuery('.productId').val(currentVal);
        jQuery('#clientUl').hide().html(' ');
        jQuery('.titleName').val(response[0].brandName);
        jQuery('.modelName').val(response[0].modelName);
        jQuery('.colorNme').val(response[0].color);
        jQuery('.priceVal').val(response[0].totalCost);
        jQuery('.Editor-editor').html(response[0].description);
      });
  });
  jQuery('body').on('click','.list-inventory-ebay',function(){
      jQuery('.ebayList').toggle();
  });

  jQuery(document).on('click','.amazoneOrderDetails',function(){
    var orderId = jQuery(this).attr('rel');
    var src= site_url+'/amazon-order-detail?order='+orderId;
    var type="html";
    var returnAMt = ajaxHit(src,type);
    returnAMt.success(function(response) {
      jQuery('.inventoryListDetail').hide();
      jQuery('#editDetails').show().html(response);
    });
  });
  jQuery(document).on('click','.amazoneShipment',function(){
    var orderId = jQuery(this).attr('rel');
    var src= site_url+'/amazon-shipment?order='+orderId;
    var type="html";
    var returnAMt = ajaxHit(src,type);
    returnAMt.success(function(response) {
      jQuery('.inventoryListDetail').hide();
      jQuery('#editDetails').show().html(response);
    });
  });

  jQuery(document).on('click','.returnOrder',function(){
      var orderId = jQuery(this).attr('data-ref');
      var orderIdTr = jQuery(this).closest('tr').attr('class');
      jQuery('#shipmentCharge').parent('.form-group').hide();
      jQuery('#returnOrderModel .modal-title').html('Order #'+orderId);
      jQuery('#returnOrderModel #orderId').val($.trim(orderId));
      jQuery('#returnOrderModel').modal();
      jQuery('#returnOrderModel .alert-success').hide();
      jQuery('#returnOrderModel .returnOrderSubmit').attr('target-tr',orderIdTr);
      jQuery('.price').trigger('change');
      jQuery.ajax({
        type        : "GET",
        url         : site_url + "/get-return-order-items",
        data        : {'orderId' : $.trim(orderId)},
        async       : true,
        datatype    : "json",
        beforeSend  : function () {
          jQuery('#wait').show();
        },
        complete: function () {
          jQuery('#wait').hide();
        },
        success: function (data) {
         var obj = jQuery.parseJSON(data);
         console.log(obj.length);
         var appendTo = '';
         var SrNo = 0;
         // if data is empty
         if(obj.length == 0)
         {
             jQuery('#shipmentCharge').val('');
             appendTo += '<tr class="returnList trSrNo1"><td class="serialNumberr">1</td>';
             appendTo +='<td><input type="text" class="form-control inputsuccess" name="chargeName[]" placeholder="Title">';
             appendTo +='<input type="hidden" class="form-control returnRef" name="returnRef[]"></td>';
             appendTo +='<td><input type="text" class="form-control inputsuccess validnumber price" name="chargePrice[]" placeholder="Price"></td>';
             appendTo +='<td class="addMins"></td></tr>';
         }
         else
         {
             jQuery('#shipmentCharge').val(obj[0].ShippingCharge);
             for (var i = 0; i < obj.length; i++)
             {
               SrNo++;
               appendTo += '<tr class="returnList trSrNo'+SrNo+'"><td class="serialNumberr">'+SrNo+'</td>';
               appendTo +='<td><input type="text" value='+obj[i].returnTitle+' class="form-control inputsuccess" name="chargeName[]" placeholder="Title">';
               appendTo +='<input type="hidden" value='+obj[i].returnRef+' class="form-control returnRef" name="returnRef[]"></td>';
               appendTo +='<td><input type="text" value='+obj[i].returnCharge+' class="form-control inputsuccess validnumber price" name="chargePrice[]" placeholder="Price"></td>';
               appendTo +='<td class="addMins"><span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span></td></tr>';
             }
         }
         jQuery('#returnItems').html(appendTo);
         jQuery('.returnOrderSubmit').prop('disabled',false);
         jQuery('.price').trigger('click');
        }
      })
  });

/*******************URL ACTIVATION/*******************/
   var urlCurrent = window.location.href;
   jQuery('.side_menu li a').removeClass('active');
   jQuery('.side_menu li a').each(function(){
     if($(this).attr('href') == urlCurrent)
     {
        document.title = jQuery(this).text();
        jQuery(this).addClass('active');
     };
   })
/*******************URL ACTIVATION/*******************/
var counter_new = 2;
    jQuery('body').on('click', '#addLayer', function ()
    {
        var lastAmount = jQuery('.serialNumberr:last').text();
        var block = jQuery("#nextLine").clone();
        block.removeAttr('id');
        block.removeClass('hide');
        block.addClass('returnList');
        block.children('.serialNumber').addClass('serialNumberr');
        block.children('.serialNumber').removeClass('serialNumber');
        block.children('.serialNumberr').text(parseInt(lastAmount) + parseInt(1));
        var last = parseInt(lastAmount) + parseInt(1);
        block.addClass('trSrNo'+last);
        block.children('td').children('.removeLayer').remove();
        block.children('td').children('.validnumber').addClass('price');
        block.children('td.addMins').append('<span class="removeLayer calculation"><i class="fa fa-trash-o iconTabFa faMin"></i></span>');
        block.insertAfter(".returnList:last");
        counter_new++;
    });
	var itemReff = "";
	jQuery('body').on('click', '.removeLayer', function () {
				 var itemRef   =   jQuery($(this)).closest('tr').find('.returnRef').val();
				 if(itemRef !="")
				 {
						 itemReff     += itemRef+',';
						 jQuery('#delReturnRef').val(itemReff);
				 }
         jQuery(this).parent('td').parent('tr').remove();
         var count     = 0;
         jQuery('.serialNumberr').each(function () {
             jQuery(this).text(parseInt(count) + parseInt(1));
             count++;
         });
         if (count == 1 || count == 0) {
             jQuery('td').children('.removeLayer').remove();
         }
				 jQuery('.price').trigger('change');
     });
jQuery(document).on('click','.returnOrderSubmit',function(event)
{
				var src = jQuery('#returnOrder').serialize();
        var closestTr = jQuery(this).attr('target-tr');
				isError = '';
				jQuery('#returnOrder .inputsuccess').each(function (event) {
						var inputVal = $(this).val();
						inputVal     = $.trim(inputVal);

					  if($.trim(inputVal) == '' || inputVal == undefined )
					  {
							isError = true;
							$(this).parents('.form-group').addClass('has-error');
							$(this).attr('placeholder', 'This Field is Required');
							$(this).closest('td').addClass('has-error');
					  }
						else
						{
								$(this).parents('.form-group').find('.search_Expense').removeClass('has-error');
								$(this).attr('placeholder', '');
								$(this).closest('td').removeClass('has-error');
						}
				})
				if(!isError){
					jQuery.ajax({
						type: "GET",
						url: site_url + "/return-order",
						data: src,
						async: true,
						beforeSend: function () {
							jQuery('#wait').show();
						},
						complete: function () {
							jQuery('#wait').hide();
						},
						success: function (msg)
            {
  							if(msg)
  							{
                  jQuery('.'+closestTr).find('.StatusTd').html('Return');
                  jQuery('.'+closestTr).hide();
  								jQuery('.returnOrderSubmit').prop('disabled',true);
  								jQuery('#returnOrderModel .alert-success').show();
    								setTimeout(function()
                    {
    									jQuery('.returnOrderSubmit').prop('disabled',false);
    									jQuery('#returnOrderModel').modal('hide');
    								}, 3000);
  							}
						}
					})
				}
				else {
					return false
				}
})
$(document).on('keypress', '.validnumber', function (eve) {
			if (eve.which == 0) {
					return true;
			} else {
					if (eve.which == '.') {
							eve.preventDefault();
					}
					if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57)) {
							if (eve.which != 8)
							{
									eve.preventDefault();
							}
					}

					$('.validNumber').keyup(function (eve) {
							if ($(this).val().indexOf('.') == 0) {
									$(this).val($(this).val().substring(1));
							}
					});
			}
	});
	jQuery('body').on('blur', '.validnumber', function ()
    {
        jQuery('#tableList > tbody tr').each(function (index)
        {
            rate            = jQuery($(this)).find('.price').val();
            if( rate > 0 )
                jQuery((this)).find('.price').val(parseFloat(rate, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
        });
    });
	jQuery('body').on('blur', '.ship', function (){ ship  = jQuery($(this)).val(); if( ship > 0 ){jQuery((this)).val(parseFloat(ship, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());}});
	jQuery(document).on('change keyup keydown blur click', '.price', function ()
    {
				 jQuery(this).attr("maxlength",10);
				 var totalServicePrice = 0;
         jQuery('.price').each(function () {
             var sprice = jQuery(this).val();
             sprice = sprice.replace(',', '');
             if (sprice != "") {
                 totalServicePrice += parseFloat(sprice);
             }
         });
        grandTotal    = parseFloat(totalServicePrice);
        grandTotal    = parseFloat(grandTotal,10).toFixed(2);
        $('#tableList #totalAmount').html(grandTotal.replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
    });
  jQuery(document).on('click','.orderStatus', function(){
    jQuery('.alertUpdateMessage').html('').hide();
    jQuery('.returnChargesDiv').hide();
    var dataRef = jQuery(this).attr('data-ref');
    var dataFor = jQuery(this).attr('data-for');
    var dataTo = jQuery(this).attr('data-to');
    var closestTr = jQuery(this).closest('tr').attr('class');
    jQuery('#StatusRecordModel').modal('show');
    jQuery('.dataStatusRef').val(dataRef);
    jQuery('.dataStatusFor').val(dataFor);
    jQuery('.dataStatusTo').val(dataTo);
    jQuery('.dataStatusTr').val(closestTr);
    jQuery('#dataStatus').html('Are you sure you want to make Order #'+dataRef+' Status <b>'+ dataFor +'</b>');
    jQuery.ajax({
      type: "GET",
      url: site_url + "/get-returnOrder-status",
      data :{'order' : dataRef},
      async: true,
      beforeSend: function () {
        jQuery('#wait').show();
      },
      complete: function () {
        jQuery('#wait').hide();
      },
      success: function (data)
      {
          if(data == 1)
          {
            jQuery('.returnChargesDiv').show();
          };
    }
  });

  })

  jQuery(document).on('click','.updateStatusOrder',function(){
    var dataRef   = jQuery('.dataStatusRef').val();
    var dataFor   = jQuery('.dataStatusFor').val();
    var dataTo    =  jQuery('.dataStatusTo').val();
    var closestTr = jQuery('.dataStatusTr').val();
    jQuery.ajax({
      type: "GET",
      url: site_url + "/update-order-status",
      data :{'status' : dataFor , 'orderId' : dataRef,'dataTo':dataTo} ,
      async: true,
      beforeSend: function () {
        jQuery('#wait').show();
      },
      complete: function () {
        jQuery('#wait').hide();
      },
      success: function (data)
      {
          jQuery('.updateStatusOrder').attr("disabled", "disabled");
          if(data == 1)
          {
            jQuery('.alertUpdateMessage').html('Record updated successfully').show();
            setTimeout(function(){jQuery('#StatusRecordModel').modal('hide');jQuery('.alertUpdateMessage').hide()},4000);
            var TrText = jQuery('.'+closestTr).find('.StatusTd').text();
            if(TrText == 'Return')
            {
              jQuery('.'+closestTr).hide();
            }
            jQuery('.'+closestTr).find('.StatusTd').html($.trim(dataFor));
          }
          else{
            jQuery('.alertUpdateMessage').html('Record not updated please try again').show();
          }
      }
    })
  })
  jQuery(document).on('click','.getPdf', function(){
    jQuery('.profitMessage').remove();
    var dataRef = jQuery(this).attr('data-ref');
    var startDateRange = jQuery('#startDateRange').val();
    var endDateRange   = jQuery('#endDateRange').val();
    var closestTr      = jQuery(this).closest('tr').attr('class');
    jQuery.ajax({
      type: "GET",
      url: site_url + "/generate-pdf",
      data :{'startDateRange' : startDateRange , 'endDateRange' : endDateRange,'dataRef':dataRef} ,
      async: true,
      dataType : 'json',
      beforeSend: function () {
        jQuery('#wait').show();
      },
      complete: function () {
        jQuery('#wait').hide();
      },
      success: function (data)
      {
        if (data.success == true) {
          setTimeout(function () {
            var newTab = window.open(site_url+"/downloadPdf", '_blank');
            newTab.location;
          },1000);
          jQuery('.ProfitErrMsg').html('<div class="alert profitMessage alert-success"><a href="javascript:void(0)" class="close" data-dismiss="alert">&times;</a><strong>Success!</strong> Please wait your file ready to download after few moments.</div>');
          // window.open(site_url+"/downloadPdf",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
        }
        else
        {
          jQuery('.ProfitErrMsg').html('<div class="alert profitMessage alert-info"><a href="javascript:void(0)" class="close" data-dismiss="alert">&times;</a><strong>Info!</strong> Please Try again with new entries.</div>');
        }
      }
    })
  })
  jQuery(document).on('click','.submitConvertReq', function(){
    var fileValue = jQuery('#getFileName').val();
    var file_type = fileValue.substr(fileValue.lastIndexOf('.')).toLowerCase();
    if (fileValue !='') {
      if (file_type !== '.pdf') {
        jQuery('#getName').html('please select pdf file.');
        return false;
      }
    }
    else {
      jQuery('#getName').html('please select pdf file.');
      return false;
    }

  })
  jQuery(document).on('change click','#getFileName',function()
  {
    jQuery('#getName').text(jQuery(this).val())
  })

jQuery(document).on('click', '.deleteProduct', function() {
    var productRef = jQuery(this).attr('data-ref');
    var dataTo     = jQuery(this).attr('data-to');
    jQuery('.productRef').val(productRef);
    jQuery('.dataTo').val(dataTo);
    jQuery('#deleteRecordModel').modal();
  });

  jQuery('body').on('click', '.deleteCurrentProduct', function() {
      var productRef = jQuery('.productRef').val();
      var dataTo     = jQuery('.dataTo').val();
      var src= site_url+'/delete-product?productRef='+productRef+'&dataTo='+dataTo;
      var type="json";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {
          if (response == 1)
          {
            jQuery('#productRef'+productRef).hide();
            jQuery('.deleteMessage').show().addClass('alert-success').removeClass('alert-info').fadeOut(4000);
            jQuery('.deleteMessage').html('Record deleted successfully.');
              setTimeout(function(){jQuery('#deleteRecordModel').modal('hide');},3000)
          }
          else {
            jQuery('.deleteMessage').show().addClass('alert-info').removeClass('alert-danger').fadeOut(4000);
            jQuery('.deleteMessage').html('Record not updated please try again.');
          }
      });

  });

  jQuery(document).on('click','.viewItemDetails',function(){
    var itemId = jQuery(this).attr('rel');
    var src= site_url+'/ebay-item-profit-detail?itemId='+itemId;
    var type="html";
    var returnAMt = ajaxHit(src,type);
    returnAMt.success(function(response) {
      jQuery('.inventoryListDetail').hide();
      jQuery('#editDetails').show().html(response);
    });
  });
  jQuery(document).on('click','.viewAmazonItemDetails',function(){
    var itemId = jQuery(this).attr('rel');
    var src= site_url+'/amazon-item-profit-detail?itemId='+itemId;
    var type="html";
    var returnAMt = ajaxHit(src,type);
    returnAMt.success(function(response) {
      jQuery('.inventoryListDetail').hide();
      jQuery('#editDetails').show().html(response);
    });
  });
  jQuery(document).on('click', '.updateInventory', function() {
      var itemRef    = jQuery(this).attr('data-ref');
      var dataTo     = jQuery(this).attr('data-to');
      jQuery('.alertMessageUpdateInv').addClass('hide');
      //var productName = $.trim($(this).parent().siblings(":first").text())
      // var ss = productName.split('( )');
      // console.log(ss);
      var src= site_url+'/get-product-details?itemId='+itemRef+'&dataTo='+dataTo;
      var type="html";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {
        var obj = JSON.parse(response)
        if(obj.hasOwnProperty('ebay'))
        {
          jQuery('.dataSellerSku').val(itemRef);
          jQuery('#productName').html(obj.ebay[0].titleName+'<br><strong>Item-ID <i class="fa fa-arrow-right" aria-hidden="true"></i> </strong> '+obj.ebay[0].ebayItemRef);
          jQuery('.productQuantity').val(obj.ebay[0].quantityEbay);
          jQuery('.productPrice').val(obj.ebay[0].price);
          jQuery('.dataOldQuantity').val(obj.ebay[0].quantityEbay);
          jQuery('.dataOldPrice').val(obj.ebay[0].price);
          jQuery('.DataTOUpdate').val(dataTo);
        }else
        {
          jQuery('.dataSellerSku').val(itemRef);
          jQuery('#productName').html(obj.amazon[0].itemName+'<br><strong>Seller SKU <i class="fa fa-arrow-right" aria-hidden="true"></i> </strong>&nbsp;&nbsp; '+obj.amazon[0].sellerSku+'<br><strong>ASIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i> </strong>&nbsp;&nbsp; '+obj.amazon[0].ASIN);
          jQuery('.dataOldQuantity').val(obj.amazon[0].quantity);
          jQuery('.dataOldPrice').val(obj.amazon[0].price);
          jQuery('.productQuantity').val(obj.amazon[0].quantity);
          jQuery('.productPrice').val(obj.amazon[0].price);
          jQuery('.DataTOUpdate').val(dataTo);
        }
        jQuery('#updateAmazonQuantity').modal();
      });

    });

    jQuery(document).on('submit','.formUpdateInventory',function(){
      var formData = $(this).serialize();
      jQuery.ajax({
        type: "GET",
        url: site_url + "/update-active-inventory",
        data :formData ,
        async: true,
        dataType : 'json',
        beforeSend: function () {
          jQuery('#wait').show();
        },
        complete: function () {
          jQuery('#wait').hide();
        },
        success: function (data)
        {

          // console.log(data);
          if(data.hasOwnProperty('ebay'))
          {
            if (data.ebay.hasOwnProperty('ItemID')) {
              jQuery('.alertMessageUpdateInv').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Succsss !</strong> Your updates have been submitted, the changes will be reflected in 30 minutes</div>').removeClass('hide');
            }
            else{
              jQuery('.alertMessageUpdateInv').html('<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'+data.ebay.Errors.ShortMessage+ ' !</strong> '+ data.ebay.Errors.LongMessage+'.</div>').removeClass('hide');
            }
          }
          else {
              if (data.hasOwnProperty('success')) {
                jQuery('.alertMessageUpdateInv').html('<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning !</strong> '+data.WarningMessage+'</div>').removeClass('hide');
              }else{
                jQuery('.alertMessageUpdateInv').html('<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Succsss !</strong> Your updates have been submitted, the changes will be reflected in 30 minutes</div>').removeClass('hide');
              }
          }


        }
      })

      return false;
    });

    jQuery(document).on('click change','.generate_Inv', function() {
      var invoiceRef        =   jQuery.trim(jQuery(this).attr('data-ref'));
      var invoiceDataTo     =   jQuery.trim(jQuery(this).attr('data-to'));
      jQuery('.invoiceRef').val(invoiceRef);
      jQuery('.invoiceDataTo').val(invoiceDataTo);
      jQuery('#OrderRefId').html('Order #'+invoiceRef);
      jQuery('#generateInvoice').modal('show');
    })

    jQuery(document).on('click change','.createInvoice', function() {
      var invoiceRef        =   jQuery.trim(jQuery('.invoiceRef').val());
      var invoiceDataTo     =   jQuery.trim(jQuery('.invoiceDataTo').val());
      jQuery.ajax({
        type: "GET",
        url: site_url + "/create-invoice",
        data :{'invoiceRef' : invoiceRef , 'invoiceDataTo': invoiceDataTo},
        async: true,
        dataType : 'json',
        beforeSend: function () {
          jQuery('#wait').show();
        },
        complete: function () {
          jQuery('#wait').hide();
        },
        success: function (data)
        {
          if (data.success == true) {
            jQuery('#generateInvoice').modal('hide');
            // window.open(site_url+"/downloadPdf",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
            setTimeout(function () {
              var newTab = window.open(site_url+"/downloadPdf", '_blank');
              newTab.location;
            },1000);
          }
          else
          {
            alert('please try again.');
          }
        }
      })

    })


    jQuery(document).on('click change','.downloadInvoice', function() {
      var invoiceRef        =   jQuery.trim(jQuery(this).attr('data-ref'));
      var invoiceDataTo     =   jQuery.trim(jQuery(this).attr('data-to'));
      jQuery.ajax({
        type: "GET",
        url: site_url + "/download-invoice",
        data :{'invoiceRef' : invoiceRef , 'invoiceDataTo': invoiceDataTo},
         async:false,
        dataType : 'json',
        beforeSend: function () {
          jQuery('#wait').show();
        },
        complete: function () {
          jQuery('#wait').hide();
        },
        success: function (data)
        {
          console.log('data'+data);
          if (data.success == true) {
            setTimeout(function () {
              var newTab = window.open(site_url+"/downloadPdf", '_blank');
              newTab.location;
            },100);
            // window.open(site_url+"/downloadPdf",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
          }
          else
          {
            alert('Please Try again.');
          }
        }
      })

    })
    jQuery(document).on('click change','.generate_ShippingLabel', function() {
      jQuery('#wait').show();
      var orderId        =   jQuery.trim(jQuery(this).attr('data-ref'));
      var src= site_url+'/getShippingDetails?order='+orderId+'&type=ebay';;
      var type="json";
      var returnAMt = ajaxHit(src,type);
      returnAMt.success(function(response) {

        var ShippingName = '';
        ShippingName = response[0].Name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
        });

        jQuery('#generateShippingLabel .ShippingName').val(ShippingName);
        jQuery('#generateShippingLabel .streetFirst').val(response[0].streetFirst);
        jQuery('#generateShippingLabel .streetSec').val(response[0].streetSec);
        jQuery('#generateShippingLabel .cityName').val(response[0].cityName);
        jQuery('#generateShippingLabel .state').val(response[0].state);
        jQuery('#generateShippingLabel .countryName').val(response[0].countryName);
        jQuery('#generateShippingLabel .phone').val(response[0].phone);
        jQuery('#generateShippingLabel .postalCode').val(response[0].postalCode);
        jQuery('#generateShippingLabel .orderID').val(response[0].orderIdRef);

        jQuery('#wait').hide();
        jQuery('.invoiceRef').val();
        jQuery('#generateShippingLabel .shippingAddressTo').find('.address').html('<table><tr><td><b>'+ShippingName+'</b><br> '+response[0].streetFirst+' <br> '+response[0].cityName+' , '+response[0].state+' '+response[0].postalCode+' '+response[0].countryName+'<br> Phone:- '+response[0].phone+'</tr> </table>');
        jQuery('#OrderRefId').html('');
        jQuery('#generateShippingLabel').modal('show');
        return false;
      });

    })
    jQuery(document).on('submit','.shippingLabelForm', function(event) {
          event.preventDefault();
          var packageType = jQuery('.packageType').val();
          var data = jQuery(this).serialize();
  				isError = '';
  				jQuery('.shippingInputsuccess').each(function (event) {
  						var inputVal = $(this).val();
  						inputVal     = $.trim(inputVal);

  					  if($.trim(inputVal) == '' || inputVal == undefined )
  					  {
  							isError = true;
  							$(this).parents('.form-group').addClass('has-error');
  							$(this).attr('placeholder', 'This Field is Required');

  					  }
  						else
  						{
  								$(this).parents('.form-group').removeClass('has-error');
  								$(this).attr('placeholder', '');

  						}
  				})
  				if(!isError){
            jQuery.ajax({
              type: "GET",
              url: site_url + "/print-ebay-shipping-label",
              data: data,
              async: true,
              beforeSend: function () {
                jQuery('#wait').show();
              },
              complete: function () {
                jQuery('#wait').hide();
              },
              success: function (response)
              {
                jQuery('.shipingMessageElement').show();
                var obj = jQuery.parseJSON(response);
                if(obj.success ==  true)
                {
                    jQuery('.shipingAlertAjaxMsg').html(obj.successMessage+' do not click back button and do not refresh the page.').parents('.shipingMessageElement').removeClass('alert-danger').addClass('alert-success');
                    setTimeout(function () {
                        jQuery('#generateShippingLabel').modal('hide');
                      var newTab = window.open(obj.labelUrl, '_blank');
                      newTab.location;
                    },4000);
                }else{
                    if(obj.exception){
                      jQuery('.shipingAlertAjaxMsg').html(obj.exception.faultstring).parents('.shipingMessageElement').removeClass('alert-success').addClass('alert-danger');
                    }else{
                      jQuery('.shipingAlertAjaxMsg').html(obj.error)
                    }
                  }
                return false;
              }
            })
  				}
        })

    jQuery(document).on('click change','.generate_amazonShippingLabel', function() {
          jQuery('#wait').show();
          var orderId        =   jQuery.trim(jQuery(this).attr('data-ref'));
          var src= site_url+'/getShippingDetails?order='+orderId+'&type=amazon';
          var type="html";
          var returnAMt = ajaxHit(src,type);
          returnAMt.success(function(response) {
              jQuery('#wait').hide();
              jQuery('#amazonGenerateShippingLabel').modal('show');
              jQuery('#amazonGenerateShippingLabel').find('#dataShipLabel').html(response);
              return false;
          });

        })

        jQuery(document).on('change','.ShippingServiceId',function() {
          var option = jQuery('option:selected', this).attr('data-ref');
          var parentLable = '';
          if(option != undefined){
            $(".dimension optgroup").each(function(){
                jQuery(this).hide();
                parentLable = jQuery(this).attr('label');
                if(parentLable.toUpperCase() == option){
                  jQuery(this).show();
                }
            });
          }

        })

        jQuery(document).on('submit','.amazonShippingLabelForm', function (event) {
            jQuery('#amazonGenerateShippingLabel #dataShipLabel').find('.shipping-alert').remove();
            event.preventDefault();
            var data = jQuery(this).serialize();
            var isError = false;
            jQuery('.shippingInputsuccess').each(function (event) {
                var inputVal = $(this).val();
                inputVal     = $.trim(inputVal);

                if($.trim(inputVal) == '' || inputVal == undefined )
                {
                  isError = true;
                  $(this).parents('.form-group').addClass('has-error');
                  $(this).attr('placeholder', 'This Field is Required');

                }
                else
                {
                    isError = false;
                    $(this).parents('.form-group').removeClass('has-error');
                    $(this).attr('placeholder', '');

                }
            })

            if(!isError)
            {
              jQuery.ajax({
                type: "GET",
                url: site_url + "/print-amazon-shipping-label",
                data: data,
                async: true,
                beforeSend: function () {
                  jQuery('#wait').show();
                },
                complete: function () {
                  jQuery('#wait').hide();
                },
                success: function (response)
                {
                    jQuery('.createAmazonShippingLabel').prop("disabled",true);
                    if (response) {
                      jQuery('#amazonGenerateShippingLabel #dataShipLabel').find('.shipingMessageElement').append('<div class="clearfix alert shipping-alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Please wait your file is ready to download after few moments.</div>');
                      setTimeout(function () {
                        var newTab = window.open(site_url+"/download-amazon-shipping-label", '_blank');
                        newTab.location;
                      },100);
                      // window.open(site_url+"/downloadPdf",null,"height=200,width=400,status=yes,toolbar=no,menubar=no,location=no");
                    }else {
                      jQuery('.createAmazonShippingLabel').prop("disabled",false);
                      jQuery('#amazonGenerateShippingLabel #dataShipLabel').find('.shipingMessageElement').append('<div class="alert shipping-alert alert-warning alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> This alert box indicates a warning that might need attention.</div>');
                    }
                }
              })
            }

        })

});
