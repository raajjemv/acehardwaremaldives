<?php session_start(); ?>
<?php include_once('inc.config.php'); ?>
<?php include_once('inc.auth.php'); ?>
<?php include_once('inc.sanitize.php'); ?>
<?php include_once('inc.functions.php'); ?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/index.css" type="text/css" media="screen" />  
</head>
<body>
<?php
$main_page = 'dashboard';
$sub_page  = '';
?>
<?php
$color_array = array("#69D2E7", "#A7DBD8","#4ECDC4", "#F38630","#a7b5c5");
$data_daybyday = statistics_groups_daybyday();
?>
<?php include('inc.topnav.php'); ?>
<?php include('inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	 <?php include('dashboard.main.stats.php'); ?>
	 	 
	 	 <div id="pad-wrapper">
			<div class="row-fluid chart">
				<h4>Quick Statistics
					<div id="chart_stats" class="btn-group pull-right">
						<button id="stat_visits" class="glow left active">Visits</button>
						<button id="stat_visitors" class="glow middle active">Visitors</button>
						<button id="stat_product" class="glow middle active">Product Views</button>
						<button id="stat_category" class="glow middle active">Category Views</button>
						<button id="stat_quickview" class="glow middle active">Quick View</button>
						<button class="glow right">Average Execution Time <?php echo statistics_avgLoadingTime(); ?> secs</button>
					</div>
				</h4>
				<div class="span12"><div id="statsChart" class="statsChart_month"></div></div>
			</div><!-- /row-fluid chart -->
			
			<div class="row-fluid stat-charts">
				<div class="span3">
					<table class="table table-hover">
						<thead><td colspan="2">Most Popular Product</td></thead>
						<tr><td colspan="2" style="text-align: center;"><canvas id="mostPopularProduct" width="150" height="150"></canvas></td></tr>
						<?php $get_popular_products = statistics_popular('products');?>
						<?php for ($i = 0; $i < count($get_popular_products); $i++) { ?>
						<tr>
							<td>
								<?php echo getProductDetails($get_popular_products[$i]['identifier'], "name"); ?><br>
								<span style="color: #999; font-size: 11px;">SKU <?php echo $get_popular_products[$i]['identifier']; ?></span>
							</td>
							<td><span class="bubble" style="background-color: <?php echo $color_array[$i]; ?>;"><?php echo $get_popular_products[$i]['COUNT(identifier)']; ?></span></td>
						</tr>
						<?php } ?>
					</table>
					
				</div>
				<div class="span3">
					<table class="table table-hover">
						<thead><td colspan="2">Most Popular Categories</td></thead>
						<tr><td colspan="2" style="text-align: center;"><canvas id="mostPopularCategory" width="150" height="150"></canvas></td></tr>
						<?php $get_popular_category = statistics_popular('category');?>
						<?php for ($i = 0; $i < count($get_popular_category); $i++) { ?>
						<tr>
							<td>
								<?php $category = explode(",", $get_popular_category[$i]['identifier']); ?>
								<?php echo getCategoryDetailsByAlias($category[0], "name"); ?>
								<?php echo ($category[1]) ? '&nbsp;&nbsp;<span class="icon-angle-right"></span>&nbsp;&nbsp;' . getCategoryDetailsByAlias($category[1], "name") : ""; ?>
								<?php echo ($category[2]) ? '&nbsp;&nbsp;<span class="icon-angle-right"></span>&nbsp;&nbsp;' . getCategoryDetailsByAlias($category[2], "name") : ""; ?>
							</td>
							<td><span class="bubble" style="background-color: <?php echo $color_array[$i]; ?>;"><?php echo $get_popular_category[$i]['COUNT(identifier)']; ?></span></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="span6">
					<table class="table ">
						<thead>
							<td colspan="5">
								Visits Per Day 
								<?php
								$month_array = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
								?>
								<?php for ($i = 1; $i <= date('m'); $i++) { ?>
								<a href="index.php?month=<?php echo $i; ?>" class="<?php echo ($i == $_GET['month']) ? 'bubble' : 'bubble_gray' ?> pull-right"><?php echo $month_array[$i]; ?></a>
								<?php } ?>
							</td>
						</thead>
						<tr><td colspan="5"><div id="statsChart" class="statsChart_daybyday" style="height: 102px; margin-bottom: 15px;"></div></td></tr>
						<?php
						$limit_activity = ($_GET['limit']) ? sanitize($_GET['limit']) : 7;
						$sql = "SELECT * FROM activity WHERE activity_title != '' AND module != 'login' ORDER BY datetime DESC LIMIT $limit_activity";
						$result = mysql_query($sql);
						?>
						<thead><td colspan="5">Recent Activity</td></thead>
						<?php while($row = mysql_fetch_assoc($result)){ ?>
						<tr>
							<td><?php echo time_elapsed_string($row['datetime']); ?></td>
							<td><?php echo getUserDetails($row['user_id'], "username"); ?></td>
							<td style="color: #999;"><?php echo $row['activity']; ?></td>
							<td><?php echo $row['activity_title']; ?></td>
							<td><?php echo $row['module']; ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			
	 	 </div>
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('inc.footer.php'); ?>

<script type="text/javascript">
var data_popular_product = [
	<?php for ($i = 0; $i < count($get_popular_products); $i++) { ?>
	{
		value: <?php echo $get_popular_products[$i]['COUNT(identifier)']; ?>,
		color:"<?php echo $color_array[$i]; ?>"
	},
	<?php } ?>
];

var data_popular_category = [
	<?php for ($i = 0; $i < count($get_popular_category); $i++) { ?>
	{
		value: <?php echo $get_popular_category[$i]['COUNT(identifier)']; ?>,
		color:"<?php echo $color_array[$i]; ?>"
	},
	<?php } ?>
]
var ctx = document.getElementById("mostPopularProduct").getContext("2d");
var myNewChart = new Chart(ctx).Doughnut(data_popular_product);

var ctx = document.getElementById("mostPopularCategory").getContext("2d");
var myNewChart = new Chart(ctx).Doughnut(data_popular_category);

</script>
<script type="text/javascript">
var visits	= [<?php for ($i = 1; $i <= 12; $i++) { ?>[<?php echo $i; ?>, <?php echo statistics_monthbymonth($i); ?>]<?php if($i != 12){ echo ','; } ?><?php } ?>];
var visitors= [<?php for ($i = 1; $i <= 12; $i++) { ?>[<?php echo $i; ?>, <?php echo statistics_groups_monthbymonth($i, 'ip_address'); ?>]<?php if($i != 12){ echo ','; } ?><?php } ?>];
var product_view = [<?php for ($i = 1; $i <= 12; $i++) { ?>[<?php echo $i; ?>, <?php echo statistics_groups_monthbymonth($i, 'section', 'products'); ?>]<?php if($i != 12){ echo ','; } ?><?php } ?>];
var category_view = [<?php for ($i = 1; $i <= 12; $i++) { ?>[<?php echo $i; ?>, <?php echo statistics_groups_monthbymonth($i, 'section', 'category'); ?>]<?php if($i != 12){ echo ','; } ?><?php } ?>];
var quick_view = [<?php for ($i = 1; $i <= 12; $i++) { ?>[<?php echo $i; ?>, <?php echo statistics_groups_monthbymonth($i, 'section', 'quick-view'); ?>]<?php if($i != 12){ echo ','; } ?><?php } ?>];

var data_hits_per_day = [<?php for ($i = 1; $i <= date('t'); $i++) { ?>[<?php echo $i; ?>, <?php echo ($data_daybyday[$i]['Hits']) ? $data_daybyday[$i]['Hits'] : "0"; ?>]<?php if($i != 31){ echo ','; } ?><?php } ?>];

var options = {
	series: {
			lines: { show: true,
			lineWidth: 1,
			fill: true, 
			fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.05 } ] 
		}
	},
	points: { show: true, 
			  lineWidth: 2,
			  radius: 3
			},
		shadowSize: 0,
		stack: false
	},
	grid: { hoverable: true, 
		clickable: true, 
		tickColor: "#f9f9f9",
		borderWidth: 0
	},
	legend: {
		// show: false
		labelBoxBorderColor: "#fff"
	},  
	//colors: ["#30a0eb", "#a7b5c5"],
	colors: ["#69D2E7", "#A7DBD8", "#4ECDC4", "#F38630", "#a7b5c5"],
	xaxis: {
		ticks: [[1, "JAN"], [2, "FEB"], [3, "MAR"], [4,"APR"], [5,"MAY"], [6,"JUN"], [7,"JUL"], [8,"AUG"], [9,"SEP"], [10,"OCT"], [11,"NOV"], [12,"DEC"]],
		font: {
			size: 11,
			family: "Open Sans, Arial",
			variant: "small-caps",
			color: "#697695"
		}
	},
	yaxis: {
		ticks:3, 
		tickDecimals: 0,
		font: {size:12, color: "#9da3a9"}
	}
};

