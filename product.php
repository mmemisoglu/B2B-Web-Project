<?php	require_once 'inc/header.php';	?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

<!-- HEADER-AREA START -->
<?php	require_once 'inc/menu.php';	?>
<!-- HEADER-AREA END -->
<!-- Mobile-menu start -->
<?php	require_once 'inc/mobilemenu.php';	?>
<!-- Mobile-menu end -->
<?php

	$sef = get('productsef');
	if(!$sef){
		go(site);
	}
	$product = $db->prepare("SELECT * FROM urunler 
	WHERE urundurum=:d AND urunsef=:se");
	$product->execute([
		':d'  => 1,
		':se' => $sef
	]);
	if($product->rowCount()){
		$row = $product->fetch(PDO::FETCH_OBJ);
	}else{
		go(site);
	}
	//Yorumlar için
	$comment = $db->prepare("SELECT urun_yorumlar.id,urun_yorumlar.yorumbayi,urun_yorumlar.yorumurun,urun_yorumlar.yorumisim,urun_yorumlar.yorumicerik,urun_yorumlar.yorumdurum,urun_yorumlar.yorumip,urun_yorumlar.yorumtarih,bayiler.bayilogo FROM urun_yorumlar INNER JOIN bayiler ON yorumbayi = bayikodu
	WHERE yorumurun = :u AND yorumdurum = :d
	ORDER BY yorumtarih DESC");
	$comment->execute([
		':u' => $row->urunkodu,
		':d' => 1
	]);	

	

?>
<!-- HEADING-BANNER START -->
<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site;?>/upload/product/<?php echo $row->urunbanner;?>) no-repeat scroll center center / cover;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-banner">
					<div class="heading-banner-title">
						<h2><?php echo $row->urunbaslik;?></h2>
					</div>
					<div class="breadcumbs pb-15">
						<ul>
							<li><a href="<?php echo site; ?>">ANA SAYFA</a></li>
							<li><a href="<?php echo site; ?>">ÜRÜN</a></li>
							<li><a href="#"><?php echo $row->urunbaslik;?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- HEADING-BANNER END -->
<!-- PRODUCT-AREA START --> 
<div class="product-area single-pro-area pt-80 pb-80 product-style-2">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">		
				<div class="row shop-list single-pro-info">
					<!-- Single-product start -->
					<div class="col-lg-12">
						<div class="single-product clearfix">
							<!-- Single-pro-slider Big-photo start -->
							<div class="single-pro-slider single-big-photo view-lightbox slider-for">
								<?php
								$pimage = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak FROM urun_resimler 
								WHERE resimurun=:u");
								$pimage->execute([
									':u' =>$row->urunkodu
								]);
								if($pimage->rowCount()){
									foreach($pimage as $pim){
								?>
							
								<div class="<?php echo $pim['kapak'] == 1 ? 'active' : null;?>">
									<img src="<?php echo site."/upload/product/".$pim['resimdosya'];?>" alt="<?php echo $row->urunbaslik;?>" width="370" height="450" />
									<a class="view-full-screen" href="<?php echo site."/upload/product/".$pim['resimdosya'];?>"  data-lightbox="roadtrip" data-title="<?php echo $row->urunbaslik;?>">
										<i class="zmdi zmdi-zoom-in"></i>
									</a>
								</div>
								<?php
								}}
								?>
							</div>	
							
							
							<!-- Single-pro-slider Big-photo end -->										
							<div class="product-info">
							<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik;?></h3>
								<div class="fix mb-20">
									<span class="pro-price"><?php echo $row->urunfiyat;?> ₺ | <?php echo $row->urunkodu; ?></span>
								</div>
								<div class="product-description">
									<p><?php echo strip_tags(mb_substr($row->urunicerik,0,1000,'utf-8'));?></p>
								</div>
								
								<!-- Size end -->
								<div class="clearfix">
									
									<form action="" method="POST" onsubmit="return false;" id="addcartform">
									
										<input type="number" value="1" name="qty" class="cart-plus-minus-box" style="width: 33.3333%;  border: medium none;
										box-shadow: none;
										color: #999;
										height: 40px;
										margin-bottom: 25px;
										padding: 0 20px;
										transition: all 0.5s ease 0s;
										outline: none;">
										<input type="hidden" value="<?php echo $row->urunkodu;?>" name="pcode"  style="width: 33.3333%;">
									
									<div class="product-action clearfix">
										<button type="submit" onclick="addcart();" id="addcartt" class="btn btn-default" style="font-size: 18px;">
										<i class="zmdi zmdi-shopping-cart-plus" style="font-size: 18px;"></i> Sepete Ekle</button>
									</div>
									</form>
									<?php
									
									?>
								</div>
								<!-- Single-pro-slider Small-photo start -->
								<div class="single-pro-slider single-sml-photo slider-nav">
									<?php
									$pimageslider = $db->prepare("SELECT resimurun,resimdosya,resimdurum,kapak FROM urun_resimler 
									WHERE resimurun=:u");
									$pimageslider->execute([
										':u' =>$row->urunkodu
									]);
									if($pimageslider->rowCount()){
										foreach($pimageslider as $pimg){
									?>
									<div>
										<img width="70" height="83" src="<?php echo site."/upload/product/".$pimg['resimdosya'];?>" alt="<?php echo $row->urunbaslik;?>" />
									</div>
									<?php
									}}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- Single-product end -->
				</div>
				<!-- single-product-tab start -->
				<div class="single-pro-tab">
					<div class="row">
						<div class="col-lg-3 col-md-4">
							<div class="single-pro-tab-menu">
								<!-- Nav tabs -->
								<ul class="nav d-block">
									<li><a href="#description" data-bs-toggle="tab">Ürün Açıklaması</a></li>
									<li><a href="#information" data-bs-toggle="tab">Ürün Özellikleri</a></li>
									<li><a href="#comment" data-bs-toggle="tab">Ürün Yorumları (<?php echo $comment->rowCount(); ?>)</a></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-9 col-md-8">
							<!-- Tab panes -->
						
							
							<div class="tab-content">
								<div class="tab-pane" id="description">
									<div class="pro-tab-info pro-description">
										<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik;?> Açıklaması</h3>
										<?php echo $row->urunicerik;?>
									</div>
								</div>
								
						<div class="tab-pane " id="reviews">
							<div class="tab-pane" id="description">
								
									
								</div>
								</div>
								<div class="tab-pane active" id="tag">
									<div class="pro-tab-info pro-information">
										<h3 class="tab-title title-border mb-30">Ana açıklama</h3>
										<p>Loraaaaem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at est bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
									</div>											
								</div>
								<div class="tab-pane" id="information">
									<div class="pro-tab-info pro-information">
										<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik;?> Özellikleri</h3>
										
										<div class="table-responsive">
											<table class="table table-hover">
													
												<?php
												
												$pskill = $db->prepare("SELECT * FROM urun_ozellikler 
												WHERE ozellikurun=:u AND ozellikdurum=:d");
												$pskill->execute([
													':u' => $row->urunkodu,
													':d' => 1
												]);
												if($pskill->rowCount()){
													foreach($pskill as $prow){
													?>
														<tr>
															<th><?php echo $prow['ozellikbaslik'];?> :</th>
															<td><?php echo $prow['ozellikicerik'];?></td>
														</tr>
													<?php
													}
												}else{
													alert('Ürün özelliği eklenmemiştir.','danger');
												}

												?>
	
											</table>
										</div>

									</div>		
																		
								</div>
								
								
								<div class="tab-pane " id="comment">
									<div class="pro-tab-info pro-reviews">
										<div class="customer-review mb-60">
											<h3 class="tab-title title-border mb-30"><?php echo $row->urunbaslik;?> | Ürün Yorumları (<?php echo $comment->rowCount() ?>)</h3>
											<ul class="product-comments clearfix">
												<?php
													
													if($comment->rowCount()){
														foreach($comment as $com){
															
															?>

																<li class="mb-30">
																	<div class="pro-reviewer">
																		<img src="<?php echo site."upload/customer/".$com['bayilogo'];?>" width="90px" height="100px" alt="" />
																	</div>
																	<div class="pro-reviewer-comment">
																		<div class="fix">
																			<div class="floatleft mbl-center">
																				<h5 class="text-uppercase mb-0"><strong><?php echo $com["yorumisim"];?></strong></h5>
																				<p class="reply-date"><?php echo dt($com["yorumtarih"]);?></p>
																			</div>
																		</div>
																		<p class="mb-0"><?php echo $com["yorumicerik"];?></p>
																	</div>
																</li>

															<?php
															
														}
													}else{
														alert('Bu ürüne yorum yapılmamış, ilk yorumu sen yap.','warning' );

													}
												?>
											</ul>
										</div>
										<?php 
										if(@$_SESSION['login'] == @sha1(md5(IP().$bcode))){
											
										?>
										<div class="leave-review">
												<h3 class="tab-title title-border mb-30">Yorum Yap</h3>
											
												<div class="reply-box">
													<form action="#" id="commentform" onsubmit="return false">
														
														<div class="row">
															<div class="col-md-12">
																<textarea class="custom-textarea" name="commentcontent" placeholder="Yorumunuzu yazınız..." ></textarea>
																<input type="hidden" name="productcode" value="<?php echo $row->urunkodu?>">
																<button type="submit" class="button-one submit-button mt-20" onclick="newcomment();" id="newcommentt" >Yorumu yayınla</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>	
										<?php
										}else{
											alert("Yorum yapabilmekk için lütfen <a href='".site."/login.php'>GİRİŞ YAPINIZ.</a>","danger");
										}
										?>	
									</div>
								
								
							</div>
															
						</div>
					</div>
				</div>
				<!-- single-product-tab end -->
			</div>
			
		</div>
	</div>
</div>
<!-- PRODUCT-AREA END -->
<!-- FOOTER START -->
<?php	require_once 'inc/footer.php';	?>
