<script src="<?php echo $wwwroot_js; ?>/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $wwwroot_js; ?>/bootstrap.min.js"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.cycle2.min.js"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.mCustomScrollbar.js" type="text/javascript"></script>
<script src="<?php echo $wwwroot_js; ?>/bootstrap-spinedit.js" type="text/javascript"></script>
<script src="<?php echo $wwwroot_js; ?>/jquery.stickyscroll.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps/api/js?v=3.13&amp;sensor=false&amp;libraries=geometry&amp;1343675513"></script>
<script src="<?php echo $wwwroot_js; ?>/maplace.js"></script>
<script>

$(function() {
	$('#ace_main_search').autocomplete({ 
		source:'<?php echo $wwwroot; ?>/ajax.php', 
		minLength:2,
		select: function( event, ui ) {
			var checkDiv = $('#' + ui.item.value);
			if (!checkDiv.length){
				//$("#selected_products").append('<input type="" name="" value="" /><div class="list" id="' + ui.item.value + '"><strong>' + ui.item.value + '</strong> ' + ui.item.label + '</div>');
				//$("#ace_main_search").append('<label class="checkbox" id="' + ui.item.value +'"><input type="checkbox" name="promotion_items[]" value="'+ ui.item.value +'" checked>' + ui.item.label + ' (' + ui.item.value + ')' +'</label>');
				$( "#product_search_form" ).submit();
			}
		}
	});
	
	//$( "#ace_main_search" ).on( "autocompletesearch", function( event, ui ) { $(".loading-indicator").show(); } );
	//$( "#ace_main_search" ).on( "autocompleteresponse", function( event, ui ) { $(".loading-indicator").hide(); } );
	
});

jQuery.fn.extend({
  slideRightShow: function() {
    return this.each(function() {
        $(this).show('slide', {direction: 'right'}, 300);
    });
  },
  slideLeftHide: function() {
    return this.each(function() {
      $(this).hide('slide', {direction: 'left'}, 300);
    });
  },
  slideRightHide: function() {
    return this.each(function() {
      $(this).hide('slide', {direction: 'right'}, 300);
    });
  },
  slideLeftShow: function() {
    return this.each(function() {
      $(this).show('slide', {direction: 'left'}, 300);
    });
  }
});
</script>
<script type="text/javascript">

$(document).ready(function() {
	//$('#cart-navi').stickyScroll({ container: '#cart-items' });
});

/* 
$('.cycle-slideshow').on( 'cycle-before', function( event, opts ) {
	$('#alt-caption').fadeOut();
});
$('.cycle-slideshow').on( 'cycle-after', function( event, opts ) {
	$('#alt-caption').fadeIn();
});
*/
	
$('.aSpinEdit').spinedit({
	minimum: 1,
	maximum: 50,
	step: 1
});

$(".top-category a").click(function(event) {
	getID 	= $(this).attr("data-id");
	getAlias= $(this).attr("data-alias");
	// toggle active for menu
	$(".top-category a").removeClass("active");
	$(this).addClass("active");
	// toggle view for submenu
	if($(".sub-top-category").is(":visible")){
	$('.sub-top-category').slideLeftHide();
	}
	$('.sub-sub-category').hide();
	$('#' + getAlias).slideLeftShow();
	
	$(".category-container").mCustomScrollbar("destroy");
	$('#' + getAlias + " .category-container").mCustomScrollbar({ scrollInertia: 300 });
	
	$('.banner .slider').css("opacity", "0.1");
	$('.cycle-slideshow').cycle('pause');
	event.preventDefault();
});

function hideTips(event) {  
    var saveAlt = $(this).attr('alt');
    var saveTitle = $(this).attr('title');
    if (event.type == 'mouseenter') {
        $(this).attr('title','');
        $(this).attr('alt','');
    } else {
        if (event.type == 'mouseleave'){
            $(this).attr('alt',saveAlt);
            $(this).attr('title',saveTitle);
        }
   }
}

$(document).ready(function(){
 	// $(".cycle-slideshow img").live("hover", hideTips);
});

$(".sub-top-category a.entypo-cancel").click(function(event) {
	$('.sub-top-category').slideLeftHide();
	$('.sub-sub-category').hide();
	$('.banner .slider').css("opacity", "1");
	$(".top-category a").removeClass("active");
	$('.cycle-slideshow').cycle('resume');
	event.preventDefault();
});

$(".banner .slider").click(function() {
	if($(".sub-top-category").is(":visible")){
		$('.sub-top-category').slideLeftHide();
		$('.sub-sub-category').hide();
		$('.banner .slider').css("opacity", "1");
		$(".top-category a").removeClass("active");
		$('.cycle-slideshow').cycle('resume');
	}
});

