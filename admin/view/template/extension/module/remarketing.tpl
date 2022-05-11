<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-remarketing" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($max_input_vars_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $max_input_vars_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-remarketing" class="form-horizontal">
		  <div class="col-md-2">
		  <ul class="nav nav-pills nav-stacked">
		    <li class="active"><a href="#tab-diagnostics" data-toggle="tab" class="diag"><i class="fa fa-gears"></i> <?php echo $text_diagnostics; ?> <i class="fa fa-flash"></i></a></li>
            <li><a href="#tab-google" data-toggle="tab" <?php if ($remarketing_google_status) { ?>class="enabled"<?php } ?>><i class="fa fa-google"></i> <?php echo $text_google_remarketing; ?></a></li>
            <li><a href="#tab-facebook" data-toggle="tab" <?php if ($remarketing_facebook_status) { ?>class="enabled"<?php } ?>><i class="fa fa-facebook"></i> <?php echo $text_facebook_remarketing; ?></a></li>
			<li><a href="#tab-feed" data-toggle="tab" <?php if ($remarketing_feed_status) { ?>class="enabled"<?php } ?>><i class="fa fa-compress"></i> <?php echo $text_feed; ?></a></li>
			<li><a href="#tab-ecommerce" data-toggle="tab" <?php if ($remarketing_ecommerce_status || $remarketing_ecommerce_measurement_status) { ?>class="enabled"<?php } ?>><i class="fa fa-money"></i> <?php echo $text_ecommerce; ?></a></li>
			<li><a href="#tab-ecommerce-ga4" data-toggle="tab" <?php if ($remarketing_ecommerce_ga4_status || $remarketing_ecommerce_ga4_measurement_status) { ?>class="enabled"<?php } ?>><i class="fa fa-money"></i> <?php echo $text_ecommerce_ga4; ?></a></li>
			<li><a href="#tab-google-reviews" data-toggle="tab" <?php if ($remarketing_reviews_status) { ?>class="enabled"<?php } ?>><i class="fa fa-google"></i> <?php echo $text_google_reviews; ?></a></li>
            <li><a href="#tab-events" data-toggle="tab"><i class="fa fa-bullhorn"></i> <?php echo $text_events; ?></a></li>
            <li><a href="#tab-counters" data-toggle="tab"><i class="fa fa-tachometer"></i> <?php echo $text_counters; ?></a></li>
            <li><a href="#tab-mytarget" data-toggle="tab" <?php if ($remarketing_mytarget_status) { ?>class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_mytarget_remarketing; ?></a></li>
            <li><a href="#tab-vk" data-toggle="tab" <?php if ($remarketing_vk_status) { ?>class="enabled"<?php } ?>><i class="fa fa-vk"></i> <?php echo $text_vk_remarketing; ?></a></li>
            <li><a href="#tab-esputnik" data-toggle="tab" <?php if ($remarketing_esputnik_status) { ?>class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_esputnik; ?></a></li>
			<li><a href="#tab-retailrocket" data-toggle="tab" <?php if ($remarketing_retailrocket_status) { ?>class="enabled"<?php } ?>><i class="fa fa-rocket"></i> <?php echo $text_retail_rocket; ?></a></li>
			<li><a href="#tab-tiktok" data-toggle="tab" <?php if ($remarketing_tiktok_status) { ?>class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_tiktok; ?></a></li>
			<li><a href="#tab-telegram" data-toggle="tab" <?php if ($remarketing_telegram_status) { ?>class="enabled"<?php } ?>><i class="fa fa-check"></i> <?php echo $text_telegram; ?></a></li>
			<li><a href="#tab-reporting" data-toggle="tab"><i class="fa fa-bar-chart"></i> <?php echo $text_reporting; ?></a></li>
            <li><a href="#tab-instruction" data-toggle="tab"><i class="fa fa-files-o"></i> <?php echo $text_instruction; ?></a></li>
            <li><a href="#tab-help" data-toggle="tab"><i class="fa fa-life-ring"></i> <?php echo $text_help; ?></a></li>
          </ul>
		  </div>
		  <div class="col-md-10">
		  <div class="tab-content">
            <div class="tab-pane" id="tab-google">
			<div class="">
            <div class="col-sm-12 control-label text-left" style="text-align:left;"><?php echo $text_help_google; ?></div>
            </div> 
			<legend><?php echo $text_google_remarketing; ?></legend>
			<div class="help-link"><a href="https://support.google.com/google-ads/answer/7305793?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_google_status" id="input-status" class="form-control">
                <?php if ($remarketing_google_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
			<div class="form-group hidden"> 
            <label class="col-sm-2 control-label" for="input-gtag-status"><?php echo $entry_google_gtag_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_google_gtag_status" id="input-gtag-status" class="form-control">
                <?php if ($remarketing_google_gtag_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_identifier"><?php echo $entry_google_identifier; ?></label>
                <div class="col-sm-10">
                   <input type="text" name="remarketing_google_identifier" value="<?php echo $remarketing_google_identifier; ?>" id="input-remarketing_google_identifier" class="form-control" />
                </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_ads_identifier"><?php echo $entry_google_ads_identifier; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier" value="<?php echo $remarketing_google_ads_identifier; ?>" id="input-remarketing_google_ads_identifier" class="form-control" />
                  </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_ads_identifier_cart"><?php echo $entry_google_ads_identifier_cart; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier_cart" value="<?php echo $remarketing_google_ads_identifier_cart; ?>" id="input-remarketing_google_ads_identifier_cart_page" class="form-control" />
            </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_ads_identifier_cart_page"><?php echo $entry_google_ads_identifier_cart_page; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_google_ads_identifier_cart_page" value="<?php echo $remarketing_google_ads_identifier_cart_page; ?>" id="input-remarketing_google_ads_identifier_cart_page" class="form-control" />
            </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_ads_ratio"><?php echo $entry_google_ads_ratio; ?></label>
            <div class="col-sm-10">
               <input type="text" name="remarketing_google_ads_ratio" value="<?php echo $remarketing_google_ads_ratio; ?>" id="input-remarketing_google_ads_ratio" class="form-control" />
            </div>
		  </div>
		    <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_google_id" id="input-status" class="form-control">
                <?php if ($remarketing_google_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_google_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
   		  </div>
            <div class="tab-pane" id="tab-facebook">
			<div class="">
            <div class="col-sm-12 control-label text-left" style="text-align:left;"><?php echo $text_help_facebook; ?></div>
            </div> 
			<legend><?php echo $text_facebook_remarketing; ?></legend>
			<div class="help-link"><a href="https://developers.facebook.com/docs/facebook-pixel/reference" target="_blank"><?php echo $text_help_link; ?> Facebook</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_status" id="input-status" class="form-control">
                <?php if ($remarketing_facebook_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_identifier"><?php echo $entry_facebook_identifier; ?></label>
              <div class="col-sm-10">
                 <input type="text" name="remarketing_facebook_identifier" value="<?php echo $remarketing_facebook_identifier; ?>" id="input-remarketing_facebook_identifier" class="form-control" />
              </div>
			</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_ratio"><?php echo $entry_facebook_ratio; ?></label>
              <div class="col-sm-10">
                 <input type="text" name="remarketing_facebook_ratio" value="<?php echo $remarketing_facebook_ratio; ?>" id="input-remarketing_facebook_ratio" class="form-control" />
              </div>
		</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook-id"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_id" id="input-facebook-id" class="form-control">
                <?php if ($remarketing_facebook_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_facebook_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <legend><?php echo $text_facebook_pixel; ?></legend>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook-script-status"><?php echo $entry_facebook_script_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_script_status" id="input-facebook-script-status" class="form-control">
                <?php if ($remarketing_facebook_script_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-pixel-status"><?php echo $entry_facebook_pixel_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_pixel_status" id="input-pixel-status" class="form-control">
                <?php if ($remarketing_facebook_pixel_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-lead"><?php echo $entry_facebook_lead; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_lead" id="input-lead" class="form-control">
                <?php if ($remarketing_facebook_lead) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>		  
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-depth"><?php echo $entry_facebook_depth; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_facebook_depth" id="input-depth" class="form-control">
                <?php if ($remarketing_facebook_depth) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_depth_params"><?php echo $entry_facebook_depth_params; ?></label>
              <div class="col-sm-10">
                 <input type="text" name="remarketing_facebook_depth_params" value="<?php echo $remarketing_facebook_depth_params; ?>" id="input-remarketing_facebook_depth_params" class="form-control" />
              </div>
		  </div>
		  <legend><?php echo $text_facebook_api; ?></legend>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-server-side"><?php echo $entry_server_side; ?></label>
            <div class="col-sm-10"> 
              <select name="remarketing_facebook_server_side" id="input-server-side" class="form-control">
                <?php if ($remarketing_facebook_server_side) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook-log"><?php echo $entry_log; ?></label>
            <div class="col-sm-10"> 
              <select name="remarketing_facebook_log" id="input-facebook-log" class="form-control">
                <?php if ($remarketing_facebook_log) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_token"><?php echo $entry_facebook_token; ?></label>
              <div class="col-sm-10">
                 <input type="text" name="remarketing_facebook_token" value="<?php echo $remarketing_facebook_token; ?>" id="input-remarketing_facebook_token" class="form-control" />
              </div>
		  </div>
		  <div class="form-group"> 
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_api_ver"><?php echo $entry_facebook_api_ver; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_facebook_api_ver" value="<?php echo $remarketing_facebook_api_ver; ?>" id="input-remarketing_facebook_token" class="form-control" />
              </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_test_code"><?php echo $entry_facebook_test_code; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_facebook_test_code" value="<?php echo $remarketing_facebook_test_code; ?>" id="input-remarketing_facebook_test_code" class="form-control" />
				<br><a class="btn btn-primary test-facebook"><?php echo $button_test_facebook; ?></a>
				<div class="facebook_result"></div>
				<script>
				$('.test-facebook').on('click', function(){
					$.ajax({ 
						type: 'post',
						url:  '<?php echo $test_facebook; ?>',
						data: {},
						dataType: 'json',
						success: function(json) { 
							if (typeof json.events_received !== "undefined" && json.events_received == 1) {
								$('.facebook_result').html('<br><div style="background: green;width: auto;display: inline-block;color: #fff;padding: 10px;font-weight: bold;">TEST OK!</div>');
							} else if (json.error !== "undefined") {
								$('.facebook_result').html('<br><div style="background: red;width: auto;display: inline-block;color: #fff;padding: 10px;font-weight: bold;">TEST FAILED! ' + json.error.message + '</div>');
							}
							console.log(json);
						}
					});
				})
				</script>
             </div>
		  </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_send_status"><?php echo $entry_facebook_send_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_facebook_send_status)) { ?>
                       <input type="checkbox" name="remarketing_facebook_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_facebook_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_facebook_lead_send_status"><?php echo $entry_facebook_lead_send_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_facebook_lead_send_status)) { ?>
                       <input type="checkbox" name="remarketing_facebook_lead_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_facebook_lead_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		  <div class="form-group">
             <label class="col-sm-2 control-label" for="input-entry_remarketing_facebook_resend_status"><?php echo $entry_resend_status; ?></label>
             <div class="col-sm-10">
             <select name="remarketing_facebook_resend_status" id="input-entry_remarketing_facebook_resend_status" class="form-control">
			  <option value="0"><?php echo $text_not_selected; ?></option>
                 <?php foreach ($order_statuses as $order_status) { ?>
                 <?php if ($order_status['order_status_id'] == $remarketing_facebook_resend_status) { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                 <?php } else { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                 <?php } ?>
                 <?php } ?>
               </select>
             </div>
          </div>
		  <div class="form-group form-facebook-transaction">
            <label class="col-sm-2 control-label"><?php echo $entry_manual_send; ?></label>
               <div class="col-sm-10">
               <label class="col-sm-2 control-label">Total</label>
               <div class="col-sm-10"><input type="text" name="manual_facebook_total" value="" class="form-control" /></div>
			   <label class="col-sm-2 control-label">Products</label><div class="select-product col-sm-10"><input type="text" name="manual_facebook_product" value="" placeholder="Select product" class="form-control" /></div>
			   <label class="col-sm-2 control-label"> </label><div class="facebook-products col-sm-10">
			   <div class="col-sm-12 manual-product"><span class="form-control">ID</span><span class="form-control">Name</span><span class="form-control">Price</span><span class="form-control">Quantity</span></div><br>
			   </div>
			   <br><br><a class="btn btn-primary send-facebook-transaction"><i class="fa fa-plus"></i> Send Transaction</a>
				<div class="send-facebook-result"></div>
			   </div>
            </div> 
<script>
	manual_facebook_product_id = 0;
	$('input[name=\'manual_facebook_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						name: item['name'],
						label: item['name'],
						product_id: item['product_id'],
						value: item['product_id'],
						price: item['price']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'manual_facebook_product\']').val('');

		$('.facebook-products').append('<div class="col-sm-12 manual-facebook-product'+manual_facebook_product_id+'"><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][product_id]" value="' + item['product_id'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][name]" value="' + item['name'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][price]" value="' + item['price'] + '" class="form-control col-sm-3" /><input type="text" name="manual_facebook_products[' + manual_facebook_product_id + '][quantity]" value="1" class="form-control col-sm-3" /> <i class="fa fa-trash-o" onclick="$(\'.manual-facebook-product' + manual_facebook_product_id + '\').remove();"></i></div>');
		manual_facebook_product_id++;
	}
});
	
	$('.send-facebook-transaction').on('click', function(){
	send_data = $('.form-facebook-transaction input[type=\'text\']');
	$.ajax({
		url: '/index.php?route=common/remarketing/sendFacebookManual',
		type: 'post',
		data: send_data,
		dataType: 'json',
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(json) {
			if (json['error']) {
				$('.send-facebook-result').html(json['error']);
			}
			if (json['success']) {
				$('.send-facebook-result').html(json['success']);
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
        }
	});
});
</script>
<style>
.facebook-products .form-control {
	width: 200px; display:inline-block;
}
</style>

		  </div>
          <div class="tab-pane" id="tab-mytarget">
          <legend><?php echo $text_mytarget_remarketing; ?></legend>
		  <div class="help-link"><a href="https://target.my.com/help/advertisers/remarketing/ru" target="_blank"><?php echo $text_help_link; ?> MyTarget</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-mytarget-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_mytarget_status" id="input-mytarget-status" class="form-control">
                <?php if ($remarketing_mytarget_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_mytarget_identifier"><?php echo $entry_mytarget_identifier; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_mytarget_identifier" value="<?php echo $remarketing_mytarget_identifier; ?>" id="input-remarketing_mytarget_identifier" class="form-control" />
                  </div>
			</div>
		    <div class="form-group">
            <label class="col-sm-2 control-label" for="input-mytarget-identifier"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_mytarget_id" id="input-mytarget-identifier" class="form-control">
                <?php if ($remarketing_mytarget_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_mytarget_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  </div>
          <div class="tab-pane" id="tab-vk">
          <legend><?php echo $text_vk_remarketing; ?></legend>
	   	  <div class="help-link"><a href="https://vk.com/faq12164" target="_blank"><?php echo $text_help_link; ?> Vkontakte</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-vk-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_vk_status" id="input-vk-status" class="form-control">
                <?php if ($remarketing_vk_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_vk_identifier"><?php echo $entry_vk_identifier; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_vk_identifier" value="<?php echo $remarketing_vk_identifier; ?>" id="input-remarketing_vk_identifier" class="form-control" />
               </div>
			</div>
		    <div class="form-group">
            <label class="col-sm-2 control-label" for="input-identifier"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_vk_id" id="input-identifier" class="form-control">
                <?php if ($remarketing_vk_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_vk_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  </div>
          <div class="tab-pane" id="tab-tiktok">
          <legend><?php echo $text_tiktok; ?></legend>
	   	  <div class="help-link"><a href="https://ads.tiktok.com/help/article?aid=10028" target="_blank"><?php echo $text_help_link; ?> TikTok</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tiktok-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_tiktok_status" id="input-tiktok-status" class="form-control">
                <?php if ($remarketing_tiktok_status) { ?> 
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  </div>
          <div class="tab-pane" id="tab-retailrocket">
          <legend><?php echo $text_retail_rocket; ?></legend>
	   	  <div class="help-link"><a href="https://manual.retailrocket.net/tracking/xml_integration/XML_Group/rus.html?partnerid=partnerIdFromPartnerOffice" target="_blank"><?php echo $text_help_link; ?> Retail Rocket</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-retailrocket-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_retailrocket_status" id="input-retailrocket-status" class="form-control">
                <?php if ($remarketing_retailrocket_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_retailrocket_identifier"><?php echo $entry_retailrocket_identifier; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_retailrocket_identifier" value="<?php echo $remarketing_retailrocket_identifier; ?>" id="input-remarketing_retailrocket_identifier" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_retailrocket_email_field"><?php echo $entry_retailrocket_email_field; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_retailrocket_email_field" value="<?php echo $remarketing_retailrocket_email_field; ?>" id="input-remarketing_retailrocket_email_field" class="form-control" />
               </div>
		  </div>
		  </div>
          <div class="tab-pane" id="tab-telegram">
          <legend><?php echo $text_telegram; ?></legend>
	   	  <div class="help-link"></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-telegram-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_telegram_status" id="input-telegram-status" class="form-control">
                <?php if ($remarketing_telegram_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_telegram_bot_id"><?php echo $entry_telegram_bot_id; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_telegram_bot_id" value="<?php echo $remarketing_telegram_bot_id; ?>" id="input-remarketing_telegram_bot_id" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_telegram_send_to_id"><?php echo $entry_telegram_send_to_id; ?></label>
               <div class="col-sm-10">
                    <input type="text" name="remarketing_telegram_send_to_id" value="<?php echo $remarketing_telegram_send_to_id; ?>" id="input-remarketing_telegram_send_to_id" class="form-control" />
               </div>
		  </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_telegram_send_status"><?php echo $entry_telegram_send_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_telegram_send_status)) { ?>
                       <input type="checkbox" name="remarketing_telegram_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_telegram_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_telegram_message"><?php echo $entry_telegram_message; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_telegram_message" rows="5" id="input-remarketing_telegram_message" class="form-control"><?php echo $remarketing_telegram_message; ?></textarea>
               </div>
		  </div>
		  </div>
		  <div class="tab-pane" id="tab-google-reviews">
          <legend><?php echo $text_google_reviews; ?></legend>
		  <div class="help-link"><a href="https://support.google.com/merchants/answer/7106244" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-reviews-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_reviews_status" id="input-reviews-status" class="form-control">
                <?php if ($remarketing_reviews_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_google_merchant_identifier"><?php echo $entry_google_merchant_identifier; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_google_merchant_identifier" value="<?php echo $remarketing_google_merchant_identifier; ?>" id="input-remarketing_google_merchant_identifier" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_reviews_country"><?php echo $entry_reviews_country; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_country" value="<?php echo $remarketing_reviews_country; ?>" id="input-remarketing_reviews_country" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_reviews_date"><?php echo $entry_reviews_date; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_date" value="<?php echo $remarketing_reviews_date; ?>" id="input-remarketing_reviews_date" class="form-control" />
                  </div>
			</div>
			 <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_reviews_feed_gtin"><?php echo $entry_feed_gtin; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="remarketing_reviews_feed_gtin" value="<?php echo $remarketing_reviews_feed_gtin; ?>" id="input-remarketing_reviews_date" class="form-control" />
                  </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-reviews-feed-status"><?php echo $entry_feed_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_reviews_feed_status" id="input-reviews-feed-status" class="form-control">
                <?php if ($remarketing_reviews_feed_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
			  <br>
			  <a href="<?php echo HTTPS_CATALOG . 'index.php?route=extension/feed/remarketing_feed/googleReviews';?>" target="_blank"><?php echo $entry_feed_link; ?></a>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-reviews-feed-anonymous"><?php echo $entry_feed_anonymous; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_reviews_feed_anonymous" id="input-reviews-feed-anonymous" class="form-control">
                <?php if ($remarketing_reviews_feed_anonymous) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		 
		  </div>
		  <div class="tab-pane" id="tab-esputnik">
          <legend><?php echo $text_esputnik; ?></legend>
		  <div class="help-link"><a href="https://esputnik.com/support/peredacha-dannyh-resursom-v1event" target="_blank"><?php echo $text_help_link; ?> eSputnik</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-esputnik-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_esputnik_status" id="input-esputnik-status" class="form-control">
                <?php if ($remarketing_esputnik_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_esputnik_login"><?php echo $entry_esputnik_login; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_esputnik_login" value="<?php echo $remarketing_esputnik_login; ?>" id="input-remarketing_esputnik_login" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
          <label class="col-sm-2 control-label" for="input-remarketing_esputnik_password"><?php echo $entry_esputnik_password; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_password" value="<?php echo $remarketing_esputnik_password; ?>" id="input-remarketing_esputnik_password" class="form-control" />
             </div>
		  </div>
		  <div class="form-group">
          <label class="col-sm-2 control-label" for="input-remarketing_esputnik_address_format"><?php echo $entry_esputnik_address_format; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_address_format" value="<?php echo $remarketing_esputnik_address_format; ?>" id="input-remarketing_esputnik_address_format" class="form-control" />
             </div>
		  </div>
		  <div class="form-group">
          <label class="col-sm-2 control-label" for="input-remarketing_esputnik_ttn_field"><?php echo $entry_esputnik_ttn_field; ?></label>
             <div class="col-sm-10">
                <input type="text" name="remarketing_esputnik_ttn_field" value="<?php echo $remarketing_esputnik_ttn_field; ?>" id="input-remarketing_esputnik_ttn_field" class="form-control" />
             </div>
		  </div>
			<div class="form-group"> 
            <label class="col-sm-2 control-label" for="input-remarketing_esputnik_initialized_status"><?php echo $entry_esputnik_initialized_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_initialized_status)) { ?>
                       <input type="checkbox" name="remarketing_esputnik_initialized_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_esputnik_initialized_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_esputnik_inprogress_status"><?php echo $entry_esputnik_inprogress_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_inprogress_status)) { ?>
                       <input type="checkbox" name="remarketing_esputnik_inprogress_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_esputnik_inprogress_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_esputnik_delivered_status"><?php echo $entry_esputnik_delivered_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_delivered_status)) { ?>
                       <input type="checkbox" name="remarketing_esputnik_delivered_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_esputnik_delivered_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_esputnik_cancelled_status"><?php echo $entry_esputnik_cancelled_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_esputnik_cancelled_status)) { ?>
                       <input type="checkbox" name="remarketing_esputnik_cancelled_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_esputnik_cancelled_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		  </div>
		  <div class="tab-pane" id="tab-events">
          <legend><?php echo $text_events; ?></legend>
		  <div class="form-group">
			   <div class="col-sm-2"></div>
               <div class="col-sm-10">
				  <?php echo $text_events_help;?>
               </div>
			</div>
			<div class="form-group">
			<label class="col-sm-2 control-label" for="input-remarketing_events_cart"><?php echo $entry_events_cart; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_cart" rows="5" id="input-remarketing_events_cart" class="form-control"><?php echo $remarketing_events_cart; ?></textarea>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_events_cart_add"><?php echo $entry_events_cart_add; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_cart_add" rows="5" id="input-remarketing_events_cart_add" class="form-control"><?php echo $remarketing_events_cart_add; ?></textarea>
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_events_purchase"><?php echo $entry_events_purchase; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_purchase" rows="5" id="input-remarketing_events_purchase" class="form-control"><?php echo $remarketing_events_purchase; ?></textarea>
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_events_quick_purchase"><?php echo $entry_events_quick_purchase; ?></label> 
               <div class="col-sm-10">
				    <textarea name="remarketing_events_quick_purchase" rows="5" id="input-remarketing_events_quick_purchase" class="form-control"><?php echo $remarketing_events_quick_purchase; ?></textarea>
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_events_wishlist"><?php echo $entry_events_wishlist; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_events_wishlist" rows="5" id="input-remarketing_events_wishlist" class="form-control"><?php echo $remarketing_events_wishlist; ?></textarea>
               </div>
		  </div>
		  </div>
		  <div class="tab-pane" id="tab-ecommerce">
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_analytics_id"><?php echo $entry_ecommerce_analytics_id; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_analytics_id" value="<?php echo $remarketing_ecommerce_analytics_id; ?>" id="input-remarketing_ecommerce_analytics_id" class="form-control" />
               </div>
		  </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_id"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_id" id="input-remarketing_ecommerce_id" class="form-control">
                <?php if ($remarketing_ecommerce_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ratio"><?php echo $entry_ecommerce_ratio; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ratio" value="<?php echo $remarketing_ecommerce_ratio; ?>" id="input-remarketing_ecommerce_ratio" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_selector"><?php echo $entry_ecommerce_selector; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_selector" value="<?php echo $remarketing_ecommerce_selector; ?>" id="input-remarketing_ecommerce_selector" class="form-control" />
               </div>
			</div>
          <legend><?php echo $text_ecommerce; ?> (dataLayer)</legend>
		  <div class="help-link"><a href="https://netpeak.net/ru/blog/kak-nastroit-rasshirennuyu-elektronnuyu-torgovlyu-s-pomoshch-yu-google-tag-manager/" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="help-link"><a href="https://yandex.ru/support/metrica/data/e-commerce.html" target="_blank"><?php echo $text_help_link; ?> Yandex</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_status" id="input-remarketing_ecommerce_status" class="form-control">
                <?php if ($remarketing_ecommerce_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
          <legend><?php echo $text_ecommerce_gtag; ?> (gtag.js)</legend>
		  <div class="help-link"><a href="https://developers.google.com/gtagjs/reference/event" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_gtag_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_gtag_status" id="input-remarketing_ecommerce_gtag_status" class="form-control">
                <?php if ($remarketing_ecommerce_gtag_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
          <legend><?php echo $text_ecommerce_measurement; ?></legend>
		  <div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_measurement_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_measurement_status" id="input-remarketing_ecommerce_measurement_status" class="form-control">
                <?php if ($remarketing_ecommerce_measurement_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_measurement_log"><?php echo $entry_log; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_measurement_log" id="input-remarketing_ecommerce_measurement_log" class="form-control">
                <?php if ($remarketing_ecommerce_measurement_log) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_measurement_id"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_measurement_id" id="input-remarketing_ecommerce_measurement_id" class="form-control">
                <?php if ($remarketing_ecommerce_measurement_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_measurement_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_measurement_user_id"><?php echo $entry_user_id; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_measurement_user_id" id="input-remarketing_ecommerce_measurement_user_id" class="form-control">
                <?php if ($remarketing_ecommerce_measurement_user_id) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div>  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_measurement_selector"><?php echo $entry_ecommerce_selector; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_measurement_selector" value="<?php echo $remarketing_ecommerce_measurement_selector; ?>" id="input-remarketing_ecommerce_measurement_selector" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_send_status"><?php echo $entry_ecommerce_send_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_ecommerce_send_status)) { ?>
                       <input type="checkbox" name="remarketing_ecommerce_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_ecommerce_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		   <div class="form-group"> 
                <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_delete_status"><?php echo $entry_delete_status; ?></label>
                <div class="col-sm-10">
                    <select name="remarketing_ecommerce_delete_status" id="input-remarketing_ecommerce_delete_status" class="form-control">
					  <option value="0"><?php echo $text_not_selected; ?></option>
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $remarketing_ecommerce_delete_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
               </div>
		   <div class="form-group">
                <label class="col-sm-2 control-label" for="input-entry_remarketing_ecommerce_resend_status"><?php echo $entry_resend_status; ?></label>
                <div class="col-sm-10">
                    <select name="remarketing_ecommerce_resend_status" id="input-entry_remarketing_ecommerce_resend_status" class="form-control">
					  <option value="0"><?php echo $text_not_selected; ?></option>
                      <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $remarketing_ecommerce_resend_status) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                  </div>
            </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_refund_status"><?php echo $entry_refund_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_refund_status)) { ?>
                       <input type="checkbox" name="remarketing_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
			<div class="form-group form-transaction">
            <label class="col-sm-2 control-label"><?php echo $entry_manual_send; ?></label>
			   <a href="https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters" target="_blank">Protocol Reference</a><br>
               <div class="col-sm-10">
               <label class="col-sm-2 control-label">Transaction ID</label>
               <div class="col-sm-10"><input type="text" name="manual_id" value="" class="form-control" /></div>
               <label class="col-sm-2 control-label">Shipping</label>
               <div class="col-sm-10"><input type="text" name="manual_shipping" value="" class="form-control" /></div>
               <label class="col-sm-2 control-label">cn</label>
               <div class="col-sm-10"><input type="text" name="manual_cn" value="" class="form-control" /></div>
               <label class="col-sm-2 control-label">cs</label>
               <div class="col-sm-10"><input type="text" name="manual_cs" value="" class="form-control" /></div>
               <label class="col-sm-2 control-label">cm</label>
               <div class="col-sm-10"><input type="text" name="manual_cm" value="" class="form-control" /></div>
               <label class="col-sm-2 control-label">Total</label>
               <div class="col-sm-10"><input type="text" name="manual_total" value="" class="form-control" /></div>
			   <label class="col-sm-2 control-label">Products</label><div class="select-product col-sm-10"><input type="text" name="manual_product" value="" placeholder="Select product" class="form-control" /></div>
			   <label class="col-sm-2 control-label"> </label><div class="products col-sm-10">
			   <div class="col-sm-12 manual-product"><span class="form-control">ID</span><span class="form-control">Name</span><span class="form-control">Price</span><span class="form-control">Quantity</span></div><br>
			   </div>
			   <br><br><a class="btn btn-primary send-transaction"><i class="fa fa-plus"></i> Send Transaction</a>
				<div class="send-result"></div>
			   </div>
            </div>
<script>
	manual_product_id = 0;
	$('input[name=\'manual_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						name: item['name'],
						label: item['name'],
						product_id: item['product_id'],
						value: item['product_id'],
						price: item['price']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'manual_product\']').val('');

		$('.products').append('<div class="col-sm-12 manual-product'+manual_product_id+'"><input type="text" name="manual_products[' + manual_product_id + '][product_id]" value="' + item['product_id'] + '" class="form-control col-sm-3" /><input type="text" name="manual_products[' + manual_product_id + '][name]" value="' + item['name'] + '" class="form-control col-sm-3" /><input type="text" name="manual_products[' + manual_product_id + '][price]" value="' + item['price'] + '" class="form-control col-sm-3" /><input type="text" name="manual_products[' + manual_product_id + '][quantity]" value="1" class="form-control col-sm-3" /> <i class="fa fa-trash-o" onclick="$(\'.manual-product' + manual_product_id + '\').remove();"></i></div>');
		manual_product_id++;
	}
});
	$('.add-manual-product').on('click', function() {
	 html  = '';
	 html += 'Name: <input type="text" name="manual_products[0][name]" value="" class="form-control col-sm-3" /> Price: <input type="text" name="manual_products[0][price]" value="" class="form-control col-sm-3" />Quantity: <input type="text" name="manual_products[0][quantity]" value="" class="form-control col-sm-3" />';
		$('.products').append(html);
	})
	
	$('.send-transaction').on('click', function(){
	send_data = $('.form-transaction input[type=\'text\']');
	$.ajax({
		url: '/index.php?route=common/remarketing/sendMeasurementManual',
		type: 'post',
		data: send_data,
		dataType: 'json',
		beforeSend: function() {
		},
		complete: function() {
		},
		success: function(json) {
			if (json['error']) {
				$('.send-result').html(json['error']);
			}
			if (json['success']) {
				$('.send-result').html(json['success']);
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
        }
	});
});
</script>
<style>
.products .form-control {
	width: 200px; display:inline-block;
}
</style>
		  </div>
		  <div class="tab-pane" id="tab-ecommerce-ga4">
		   <legend><?php echo $text_ecommerce_ga4; ?> - (gtag.js)</legend>
			<div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/ga4/ecommerce" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_status" id="input-remarketing_ecommerce_ga4_status" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_id"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_id" id="input-remarketing_ecommerce_ga4_id" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_ga4_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_identifier"><?php echo $entry_ecommerce_ga4_identifier; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_identifier" value="<?php echo $remarketing_ecommerce_ga4_identifier; ?>" id="input-remarketing_ecommerce_ga4_identifier" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_selector"><?php echo $entry_ecommerce_selector; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_selector" value="<?php echo $remarketing_ecommerce_ga4_selector; ?>" id="input-remarketing_ecommerce_selector" class="form-control" />
               </div>
			</div>
           <legend><?php echo $text_ecommerce_ga4_measurement; ?> - Alpha!</legend>
		  <div class="help-link"><a href="https://developers.google.com/analytics/devguides/collection/protocol/ga4/reference/events" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_measurement_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_measurement_status" id="input-remarketing_ecommerce_ga4_measurement_status" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_measurement_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_measurement_log"><?php echo $entry_log; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_measurement_log" id="input-remarketing_ecommerce_ga4_measurement_log" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_measurement_log) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_measurement_id"><?php echo $text_identifier; ?> (пока принимается ТОЛЬКО НАЗВАНИЕ ТОВАРА, числовые идентификаторы Google отвергает в ID, настройка ни на что не влияет)</label>
            <div class="col-sm-10">
              <select name="remarketing_ecommerce_ga4_measurement_id" id="input-remarketing_ecommerce_ga4_measurement_id" class="form-control">
                <?php if ($remarketing_ecommerce_ga4_measurement_id == 'id') { ?>
                <option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_ecommerce_ga4_measurement_id == 'model')  { ?>
                <option value="id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_measurement_selector"><?php echo $entry_ecommerce_ga4_selector; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_measurement_selector" value="<?php echo $remarketing_ecommerce_ga4_measurement_selector; ?>" id="input-remarketing_ecommerce_measurement_selector" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_measurement_api_secret"><?php echo $entry_ecommerce_ga4_api_secret; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_measurement_api_secret" value="<?php echo $remarketing_ecommerce_ga4_measurement_api_secret; ?>" id="input-remarketing_ecommerce_ga4_measurement_api_secret" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_analytics_id"><?php echo $entry_ecommerce_ga4_analytics_id; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_ecommerce_ga4_analytics_id" value="<?php echo $remarketing_ecommerce_ga4_analytics_id; ?>" id="input-remarketing_ecommerce_ga4_analytics_id" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_send_status"><?php echo $entry_remarketing_ecommerce_ga4_send_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_ecommerce_ga4_send_status)) { ?>
                       <input type="checkbox" name="remarketing_ecommerce_ga4_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_ecommerce_ga4_send_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_ecommerce_ga4_refund_status"><?php echo $entry_remarketing_ecommerce_ga4_refund_status; ?></label>
               <div class="col-sm-10">
                 <div class="well well-sm" style="height: 150px; overflow: auto;">
                   <?php foreach ($order_statuses as $order_status) { ?>
                   <div class="checkbox">
                     <label>
                       <?php if (in_array($order_status['order_status_id'], $remarketing_ecommerce_ga4_refund_status)) { ?>
                       <input type="checkbox" name="remarketing_ecommerce_ga4_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
                       <?php echo $order_status['name']; ?>
                       <?php } else { ?>
                       <input type="checkbox" name="remarketing_ecommerce_ga4_refund_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
                       <?php echo $order_status['name']; ?>
                       <?php } ?>
                     </label>
                   </div>
                   <?php } ?>
                 </div>
               </div>
             </div>
		  </div>
		  <div class="tab-pane" id="tab-counters">
		   <legend><?php echo $text_counters; ?></legend>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_counter1"><?php echo $entry_counter1; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter1" rows="10" id="input-remarketing_counter1" class="form-control"><?php echo $remarketing_counter1; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_counter_bot"><?php echo $entry_counter_bot; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter_bot" rows="10" id="input-remarketing_counter_bot" class="form-control"><?php echo $remarketing_counter_bot; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_counter2"><?php echo $entry_counter2; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter2" rows="10" id="input-remarketing_counter2" class="form-control"><?php echo $remarketing_counter2; ?></textarea>
               </div>
		   </div>
		   <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_counter3"><?php echo $entry_counter3; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_counter3" rows="10" id="input-remarketing_counter3" class="form-control"><?php echo $remarketing_counter3; ?></textarea>
               </div>
		   </div>
		  </div>
		  <div class="tab-pane" id="tab-feed">
		   <legend><?php echo $text_feed; ?></legend>
		   <div class="help-link"><a href="https://support.google.com/merchants/answer/7052112?hl=ru" target="_blank"><?php echo $text_help_link; ?> Google</a></div>
		   <div class="help-link"><a href="https://www.facebook.com/business/help/125074381480892?id=725943027795860" target="_blank"><?php echo $text_help_link; ?> Facebook</a></div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_status" id="input-remarketing_feed_status" class="form-control">
                <?php if ($remarketing_feed_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div>
		  <div class="form-group">
		  <label class="control-label col-sm-2" for="input-remarketing_feed_currency"><?php echo $entry_remarketing_feed_currency; ?></label>
		  <div class="col-sm-10">
			<select name="remarketing_feed_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_feed_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
		  <label class="control-label col-sm-2" for="input-remarketing_feed_currency_base"><?php echo $entry_remarketing_feed_currency_base; ?></label>
		  <div class="col-sm-10">
			<select name="remarketing_feed_currency_base" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_feed_currency_base) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_identifier"><?php echo $text_identifier; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_identifier" id="input-remarketing_feed_identifier" class="form-control">
                <?php if ($remarketing_feed_identifier == 'product_id') { ?>
                <option value="product_id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
                <?php } elseif ($remarketing_feed_identifier == 'model')  { ?>
                <option value="product_id"><?php echo $text_id; ?></option>
                <option value="model" selected="selected"><?php echo $text_model; ?></option>
                <?php } else { ?>
				<option value="product_id" selected="selected"><?php echo $text_id; ?></option>
                <option value="model"><?php echo $text_model; ?></option>
				<?php } ?>
              </select>
            </div>
          </div> 
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_key"><?php echo $entry_remarketing_feed_key; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_key" value="<?php echo $remarketing_feed_key; ?>" id="input-remarketing_feed_key" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_remarketing_feed_links; ?></label>
               <div class="col-sm-10">
               		<b><?php echo $text_feed_merchant; ?></b> <a href="<?php echo $link_merchant; ?><?php echo $remarketing_feed_key ? '&key=' . $remarketing_feed_key : ''; ?>" target="_blank"><b><?php echo $link_merchant; ?><?php echo $remarketing_feed_key ? '&key=' . $remarketing_feed_key : ''; ?></b></a><br>
					<b><?php echo $text_feed_facebook; ?></b> <a href="<?php echo $link_facebook; ?><?php echo $remarketing_feed_key ? '&key=' . $remarketing_feed_key : ''; ?>" target="_blank"><b><?php echo $link_facebook; ?><?php echo $remarketing_feed_key ? '&key=' . $remarketing_feed_key : ''; ?></b></a><br><br>
					<b><?php echo $text_feed_help; ?></b>
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_condition"><?php echo $entry_remarketing_feed_condition; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_condition" value="<?php echo $remarketing_feed_condition; ?>" id="input-remarketing_feed_condition" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_gtin"><?php echo $entry_remarketing_feed_gtin; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_gtin" value="<?php echo $remarketing_feed_gtin; ?>" id="input-remarketing_feed_gtin" class="form-control" />
               </div>
			</div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_mpn"><?php echo $entry_remarketing_feed_mpn; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_mpn" value="<?php echo $remarketing_feed_mpn; ?>" id="input-remarketing_feed_mpn" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_tuning"><?php echo $entry_remarketing_feed_tuning; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_tuning" id="input-remarketing_feed_tuning" class="form-control">
                <?php if ($remarketing_feed_tuning) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
		  	<div class="form-group <?php if (!$remarketing_feed_tuning) echo 'hidden'; ?>">
             <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?>
			 <br>
			 <a href="http://www.google.com/basepages/producttype/taxonomy-with-ids.ru-RU.xls" target="_blank"><?php echo $text_category_google; ?></a><br><br>
			 <a href="https://support.google.com/merchants/answer/6324436?hl=ru" target="_blank">google_product_category HELP</a><br>
			 <a href="https://support.google.com/merchants/answer/6324406?hl=ru" target="_blank">product_type HELP</a><br>
			 <a href="https://support.google.com/merchants/answer/6324469?hl=ru" target="_blank">condition HELP</a><br>
			 <a href="https://support.google.com/google-ads/answer/6275295?hl=ru" target="_blank"> custom_label HELP</a>
			 </label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="max-height: 400px; overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($categories as $category) { ?>
                    <tr class="feed-category">
                      <td class="checkbox">
                        <label>
                          <?php if (in_array($category['category_id'], $remarketing_feed_category)) { ?>
                          <input type="checkbox" name="remarketing_feed_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                          <b><?php echo $category['name']; ?></b>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_feed_category[]" value="<?php echo $category['category_id']; ?>" />
                          <b><?php echo $category['name']; ?></b>
                          <?php } ?>
                        </label>
						<table class="table table-striped table-bordered">
							<tr>
								<td class="text-left gpc">google_product_category <input type="text" name="remarketing_feed_category_google_category[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_google_category[$category['category_id']]) ? $remarketing_feed_category_google_category[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left gpt">product_type <input type="text" name="remarketing_feed_category_product_type[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_product_type[$category['category_id']]) ? $remarketing_feed_category_product_type[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">condition <input type="text" name="remarketing_feed_category_condition[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_condition[$category['category_id']]) ? $remarketing_feed_category_condition[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">custom_label_0 <input type="text" name="remarketing_feed_category_custom_label_0[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_custom_label_0[$category['category_id']]) ? $remarketing_feed_category_custom_label_0[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">custom_label_1 <input type="text" name="remarketing_feed_category_custom_label_1[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_custom_label_1[$category['category_id']]) ? $remarketing_feed_category_custom_label_1[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">custom_label_2 <input type="text" name="remarketing_feed_category_custom_label_2[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_custom_label_2[$category['category_id']]) ? $remarketing_feed_category_custom_label_2[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">custom_label_3 <input type="text" name="remarketing_feed_category_custom_label_3[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_custom_label_3[$category['category_id']]) ? $remarketing_feed_category_custom_label_3[$category['category_id']] : ''); ?>" class="form-control"/></td>
								<td class="text-left">custom_label_4 <input type="text" name="remarketing_feed_category_custom_label_4[<?php echo $category['category_id']; ?>]" value="<?php echo (!empty($remarketing_feed_category_custom_label_4[$category['category_id']]) ? $remarketing_feed_category_custom_label_4[$category['category_id']] : ''); ?>" class="form-control"/></td>
							</tr>
						</table>
                      </td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a><br><br>
				  <a onclick="copyToGpc();"><?php echo $text_copy_to_category; ?></a><br>
				  <a onclick="copyToGpt();"><?php echo $text_copy_to_product_type; ?></a>
				  <script>
				  function copyToGpc() {
					  $('.feed-category').each(function(){
						  $(this).find('.gpc input').val($(this).find('.checkbox b').text());
					  })
				  }
				  function copyToGpt() {
					  $('.feed-category').each(function(){
						  $(this).find('.gpt input').val($(this).find('.checkbox b').text());
					  })
				  }
				  </script>
				  </div>
          </div>
		  <div class="form-group <?php if (!$remarketing_feed_tuning) echo 'hidden'; ?>">
             <label class="col-sm-2 control-label" for="input-manufacturer"><?php echo $entry_manufacturer; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="max-height: 400px; overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($manufacturers as $manufacturer) { ?>
                    <tr>
                      <td class="checkbox">
                        <label>
                          <?php if (in_array($manufacturer['manufacturer_id'], $remarketing_feed_manufacturer)) { ?>
                          <input type="checkbox" name="remarketing_feed_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" checked="checked" />
                          <?php echo $manufacturer['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="remarketing_feed_manufacturer[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
                          <?php echo $manufacturer['name']; ?>
                          <?php } ?>
                        </label>
                      </td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
          </div>
		  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-remarketing_feed_customer_group"><?php echo $entry_customer_group; ?></label>
				<div class="col-sm-10">
				<select name="remarketing_feed_customer_group" id="input-remarketing_feed_customer_group" class="form-control">
				<?php foreach ($customer_groups as $customer_group) { ?>
					<?php if ($customer_group['customer_group_id'] == $remarketing_feed_customer_group) { ?>
					<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
				<?php } ?>
				<?php } ?>
				</select>
			</div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_custom_sql"><?php echo $entry_remarketing_feed_custom_sql; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_custom_sql" value="<?php echo $remarketing_feed_custom_sql; ?>" id="input-remarketing_feed_custom_sql" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_special"><?php echo $entry_remarketing_feed_special; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_special" id="input-remarketing_feed_special" class="form-control">
                <?php if ($remarketing_feed_special) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_min_price"><?php echo $entry_remarketing_feed_min_price; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_min_price" value="<?php echo $remarketing_feed_min_price; ?>" id="input-remarketing_feed_min_price" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_max_price"><?php echo $entry_remarketing_feed_max_price; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_max_price" value="<?php echo $remarketing_feed_max_price; ?>" id="input-remarketing_feed_max_price" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_zero_quantity"><?php echo $entry_remarketing_feed_zero_quantity; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_zero_quantity" id="input-remarketing_feed_zero_quantity" class="form-control">
                <?php if ($remarketing_feed_zero_quantity) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_original_description"><?php echo $entry_remarketing_feed_original_description; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_original_description" id="input-remarketing_feed_original_description" class="form-control">
                <?php if ($remarketing_feed_original_description) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_ocstore_main"><?php echo $entry_remarketing_feed_ocstore_main; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_ocstore_main" id="input-remarketing_feed_ocstore_main" class="form-control">
                <?php if ($remarketing_feed_ocstore_main) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_last_category"><?php echo $entry_remarketing_feed_last_category; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_last_category" id="input-remarketing_feed_last_category" class="form-control">
                <?php if ($remarketing_feed_last_category) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_type_category"><?php echo $entry_remarketing_feed_type_category; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_type_category" id="input-remarketing_feed_type_category" class="form-control">
                <?php if ($remarketing_feed_type_category) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_multiplier"><?php echo $entry_remarketing_feed_multiplier; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_multiplier" value="<?php echo $remarketing_feed_multiplier; ?>" id="input-remarketing_feed_multiplier" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_original_image_status"><?php echo $entry_remarketing_feed_original_image_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_original_image_status" id="input-remarketing_feed_original_image_status" class="form-control">
                <?php if ($remarketing_feed_original_image_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_additional_images"><?php echo $entry_remarketing_feed_additional_images; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_feed_additional_images" id="input-remarketing_feed_additional_images" class="form-control">
                <?php if ($remarketing_feed_additional_images) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>  
              </select>
            </div> 
          </div> 
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_utm"><?php echo $entry_remarketing_feed_utm; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_utm" value="<?php echo $remarketing_feed_utm; ?>" id="input-remarketing_feed_multiplier" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_utm_facebook"><?php echo $entry_remarketing_feed_utm_facebook; ?></label>
               <div class="col-sm-10">
                  <input type="text" name="remarketing_feed_utm_facebook" value="<?php echo $remarketing_feed_utm_facebook; ?>" id="input-remarketing_feed_utm_facebook" class="form-control" />
               </div>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-remarketing_feed_description"><?php echo $entry_remarketing_feed_description; ?></label>
               <div class="col-sm-10">
				    <textarea name="remarketing_feed_description" rows="5" id="input-remarketing_feed_description" class="form-control"><?php echo $remarketing_feed_description; ?></textarea>
               </div>
			</div>
		  </div> 
		  <div class="tab-pane active" id="tab-diagnostics">
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_status" id="input-status" class="form-control">
                <?php if ($remarketing_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
            </div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-bot-status"><?php echo $entry_bot_status; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_bot_status" id="input-status" class="form-control">
                <?php if ($remarketing_bot_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		  <div class="form-group">
		  <label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?> - Google</label>
		  <div class="col-sm-10">
			<select name="remarketing_google_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_google_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		 <div class="form-group">
		  <label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?> - Facebook</label>
		  <div class="col-sm-10">
			<select name="remarketing_facebook_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_facebook_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		 <div class="form-group">
		  <label class="col-sm-2 control-label" for="input-currency"><?php echo $entry_currency; ?> - Ecommerce</label>
		  <div class="col-sm-10">
			<select name="remarketing_ecommerce_currency" class="form-control">
				<?php foreach ($currencies as $currency) { ?>
				<?php if ($currency['code'] == $remarketing_ecommerce_currency) { ?>
				<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		 </div>
		 </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-no-shipping"><?php echo $entry_no_shipping; ?></label>
            <div class="col-sm-10">
              <select name="remarketing_no_shipping" id="input-no-shipping" class="form-control">
                <?php if ($remarketing_no_shipping) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		   <legend><?php echo $text_version; ?>: <span class="version"><?php echo $version; ?></span><span class="version-update"></span></legend>
		   <legend><?php echo $text_forum_documentation; ?> <div class="help-link"><a href="https://opencartforum.com/files/file/7492-sp-seo-remarketing-all-in-one-pro-elektronnaya-torgovlya-google-ga4-i-yandeks-dinamicheskiy-remarketing-google-facebook-vk-mytarget-tovarnyy-fid-dlya-google-merchant-i-facebook-programma-google-otzyvy-esputnik-15x-2x-3x-free-install/?tab=tutorials" target="_blank"><?php echo $text_help_link; ?></a></div></legend>
		   <legend><?php echo $text_check_config; ?></legend>
		   <div>
           <div class="col-sm-12 config-summary"><?php echo $check_config; ?></div>
		   </div>
		   <legend><?php echo $text_check_install; ?></legend>
		   <div>
           <div class="col-sm-12"><?php echo $check_install; ?></div>
		   </div>
		  </div> 
		  <div class="tab-pane" id="tab-reporting">
		   <legend><?php echo $text_reporting; ?></legend>
		   <div class="utm-data">
		   <?php foreach ($order_utm_reporting as $utm => $values) { ?>
		   <legend><?php echo $utm; ?></legend>
		   <div class="utm-values">
		   <?php foreach($values as $value) { ?>
		   <?php echo $value['value'] . ': ' . $value['count'] . '<br>'; ?>
		   <?php } ?>
		   </div>
		   <?php } ?>
		   </div>
		   <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <tbody>
                <?php if ($order_reporting) { ?>
			  <thead>
                <tr>
                  <td class="text-left">Order ID</td>
                  <td class="text-left">Ecommerce</td>
                  <td class="text-left">Ecommerce GA4</td>
                  <td class="text-left">Facebook</td>
                  <td class="text-left">Esputnik</td>
                  <td class="text-left">Telegram</td>
                  <td class="text-left">Success Page</td>
                  <td class="text-left">Order Data</td>
                  <td class="text-left">UTM Data</td>
                  <td class="text-left">Date Added</td>
                </tr>
              </thead>
                <?php foreach ($order_reporting as $order) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $order['link'] ;?>" target="_blank"><?php echo $order['order_id']; ?></a></td>
                  <td class="text-left"><?php echo $order['ecommerce']; ?></td>
                  <td class="text-left"><?php echo $order['ecommerce_ga4']; ?></td>
                  <td class="text-left"><?php echo $order['facebook']; ?></td>
                  <td class="text-left"><?php echo $order['esputnik']; ?></td>
                  <td class="text-left"><?php echo $order['telegram']; ?></td>
                  <td class="text-left"><?php echo $order['success_page']; ?></td>
                  <td class="text-left" style="max-width:400px;"><a onclick="$('.show-data-<?php echo $order['order_id']; ?>').show();">Show Data</a><div class="show-data-<?php echo $order['order_id']; ?>" style="display:none;"><?php echo $order['order_data']; ?></div></td>
                  <td class="text-left">
				  <?php if ($order['utm']) { ?>
				  <?php foreach ($order['utm'] as $utm => $value) { ?>
				  <?php echo $utm . ': ' . $value; ?><br>
				  <?php } ?>
				  <?php } ?>
				  </td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                </tr>
                <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
		  </div>
		  <div class="tab-pane" id="tab-instruction">
		   <legend><?php echo $text_instruction; ?></legend>
		   <iframe src="https://mega.freelancer.od.ua/remarketing<?php echo !$ru ? '_en' : ''; ?>.html?version=<?php echo $version; ?>&domain=<?php echo $domain; ?>" style="top:0; left:0; bottom:0; right:0; width:100%; height:600px; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"></iframe>
		  </div>
		  <div class="tab-pane" id="tab-help">
		   <legend><?php echo $text_help; ?></legend>
		   <?php echo $text_credits; ?>
		  </div>
		  </div>
		  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$.ajax({ 
		type: 'post',
		url:  '<?php echo $check_version; ?>',
		data: {'version': '<?php echo $version; ?>'},
		dataType: 'text',
		success: function(response) { 
			if (response != '') {
				$('.version-update').html(response);
			}
		}
	});
})
</script>
<style>
.config-summary span {
	font-size:20px;
	color:#0043ff;
	font-weight:bold;
}
.version {
    color: green;
	font-weight:bold;
}
.summary-heading {
	font-size:20px;
	color:green;
	margin-bottom: 15px;
}
.enabled, .enabled:hover {
	background: #c7ffc7 !important;
    font-weight: bold;
}
.version-update {
	background: #c7ffc7 !important;
    font-weight: bold;
	margin-left:15px;
}
.diag, .diag:hover{
    background: #00b9ff !important;
    color: #fff !important;
}
legend {
	font-size:30px;
	margin-top:15px;
}
.help-link{
	font-size: 22px;
}
.help-link a{
	color: red;
}
.nav li a {
font-weight: bold;
}
.nav-pills > li.active > a.enabled, .nav-pills > li.active > a.enabled:hover, .nav-pills > li.active > a.enabled:focus {
color: red;
}
</style>
<?php echo $footer; ?>