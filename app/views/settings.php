<section id="settingsPage">

<div class="wrap">

	<div id="icon-options-general" class="icon32 icon32-posts-post"><br></div>
	<h2>Settings</h2>
	<br/>
	
	<div class="metabox-holder">
		<div class="postbox-container">
			<div class="postbox">
				<h3 class="hndle">Account</h3>
				<div class="inside">
				<ul>
					<li>
						<span>Check out your profile on notelr.com</span>
						<a href="http://notelr.com/<?php echo $this->username; ?>" class="button-primary" target="_blank">Profile</a>
					</li>
					<li>
						<a href="http://notelr.com/stats/date" class="button-primary" target="_blank">Stats</a>
					</li>
					<div class="divider"></div>
					<li>
						<span>You are logged in as <strong><?php echo $this->name; ?></strong></span>
						<a href="admin.php?page=notelr-logout" class="button-secondary">Logout</a>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</div>
	
	<div style="display:block; clear:both;"></div>
	
	<div class="metabox-holder">
		<div class="postbox-container">
			<div class="postbox">
				<h3 class="hndle">PayPal email</h3>
				<div class="inside">
					<form class="notelr-paypal-form">
				    <input required class="notelr-paypal-email" type="email" value="<?php if(!empty($this->paypalEmail)) echo $this->paypalEmail; ?>"/>
				        <input type="submit" class="button-secondary" value="Update"/>
				    </form>
				    <span class="inst">Please provide your registered Paypal email to receive payments from Notelr. We'll only use this email to send you money.</span>
				</div>
	
			</div>
		</div>
	</div>

</div>
</section>