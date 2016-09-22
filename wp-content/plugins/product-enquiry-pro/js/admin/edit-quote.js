jQuery(document).ready(function(){
  jQuery(".msg-wrapper:last").find(".msg-border").hide();

    // Trigger WooCommerce Tooltips. This is used to trigger tooltips added by function \wc_help_tip
 //    var tiptip_args = {
 //     'attribute': 'data-tip',
 //     'fadeIn': 50,
 //     'fadeOut': 50,
 //     'delay': 200
 // };
 // jQuery( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip( tiptip_args );
 var atLeastOneIsChecked;
 jQuery('.wdm-checkbox-quote').each(function () {
  if (jQuery(this).is(':checked')) {
    atLeastOneIsChecked = true;
    rowNumber=jQuery(this).attr("data-row-num");
    jQuery('#content-qty-'+rowNumber).removeClass("unchecked");
    jQuery('#content-new-'+rowNumber).removeClass("unchecked");
    jQuery('#variation-'+rowNumber).show();
    jQuery('#variation-unchecked-'+rowNumber).hide();
            // jQuery(this).removeClass("unchecked");
          }else{
            rowNumber=jQuery(this).attr("data-row-num");
            jQuery('#content-qty-'+rowNumber).addClass("unchecked");
            jQuery('#content-new-'+rowNumber).addClass("unchecked");
            jQuery('#variation-'+rowNumber).hide();
            jQuery('#variation-unchecked-'+rowNumber).show();
            // jQuery(this).addClass("unchecked");
          }
          rowNumber=jQuery(this).attr("data-row-num");
          if(jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-variations').find('#variation-unchecked-'+rowNumber).hasClass('quotation-disabled')){
            jQuery('#variation-unchecked-'+rowNumber).hide();
          }
        });
if(atLeastOneIsChecked){
  jQuery( '#send' ).prop( 'disabled', false );
  jQuery( '#btnPQuote' ).prop( 'disabled', false );
}else{
  jQuery( '#send' ).prop( 'disabled', true );
  jQuery( '#btnPQuote' ).prop( 'disabled', true );
}

jQuery('.rply-link').click(function (e)
{
  e.preventDefault();

  jQuery(this).next('.reply-div').slideToggle();

});

jQuery('.button-rply-user').click(function (e)
{
  e.preventDefault();
  elem = jQuery(this);
  thread_id = jQuery(this).attr('data_thread_id');

  user_email = jQuery('.wdm-enquiry-usr').val();
  subject = jQuery('.wdm_reply_subject_'+thread_id).val();
  path = jQuery('.admin-url').val();
  message = jQuery('.wdm_reply_msg_'+thread_id).val();
  enq_id =jQuery('.wdm-enq-id').val();
  parent_id=elem.closest('.reply-div').find('.parent-id').val();
  jQuery(this).next('.load-ajax').css('display','inline-block');
  jQuery.ajax(
  {
    method: 'POST',
    url: path,
    data: {action: 'wdmSendReply',
    'email': user_email,
    'subject': subject,
    'msg': message,
    'eid': enq_id,
    'parent_id':parent_id
  },
  success: function (response) {
    jQuery('.wdm-action option:first-child').attr('selected', 'selected');
    elem.closest('.reply-div').slideUp();
    elem.closest('.reply-div').next('.msg-sent').fadeIn();
    jQuery(this).next('.load-ajax').css('display','none');
    setTimeout(function () {
      elem.next('.msg-sent').fadeOut();
    }, 3000);
    location.reload();
  },
  error: function (error) {
    console.log(error);
  }
});


});

jQuery( ".newqty" ).change( function () {
  quantity = jQuery(this).val();
  if(quantity % 1 !== 0){
    jQuery(this).css('border-color','red');
    jQuery( "#btnPQuote" ).attr( "disabled", false );
    jQuery( "#send" ).attr( "disabled", false );
    jQuery( "#downloadPDF" ).attr( "disabled", false );

    jQuery( "#PdfLoad" ).css( "visibility", "hidden" );

    // displayAjaxResponseMessages( quote_data.quantity_invalid );
    return;
  }else{
    jQuery(this).css('border-color','#ddd');
  }
} );

var totalprice=0;
var rowNumber;
var previousSKU = jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-sku').text();
        //Enable input boxes if checkbox is checked
        jQuery('.wdm-checkbox-quote').click (function(){
          var atLeastOneIsChecked = false;
          jQuery('.wdm-checkbox-quote').each(function () {
            if (jQuery(this).is(':checked')) {
              atLeastOneIsChecked = true;
                  // Stop .each from processing any more items
                  return false;
                }
              });
          if(atLeastOneIsChecked){
            jQuery( '#send' ).prop( 'disabled', false );
            jQuery( '#btnPQuote' ).prop( 'disabled', false );
          }else{
            jQuery( '#send' ).prop( 'disabled', true );
            jQuery( '#btnPQuote' ).prop( 'disabled', true );
          }
          rowNumber=jQuery(this).attr("data-row-num");
          if(jQuery(this).is(":checked")){
            jQuery('#content-qty-'+rowNumber).removeClass("unchecked");
            jQuery('#content-new-'+rowNumber).removeClass("unchecked");
            jQuery('#variation-'+rowNumber).show();
            jQuery('#variation-unchecked-'+rowNumber).hide();
            jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-sku').text(previousSKU);
            if(!jQuery('#content-qty-'+rowNumber).hasClass('sold-individual-quantity')){
              jQuery('#content-qty-'+rowNumber).prop('disabled', false);
            }
            jQuery('#content-new-'+rowNumber).prop('disabled', false);
            var quantity=jQuery('#content-qty-'+rowNumber).val();
            var newprice=jQuery('#content-new-'+rowNumber).val();
            var finalprice=newprice*quantity;
            jQuery('#content-cost-'+rowNumber).html(quoteupFormatPrice(finalprice));
            jQuery('#content-amount-'+rowNumber).val(finalprice);
            var finaltotal=0
            jQuery('.amount_database').each(function(){
              var current=jQuery(this).val();
              finaltotal=parseFloat(finaltotal)+parseFloat(current);
            })

            jQuery('#amount_total').html(quoteupFormatPrice(finaltotal));
          }else{
            previousSKU = jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-sku').text();
            jQuery('#content-qty-'+rowNumber).addClass("unchecked");
            jQuery('#content-new-'+rowNumber).addClass("unchecked");
            jQuery('#variation-'+rowNumber).hide();
            jQuery('#variation-unchecked-'+rowNumber).show();
            jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-sku').text(jQuery('#variationUnchecked-'+rowNumber).val());
            jQuery('#content-qty-'+rowNumber).prop('disabled', true);
            jQuery('#content-new-'+rowNumber).prop('disabled', true);
            jQuery('#content-cost-'+rowNumber).html("-");
            jQuery('#content-amount-'+rowNumber).val(0);
            var finaltotal=0
            jQuery('.amount_database').each(function(){
              var current=jQuery(this).val();
              finaltotal=parseInt(finaltotal)+parseInt(current);
            })

            jQuery('#amount_total').html(quoteupFormatPrice(finaltotal));
          }
        });

        //Update Amout and total amount on change of new price or quantity
        jQuery('.newprice, .newqty').on('input',function(e){
          rowNumber=jQuery(this).attr("data-row-num");
          var quantity=jQuery('#content-qty-'+rowNumber).val();
          var newprice=jQuery('#content-new-'+rowNumber).val();
          var finalprice=newprice*quantity;
          jQuery('#content-cost-'+rowNumber).html(quoteupFormatPrice(finalprice));
          jQuery('#content-amount-'+rowNumber).val(finalprice);
          var finaltotal=0
          jQuery('.amount_database').each(function(){
            var current=jQuery(this).val();
            finaltotal=parseFloat(finaltotal)+parseFloat(current);
          })

          jQuery('#amount_total').html(quoteupFormatPrice(finaltotal));
        })

        //Change Quantity to 1 if it is blank or invalid
        jQuery('.newqty, .newprice').focusout(function(){
          makeDataValid(jQuery(this));

        });

        function makeDataValid(selector){
          var isDataValid = true;
          if(selector.hasClass('newqty')){
            if(!jQuery.trim(selector.val()) || selector.val() <= 0){
              isDataValid = false;
              selector.val("1");
            }
          } else {
            if(!jQuery.trim(selector.val()) || selector.val() < 0){
              isDataValid = false;
              selector.val("0");
            }
          }

          if(isDataValid == false){
           rowNumber=selector.attr("data-row-num");
           var quantity=jQuery('#content-qty-'+rowNumber).val();
           var newprice=jQuery('#content-new-'+rowNumber).val();
           var finalprice=newprice*quantity;
           jQuery('#content-cost-'+rowNumber).html(quoteupFormatPrice(finalprice));
           jQuery('#content-amount-'+rowNumber).val(finalprice);
           var finaltotal=0;
           jQuery('.amount_database').each(function(){
            var current=selector.val();
            finaltotal=parseFloat(finaltotal)+parseFloat(current);
          })

           jQuery('#amount_total').html(quoteupFormatPrice(finaltotal));
         }
       }


       jQuery(".wdm-input-expiration-date").datepicker({
         altFormat: "yy-mm-dd 00:00:00",
         altField: ".expiration_date_hidden",
         dateFormat: "MM d, yy",
         minDate: 0,
       });

    // When WooCommerce changes image on changing variation, copy new image's src value in the image column of Product Details Table 
    jQuery('.variation_image').observe({ attributes: true, attributeFilter: ['src'] }, function(){
     if(empty(this.getAttribute('src'))) {
       jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-img img').attr('src', this.getAttribute('data-o_src'));
     } else {
       jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-img img').attr('src', this.getAttribute('src')); 
     }
   });

    // When WooCommerce changes SKU, copy new SKU value in the SKU column of Product Details Table 
    jQuery('.sku').observe('childlist subtree', function(){
      jQuery(this).closest('.wdmpe-detailtbl-content-row').find('.item-content-sku').text(jQuery(this).text());
    });

	//If no date is filled, set hidden value to 0000-00-00 00:00:00 
	jQuery(".wdm-input-expiration-date").change(function(){
   if(empty(jQuery(this).val())){
    jQuery('.expiration_date_hidden').val('0000-00-00 00:00:00');
  }
});


  jQuery('#wpfooter').css("position", "relative");

});




