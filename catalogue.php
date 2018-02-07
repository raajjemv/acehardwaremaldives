<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300' rel='stylesheet' type='text/css'>
<style>
@import url(http://weloveiconfonts.com/api/?family=entypo);
[class*="entypo-"]:before {
  font-family: 'entypo', sans-serif;
}
body{
	font-family: 'Open Sans', sans-serif;
	background-color: #efefef;
	margin: 0px;;
}
.header{
	color: #FFF;
	font-weight: 300;
	padding:10px 15px;
	position: fixed;
	bottom: 0px;
	left: 0px;
	width: 100%;
	background-color: #333;
}
	.header .logo{
		width: 29%;
		color: #F43E43;
		display: inline-block;
	}
	.header .navi{
		width: 69%;
		color: #F43E43;
		display: inline-block;
	}
	.header .logo span{
		font-weight: 600;
		display: inline-block;
		margin-left: 15px;
		color: rgba(255, 255, 255, .85);
	}
	.header .navi{
		text-align: right;
	}
	.header .navi a{
		font-size: 12px;
		text-decoration: none;
		display: inline-block;
		background-color: #EEE;
		padding-right: 10px;
		color: #888;
	}
	.header .navi a:before{
		display: inline-block;
		margin-right: 10px;
		color: #FFF;
		padding: 10px;
		background-color: #C82C34;
	}
.frame{
	margin: 0px;
	padding: 0px;
	border: 0px solid #EEE;
	width: 100%;
	height: 100%;
	min-height: 100%;
}
</style>
<div class="header">
	<div class="logo">ACE HARDWARE <span>MAKE A CATALOGUE</span></div>
	<div class="navi">
		<a href="http://acehardwaremaldives.com/cart/" class="entypo-basket">Add / Remove Products</a>
		<a href="catalogue_pdf.php" target="pdf" class="entypo-arrows-ccw">Refresh</a>
		<a href="catalogue_pdf.php?download=true" target="pdf" class="entypo-download">Download Catalogue</a>
		<a href="http://acehardwaremaldives.com/" class="entypo-back">Go Back</a>
	</div>
</div>
<iframe class="frame" name="pdf" src="catalogue_pdf.php" frameborder="0"></iframe>