$(".sub-sub-category a.entypo-cancel").click(function(event) {
	$('.sub-sub-category').slideLeftHide();
	$(".sub-top-category a").removeClass("active");
	event.preventDefault();
});

$(".sub-top-category .category-container a").click(function(event) {
	getID 			= $(this).attr("data-id");
	getName 		= $(this).attr("data-name");
	getParentAlias 	= $(this).attr("data-parent-alias");
	getAlias 		= $(this).attr("data-alias");
	
	make_cat_url = "<?php echo $wwwroot; ?>/store/" + getParentAlias + "," + getAlias + "/";
	console.log(make_cat_url);
	
	if(!$(this).hasClass("shopall")){
		
		$(".sub-sub-category .title span").html(getName);
		// toggle active for menu
		$(".sub-top-category a").removeClass("active");
		$(this).addClass("active");
		// toggle view for submenu
		if($(".sub-sub-category").is(":visible")){
		$('.sub-sub-category').slideLeftHide();
		}
		//$("#quick-view-bg").fadeIn();
		$('.sub-sub-category').slideLeftShow();
		$('.sub-sub-category .category-container').empty();
		//
		$(".sub-sub-category .category-container").append('<a href="' + make_cat_url + '" class="shopall">Shop All ' + getName +'</a><a href="#" class="sub-menu-loading">Loading...</a>');
		setTimeout(function(){
			$.get('<?php echo $wwwroot; ?>/ajax.php?request=subcategory&category_id=' + getID, function(data) {
				var json = $.parseJSON(data);
				console.log(data);console.log(getAlias);
				// category-container
				for (var i in json)
				{
					make_sub_cat_url = "<?php echo $wwwroot; ?>/store/" + getParentAlias + "," + getAlias + "," + json[i].alias + "/";
					html = '<a href="' + make_sub_cat_url +'" class="entypo-right-open-mini">';
					html += json[i].name;
					html += '</a>';
					$(".sub-sub-category .category-container").append(html);
				}
				$(".sub-menu-loading").hide();
				//$("#quick-view-bg").fadeOut();
				$(".sub-sub-category .category-container").mCustomScrollbar({ scrollInertia: 300 });
			});
		},300);
		event.preventDefault();
	}
	
});

$(".add-to-cart").click(function(event) {
	event.preventDefault();
	getProductID  = $(this).attr("data-product-id");
	getProductQty = $("input[data-product-id=" + getProductID + "]").val();
	$("#quick-view-bg").fadeIn();
	//console.log(getProductQty);
	$.get('<?php echo $wwwroot; ?>/ajax.php?action=add&product_qty='+ getProductQty +'&product_id=' + getProductID, function(data) {
		$("#alert-add-to-cart").fadeIn();
		console.log(data);
		setTimeout(function() { $(".alert-add-to-cart").fadeOut(); $(".quick-view-bg").fadeOut(); }, 1000);
		updateCartCount();
	});
});

<?php if($_SESSION['SESS_CUS_ID']){ ?>
$(".add-to-wishlist").click(function(event) {
	event.preventDefault();
	getProductID  = $(this).attr("data-product-id");
	
	$("#quick-view-bg").fadeIn();
	//console.log(getProductQty);
	//http://localhost:8888/acehardware/ajax.php?request=wish-list&product_id=8255796
	$.get('<?php echo $wwwroot; ?>/ajax.php?request=wish-list&product_id=' + getProductID, function(data) {
		$("#alert-add-to-wishlist").fadeIn();
		console.log(data);
		setTimeout(function() { 
			$(".alert-add-to-wishlist").fadeOut(); 
			$(".quick-view-bg").fadeOut(); 
		}, 1000);
		//updateCartCount();
	});
});

$(".wishlist-remove-item").click(function(event) {
	event.preventDefault();
	//console.log(getProductQty);
	getProductID  = $(this).attr("data-product-id");
	console.log(getProductID);
	$.get('<?php echo $wwwroot; ?>/ajax.php?request=wish-list-remove&product_id=' + getProductID, function(data) {
		$(".table-cart tbody tr[data-product-id=" + getProductID +"]").hide();
		console.log(data);
//		if(data == 0){
//			$(".table-cart tbody").html('<tr><td colspan="4"><div class="alert-cart-empty"><span class="entypo-basket"></span><strong>YOUR CART IS CURRENTLY EMPTY.</strong> You have not added any items in your shopping cart</div></td></tr>');
//		}
//		$(".cart-alert-success").fadeIn();
//		$(".cart-alert-success span").html("<strong>Cart Updated!</strong> Item no."+ getProductID +" removed from your cart.");
//		setTimeout(function() { $(".cart-alert-success").fadeOut(); }, 3000);
//		updateCartCount();
	});
});

$("#change_password").click(function(event) { 
	if($(".password-controller-fields").is(":visible")){
		$(".password-controller-fields").slideUp();
		$(this).val("Change Password");
		$(".password-controller-fields input").attr("disabled", true);
		$(".password-controller-fields input").val("");
	}else{
		$(".password-controller-fields").slideDown();
		$(this).val("Cancel Password Change");
		$(".password-controller-fields input").attr("disabled", false);
		$(".password-controller-fields input").val("");
	}
});
<?php } ?>

