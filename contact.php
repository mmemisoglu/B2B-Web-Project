			<?php	require_once 'inc/header.php';	?>
			<!-- WRAPPER START -->
			<div class="wrapper bg-dark-white">

			<!-- HEADER-AREA START -->
			<?php	require_once 'inc/menu.php';	?>
			<!-- HEADER-AREA END -->
			<!-- Mobile-menu start -->
			<?php	require_once 'inc/mobilemenu.php';	?>
			<!-- Mobile-menu end -->
			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>İLETİŞİM</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site ?>">ANA SAYFA</a></li>
										<li><a href="<?php echo site ?>">İLETİŞİM</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- HEADING-BANNER END -->
			<!-- contact-us-AREA START -->
			<div class="contact-us-area  pt-80 pb-80">
				<div class="container">	
					<div class="contact-us customer-login bg-white">
						<div class="row">
							<div class="col-lg-4 col-md-5">
								<div class="contact-details">
									<h4 class="title-1 title-border text-uppercase mb-30">İLETİŞİM BİLGİLERİ</h4>
									<ul>
										<li>
											<i class="zmdi zmdi-pin"></i>
											<span><?php echo $arow->adres;?></span>
										</li>
										<li>
											<i class="zmdi zmdi-phone"></i>
											<span>Telefon: <?php echo $arow->tel;?></span>
											<span>Fax: <?php echo $arow->fax;?></span>
										</li>
										<li>
											<i class="zmdi zmdi-email"></i>
											<span>E-Posta: <?php echo $arow->fax;?></span>
										</li>
									</ul>
								</div>
								<div class="send-message mt-60">
									<form method="POST" id="contactform" action="" onsubmit="return false;">
										<h4 class="title-1 title-border text-uppercase mb-30">İLETİŞİM FORMU</h4>
										<input type="text" name="name" placeholder="Adınız Soyadınız" style="background: #f6f6f6 none repeat scroll 0 0;"/>
										<input type="text" name="email" placeholder="E-Posta hesabınız" style="background: #f6f6f6 none repeat scroll 0 0;"/>
										<input type="text" name="subject" placeholder="Konu" style="background: #f6f6f6 none repeat scroll 0 0;"/>
										<textarea class="custom-textarea" name="message" placeholder="Mesajınız"></textarea>
										<button class="button-one submit-button mt-20" onclick="sendmessage()" id="sendmessages" type="submit">GÖNDER</button>
										<p class="form-message"></p>
									</form>
								</div>
							</div>
							<div class="col-lg-8 col-md-7 mt-xs-30">
								<div class="map-area">
									<?php echo $arow->map;	?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ABOUT-US-AREA END -->
			<!-- FOOTER START -->
			<?php	require_once 'inc/footer.php';	?>