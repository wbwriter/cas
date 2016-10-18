<?php

$lang = $this->lang;
?>
<footer>
	<div class="container">
		<div class="row">


			<div class="widgets">

				<div class="col-md-3">
					<div class="fwidget">

						<h4><?php echo $lang['CONTACT_US']; ?></h4>

						<p><?php echo $lang['WEBSITE_NAME']; ?></p>
						<hr />
						<i class="fa fa-home"></i> &nbsp; <?php echo $lang['CAS_HOMETOWN']; ?>
						<hr />
						<i class="fa fa-phone"></i> &nbsp;<?php echo $lang['CAS_PHONE']; ?>
						<hr />
						<i class="fa fa-envelope-o"></i> &nbsp; <a href="mailto:#"><?php echo $lang['CAS_MAIL']; ?></a>
						<hr />
						<div class="social">
							<a href="#" class="bblue"><i class="fa fa-facebook"></i></a>
							<a href="#" class="borange"><i class="fa fa-google-plus"></i></a>
							<a href="#" class="blightblue"><i class="fa fa-twitter"></i></a>
							<a href="#" class="bviolet"><i class="fa fa-linkedin"></i></a>
							<a href="#" class="bred"><i class="fa fa-pinterest"></i></a>
							<a href="#" class="borange"><i class="fa fa-rss"></i></a>
						</div>

					</div>
				</div>

				<div class="col-md-3">
					<div class="fwidget">
						<h4><?php echo $lang['PAGES']; ?></h4>
						<ul>
							<li><a href="home"><?php echo $lang['HOME']; ?></a></li>
							<li><a href="login"><?php echo $lang['LOGIN']; ?></a></li>
							<li><a href="proximite"><?php echo $lang['PROXIMITY_MENU_BUTTON']; ?></a></li>
							<li><a href="sorties"><?php echo $lang['EXCURSIONS_CALENDAR']; ?></a></li>
							<li><a href="contact"><?php echo $lang['CONTACT_US']; ?></a></li>
							<li><a href="<?php echo URL_DIR;?>/home">Home</a></li>
							<li><a href="<?php echo URL_DIR;?>/login">Login</a></li>
							<li><a href="<?php echo URL_DIR;?>/proximite">A proximité</a></li>
							<li><a href="<?php echo URL_DIR;?>/sorties">Sorties - Calendrier</a></li>
							<li><a href="<?php echo URL_DIR;?>/contact">Contact</a></li>
						</ul>
					</div>
				</div>

				<div class="col-md-3">
					<div class="fwidget">

						<h4><?php echo $lang['NEWSLETTER']; ?></h4>
						<p><?php echo $lang['SUBSCRIBE_NEWSLETTER']; ?></p>
						<p></p>

						<form class="form-inline" role="form" method="post" onsubmit="subscribe(); return false;">
							<div class="input-group">
								<input type="text" class="form-control" id="subscribe" placeholder="Subscribe...">
								<span class="input-group-btn">
<<<<<<< HEAD
					<button type="button" id="button_form" class="btn btn-danger">Subscribe</button>
=======
					<button type="submit" class="btn btn-danger"><?php echo $lang['SUBSCRIBE_BUTTON']; ?></button>
>>>>>>> origin/master
				</span>
							</div>
						</form>
						<div id="newsletter_success" class="alert alert-success" style="display: none">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Success! </strong>You will receive our newsletter at <span id="newsletter_success_msg"></span>
						</div>

						<div id="newsletter_duplicate" class="alert alert-info" style="display: none">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Info ! </strong><span id="newsletter_duplicate_msg"></span> is already subscribed.
						</div>

						<div id="newsletter_error" class="alert alert-danger" style="display: none">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error ! </strong><span id="newsletter_error_msg"></span> is not a valid address.
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="fwidget">
						<h4><?php echo $lang['BECOME_MEMBER']; ?></h4>
						<p>
                            <?php echo $lang['FOR_MEMBERSHIP_CLICK_LINK']; ?>
							<a href="<?php echo URL_DIR;?>/login"><?php echo $lang['CLICK_HERE']; ?></a>
						</p>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="copy">
					<p>Copyright &copy; <a href="#">CASMONTANA</a></p>
				</div>
			</div>

		</div>
		<div class="clearfix"></div>
	</div>
</footer>
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

		$('#button_form').click( function()
		{
			subscribe();
		});

	});
</script>
<script src="<?php echo URL_DIR;?>/js/custom.js"></script>

<!-- This page JS -->

</body>
</html>
<?php

$_SESSION['msg']="";
?>