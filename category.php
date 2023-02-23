
		<!-- Header -->
		<?php	require_once 'inc/header.php';	?>

		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white">
		<!-- HEADER-AREA -->
		<?php	require_once 'inc/menu.php';	?>

		<!-- Mobile-menu start -->
		<?php	require_once 'inc/mobilemenu.php';	?>

		<?php	
		
		$catsef = get('catsef');
		if(!$catsef){
			go(site);
		}
		$catresult = $db->prepare("SELECT id,katbaslik,katsef,katdurum,katresim FROM urun_kategoriler WHERE katsef=:se AND katdurum=:d");
		$catresult->execute([':se' => $catsef,'d' => 1]);
		if($catresult->rowCount()){
			
			$catrow = $catresult->fetch(PDO::FETCH_OBJ);

		}else{
			
			go(site);
			
		}
		


		

		$s = @intval(get('s'));
		if(!$s){
			$s = 1;
		}
		$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum = :d AND urunkat = :v
		ORDER BY uruntarih DESC");
		$plist->execute([
		':d'=>1,
		':v'=>$catrow->id
		]);
		$total = $plist->rowCount();
		$lim = 9;
		$show = $s * $lim - $lim;


		?>

		<!-- Mobile-menu end -->

			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site;?>/upload/<?php echo $catrow->katresim;?>) no-repeat scroll center center / cover;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2><?php echo $catrow->katbaslik;	?></h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="<?php echo site;?>">Ana Sayfa</a></li>
										<li><a href="#">Kategori</a></li>
										<li><?php echo $catrow->katbaslik ;?></li>
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
							
							$plist = $db->prepare("SELECT * FROM urunler WHERE urundurum=:d AND urunkat=:v 
							ORDER BY uruntarih DESC LIMIT :show, :lim");

							$plist->bindValue(':d',(int) 1,PDO::PARAM_INT);
							$plist->bindValue(':v',(int) $catrow->id,PDO::PARAM_INT);
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
									<p class="mb-0"><?php echo $catrow->katbaslik; ?>Ürün Listesi (<?php echo $total;?>)</p>
									</ul>
									
								</div>
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane active" id="grid-view">							
										<div class="row ">

											<?php if($plist->rowCount()){	
												
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
														<a href="<?php echo site."/product.php?productsef=".$row['urunsef']; ?>" title="Ürün detayına git"><i class="zmdi zmdi-arrow-right"></i>Ürün Detayı</a>
														
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
									<div class="tab-pane" id="list-view">							
										<div class="row shop-list">
											<!-- Single-product start -->
											<div class="col-lg-12">
												<div class="single-product clearfix">
													<div class="product-img">
														<span class="pro-label new-label">new</span>
														<span class="pro-price-2">$ 56.20</span>
														<a href="single-product.html"><img src="img/product/6.jpg" alt="" /></a>
													</div>
													<div class="product-info">
														<div class="fix">
															<h4 class="post-title floatleft"><a href="#">dummy Product name</a></h4>
															<span class="pro-rating floatright">
																<a href="#"><i class="zmdi zmdi-star"></i></a>
																<a href="#"><i class="zmdi zmdi-star"></i></a>
																<a href="#"><i class="zmdi zmdi-star"></i></a>
																<a href="#"><i class="zmdi zmdi-star-half"></i></a>
																<a href="#"><i class="zmdi zmdi-star-half"></i></a>
																<span>( 27 Rating )</span>
															</span>
														</div>
														<div class="fix mb-20">
															<span class="pro-price">$ 56.20</span>
														</div>
														<div class="product-description">
															<p>There are many variations of passages of Lorem Ipsum available, but the majority have be suffered alteration in some form, by injected humour, or randomised words which donot look even slightly believable. If you are going to use a passage of Lorem Ipsum, you neede be sure there isn't anythin  going to use a passage embarrassing.</p>
														</div>
														<div class="clearfix">
															<div class="cart-plus-minus">
																<input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
															</div>
															<div class="product-action clearfix">
																<a href="wishlist.html" data-bs-toggle="tooltip" data-placement="top" title="Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a>
																<a href="#" data-bs-toggle="modal"  data-bs-target="#productModal" title="Quick View"><i class="zmdi zmdi-zoom-in"></i></a>
																<a href="#" data-bs-toggle="tooltip" data-placement="top" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
																<a href="cart.html" data-bs-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- Single-product end -->
										
										</div>
									</div>
								</div>
								<!-- Pagination start -->
								<div class="shop-pagination text-center">
									<div class="pagination">
										<ul>
										<?php
										
											if($total > $lim){
												pagination($s, ceil($total/$lim),'category.php?catsef='.$cat.'&s=');
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
