<?php 
if(get_page_info($_GET['page_id'], "title") != ""){ 
?>
<div class="container main-container">

	<div class="page-info">
		<h1><?php echo get_page_info($_GET['page_id'], 'title'); ?></h1>
		
		<div class="row">
			<div class="col-xs-9">
				<div class="page-contents" style="padding-bottom: 20px;">
					<h2><?php echo get_page_info($_GET['page_id'], 'subtitle'); ?></h2>
					<?php if($_GET['page_id'] == "store-locations"){ ?>
					<div id="gmap-menu" class="ace-locations"></div>
					<?php }else{ ?>
						<?php
						$page_image_file = 'core/images/pages/' . get_page_info($_GET['page_id'], 'alias') . '.jpg';
						if(file_exists($page_image_file)){
						?>
						<img src="<?php echo $wwwroot_img; ?>/pages/<?php echo get_page_info($_GET['page_id'], 'alias'); ?>.jpg" alt="" />
						<?php } ?>
					<?php } ?>
					<div class="padding">
						<p><?php echo get_page_info($_GET['page_id'], 'body'); ?></p>
					</div>
				</div><!-- /page-contents -->
			</div><!-- /col-xs-6 -->
			
			<div class="col-xs-3">
				<div class="page-contents">
					<div class="submenu">
						<a href="<?php echo $wwwroot; ?>">Home</a>
						<?php
						$submenu = get_page_info($_GET['page_id'], 'submenu');
						if($submenu){ 
						$submenu_items = explode(', ', $submenu);
						?>
						<?php for ($i = 0; $i < count($submenu_items); $i++) { ?>
						<a href="<?php echo $wwwroot; ?>/ace/<?php echo $submenu_items[$i]; ?>/" <?php echo ($_GET['page_id'] == $submenu_items[$i]) ? 'class="active"' : ''; ?>><?php echo get_page_info($submenu_items[$i], "title"); ?></a>
						<?php } }?>
					</div>
				</div><!-- /page-contents -->
				
				<div class="feedback-form">
					<h2>Feedback</h2>
					<?php if(!$success_register){ ?>
					<p>Use the form below to send us your comments. We read all feedback carefully.</p>
					<?php } ?>
					<?php if($invalid_captcha) { echo $invalid_captcha; } ?>
					<?php if($error_register) { echo $error_register; } ?>
					<?php if($success_register) { echo $success_register; } ?>
					<?php if(!$success_register){ ?>
					<form method="post" action="<?php echo $wwwroot; ?>/ace/contact-us/">
						<input type="text" name="name" id="name" value="<?php echo $_POST['name']; ?>" placeholder="Name" />
						<input type="text" name="email" id="email" value="<?php echo $_POST['email']; ?>" placeholder="Email Address" />
						<textarea name="message" placeholder="Comments" rows="4"><?php echo $_POST['message']; ?></textarea>
						<img src="<?php echo $wwwroot; ?>/recaptcha/captcha.php" id="captcha" width="100" style="border: 1px solid #EEE; margin-left: 10px;">
						<input type="text" name="captcha" placeholder="Type the word in above image">
						<input type="submit" name="send_feedback" value="Submit Feedback" />
					</form>
					<?php } ?>
				</div><!-- /feedback-form -->
				
			</div><!-- /col-xs-3 -->
		</div><!-- /row -->
	</div><!-- /product-info -->
</div>
<?php 
}else{
	include('404.tpl');
}
?>