updateCartCount();

function updateCartCount() {
	$.get('<?php echo $wwwroot; ?>/ajax.php?request=getCartCount', function(data) {
		//console.log(data);
		$('#cart_count').html(data);
	});
}

$(".show-quick-view").click(function(event) {
	event.preventDefault();
	getProductID  = $(this).attr("data-product-id");
	
	$("#quick-view-bg").fadeIn();
	
	$.get('<?php echo $wwwroot; ?>/ajax.php?request=quick-view&product_id=' + getProductID, function(data) {
		
		$("#quick-view").fadeIn();
		var json = $.parseJSON(data);
		//console.log(json); 
		$("#quick-view h1").html(json[0].name);
		$("#quick-view .sku").html("SKU " + json[0].product_id);
		$("#quick-view .description").html(json[0].description);
		//
		$("#quick-view .readmore").attr("href", "<?php echo $wwwroot; ?>/product/quick-view/" + json[0].product_id + "/");
		//
		$("#quick-view .aSpinEdit").attr("data-product-id", json[0].product_id);
		$("#quick-view .add-to-cart").attr("data-product-id", json[0].product_id);
		$("#quick-view .add-to-wishlist").attr("data-product-id", json[0].product_id);
		$("#quick-view .thumb-image").attr("src", "<?php echo $wwwroot_img; ?>/products/" + json[0].product_id + "/thumb.jpg");
		//json[i].name;  
	});
});

$(".quick-view-close, .quick-view-bg").click(function(event) {
	
	$("#quick-view-bg").fadeOut();
	$("#quick-view").fadeOut();
	event.preventDefault();
	//$(".alert-add-to-cart").fadeOut();
});


$(".empty-cart").click(function(event) {
	event.preventDefault();
	//console.log(getProductQty);
	$.get('<?php echo $wwwroot; ?>/ajax.php?action=empty&product_id=1', function(data) {
		//console.log(data);
		$(".table-cart tbody").html('<tr><td colspan="4"><div class="alert-cart-empty"><span class="entypo-basket"></span><strong>YOUR CART IS CURRENTLY EMPTY.</strong> You have not added any items in your shopping cart</div></td></tr>');
		$(".cart-alert-success").fadeIn();
		$(".cart-alert-success span").html("<strong>Cart Updated!</strong> Your cart is currently empty.");
		setTimeout(function() { $(".cart-alert-success").fadeOut(); }, 3000);
		
		updateCartCount();
	});
});

$(".cart-remove-item").click(function(event) {
	event.preventDefault();
	//console.log(getProductQty);
	getProductID  = $(this).attr("data-product-id");
	$.get('<?php echo $wwwroot; ?>/ajax.php?action=remove&product_id=' + getProductID, function(data) {
		console.log(data);
		$(".table-cart tbody tr[data-product-id=" + getProductID +"]").hide();
		if(data == 0){
			$(".table-cart tbody").html('<tr><td colspan="4"><div class="alert-cart-empty"><span class="entypo-basket"></span><strong>YOUR CART IS CURRENTLY EMPTY.</strong> You have not added any items in your shopping cart</div></td></tr>');
		}
		$(".cart-alert-success").fadeIn();
		$(".cart-alert-success span").html("<strong>Cart Updated!</strong> Item no."+ getProductID +" removed from your cart.");
		setTimeout(function() { $(".cart-alert-success").fadeOut(); }, 3000);
		updateCartCount();
	});
});

$('.cart-item-qty').on('change',function () {
	getProductID   = $(this).attr("data-product-id");
	getProductQty  = $(this).val();
	console.log(getProductID);

	$.get('<?php echo $wwwroot; ?>/ajax.php?action=update&product_id=' + getProductID + '&product_qty=' + getProductQty, function(data) {
		if(getProductQty == 0){
			$(".table-cart tbody tr[data-product-id=" + getProductID +"]").hide();
		}
		$(".cart-alert-success").fadeIn();
		$(".cart-alert-success span").html("<strong>Cart Updated!</strong> Item no."+ getProductID +" quanity updated.");
		setTimeout(function() { $(".cart-alert-success").fadeOut(); }, 3000);
		
		updateCartCount();
	});
});