var options2 = {
	series: {
			lines: { show: true,
			lineWidth: 1,
			fill: true, 
			fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.05 } ] 
		}
	},
	points: { show: true, 
			  lineWidth: 2,
			  radius: 3
			},
		shadowSize: 0,
		stack: false
	},
	grid: { hoverable: false, 
		clickable: true, 
		tickColor: "#FFF",
		borderWidth: 0
	},
	legend: {
		show: false,
		labelBoxBorderColor: "#fff"
	},  
	//colors: ["#30a0eb", "#a7b5c5"],
	colors: ["#69D2E7", "#A7DBD8", "#4ECDC4", "#F38630", "#a7b5c5"],
	xaxis: {
		ticks: [	
					<?php for ($i = 0; $i <= date('t'); $i++) { ?>
					[<?php echo $i; ?>, "<?php echo $i; ?>"],
					<?php } ?>
				],
		font: {
			size: 10,
			family: "Open Sans, Arial",
			variant: "small-caps",
			color: "#697695"
		}
	},
	yaxis: {
		ticks:3, 
		tickDecimals: 0,
		font: {size:10, color: "#9da3a9"}
	}
};
///  statsChart_month statsChart_daybyday
var plot = $.plot($(".statsChart_month"),
	[ 	{ data: visits, label: "Visits"},
		{ data: visitors, label: "Unique Visitors" },
		{ data: product_view, label: "Product" },
		{ data: category_view, label: "Category" },
		{ data: quick_view, label: "Quick View" }
	], options
);

