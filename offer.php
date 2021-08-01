<?php session_start(); include_once("sessionControl.php"); ?>

<div class="container">
    <h5>Ürüne Teklif Ekle</h5>
    <form class="form-horizontal" action="index.php" method="post" name="SaveProductOffer">
        <div class="form-group">
            <input type="hidden" id="uuid" name="uuid" value="<?php if (isset($_SESSION['ProductId'])) {echo($_SESSION['ProductId']);} ?>">
            <input type="hidden" class="form-control" id="ProductOfferId" name="ProductOfferId" value="<?php 
                if (isset($_GET["Status"]) && "SELECT_OFFER" == $_GET["Status"]) {
                    echo $_GET["ProductOfferId"];
                } else echo("");
                ?>">
                <input type="hidden" class="form-control" id="Status" name="Status" value="<?php if (isset($_GET["Status"])) echo($_GET["Status"]); ?>">
        </div>
        <?php include_once('offerUtils.php'); if (isset($_GET['ProductOfferId'])) $productOffer = getProductOfferById($_GET['ProductOfferId']); ?>
        <div class="form-group">
            <input type="text" class="form-control" id="brandName" name="brandName" placeholder="Marka" value="<?php if(isset($productOffer)) echo($productOffer["BRAND_NAME"]); ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Firma" value="<?php if(isset($productOffer)) echo($productOffer["COMPANY_NAME"]); ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Yetkili Adı" value="<?php if(isset($productOffer)) echo($productOffer["CONTACT_NAME"]); ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="contactPhone" name="contactPhone" placeholder="Yetkili Telefon" value="<?php if(isset($productOffer)) echo($productOffer["CONTACT_PHONE"]); ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="offer" name="offer" placeholder="Teklif" value="<?php if(isset($productOffer)) echo($productOffer["OFFER"]); ?>">
        </div>
        <div class="form-group">
            <textarea id="comment" name="comment" class="form-control" rows="4" cols="50" placeholder="Not"><?php if(isset($productOffer)) echo($productOffer["COMMENT"]); ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" name="SaveProductOffer" class="btn btn-default">Kaydet</button>
        </div>
    </form>
</div>