<?php	require_once 'inc/header.php';	?>
<!-- WRAPPER START -->
<div class="wrapper bg-dark-white">

<?php 
if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
	go(site);
}


?>

<!-- HEADER-AREA START -->
<?php	require_once 'inc/menu.php';	?>
<!-- HEADER-AREA END -->
<!-- Mobile-menu start -->
<?php	require_once 'inc/mobilemenu.php';	?>
<!-- Mobile-menu end -->

<?php

	$shopping = $db->prepare("SELECT * FROM sepet
	INNER JOIN urunler ON urunler.urunkodu = sepet.sepeturun
	WHERE sepetbayi = :b");
	$shopping->execute([
		':b' => $bcode
	]);

	if(isset($_GET['productdelete'])){
		$code = get('code');
		$delete = $db->prepare("DELETE FROM sepet 
		WHERE sepeturun = :u AND sepetbayi = :b");
		$delete->execute([
			':u' => $code,
			':b' => $bcode
		]);
		go($_SERVER['HTTP_REFERER']);
	}

?>	

<!-- HEADING-BANNER START -->
<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site;?>/upload/MainBanner.webp) no-repeat scroll center center / cover;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-banner">
					<div class="heading-banner-title">
						<h2>ALIŞVERİŞ SEPETİM (<?php echo $shopping->rowCount();?>)</h2>
					</div>
					<div class="breadcumbs pb-15">
						<ul>
							<li><a href="<?php echo site;?>">ANA SAYFA</a></li>
							<li>ALIŞVERİŞ SEPETİM (<?php echo $shopping->rowCount();?>)</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- HEADING-BANNER END -->
<!-- SHOPPING-CART-AREA START -->
<div class="shopping-cart-area  pt-80 pb-80">
	<div class="container">	
		<div class="row">
			<div class="col-lg-12">
				<div class="shopping-cart">
					<!-- Nav tabs -->
					<ul class="cart-page-menu nav row clearfix mb-30">
						<li><a class="active" href="#shopping-cart" data-bs-toggle="tab">Sepetim</a></li>
						
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<!-- shopping-cart start -->
						<div class="tab-pane active" id="shopping-cart">
							
							<?php
							if($shopping->rowCount()){
								
							
							?>

							
							<div class="shop-cart-table">
								<div class="table-content table-responsive">
									<table>
										<thead>
											<tr>
												<th class="product-thumbnail">Ürün</th>
												<th class="product-price">Fİyat</th>
												<th class="product-quantity">Adet</th>
												<th class="product-subtotal">Toplam</th>
												<th class="product-remove">İŞlem</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$totalprice = 0;
											$subtotal = 0;
											foreach($shopping as $cart){
												$ptax = $cart['kdv'] == 0 ? '' : ' + KDV';
												$htax = $cart['kdv'] == 0 ? 1 : (100 + $cart['kdv'])/100;
											?>
											<tr>
												<td class="product-thumbnail  text-left">
													<!-- Single-product start -->
													<div class="single-product">
														<div class="product-img">
															<a href="<?php echo site."/product.php?productsef=".$cart['urunsef'];?>"><img width="270" height="270" src="<?php echo "upload/product/".$cart['urunkapak'];?>" alt="<?php echo $cart['urunbaslik'] ?>" /></a>
														</div>
														<div class="product-info">
															<h4 class="post-title"><a class="text-light-black" href="<?php echo site."/product.php?productsef=".$cart['urunsef'];?>"><?php echo $cart['urunbaslik'] ?></a></h4>
														</div>
													</div>
													<!-- Single-product end -->												
												</td>
												<td class="product-price"><?php echo $cart['urunfiyat']." ₺".$ptax;?></td>
												<td class="product-quantity">
													<div class="cart-plus-minus">
														<input type="text" value="<?php echo $cart['sepetadet'];?>" name="qtybutton" class="cart-plus-minus-box" style="padding: 0 5px; width: 33%;">
													</div>
												</td>
												<td class="product-subtotal"><?php echo $cart['sepetadet']*round($cart['urunfiyat']*$htax,2);?></td>
												<td class="product-remove">
													<a href="<?php echo site."/cart.php?productdelete&code=".$cart['sepeturun'] ?>"><i class="zmdi zmdi-close"></i></a>
												</td>
											</tr>
											<?php
											$subtotal += round($cart['sepetadet']*$cart['urunfiyat'],2);
											$totalprice += $cart['sepetadet']*round($cart['urunfiyat']*$htax,2);
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row d-flex justify-content-center">
								
								<div class="col-md-7  align-self-center " >
									<div class="customer-login payment-details mt-30">
										<h4 class="title-1 title-border text-uppercase">Hesap Detayı</h4>
										<table>
											<tbody>
												<tr>
													<td class="text-left">Ara Toplam</td>
													<td class="text-end"><?php echo $subtotal." ₺"; ?></td>
												</tr>
												<tr>
													<td class="text-left">İskonto</td>
													<td class="text-end"><?php echo "00,00 ₺";?></td>
												</tr>
												<tr>
													<td class="text-left">KDV</td>
													<td class="text-end"><?php echo  $totalprice*($cart['kdv']/100)." ₺";?></td>
												</tr>
												<tr>
													<td class="text-left">Genel Toplam</td>
													<td class="text-end"><?php echo $totalprice." ₺"; ?></td>
												</tr>
												<tr>
													
													<td colspan="2" class="text-center">
														<a onclick="nextcart();" class="button-one submit-button " href="#">ÖDEME YAP & SİPARİŞİNİ TAMAMLA</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php
							}else{
								alert("Alışveriş sepetiniz boştur.","info");
							}
							?>
						</div>
						
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- SHOPPING-CART-AREA END -->
<!-- FOOTER START -->
<?php	require_once 'inc/footer.php';	?>