var plot2 = $.plot($(".statsChart_daybyday"),
	[ 	
		{ data: data_hits_per_day, label: "Visits"},
	], options2
);


function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css( {
        position: 'absolute',
        display: 'none',
        top: y - 30,
        left: x - 50,
        color: "#fff",
        padding: '2px 5px',
        'border-radius': '6px',
        'background-color': '#000',
        opacity: 0.80
    }).appendTo("body").fadeIn(200);
}
            
var previousPoint = null;
$("#statsChart").bind("plothover", function (event, pos, item) {
    if (item) {
        if (previousPoint != item.dataIndex) {
            previousPoint = item.dataIndex;

            $("#tooltip").remove();
            var x = item.datapoint[0].toFixed(0),
                y = item.datapoint[1].toFixed(0);

            var month = item.series.xaxis.ticks[item.dataIndex].label;

            //showTooltip(item.pageX, item.pageY,
            //            item.series.label + " of " + month + ": " + y);
            showTooltip(item.pageX, item.pageY, item.series.label + ": " + y);
        }
    }
    else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});

$("#chart_stats button").click(function() {
	$(this).toggleClass("active"); //Hide all tab content
	//stat_visits stat_visitors stat_product stat_category stat_quickview | visits visitors product_view category_view quick_view
	
	if( $("#stat_visits").hasClass("active") ){ stat_visits = visits }else{ stat_visits = 0; } 
	if( $("#stat_visitors").hasClass("active") ){ stat_visitors = visitors }else{ stat_visitors = 0; }
	if( $("#stat_product").hasClass("active") ){ stat_product = product_view }else{ stat_product = 0; } 
	if( $("#stat_category").hasClass("active") ){ stat_category = category_view }else{ stat_category = 0; } 
	if( $("#stat_quickview").hasClass("active") ){ stat_quickview = quick_view }else{ stat_quickview = 0; } 
	
	var plot = $.plot($(".statsChart_month"),
		[ 	
			{ data: stat_visits, label: "Visits"},
			{ data: stat_visitors, label: "Unique Visitors" },
			{ data: stat_product, label: "Product" },
			{ data: stat_category, label: "Category" },
			{ data: stat_quickview, label: "Quick View" }
		], 
		options
	);
	
});

</script>
</body>
</html>