jQuery(document).ready(function(){
	(function($){
	    $.fn.extend({
	        donetyping: function(callback,timeout){
	            timeout = timeout || 1e3; // 1 second default timeout
	            var timeoutReference,
	                doneTyping = function(el){
	                    if (!timeoutReference) return;
	                    timeoutReference = null;
	                    callback.call(el);
	                };
	            return this.each(function(i,el){
	                var $el = $(el);
	                // Chrome Fix (Use keyup over keypress to detect backspace)
	                // thank you @palerdot
	                $el.is(':input') && $el.on('keyup keypress paste',function(e){
	                    // This catches the backspace button in chrome, but also prevents
	                    // the event from triggering too preemptively. Without this line,
	                    // using tab/shift+tab will make the focused element fire the callback.
	                    if (e.type=='keyup' && e.keyCode!=8) return;

	                    // Check if timeout has been set. If it has, "reset" the clock and
	                    // start over again.
	                    if (timeoutReference) clearTimeout(timeoutReference);
	                    timeoutReference = setTimeout(function(){
	                        // if we made it here, our timeout has elapsed. Fire the
	                        // callback
	                        doneTyping(el);
	                    }, timeout);
	                }).on('blur',function(){
	                    // If we can, fire the event since we're leaving the field
	                    doneTyping(el);
	                });
	            });
	        }
	    });
	})(jQuery);
	jQuery('body').on('keyup','.success,.successEbay',function(){

		var currentVal = jQuery(this).val();
		text = currentVal.trim();
        if (text != '') {
			jQuery(this).css('border', '1.8px solid #3c763d');
		}
		else{
			jQuery(this).css('border', '1.8px solid #a94442');
		}
	});
	jQuery('body').on('click','.checkform',function(){

		var count = 0;
		jQuery('.success').each(function(){
			var currentVal = jQuery(this).val();
			text = currentVal.trim();
			if (text != '') {
				jQuery(this).css('border', '1.8px solid #3c763d');
			}
			else{
				count = parseInt(count) + parseInt(1);
				jQuery(this).css('border', '1.8px solid #a94442');
			}
		});

		if(count > 0){
			return false;
		}
	});
	jQuery('body').on('click','.checkLogin',function(){
		var count = 0;
		jQuery('.success').each(function(){
			var currentVal = jQuery(this).val();
			text = currentVal.trim();
			if (text != '') {
				jQuery(this).css('border', '1.8px solid #3c763d');
			}
			else{
				count = parseInt(count) + parseInt(1);
				jQuery(this).css('border', '1.8px solid #a94442');
			}
		});
		var emailVal = jQuery('#emailIdMail').val();
		var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		var valid = emailReg.test(emailVal);
		if(!valid) {
			jQuery('#emailIdMail').removeClass('error');
			jQuery('#emailIdMail').removeClass('successMail');
			jQuery('#emailIdMail').css('border', '1.8px solid #a94442');

			count = parseInt(count) + parseInt(1);

		}
		else{
			jQuery('#emailIdMail').css('border', '1.8px solid #3c763d');
		}
		if(count > 0){
			return false;
		}
	});
	jQuery('body').on('keyup', '#emailIdMail', function () {
	var emailVal = jQuery(this).val();
	var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	var valid = emailReg.test(emailVal);
	if(!valid) {
		jQuery(this).removeClass('error');
		jQuery(this).removeClass('successMail');
		jQuery(this).css('border', '1.8px solid #a94442');
		jQuery('#sendMailInvoice').prop('disabled',true);

	}
	else{
		jQuery(this).addClass('successMail');

		jQuery(this).css('border', '1.8px solid #3c763d');
		jQuery('#sendMailInvoice').prop('disabled',false);
	}
	});
	jQuery('body').on('keypress keyup blur', '.number', function (event) {
        var valid = /^\d{0,20}(\.\d{0,2})?$/.test(this.value),
                val = this.value;
        if (!valid) {
            // console.log("Invalid input!");
            this.value = val.substring(0, val.length - 1);
        }
        if (isNaN(this.value )) {
			this.value = '';
		}
    });
		jQuery('body').on('keypress keyup blur','.checkPrice',function(){
				var regex = /^\d*(.\d{2})?$/;
				var price = jQuery(this).val();
				var valid = regex.test(price);
				if (!valid) {
					jQuery(this).closest('form').find('input.checkform').prop('disabled',true);
					jQuery(this).css('border', '1.8px solid #a94442');
				}
				else{
					jQuery(this).closest('form').find('input.checkform').prop('disabled',false);
					jQuery(this).css('border', '1.8px solid #3c763d');
				}

		});
		jQuery('body').on('focus','.datePicker',function(){
		jQuery( this).datepicker({ dateFormat: 'dd/mm/yy' }).val();
	});
	jQuery('body').on('click','.backArrow',function(){
			jQuery('#editDetails').html('').hide();
				jQuery('.inventoryListDetail').show();
	});
});
	function ajaxHit(string,type){
		return jQuery.ajax({
            type: "GET",
            url: string,
            beforeSend: function() { jQuery('#wait').show()},
            complete: function() { jQuery('#wait').hide() },
            data: {},
            dataType: type
        });
	}
	function ajaxHit1(string,type){
		return jQuery.ajax({
            type: "GET",
            url: string,
            beforeSend: function() {},
            complete: function() {  },
            data: {},
            dataType: type
        });
	}
	function ajaxFormHit(type,className){
		var result="";
		 jQuery('.'+className).ajaxForm({
            beforeSend: function() { $('#wait').show(); },
            complete: function() { $('#wait').hide() },
            data: {},
            dataType: type,
			async: false,
			success: function (data) {
                try {
					 result = data;
                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }
        }).submit();
return result;
	}
		function ajaxFormHit1(type,className,typeFor){
		var result="";
		 jQuery('#'+className).ajaxForm({
            beforeSend: function() { $('#wait').show(); },
            complete: function() { $('#wait').hide() },
            data: {},
            dataType: type,
						async: -1,
			success: function (data) {

                try {

						if(typeFor == 'addInv'){
							jQuery('#'+className)[0].reset();
							//	jQuery('.updateclientdetailsTrading').show().addClass('alert-danger').removeClass('alert-success').fadeOut(4000);
								//jQuery('.updateclientmessageTrading').html(tradingCount).css('color','#a94442');

								jQuery('.updateclientdetails').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
								jQuery('.updateclientmessage').html(addInventory);
								  jQuery("html, body").animate({scrollTop: 0}, "slow");
								//jQuery('#tradingAccountTb').append(data);

							//result = data;
							}
							if(typeFor == 'editInv'){
								var productRef = jQuery('.productRef').val();

								if(data[0] == 1 || data[1] == 1){
									var listVal = [];
									jQuery('.listValue').each(function(){
											listVal.push(jQuery(this).val());
									});
									//alert(listVal);
									jQuery('#brandNameList'+productRef).text(listVal[0]);
									jQuery('#modelName'+productRef).text(listVal[1]);
									jQuery('#stockNumber'+productRef).text(listVal[5]);
									jQuery('#createdDate'+productRef).text(listVal[2]);
									jQuery('#imeNum'+productRef).text(listVal[4]);
									jQuery('#totalCost'+productRef).text(listVal[6]);
									jQuery('#quantity'+productRef).text(listVal[3]);
								//	jQuery('#ebaylisted'+productRef).text(listVal[0]);
								//	jQuery('#amazonListed'+productRef).text(listVal[0]);
									jQuery('.updateclientdetailsInv').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
									jQuery('.updateclientmessageInv').html(editInventory);
								}
								else{
									jQuery('.updateclientdetailsInv').show().addClass('alert-danger').removeClass('alert-success').fadeOut(4000);
									jQuery('.updateclientmessageInv').html(editInventory1);
								}
									jQuery("html, body").animate({scrollTop: 0}, "slow");
								}
								else if(typeFor == 'ebayInv'){
									if(data ==  1){
										jQuery('.updateclientdetailsInv').show().addClass('alert-success').removeClass('alert-danger').fadeOut(4000);
										jQuery('.updateclientmessageInv').html(listedEbay);
								}
								else{
									jQuery('.updateclientdetailsInv').show().addClass('alert-danger').removeClass('alert-success').fadeOut(4000);
									jQuery('.updateclientmessageInv').html(notListedEbay);
								}
								jQuery("html, body").animate({scrollTop: 0}, "slow");
								}

                } catch (e) {
                    alert('Exception while request..');
                }
            },
            error: function () {
                alert('Error while request..');
            }
        }).submit();
	}
