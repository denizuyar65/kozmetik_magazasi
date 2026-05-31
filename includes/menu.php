 <?php

    $sepetAdet = 0;

    if (isset($_SESSION["kullanici_id"])) {

        $sorgu = $db->prepare("
        SELECT SUM(adet)
        FROM sepet_detaylari sd
        INNER JOIN sepet s
        ON sd.sepet_id = s.sepet_id
        WHERE s.kullanici_id = ?
    ");

        $sorgu->execute([
            $_SESSION["kullanici_id"]
        ]);

        $sepetAdet = $sorgu->fetchColumn();

        if (!$sepetAdet) {
            $sepetAdet = 0;
        }
    }
    ?>
 <nav class="navbar navbar-expand-lg bg-white shadow-sm">

     <div class="container">

         <!-- Sol Menü Butonu -->

         <button
             class="btn btn-outline-dark me-3"
             data-bs-toggle="offcanvas"
             data-bs-target="#yanMenu">

             <i class="bi bi-list"></i>

         </button>

         <!-- Logo -->

         <a
             class="navbar-brand fw-bold"
             href="/kozmetik_magazasi/index.php">

             VELOURA COSMETICS

         </a>

         <!-- Arama -->

         <div class="position-relative w-50">

             <form
                 action="/kozmetik_magazasi/sayfalar/arama.php"
                 method="GET"
                 class="position-relative">

                 <div
                     class="position-relative"
                     style="width:580px;">

                     <!-- Arama İkonu -->

                     <i
                         class="bi bi-search position-absolute"
                         style="
                            left:15px;
                            top:50%;
                            transform:translateY(-50%);
                            z-index:10;
                            color:gray;
                        "></i>

                     <!-- Input -->

                     <input
                         class="form-control ps-5"
                         type="search"
                         placeholder="Ürün ara..."
                         id="aramaInput"
                         name="arama">

                     <!-- Sonuç -->

                     <div
                         id="aramaSonuc"
                         class="bg-white shadow position-absolute w-100 rounded mt-1"
                         style="
                        
                            z-index:9999;
                            max-height:400px;
                            overflow-y:auto;
                        "></div>

                 </div>

             </form>

         </div>

         <!-- Sağ Menü -->

         <div class="d-flex align-items-center gap-3">

             <!-- Favoriler -->

             <a
                 href="/kozmetik_magazasi/sayfalar/favoriler.php"
                 class="text-dark text-decoration-none d-flex flex-column align-items-center">

                 <i class="bi bi-heart fs-5"></i>

                 <small>

                     Favorilerim

                 </small>

             </a>

             <!-- Kullanıcı -->

             <?php if (isset($_SESSION["kullanici_id"])) { ?>

                 <a
                     href="/kozmetik_magazasi/sayfalar/profil.php"
                     class="text-dark text-decoration-none d-flex flex-column align-items-center">

                     <i class="bi bi-person fs-5"></i>

                     <small>

                         Hesabım

                     </small>

                 </a>

             <?php } else { ?>

                 <a
                     href="/kozmetik_magazasi/sayfalar/giris.php"
                     class="text-dark text-decoration-none d-flex flex-column align-items-center">

                     <i class="bi bi-person fs-5"></i>

                     <small>

                         Giriş Yap

                     </small>

                 </a>

             <?php } ?>

             <!-- Adres -->

             <a
                 href="/kozmetik_magazasi/sayfalar/adresler.php"
                 class="text-dark text-decoration-none d-flex flex-column align-items-center">

                 <i class="bi bi-geo-alt fs-5"></i>

                 <small>

                     Adreslerim

                 </small>

             </a>

             <!-- Sepet -->
             <a
                 href="/kozmetik_magazasi/sayfalar/sepet.php"
                 class="text-dark text-decoration-none d-flex flex-column align-items-center position-relative">

                 <i class="bi bi-cart fs-5"></i>

                 <?php if ($sepetAdet > 0) { ?>

                     <span
                         class="position-absolute badge rounded-pill bg-danger"
                         style="
                top:-8px;
                right:-12px;
                font-size:11px;
            ">
                         <?= $sepetAdet ?>
                     </span>

                 <?php } ?>

                 <small>
                     Sepetim
                 </small>

             </a>

         </div>

     </div>

 </nav>

 <!-- Sol Açılır Menü -->

 <!-- Sol Açılır Menü -->

 <div
     class="offcanvas offcanvas-start"
     tabindex="-1"
     id="yanMenu"
     style="width:280px;">

     <div class="offcanvas-header">

         <h5 class="fw-bold mb-0">
             🛍️ Kategoriler
         </h5>
         <button
             type="button"
             class="btn-close fs-4"
             data-bs-dismiss="offcanvas"></button>
     </div>

     <div class="offcanvas-body">
         <div
             class="text-center p-3 rounded-4 mb-4"
             style="
        background:linear-gradient(135deg,#f8d568,#f7b733);
        color:#000;
    ">

             <h5 class="fw-bold mb-1">
                 VELOURA COSMETICS
             </h5>

             <small>
                 Güzelliğin yeni adresi ✨
             </small>

         </div>

         <div class="accordion" id="kategoriAccordion">

             <!-- MAKYAJ -->

             <div class="accordion-item">

                 <h2 class="accordion-header">

                     <button
                         class="accordion-button"
                         type="button"
                         data-bs-toggle="collapse"
                         data-bs-target="#makyaj">

                         💄 Makyaj

                     </button>

                 </h2>

                 <div
                     id="makyaj"
                     class="accordion-collapse collapse"
                     data-bs-parent="#kategoriAccordion">

                     <div class="accordion-body p-0">

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=13" class="list-group-item list-group-item-action">Ruj</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=14" class="list-group-item list-group-item-action">Maskara</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=15" class="list-group-item list-group-item-action">Fondöten</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=16" class="list-group-item list-group-item-action">Allık</a>

                     </div>

                 </div>

             </div>

             <!-- CİLT BAKIMI -->

             <div class="accordion-item">

                 <h2 class="accordion-header">

                     <button
                         class="accordion-button collapsed"
                         type="button"
                         data-bs-toggle="collapse"
                         data-bs-target="#cilt">

                         ✨ Cilt Bakımı

                     </button>

                 </h2>

                 <div
                     id="cilt"
                     class="accordion-collapse collapse"
                     data-bs-parent="#kategoriAccordion">

                     <div class="accordion-body p-0">

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=17" class="list-group-item list-group-item-action">Nemlendirici</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=18" class="list-group-item list-group-item-action">Temizleyici</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=19" class="list-group-item list-group-item-action">Serum</a>

                     </div>

                 </div>

             </div>

             <!-- SAÇ BAKIMI -->

             <div class="accordion-item">

                 <h2 class="accordion-header">

                     <button
                         class="accordion-button collapsed"
                         type="button"
                         data-bs-toggle="collapse"
                         data-bs-target="#sac">

                         🧴 Saç Bakımı

                     </button>

                 </h2>

                 <div
                     id="sac"
                     class="accordion-collapse collapse"
                     data-bs-parent="#kategoriAccordion">

                     <div class="accordion-body p-0">

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=20" class="list-group-item list-group-item-action">Şampuan</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=21" class="list-group-item list-group-item-action">Saç Kremi</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=22" class="list-group-item list-group-item-action">Saç Maskesi</a>

                     </div>

                 </div>

             </div>

             <!-- PARFÜM -->

             <div class="accordion-item">

                 <h2 class="accordion-header">

                     <button
                         class="accordion-button collapsed"
                         type="button"
                         data-bs-toggle="collapse"
                         data-bs-target="#parfum">

                         🌸 Parfüm

                     </button>

                 </h2>

                 <div
                     id="parfum"
                     class="accordion-collapse collapse"
                     data-bs-parent="#kategoriAccordion">

                     <div class="accordion-body p-0">

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=23" class="list-group-item list-group-item-action">Kadın Parfümü</a>

                         <a href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=24" class="list-group-item list-group-item-action">Erkek Parfümü</a>

                     </div>

                 </div>
                 <!-- KURUMSAL -->

                 <div class="accordion-item">

                     <h2 class="accordion-header">

                         <button
                             class="accordion-button collapsed"
                             type="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#kurumsal">

                             🏢 Kurumsal

                         </button>

                     </h2>

                     <div
                         id="kurumsal"
                         class="accordion-collapse collapse"
                         data-bs-parent="#kategoriAccordion">

                         <div class="accordion-body p-0">

                             <a
                                 href="/kozmetik_magazasi/sayfalar/hakkimizda.php"
                                 class="list-group-item list-group-item-action">

                                 Hakkımızda

                             </a>

                             <a
                                 href="/kozmetik_magazasi/sayfalar/iletisim.php"
                                 class="list-group-item list-group-item-action">
                                 İletişim
                             </a>

                             <a
                                 href="/kozmetik_magazasi/sayfalar/sss.php"
                                 class="list-group-item list-group-item-action">
                                 Sık Sorulan Sorular
                             </a>

                             <a
                                 href="/kozmetik_magazasi/sayfalar/iade.php"
                                 class="list-group-item list-group-item-action">
                                 İade Politikası
                             </a>

                             <a
                                 href="/kozmetik_magazasi/sayfalar/gizlilik.php"
                                 class="list-group-item list-group-item-action">
                                 Gizlilik Politikası
                             </a>

                         </div>

                     </div>

                 </div>

             </div>

         </div>

     </div>

 </div>