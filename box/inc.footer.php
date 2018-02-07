<!-- scripts -->
 <link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/jquery-ui.css">
<script src="<?php echo $wwwroot_js; ?>/wysihtml5-0.3.0.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo $wwwroot_js; ?>/bootstrap.min.js"></script>
<script src="<?php echo $wwwroot_js; ?>/bootstrap-wysihtml5-0.0.2.js"></script>
<script src="<?php echo $wwwroot_js; ?>/bootstrap.datepicker.js"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.uniform.min.js"></script>
<script src="<?php echo $wwwroot_js; ?>/select2.min.js"></script>

<script src="<?php echo $wwwroot_js; ?>/jquery.flot.js"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.flot.stack.js"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.flot.resize.js"></script>
<script src="<?php echo $wwwroot_js; ?>/chart.js"></script>
<script src="<?php echo $wwwroot_js; ?>/theme.js"></script>

<script type="text/javascript">
$(function () {
    // select2 plugin for select elements
    $(".select2").select2({
        placeholder: " "
    });
});
</script>

<script>
$(function() {
	$('#product_search').autocomplete({ 
		source:'../ajax.php', 
		minLength:2,
		select: function( event, ui ) {
			var checkDiv = $('#' + ui.item.value);
			if (!checkDiv.length){
				//$("#selected_products").append('<input type="" name="" value="" /><div class="list" id="' + ui.item.value + '"><strong>' + ui.item.value + '</strong> ' + ui.item.label + '</div>');
				$("#selected_products").append('<label class="checkbox" id="' + ui.item.value +'"><input type="checkbox" name="promotion_items[]" value="'+ ui.item.value +'" checked>' + ui.item.label + ' (' + ui.item.value + ')' +'</label>');
			}
		}
	});
	
	$( "#product_search" ).on( "autocompletesearch", function( event, ui ) { $(".loading-indicator").show(); } );
	$( "#product_search" ).on( "autocompleteresponse", function( event, ui ) { $(".loading-indicator").hide(); } );
	
});
</script>