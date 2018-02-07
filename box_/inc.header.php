<title><?php echo $default_seo_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- bootstrap -->
<link href="<?php echo $wwwroot_css; ?>/bootstrap/bootstrap.css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

<!-- global styles -->
<link rel="stylesheet" type="text/css" href="<?php echo $wwwroot_css; ?>/layout.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $wwwroot_css; ?>/elements.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $wwwroot_css; ?>/icons.css" />

<!-- libraries -->
<link href="<?php echo $wwwroot_css; ?>/lib/bootstrap-wysihtml5.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/lib/uniform.default.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/lib/select2.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $wwwroot_css; ?>/lib/font-awesome.css" type="text/css" rel="stylesheet" />

<!-- open sans font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

<!-- lato font -->
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
*{
	text-decoration: none!important;
}
.selected_products{
	
}
	.selected_products label{
		position: relative;
		margin-right: 10px;
		padding: 10px!important;
		overflow: hidden;
		width:96%!important;
		border: 1px solid #EEE;
	}
		.selected_products label input{
			margin-right: 5px;
		}
		.selected_products label .icon-remove{
			color: #FFF;
			display: inline-block;
			text-align: center;
			font-size: 12px;
			width: 20px;
			height: 20px;
			line-height: 20px;
			background-color: #C82C34;
			-webkit-border-radius: 20px;
					border-radius: 20px;
		}
.view-sub-categories{
	cursor:pointer;
}

.small{
	
}
	.small td{
		font-size: 12px;
		padding: 4px 8px;
		
	}
		.small td:first-child{
			border-top: none;
		}
	.small td .icon-circle{
		font-size: 5px;
	}
	.small td .icon-sort-down{
		margin-top: -5px;
	}
.stat-charts{
	margin-top: 25px;
}
	.stat-charts table{
		margin-left: 15px;
	}
.bubble{
	color: #FFF;
	font-size: 10px;
	width: 24px;
	height: 24px;
	line-height: 24px;
	text-align: center;
	display: inline-block;
	background-color: #F47771;
	-webkit-border-radius: 24px;
			border-radius: 24px;
}
	.small td .bubble{
		background-color: #8199A6;
	}
	.bubble_gray{
		margin:0px 5px;
		color: #FFF;
		font-size: 10px;
		width: 24px;
		height: 24px;
		line-height: 24px;
		text-align: center;
		display: inline-block;
		background-color: #485B65;
		-webkit-border-radius: 24px;
				border-radius: 24px;
	}
		.bubble_gray:hover{
			color: #FFF;
			background-color: #F47771;
		}
.loading-indicator{
	display: none;
}
	.navbar-inverse .loading-indicator i {
		color: #FFF;
	}
	.navbar-inverse .nav > li.loading-indicator > a:hover{
		background: none!important;
	}
.rotate{
	-webkit-animation:	spin 1.5s linear infinite;
	-moz-animation:		spin 1.5s linear infinite;
	animation:			spin 1.5s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style>