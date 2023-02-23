
<!-- Header -->
<?php	require_once 'inc/header.php';	?>

<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">
<!-- HEADER-AREA -->
<?php	require_once 'inc/menu.php';	?>

<!-- Mobile-menu start -->
<?php	require_once 'inc/mobilemenu.php';	?>
<!-- Mobile-menu end -->

<!-- HEADING-BANNER START -->
<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site;?>/upload/MainBanner.webp) no-repeat scroll center center / cover;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-banner">
					<div class="heading-banner-title">
						<h2>Ürünler</h2>
					</div>
					<div class="breadcumbs pb-15">
						<ul>
							<li><a href="<?php echo site;?>">Ana Sayfa</a></li>
							<li><a href="<?php echo site;?>">Ürünler</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- HEADING-BANNER END -->
<!-- PRODUCT-AREA START -->
<div class="product-area pt-80 pb-80 product-style-2">
	<div class="container">
		<div class="row">
			<?php	require_once 'inc/sidebar.php';		?>
			<?php
				$s = @intval(get('s'));
				if(!$s){
					$s = 1;
				}
				$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum = :d AND urunvitrin = :v
				ORDER BY uruntarih DESC");
				$plist->execute([
				':d'=>1,
				':v'=>1
				]);
				$total = $plist->rowCount();
				$lim = 9;
				$show = $s * $lim - $lim;

				$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum=:d AND urunvitrin=:v 
				ORDER BY uruntarih DESC LIMIT :show, :lim");

				$plist->bindValue(':d',(int) 1,PDO::PARAM_INT);
				$plist->bindValue(':v',(int) 1,PDO::PARAM_INT);
				$plist->bindValue(':show',(int) $show,PDO::PARAM_INT);
				$plist->bindValue(':lim',(int) $lim,PDO::PARAM_INT);
				$plist->execute();

				if($s > ceil($total/$lim)){
					$s = 1;
				}
			?>

			<div class="col-lg-9 order-1 order-lg-2">
				<!-- Shop-Content End -->
				<div class="shop-content mt-tab-30 mb-30 mb-lg-0">
					<div class="product-option mb-30 clearfix">
						<!-- Nav tabs -->
						<ul class="nav d-block shop-tab">
						<p class="mb-0">Ürün Listesi (<?php echo $total;?>)</p>
						</ul>
					</div>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="grid-view">							
							<div class="row ">
								<?php 
								if($plist->rowCount()){	
								foreach($plist as $row){
								?>
								<div class="col-lg-4 col-md-6">
									<div class="single-product">
										<div class="product-img">
											<span class="pro-price-2"><?php echo $row['urunfiyat'];?> ₺</span>
											<a href="<?php echo site."/product.php?productsef=".$row['urunsef']; ?>">
												<img width="270" height="270" src="<?php echo site."/upload/product/".$row['urunkapak']	?>" alt="<?php echo $row['urunbaslik'];?>" /></a>
										</div>
										<div class="product-info clearfix text-center">
											
											<div class="fix">
												<h4 class="post-title"><a href="<?php echo site."/product.php?productsef=".$row['urunsef']; ?>"><?php echo $row['urunbaslik'];?></a></h4>
											</div>
											
											<div class="product-action ">
												<a style="font-size: 18px;" href="<?php echo site."/product.php?productsef=".$row['urunsef']; ?>" title="Ürün detayına git"><i class="zmdi zmdi-arrow-right" style="font-size: 18px;"></i> Ürün Detayı</a><br>
											</div>
											
										</div>
									</div>
								</div>
								<?php
								}
								}else{
									alert("Ürün bulunmuyor","danger");
								}?>
							</div>
						</div>
					</div>

					<!-- Pagination start -->
					<div class="shop-pagination text-center">
						<div class="pagination">
							<ul>
							<?php
								if($total > $lim){
									pagination($s, ceil($total/$lim),'index.php?s=');
								}
							?>
							</ul>
						</div>
					</div>
					<!-- Pagination end -->

				</div>
				<!-- Shop-Content End -->
			</div>
		</div>
	</div>
</div>
<!-- PRODUCT-AREA END -->
<?php	require_once 'inc/footer.php';	?>
