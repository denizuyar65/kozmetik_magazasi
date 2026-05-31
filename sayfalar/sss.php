<?php
include "../config/baglan.php";
include "../includes/header.php";
include "../includes/menu.php";

?>

<div class="container mt-5 mb-5">

    <div class="card shadow border-0">

        <div class="card-body p-5">

            <h1 class="fw-bold mb-4">

                Sık Sorulan Sorular

            </h1>

            <div class="accordion" id="sssAccordion">

                <!-- SORU 1 -->

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#soru1">

                            Siparişim kaç günde teslim edilir?

                        </button>

                    </h2>

                    <div
                        id="soru1"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#sssAccordion">

                        <div class="accordion-body">

                            Siparişleriniz genellikle
                            1-3 iş günü içerisinde
                            kargoya teslim edilir.

                        </div>

                    </div>

                </div>

                <!-- SORU 2 -->

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#soru2">

                            Ürün iadesi yapabilir miyim?

                        </button>

                    </h2>

                    <div
                        id="soru2"
                        class="accordion-collapse collapse"
                        data-bs-parent="#sssAccordion">

                        <div class="accordion-body">

                            Teslim tarihinden itibaren
                            14 gün içerisinde iade
                            talebinde bulunabilirsiniz.

                        </div>

                    </div>

                </div>

                <!-- SORU 3 -->

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#soru3">

                            Hangi ödeme yöntemleri kabul ediliyor?

                        </button>

                    </h2>

                    <div
                        id="soru3"
                        class="accordion-collapse collapse"
                        data-bs-parent="#sssAccordion">

                        <div class="accordion-body">

                            Kredi kartı, banka kartı ve
                            havale/EFT yöntemleri desteklenmektedir.

                        </div>

                    </div>

                </div>

                <!-- SORU 4 -->

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#soru4">

                            Siparişimi nasıl takip edebilirim?

                        </button>

                    </h2>

                    <div
                        id="soru4"
                        class="accordion-collapse collapse"
                        data-bs-parent="#sssAccordion">

                        <div class="accordion-body">

                            Hesabım bölümünden sipariş
                            durumunuzu takip edebilirsiniz.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>