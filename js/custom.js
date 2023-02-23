var url = "http://localhost/b2b";

function registerbutton(){

    document.getElementById("registerbuton").disabled = true;
 
    var data = $("#bregisterform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/register.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "format"){
                swal("Hatalı format","E-posta formatı hatalı.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "match"){
                swal("Uyuşmazlık","Şifreler uyuşmadı.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "already"){
                swal("Mevcut E-posta!","Bu E-posta adına ait bir bayi zaten kayıtlı.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Üyeliğiniz başarıyla oluşturuldu... Yönetici onayından sonra aktifleşecektir.","success");
                setTimeout(function(){
                    window.location.href = url;
                 }, 2000);
            }
        }
    });
}

function loginbutton(){

    document.getElementById("registerbuton").disabled = true;

    var data = $("#bloginform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/login.php",
        data: data,
        success: function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bayi kodu, e-posta veya şifre yanlış","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "passive"){
                swal("Pasif!","Üyeliğiniz pasif durumdadır.","error");
                document.getElementById("registerbuton").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Başarıyla giriş yaptınız, yönlendiriliyorsunuz.","success");
                setTimeout(function(){
                    window.location.href = url;
                 }, 2000);
                
            }
        }
    })
}

function passwordbutton(){

    document.getElementById("passwordbuton").disabled = true;

    var data = $("#passwordform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/changepassword.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("passwordbuton").disabled = false;
            }else if($.trim(result) == "match"){
                swal("Uyuşmazlık","Şifreler uyuşmadı.","error");
                document.getElementById("passwordbuton").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu.","error");
                document.getElementById("passwordbuton").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Şifreniz başarıyla güncellendi.","success");
                setTimeout(function(){
                    window.location.href = url + "/profile.php?process=profile";
                 }, 2000);
            }
        }
    });
}

function logoutmessage(){
    
    swal("Çıkış yapmak istediğinize emin misiniz?", {
        title: "Çıkış yapılıyor!",
        icon: "info",
        buttons: {
          cancel: "İptal Et",
          defeat: "Çıkış Yap",
        },
      })
      .then((value) => {
        switch (value) {
            case "defeat":
            swal("Çıkış işleminiz başarıyla gerçekleşti.", {
                icon: "success",
            });
            setTimeout(function(){
                window.location.href = url + "/logout.php";
             }, 500);
            
            break;
          default:
            swal("Çıkış işleminiz iptal edildi.", {
                icon: "success",
            });
            
        }
      });
}


function nextcart(){
    
    swal("Sonraki aşamaya geçmek istediğinize emin misiniz?", {
        title: "Ödeme & Sipariş",
        icon: "success",
        buttons: {
          cancel: "İptal Et",
          defeat: "Git",
        },
      })
      .then((value) => {
        switch (value) {
            case "defeat":
            setTimeout(function(){
                window.location.href = url + "/checkout.php";
             }, 500);
            break;
        }
    });
}

function addressbutton(){

    document.getElementById("addressbuton").disabled = true;

    var data = $("#addressform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/addressupdate.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("addressbuton").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu.","error");
                document.getElementById("addressbuton").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Adresiniz başarıyla güncellendi.","success");
                setTimeout(function(){
                    window.location.href = url + "/profile.php?process=address";
                 }, 2000);
                
            }
        }
    });
}

function newaddress(){

    document.getElementById("newaddres").disabled = true;

    var data = $("#newaddressform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/newaddress.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("newaddres").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu.","error");
                document.getElementById("newaddres").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Adresiniz başarıyla eklendi.","success");
                setTimeout(function(){
                    window.location.href = url + "/profile.php?process=address";
                 }, 2000);
                
            }
        }
    });
}

function newcomment(){

    document.getElementById("newcommentt").disabled = true;

    var data = $("#commentform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/newcomment.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("newcommentt").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu","error");
                document.getElementById("newcommentt").disabled = false;
            }else if($.trim(result) == "char"){
                swal("Min 500","Yorumunuz en az 500 karakter olmalıdır.","error");
                document.getElementById("newcommentt").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Yorumunuz eklendi.","success");
                setTimeout(function(){
                    window.location.reload(1);
                 }, 2000);
            }
        }
    });
}

function addcart(){

    document.getElementById("addcartt").disabled = true;

    //Tüm verileri al ve data değişkenine ata
    var data = $("#addcartform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/addcart.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Ürün adeti","Ürün adeti belirtiniz.","warning");
                document.getElementById("addcartt").disabled = false;
            }else if($.trim(result) == "login"){
                swal("Giriş yap","Sepete eklemek için giriş yapınız.","warning");
                document.getElementById("addcartt").disabled = false;
            }else if($.trim(result) == "qty"){
                swal("Min miktar","En az 1 adet seçmelinisiniz.","warning");
                document.getElementById("addcartt").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu","error");
                document.getElementById("addcartt").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Ürün sepete eklendi.","success");
                setTimeout(function(){
                    window.location.reload(1);
                 }, 2000);
                
            }
        }
    });
}

function sendmessage(){

    document.getElementById("sendmessages").disabled = true;

    var data = $("#contactform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/sendmessage.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("sendmessages").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu","error");
                document.getElementById("sendmessages").disabled = false;
            }else if($.trim(result) == "format"){
                swal("Hata!","E-Posta formatı hatalı.","error");
                document.getElementById("sendmessages").disabled = false;
            }else if($.trim(result) == "char"){
                swal("Min 100","Mesajınız en az 100 karakter olmalıdır.","error");
                document.getElementById("sendmessages").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Mesajınız gönderildi, en kısa sürede dönüş sağlanacaktır.","success");
                setTimeout(function(){
                    window.location.reload(1);
                 }, 2000);
                
            }
        }
    });
}



function newnotification(){

    document.getElementById("newnotificationn").disabled = true;

    var data = $("#newnotificationform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/newnotification.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("newnotificationn").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu","error");
                document.getElementById("newnotificationn").disabled = false;
            }else if($.trim(result) == "number"){
                swal("Numarik değil!","Havale tutarı sayısal bir ifade olmalıdır.","error");
                document.getElementById("newnotificationn").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Havale bildiriminiz gönderildi, yönetici kontrolünden sonra tarafınıza ulaşım sağlanacaktır.","success");
                
                setTimeout(function(){
                    window.location.href = url + "/profile.php?process=notification";
                 }, 2000);
            }
        }
    });
}

function profilebutton(){

    document.getElementById("profilebuton").disabled = true;

    var data = $("#profileform").serialize();
    $.ajax({
        type: "POST",
        url: url + "/inc/profileupdate.php",
        data: data,
        success : function(result){
            if($.trim(result) == "empty"){
                swal("Boş bırakma","Lütfen boş bırakmayınız.","error");
                document.getElementById("profilebuton").disabled = false;
            }else if($.trim(result) == "format"){
                swal("Hatalı format!","E-posta formatı hatalı","error");
                document.getElementById("profilebuton").disabled = false;
            }else if($.trim(result) == "already"){
                swal("Mevcut E-posta","Bu E-posta adına ait bir bayi zaten kayıtlı.","error");
                document.getElementById("profilebuton").disabled = false;
            }else if($.trim(result) == "error"){
                swal("Hata!","Bir problem oluştu","error");
                document.getElementById("profilebuton").disabled = false;
            }else if($.trim(result) == "ok"){
                swal("Başarılı","Profiliniz başarıyla güncellendi.","success");
                setTimeout(function(){
                    window.location.reload(1);
                 }, 2000);
            }
        }
    });
}




