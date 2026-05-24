<?php

include "../config/baglan.php";

if(isset($_GET["arama"])){

    $arama = trim($_GET["arama"]);

    if($arama != ""){

        $sorgu = $db->prepare("
            SELECT *
            FROM urunler
            WHERE urun_adi LIKE ?
            OR aciklama LIKE ?
            LIMIT 8
        ");

        $sorgu->execute([
            "%$arama%",
            "%$arama%"
        ]);

        $urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

        if(count($urunler) > 0){

            foreach($urunler as $urun){

?>

<a
    href="/kozmetik_magazasi/sayfalar/urun_detay.php?id=<?= $urun["urun_id"] ?>"
    class="d-flex align-items-center p-2 border-bottom text-dark text-decoration-none arama-item"
>

    <img
        src="/kozmetik_magazasi/<?= $urun["resim_url"] ?>"
        width="55"
        height="55"
        class="rounded me-3"
        style="object-fit:cover;"
    >

    <div>

        <div class="fw-semibold">

            <?= htmlspecialchars($urun["urun_adi"]) ?>

        </div>

        <small class="text-muted">

            ₺<?= $urun["fiyat"] ?>

        </small>

    </div>

</a>

<?php

            }

        }else{

            echo "
                <div class='p-3 text-muted'>

                    Ürün bulunamadı.

                </div>
            ";

        }

    }

}
?>