$(".accordion h3.title_<?php echo $grand_category; ?>").addClass("active");
$(".accordion .sub_<?php echo $grand_category; ?>").slideDown();

$(".accordion h3").click(function() {
	$(".accordion h3").removeClass("active"); //Remove any "active" class
	$(this).addClass("active"); //Add "active" class to selected tab
	$(".accordion .subcategory").slideUp(); //Hide all tab content

	var activeTab = $(this).attr("data-alias"); //Find the href attribute value to identify the active tab + content
	if($(".sub_" + activeTab).is(":visible")){
		$(".sub_" + activeTab).slideUp(); //Fade in the active ID content
		$(".accordion h3").removeClass("active")
	}else{
		$(".sub_" + activeTab).slideDown();
	}
	return false;
});

$("#accordion-nav .redhotbuy").addClass("active"); 
$("#home-products-red").show(); //Show first tab content

//On Click Event
$("#accordion-nav a").click(function(event) {
	activeTab = "#" + $(this).attr("data-id");
	
	$("#accordion-nav a").removeClass("active"); //Remove any "active" class
	$(this).addClass("active"); //Add "active" class to selected tab
	$(".accordion-container").hide(); //Hide all tab content

	$(activeTab).fadeIn(); //Fade in the active ID content
	event.preventDefault();
});
 
//$('#ace_main_search').keydown(function() {
//	var keyword = $('#ace_main_search').val();
//	var len = keyword.length;
//	if(len > 1){
//		$("#ace_main_search_spinner").fadeIn();
//		$("#ace_main_search_results").html("<ul></ul>");
//		$.get('<?php echo $wwwroot; ?>/ajax.php?request=quick-search&keyword=' + keyword, function(data) {
//			var json = $.parseJSON(data);
//			
//			for (var i in json)
//			{
//				make_url = "<?php echo $wwwroot; ?>/product/search/" + json[i].product_id + "/";
//				html =  '<li><a href="'+ make_url +'">';
//				html += '<strong>' + json[i].name + '</strong> SKU' + json[i].product_id;
//				html += '</a></li>';
//				$("#ace_main_search_results ul").append(html);
//			}
//			
//			$("#ace_main_search_results").slideDown();
//			$("#ace_main_search_spinner").fadeOut();
//		});
//	}else{
//		$("#ace_main_search_spinner").fadeOut();
//		$("#ace_main_search_results").slideUp();
//	}
//});
//
//$('#ace_main_search').focusout(function() {
//	$("#ace_main_search_spinner").fadeOut();
//	$("#ace_main_search_results").slideUp();
//});

var store_locations = [
	{
        lat: 4.1753402, lon: 73.5048208,
        title: 'Ace Hardware & Home Centre 1', 
        html:  '<strong>Ace Hardware & Home Centre</strong><br>M.Sosunmaage<br>Alhivilaa Magu, 20292 Male, Maldives<br>sales@acemaldives.com.mv',
        icon: '<?php echo $wwwroot_img; ?>/marker.png',
        zoom: 19,
        draggable: false,
        animation: google.maps.Animation.DROP
	},
	{
        lat: 4.1745402, lon: 73.5172711,
        title: 'Ace Hardware & Home Centre 2', 
       html:  '<strong>Ace Hardware & Home Centre</strong><br>H.Merry Rose<br>Filigus Hingun, 20006 Male, Maldives<br>sales2@acemaldives.com.mv',
        icon: '<?php echo $wwwroot_img; ?>/marker.png',
        zoom: 19,
        draggable: false,
        animation: google.maps.Animation.DROP
	},
]; 

var maplace2 = new Maplace({
	locations: store_locations,
	map_div: '#gmap-menu',
	controls_type: 'list',
	controls_on_map: true,
	draggable: false,
//	directions_panel: '#route',
//	type: 'directions',
	styles: {
			'Light': [{
				stylers: [
						{ hue: "#00ffe6" },
						{ saturation: -20 }
				]
			}, {
				featureType: "road",
				elementType: "geometry",
				stylers: [
						{ lightness: 100 },
						{ visibility: "simplified" }
				]
			}, {
				featureType: "road",
				elementType: "labels",
				stylers: [
						{ visibility: "off" }
				]
			}],
			'Night': [{
				featureType: 'all',
				stylers: [
					{ invert_lightness: 'true' }
				]
			}],
			'Greyscale': [{              
				featureType: 'all',
				stylers: [
					{ saturation: -100 },
					{ gamma: 0.50 },
					{ lightness: 50 },
				]
			}]
		}
}).Load();

</script>



