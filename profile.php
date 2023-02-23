
        <!-- Header -->
		<?php	require_once 'inc/header.php';	
        
        if(@$_SESSION['login'] != @sha1(md5(IP().$bcode))){
            go(site);
        }
        ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
        <style>

        .pagination{
            background: transparent!important;
            display: flex!important;
            padding:20px!important;
        }
    
        #selectt1, input[type="date"],input[type="file"],textarea{
            background: #f6f6f6 none repeat scroll 0 0;
            border: medium none;
            box-shadow: none;
            color: #999;
            height: 40px;
            margin-bottom: 15px;
            padding: 0 20px;
            transition: all 0.5s ease 0s;
            width: 100%;
            outline: none;
        }

        </style>
		<!-- WRAPPER START -->
		<div class="wrapper bg-dark-white">
		<!-- HEADER-AREA -->
		<?php	require_once 'inc/menu.php';	?>

		<!-- Mobile-menu start -->
		<?php	require_once 'inc/mobilemenu.php';	?>
		<!-- Mobile-menu end -->

			<!-- HEADING-BANNER START -->
			<div class="heading-banner-area overlay-bg" style="background: rgba(0, 0, 0, 0) url(<?php echo site;?>/upload/profilepage.webp) no-repeat scroll center center / cover;">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="heading-banner">
								<div class="heading-banner-title">
									<h2>Bayi Profil</h2>
								</div>
								<div class="breadcumbs pb-15">
									<ul>
										<li><a href="#">Ana Sayfa</a></li>
										<li>Profil</li>
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
						<div class="col-lg-3 order-2 order-lg-1">
							
						
							<!-- Widget-Categories start -->
							<aside class="widget widget-categories  mb-30">
								<div class="widget-title">
									<h4>Menü</h4>
								</div>
								<div id="cat-treeview"  class="widget-info product-cat boxscrol2">
									<ul>
										<li><a href="<?php echo site."/profile.php?process=profile" ; ?>"><span>Profil Bilgileri</span></a></li>          
										<li><a href="<?php echo site."/profile.php?process=changepassword" ; ?>"><span>Şifre Değiştir</span></a></li>
                                        <li><a href="<?php echo site."/profile.php?process=logo" ; ?>"><span>Logo Değiştir</span></a></li>         
										<li><a href="<?php echo site."/profile.php?process=order" ; ?>"><span>Siparişlerim</span></a></li>  
                                        <li><a href="<?php echo site."/profile.php?process=address" ; ?>"><span>Adreslerim</span></a></li> 
                                        <li><a href="<?php echo site."/profile.php?process=notification" ; ?>"><span>Havale Bildirimlerim</span></a></li>            
										<li><a href="<?php echo site."cart.php" ; ?>"><span>Sepetim</span></a></li>          
										<li><a href="<?php echo site."/logout.php" ; ?>"><span>Çıkış</span></a></li>         
										
                                    
                                
									</ul>
								</div>
							</aside>
							<!-- Widget-categories end -->
							
						</div>
						<div class="col-lg-9 order-1 order-lg-2">
							<!-- Shop-Content End -->

                            <?php
                            
                            $process = get('process');
                            
                        

                            switch($process){
                                
                                case 'logo':
                                    
                                    if(isset($_POST['logoupdate'])){

                                        require_once 'inc/class.upload.php';
                                        $image = new Upload($_FILES['logoimage']);
                                        if($image->uploaded){
                                            $rname = $bcode."-".uniqid();
                                            $image->allowed = array('image/*');
                                            $image->image_convert = 'webp';
                                            $image->file_new_name_body = $rname;
                                            //$image->file_max_size = 10240;
                                            $image->process("upload/customer");
                                            
                                            if($image->processed){
                                                $up = $db->prepare("UPDATE bayiler SET bayilogo=:logo WHERE bayikodu=:k");
                                                $up->execute([
                                                ':logo' => $rname.'.webp',
                                                ':k' => $bcode
                                                ]);
                                                if ($up) {
                                                    alert("Logonuz başarıyla güncellendi", "success");
                                                    go(site."/profile.php?process=logo",2);
                                                }else{
                                                    alert("Hata oluştu","danger");
                                                }
                                            }

                                            
                                        }else{
                                            alert("Resim seçmediniz","danger");
                                        }

                                    }

                                    ?>  <!--Logo kısmını ajax ile yapmayacağız normal post yöntemi ile yapılacak.-->
                                        <form action="" method="POST" enctype="multipart/form-data">	
                                            <div class="customer-login text-left">
                                                <h4 class="title-1 title-border text-uppercase mb-30">LOGO GÜNCELLE</h4>
                                                <img src="<?php echo site."/upload/customer/".$blogo?>" width="100" height="100" alt="<?php echo $bcode; ?>">
                                                <input type="file" placeholder="Bayi logo" name="logoimage">
                                                <button type="submit" name="logoupdate" class="button-one submit-button mt-15">LOGO GÜNCELLE</button>
                                            </div>	
                                        </form>	
                                    <?php

                                break;
                                case 'notification':
                                    
                                    $notification = $db->prepare("SELECT havalebildirim.id, havalebildirim.havaletarih, havalebildirim.havalesaat, havalebildirim.havaletutar, havalebildirim.havalenot, bankalar.bankaadi FROM havalebildirim
                                    INNER JOIN bankalar ON bankalar.id = havalebildirim.banka
                                    WHERE havalebayi = :b ");
                                    $notification->execute([
                                        ':b' => $bcode
                                    ]);

                                    ?>

                                        <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                            <div class="product-option mb-30 clearfix">
                                                <!-- Nav tabs -->
                                                <ul class="nav d-block shop-tab">
                                                    <li><a href="<?php echo site; ?>/profile.php?process=newnotification"> Havale Bildirimlerim ( <?php echo $notification->rowCount(); ?> )  &emsp; [Yeni Bildirim Ekle] </a> </li>
                                                </ul>
                                            </div>
                                            
                                            <!-- Tab panes -->
                                            
                                            <div class="login-area ">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                            
                                                    <div class="table-responsive">
                                                        <?php   
                                                            
                                                            if($notification->rowCount()){

                                                            
                                                        ?>
                                                        <table class="table table-hover" id="b2btable">

                                                                <thead>
                                                                    <tr>
                                                                    <th>ID</th>
                                                                    <th>TARİH</th>
                                                                    <th>TUTAR</th>
                                                                    <th>BANKA</th>
                                                                    <th>NOT</th>
                                                                   

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    
                                                                    foreach($notification as $notificationn){
                                                                        ?>

                                                                            <tr>
                                                                                <td>#<?php echo $notificationn['id'];?></td>
                                                                                <td><?php echo dt($notificationn['havaletarih'])." | ".$notificationn['havalesaat'];?></td>
                                                                                <td><?php echo $notificationn['havaletutar']; ?></td>
                                                                                <td><?php echo $notificationn['bankaadi']; ?></td>
                                                                                <td><?php echo $notificationn['havalenot']; ?></td>
                                                                            </tr>

                                                                        <?php
                                                                    }
                                                                    
                                                                    ?>
                                                                </tbody>
                                                        </table>
                                                        <?php
                                                        
                                                            }else{
                                                                alert('Bildirim bulunmuyor','danger');
                                                            }
                                                        
                                                        ?>         

                                                    </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                            <?php

                                break;

                                case 'newnotification':
                                
                                    ?>
                                        <form action="" method="POST" onsubmit="return false;" id="newnotificationform">	
                                            <div class="customer-login text-left">
                                                <h4 class="title-1 title-border text-uppercase mb-30">YENİ HAVALE BİLDİRMİ</h4>
                                                <select name="hbank" id="selectt1">
                                                    <option value="0" readonly >Havale yaptığınız bankayı seçiniz</option>
                                                    <?php
                                                    $banks = $db->prepare("SELECT * FROM bankalar 
                                                    WHERE bankadurum=:d");

                                                    $banks->execute([':d' => 1]);
                                                    if($banks->rowCount()){
                                                        foreach($banks as $bank){
                                                            echo '<option value="'.$bank['id'].'">'.$bank['bankaadi'].'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                
                                                <input type="date"    placeholder="Havale tarih"    name="hdate">
                                                <input type="text" placeholder="Havale saati"    name="hhour">
                                                <input type="text"   placeholder="Havale tutarı"   name="hprice">
                                                <textarea placeholder="Havale açıklama" row="10" name="hdesc"></textarea>
                                                <button type="submit" onclick="newnotification();" id="newnotificationn" class="button-one submit-button mt-15">HAVALE BİLDİRİMİ YAP</button>
                                                
                                            </div>	
                                        </form>	
                                    <?php
                                
                                break;
                                case 'order':

                                    

                                    $orders = $db->prepare("SELECT * FROM siparisler 
                                                    INNER JOIN durumkodlari ON durumkodlari.durumkodu = siparisler.siparisdurum 
                                                    WHERE siparisbayi = :b ");
                                                    $orders->execute([
                                                        ':b' => $bcode
                                                    ]);
                                    ?>

                                <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                    <div class="product-option mb-30 clearfix">
                                        <!-- Nav tabs -->
                                        <ul class="nav d-block shop-tab">
                                            <li>Siparişlerim ( <?php echo $orders->rowCount(); ?> )</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Tab panes -->
                                    
                                    <div class="login-area ">
                                        <div class="row">
                                            <div class="col-lg-12">
                                               		
                                            <div class="table-responsive">
                                                <?php   
                                                    
                                                    if($orders->rowCount()){

                                                    
                                                ?>
                                                <table class="table table-hover" id="b2btable">

                                                        <thead>
                                                            <tr>

                                                            <th>KOD</th>
                                                            <th>DURUM</th>
                                                            <th>TUTAR</th>
                                                            <th>ÖDEME TÜRÜ</th>
                                                            <th>TARİH</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach($orders as $order){
                                                                ?>
                                                                    <tr>
                                                                        <td><a href="" title="Siparis detayı"><?php echo $order['sipariskodu']; ?></a></td>
                                                                        <td><?php echo $order['durumbaslik']; ?></td>
                                                                        <td><?php echo $order['siparistutar']; ?> ₺</td>
                                                                        <td><?php echo $order['siparisodeme'] == 1 ? 'Havale' : 'Kredi Kartı'; ?></td>
                                                                        <td><?php echo dt($order['siparistarih'])." | ".$order['siparissaat']; ?></td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                </table>
                                                <?php
                                                    }else{
                                                        alert('Siparisiniz bulunmuyor','danger');
                                                    }
                                                ?>         

                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                                case 'addressdelete':
                                    $id = get('id');
                                    //id get edilmediği durumda ana sayfaya dön
                                    if(!$id){
                                        go(site);
                                    }
                                    $query = $db->prepare("SELECT * FROM bayi_adresler
                                    WHERE adresbayi=:b AND id=:id");
                                    $query->execute([
                                        ':b' => $bcode,
                                        ':id' => $id
                                    ]);
                                    //Sql sorgusu yanıt verdi ise
                                    if($query->rowCount()){
                                        //Adres durumunu pasife al
                                        $delete = $db->prepare("UPDATE bayi_adresler SET adresdurum=:d 
                                        WHERE adresbayi=:b AND id=:id");
                                        $delete->execute([
                                            ':d' => 2,
                                            ':b' => $bcode,
                                            ':id' => $id
                                        ]);
                                        if($delete){
                                            //Bilgilendir ve sayfayı yenile
                                            alert("Adres pasife alındı","success");
                                            go(site."/profile.php?process=address",2);
                                        }else{
                                            alert("Hata oluştu","danger");
                                        }
                                    }else{
                                        //Ana Sayfaya geri dön
                                        go(site);
                                    }
                                break;

                                case 'addressedit':
                                    $id = get('id');
                                    //id get edilmediği durumda ana sayfaya dön
                                    if(!$id){
                                        go(site);
                                    }
                                    $query = $db->prepare("SELECT * FROM bayi_adresler
                                    WHERE adresbayi=:b AND id=:id");
                                    $query->execute([
                                        ':b' => $bcode,
                                        ':id' => $id
                                    ]);
                                    //Sql sorgusu yanıt verdi ise
                                    if($query->rowCount()){
                                        $arow = $query->fetch(PDO::FETCH_OBJ);
                                    ?>
                                        <form action="" method="POST" onsubmit="return false;" id="addressform">	
                                            <div class="customer-login text-left">
                                                <h4 class="title-1 title-border text-uppercase mb-30"><?php echo $row->adresbaslik;?> | ADRES DÜZENLE</h4>
                                                <input type="text" placeholder="Adres başlık" name="title" value="<?php echo $row->adresbaslik; ?>">
                                                <input type="text" placeholder="Adres tarif" name="content" value="<?php echo $row->adrestarif; ?>">
                                                <select name="status" id="selectt1">
                                                    <option value="1"<?php echo $row->adresdurum == 1 ? 'selected' : null; ?>>Aktif</option>
                                                    <option value="2"<?php echo $row->adresdurum == 2 ? 'selected' : null; ?>>Pasif</option>
                                                </select><br>
                                                <input type="hidden" value="<?php echo $row->id; ?>" name="addressid">
                                                <button type="submit" onclick="addressbutton();" id="addressbuton" class="button-one submit-button mt-15">ADRES GÜNCELLE</button>
                                            </div>	
                                        </form>	
                                    <?php
                                    }else{
                                        go(site);
                                    }
                                break;

                                case 'newaddress':
                                    
                                
                                        ?>
                                            <form action="" method="POST" onsubmit="return false;" id="newaddressform">	
                                                <div class="customer-login text-left">
                                                    <h4 class="title-1 title-border text-uppercase mb-30">YENİ ADRES EKLE</h4>
                                                    <input type="text" placeholder="Adres başlık" name="title">
                                                    <input type="text" placeholder="Adres tarif" name="content">
                                                    <button type="submit" onclick="newaddress();" id="newaddres" class="button-one submit-button mt-15">ADRES EKLE</button>
                                                </div>	
                                            </form>	
                                        <?php
                                    
                                break;

                                case 'address':
                                    
                                    $address = $db->prepare("SELECT * FROM bayi_adresler 
                                    WHERE adresbayi = :b ");
                                    $address->execute([
                                        ':b' => $bcode
                                    ]);
                                            ?>

                                        <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                            <div class="product-option mb-30 clearfix">
                                                <!-- Nav tabs -->
                                                <ul class="nav d-block shop-tab">
                                                    <li><a href="<?php echo site;?>/profile.php?process=newaddress"> Adreslerim ( <?php echo $address->rowCount(); ?> )  &emsp; [Yeni Adres Ekle] </a> </li>
                                                   
                                                </ul>
                                            </div>
                                            
                                            <!-- Tab panes -->
                                            
                                            <div class="login-area ">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                            
                                                    <div class="table-responsive">
                                                        <?php   
                                                            
                                                            if($address->rowCount()){

                                                        ?>
                                                        <table class="table table-hover" id="b2btable">

                                                                <thead>
                                                                    <tr>
                                                                    <th>ID</th>
                                                                    <th>BAŞLIK</th>
                                                                    <th>AÇIK ADRES</th>
                                                                    <th>DURUM</th>
                                                                    <th>İŞLEM</th>
                                                                   

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    
                                                                    foreach($address as $addres){
                                                                        ?>

                                                                            <tr>
                                                                                <td><?php echo $addres['id'];?></td>
                                                                                <td><?php echo $addres['adresbaslik']; ?></td>
                                                                                <td><?php echo $addres['adrestarif']; ?></td>
                                                                                <td><?php echo $addres['adresdurum'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
                                                                                <td>
                                                                                    <a href="<?php  echo site; ?>/profile.php?process=addressedit&id=<?php echo $addres['id'];?>" title="Adres düzenle"><i style="font-size:25px" class="zmdi zmdi-edit"></i></a> 
                                                                                    &emsp;
                                                                                    <a href="<?php  echo site; ?>/profile.php?process=addressdelete&id=<?php echo $addres['id'];?>" title="Adresi pasife al"><i style="font-size:30px" class="zmdi zmdi-close"></i></a> 
                                                                                </td>
                                                                            </tr>

                                                                        <?php
                                                                    }
                                                                    
                                                                    ?>
                                                                </tbody>
                                                        </table>
                                                        <?php
                                                        
                                                            }else{
                                                                alert('Adres bulunmuyor','danger');
                                                            }
                                                        
                                                        ?>         

                                                    </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                            <?php

                                break;
                                case 'profile':
                                ?>
                                    <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                        <div class="product-option mb-30 clearfix">
                                            <!-- Nav tabs -->
                                            <ul class="nav d-block shop-tab">
                                                <li>Profil Bilgileri</li>
                                            </ul>
                                        </div>

                                        <!-- Tab panes -->
                                        
                                        <div class="login-area">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="" method="POST" onsubmit="return false;" id="profileform">	
                                                        <div class="customer-login ">

                                                            <label>Bayi Kodu:</label>
                                                            <input type="text" disabled value="<?php echo $bcode; ?>" name="bec">
                                                        
                                                            <label>Bayi Adı:</label>
                                                            <input type="text" value="<?php echo $bname; ?>" name="bname" placeholder="Bayi Adı" >
                                                         
                                                        
                                                            <label>Bayi Mail:</label>
                                                            <input type="text"  value="<?php echo $bmail; ?>" name="bmail" placeholder="Bayi Mail">
                                                           
                                                            <label>Bayi Telefon:</label>
                                                            <input type="text"  value="<?php echo $bphone; ?>" name="bphone" placeholder="Bayi Telefon">

                                                            <label>Bayi Fax:</label>
                                                            <input type="text"  value="<?php echo $bfax; ?>" name="bfax" placeholder="Bayi Fax">

                                                            <label>Bayi Vergi No:</label>
                                                            <input type="text"  value="<?php echo $bvno; ?>" name="bvno" placeholder="Bayi Vergi No">

                                                            <label>Bayi Vergi Dairesi:</label>
                                                            <input type="text"  value="<?php echo $bvd; ?>" name="bvd" placeholder="Bayi Vergi Dairesi">

                                                            <label>Bayi Web Sitesi:</label>
                                                            <input type="text"  value="<?php echo $bweb; ?>" name="bweb" placeholder="Bayi Web Sitesi">

                                                            <button type="submit" onclick="profilebutton();" id="profilebuton" class="button-one submit-button mt-15">PROFİLİMİ GÜNCELLE</button>

                                                        </div>	
                                                    </form>				
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                
                                <?php
                                break;
                            
                                case 'changepassword':
                                ?>
                                    <div class="shop-content mt-tab-30 mb-30 mb-lg-0">
                                        <div class="product-option mb-30 clearfix">
                                            <!-- Nav tabs -->
                                            <ul class="nav d-block shop-tab">
                                                <li>Profil Bilgileri</li>
                                            </ul>
                                        </div>

                                        <!-- Tab panes -->
                                        
                                        <div class="login-area ">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="" method="POST" onsubmit="return false;" id="passwordform">	
                                                        <div class="customer-login ">
                                                            <label>Yeni Şifreniz:</label>
                                                            <input type="password"  name="password" placeholder="Yeni şifreniz">
                                                            
                                                            <label>Yeni Şifreniz Tekrar:</label>
                                                            <input type="password"  name="password2" placeholder="Yeni şifreniz tekrar giriniz.">

                                                           

                                                            <button type="submit" onclick="passwordbutton();" id="passwordbuton" class="button-one submit-button mt-15">ŞİFREMİ GÜNCELLE</button>

                                                        </div>	
                                                    </form>				
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                
                                <?php
                                break;
                            }
                                
                            ?>

							<!-- Shop-Content End -->
						</div>
					</div>
				</div>
			</div>
			<!-- PRODUCT-AREA END -->
		<?php	require_once 'inc/footer.php';	?>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#b2btable').DataTable();
            });
        </script>
