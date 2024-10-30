<?php 
wp_enqueue_style( 'admin-style' );
wp_enqueue_script( 'jquery-ui-tabs' );
wp_enqueue_script( 'admin-script' );

$general 		= get_option( 'imcm-setting-general' );
$troubleshoot 	= get_option( 'imcm-setting-troubleshoot' );
?>
<div class="wrap">
	<div id="imcm-settings">
		<div id="imcm-setting-tabs">
			<div class="imcm-setting-tabs-panel">
				<ul>
				    <li class=""><a href="#general"><span class="dashicons dashicons-admin-generic"></span> <?php _e( 'General', 'checkout-manager' ); ?></a></li>
				    <li><a href="#troubleshoot"><span class="dashicons dashicons-admin-tools"></span> <?php _e( 'Troubleshoot', 'checkout-manager' ); ?></a></li>
				  </ul>
			</div>

		  	<div class="imcm-setting-tabs-content">
				<div class="imcm-setting-heading">
					<h4><?php _e( 'Settings', 'checkout-manager' ); ?></h4>
					<button class="imcm-setting-button imcm-setting-save-button"><?php _e( 'Save Change', 'checkout-manager' ); ?></button>
				</div>
		  		<div id="general">
		  			<div class="imcm-setting-content">
						<form action="" id="imcm-setting-form" class="imcm-setting">
							<?php wp_nonce_field( 'checkout-manager' ); ?>
							<input type="hidden" name="action" value="imcm-setting">
							<input type="hidden" name="option_name" value="imcm-setting-general">
							<input type="hidden" name="page_load" value="yes">
							<p class="imcm-setting-form-group">
								<label class="imcm-setting-form-label" for="fields-editor"><?php _e( 'Checkout Fields', 'checkout-manager' ); ?></label>
								<label class="switch imcm-setting-form-field">
									<input id="fields-editor" type='checkbox' name='fields-editor' <?php checked( isset( $general['fields-editor'] ) ); ?> value='1'>
    
								  	<span class="slider"></span>
								</label>
							</p>
						</form>
						<div class="cx-response-message" style="display: none;"></div>
					</div>
				</div>
				<div id="troubleshoot" style="display: none;">
					<div class="imcm-setting-content">
						<form action="" id="imcm-setting-form" class="imcm-setting">
							<?php wp_nonce_field( 'checkout-manager' ); ?>
							<input type="hidden" name="action" value="imcm-setting">
							<input type="hidden" name="option_name" value="imcm-setting-troubleshoot">
							<input type="hidden" name="page_load" value="">
							<p class="imcm-setting-form-group">
								<label class="imcm-setting-form-label" for="enable-debug"><?php _e( 'Enable Debug', 'checkout-manager' ); ?></label>
								<label class="switch imcm-setting-form-field">
									<input id="enable-debug" type='checkbox' name='enable-debug' <?php checked( isset( $troubleshoot['enable-debug'] ) ); ?> value='1'>
								  	<span class="slider"></span>
								</label>
								<span class="cx-desc"></span>
								<span class="cx-desc"><?php _e( 'Enable this if you face any CSS or JS related issues.', 'checkout-manager' ); ?></span>
							</p>
						</form>
						<div class="cx-response-message" style="display: none;"></div>
					</div>
				</div>
				<div class="imcm-setting-footer">
					<button class="imcm-setting-button imcm-setting-save-button"><?php _e( 'Save Change', 'checkout-manager' ); ?></button>
				</div>
		  	</div>
		</div>
	</div>
</div>