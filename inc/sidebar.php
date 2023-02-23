                            <?php
                            $cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d");
                            $cat->execute([':d' => 1]);
                            ?>
                        <div class="col-lg-3 order-2 order-lg-1">
                                <!-- Widget-Search start -->
                                <aside class="widget widget-search mb-30">
                                    <form action="#" style="    background: #f6f6f6 none repeat scroll 0 0;border: medium none;
  box-shadow: none;
  color: #999;
  height: 40px;
  margin-bottom: 25px;
   
  transition: all 0.5s ease 0s;
  width: 100%;
  outline: none;">
                                        <input type="text" placeholder="Ürün arama" />
                                        <button type="submit">
                                            <i class="zmdi zmdi-search" style="font-size: 30px;"></i>
                                        </button>
                                    </form>
                                </aside>
                                <!-- Widget-search end -->
                                <!-- Widget-Categories start -->
                                <aside class="widget widget-categories  mb-30">
                                    <div class="widget-title">
                                        <h4>Kategoriler (<?php echo $cat->rowCount()  ?>)</h4>
                                    </div>
                                    <div id="cat-treeview"  class="widget-info product-cat boxscrol2">
                                        <ul>
                                            
                                            <?php

                                                $cat = $db->prepare("SELECT * FROM urun_kategoriler WHERE katdurum=:d");
                                                $cat->execute([':d' => 1]);
                                                if($cat->rowCount()){
                                                    foreach($cat as $ca){
                                                        echo '<li><a href="category.php?catsef='.$ca['katsef'].'"><span>'.$ca['katbaslik'].'</span></a></li>';
                                                        //echo '<li><a href="category/'.$ca['katsef'].'"><span><input type="radio" name="kat" value="'.$ca['id'].'" />'.$ca['katbaslik'].'</span></a></li>';
                                                    }
                                                }

                                            ?>

                                        </ul>
                                    </div>
                                </aside>
                                <!-- Widget-categories end -->
                                <!-- Shop-Filter start -->
                                <aside class="widget shop-filter mb-30">
                                    <div class="widget-title">
                                        <h4>Fiyat</h4>
                                    </div>
                                    <div class="widget-info">
                                        <div class="price_filter">
                                            <div class="price_slider_amount">
                                                <input type="submit"  value="Fiyat aralığı :"/> 
                                                <input type="text" id="amount" name="price"  placeholder="Fiyat ekle" /> 
                                            </div>
                                            <div id="slider-range"></div>
                                        </div>
                                    </div>
                                </aside>
							<!-- Shop-Filter end -->
						</div>