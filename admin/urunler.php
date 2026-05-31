<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// Ürünleri çek

$sorgu = $db->query("
    SELECT
        u.*,
        k.kategori_adi

    FROM urunler u

    LEFT JOIN kategoriler k
    ON u.kategori_id = k.kategori_id

    ORDER BY u.urun_id DESC
");

$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="admin-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Ürün Yönetimi

        </h2>

        <a
            href="urun_ekle.php"
            class="btn btn-dark">

            <i class="bi bi-plus-circle"></i>

            Yeni Ürün

        </a>

    </div>

    <div class="table-responsive">

        <table class="table align-middle bg-white">

            <thead>

                <tr>

                    <th>Resim</th>
                    <th>Ürün</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>İşlem</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($urunler as $urun) { ?>

                    <tr>

                        <!-- Resim -->

                        <td width="100">

                            <img
                                src="../<?= $urun["resim_url"] ?>"
                                class="urun-resim">

                        </td>

                        <!-- Ürün -->

                        <td>

                            <div class="urun-adi">

                                <?= htmlspecialchars($urun["urun_adi"]) ?>

                            </div>

                        </td>

                        <!-- Kategori -->

                        <td>

                            <?= htmlspecialchars($urun["kategori_adi"]) ?>

                        </td>

                        <!-- Fiyat -->

                        <td>

                            ₺<?= $urun["fiyat"] ?>

                        </td>

                        <!-- Stok -->

                        <td>

                            <?php if ($urun["stok"] <= 5) { ?>

                                <span class="badge bg-danger">

                                    <?= $urun["stok"] ?>

                                </span>

                            <?php } else { ?>

                                <span class="badge bg-success">

                                    <?= $urun["stok"] ?>

                                </span>

                            <?php } ?>

                        </td>

                        <!-- İşlem -->

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="urun_duzenle.php?id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-sm btn-primary">

                                    Düzenle

                                </a>

                                <a
                                    href="urun_sil.php?id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="
                                        return confirm(
                                            'Ürün silinsin mi?'
                                        )
                                    ">

                                    Sil

                                </a>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>