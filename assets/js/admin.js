;(function ($){
	$('#imcm-setting-tabs').tabs();

	$(document).on("click",".imcm-setting-save-button",function(e) {
		e.preventDefault();
		$('.ui-tabs-panel[aria-hidden="false"] .imcm-setting, .imcm-checkout-fields-panel .imcm-setting').submit();
	});
	
	$('.imcm-setting').submit(function(e) {
		e.preventDefault();

		$('.cx-response-message').hide();

		var $form = $(this);
		var $data = $form.serialize();
		$.ajax({
			url: IMCM.ajaxurl,
			data: $data,
			type: 'POST',
			dataType: 'JSON',
			success: function(resp) {
				$('.cx-response-message').html( resp.message ).show();
				console.log(resp);
				if ( resp.page_load == 'yes' ) {
					setTimeout(function() {
						location.reload()
					}, 2000);
				}
				else {
					setTimeout(function() {
						$('.cx-response-message').hide();
					}, 2000);
				}
			},
			error: function( $xhr, $sts, $err ) {
				console.log($err);
			}
		});
	});

	$(document).on("click",".imcm-setting-reset-button",function(e) {
		e.preventDefault();

		$.ajax({
			url: IMCM.ajaxurl,
			data: { 'action':'reset-checkout-fields', 'nonce' : IMCM.nonce },
			type: 'POST',
			dataType: 'JSON',
			success: function(resp){
				$('.cx-response-message').html( resp.message ).show();

				if ( resp.status == 1 ) {
					setTimeout(function() {
						location.reload()
					}, 2000);
				}
			}
		});
	});

	$('.woocm-tab-btn').on('click', function(e) {
		e.preventDefault();
		var $tab = $(this).attr('data-tab');
		$('.woocm-tab-content').hide();
		$('.woocm-tab-btn').removeClass('active');
		$(this).addClass('active');
		$('#'+$tab).show();
	});

	$('.woocm-item-wrap.woocm-accordion').hide();
	$(document).on('click','.woocm-list-wrap li.woocm-list-item h4',function() {
		var name = $(this).attr('data-name');
	    $('.woocm-item-wrap.woocm-accordion').slideUp();
	    $('.woocm-item-wrap.woocm-accordion' +'.'+name).stop().slideToggle();
	});

	$('.woocm-item-wrap .woocm-item-field-options').hide();
	$(document).on("change",".woocm-item-wrap .woocm-item-field-type select",function(e){
		if ( this.value == 'select' || this.value == 'radio' ) {
			$('.woocm-item-wrap .woocm-item-field-options').slideDown();
		}
		else {
			$('.woocm-item-wrap .woocm-item-field-options').slideUp();
		}
	});
	
	$('.woocm-modal-toggle').on('click', function(e) {
		e.preventDefault();

		var type 		= $(this).attr('data-type');
		var id 			= Math.random().toString(36).substring(7);

		$('.woocm-input-field.woocm-id').val('new_field_' + id)
		
		// console.log(type)
		$('.woocm-modal').toggleClass('is-visible');
	});

	$(document).on('click','.woocm-clone-item-btn-panel .woocm-clone-item',function( e ) {
		e.preventDefault();
		var type 		= $(this).attr('data-type');
		// var id 		= Math.random().toString(36).substring(7);
		var field_name 	= $('.woocm-input-field.woocm-id').val();
		var clone_field = $("#woocm-clone-"+ type +"-item").clone();
		var rep_name 	= clone_field.html().replace(/%attrname%/g, 'name');
		var new_field 	= rep_name.replace(/%%%/g, field_name);

		$("#woocm-"+ type +"-list-wrap").append( new_field );
		
		$('.woocm-input-field.woocm-id').val(field_name)
		$('.woocm-modal').removeClass('is-visible');

	});

	$(document).on('keyup','.woocm-item-input-field.woocm-label',function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		$(this).attr('value', value);
		var parent 	= $(this).closest('.woocm-list-item');
		$('.woocm-item-heading', parent).html(value);
	});

	$(document).on('change','.woocm-input-field.woocm-id',function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		var oldid 	= $(this).data('oldid');
		var parent 	= $(this).closest('.woocm-accordion');
		var heading = $('.woocm-item-heading');

		console.log(heading.data('name'))

		if ( oldid ) {
			var $replace = $(this).attr('data-oldid');
		}
		else {
			var $replace = 'new_field';
		}

		heading.data('name', heading.data('name').replace($replace,value));

		$('input, select, textarea', parent).each(function($i) {
			$(this).attr('data-oldid', value);
			$(this).attr('name', $(this).attr('name').replace($replace,value));
		});

	});

	$(document).on('keyup','.woocm-input-field.woocm-label',function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		$(this).attr('value', value);
		var parent 	= $(this).closest('.woocm-list-item');
		$('.woocm-item-heading', parent).html(value);
	});

	$(document).on('keyup','.woocm-input-field.woocm-placeholder',function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		$(this).attr('value', value);
	});

	$(document).on('change','.woocm-clone-item-panel .woocm-input-field.woocm-type', function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		console.log(value)

		$('.woocm-clone-item-panel .woocm-input-field.woocm-type > option[selected="selected"]').removeAttr('selected');

		// $('.woocm-input-field.woocm-type option').each(function() {
		//     $(this).removeAttr('selected');
		// });

		$(this).find('option[value='+ value +']').attr('selected',true);
	});

	$(document).on('change','.woocm-clone-item-panel .woocm-input-field.woocm-class', function(e) {
		e.preventDefault();
		var value 	= $(this).val();
		console.log(value)

		$('.woocm-clone-item-panel .woocm-input-field.woocm-class > option[selected="selected"]').removeAttr('selected');

		// $('.woocm-input-field.woocm-type option').each(function() {
		//     $(this).removeAttr('selected');
		// });

		$(this).find('option[value='+ value +']').attr('selected',true);
	});

	$(document).on("click",".woocm-action-panel .woocm-item-remove", function(e){
		e.preventDefault()
		var parent 	= $(this).closest('.woocm-action-panel').parent();
		parent.remove();
		// alert('fffff')
	});

	if ( localStorage.getItem("woocm-active-tab") ) {
		$('a.ui-tabs-anchor[href="'+ localStorage.getItem("woocm-active-tab") +'"]').click();
	}

	$("a.ui-tabs-anchor").click(function (e) {
        e.preventDefault();

        var target = $(this).attr("href");
        localStorage.setItem("woocm-active-tab", target);
    });

	$('.woocm-sortable').sortable({axis: 'y'});

	$('.imcm-style-color').minicolors({

	  control: 'hue',

	  defaultValue: '',

	  format: 'rgb',

	  showSpeed: 100,
	  hideSpeed: 100,

	  inline: false,

	  letterCase: 'lowercase',

	  opacity: false,

	  position: 'bottom left',

	  theme: 'default',
	  swatches: [ 'swatches', 'opacity']
	  
	});

	$('#imcm-display-position-form').submit(function(e) {
		e.preventDefault();
	});

})(jQuery);