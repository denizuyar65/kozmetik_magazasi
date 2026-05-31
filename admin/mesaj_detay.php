<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

$id = intval($_GET["id"]);

$sorgu = $db->prepare("
    SELECT *
    FROM iletisim_mesajlari
    WHERE mesaj_id = ?
");

$sorgu->execute([$id]);

$mesaj = $sorgu->fetch(PDO::FETCH_ASSOC);

?>

<div class="admin-content">

    <h2 class="fw-bold mb-4">

        Mesaj Detayı

    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <h5>

                <?= htmlspecialchars($mesaj["ad_soyad"]) ?>

            </h5>

            <p>

                <strong>E-Posta:</strong>

                <?= htmlspecialchars($mesaj["email"]) ?>

            </p>

            <p>

                <strong>Tarih:</strong>

                <?= $mesaj["tarih"] ?>

            </p>

            <hr>

            <p>

                <?= nl2br(
                    htmlspecialchars(
                        $mesaj["mesaj"]
                    )
                ) ?>

            </p>

        </div>

    </div>

</div>