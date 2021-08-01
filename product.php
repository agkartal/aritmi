<?php session_start(); include_once("sessionControl.php"); ?>

<div class="container">
  <h5>Ürün Ekle</h5>
  <form class="form-horizontal" action="index.php" method="post" name="saveProduct">
    <div class="form-group">
      <input type="hidden" class="form-control" id="ProductId" name="ProductId" value="<?php 
          if (isset($_GET["Status"]) && "SELECT_PRODUCT" == $_GET["Status"]) {
            echo $_GET["ProductId"];
          } else echo("");
        ?>">
        <input type="hidden" class="form-control" id="Status" name="Status" value="<?php if (isset($_GET["Status"])) echo($_GET["Status"]); ?>">
    </div>
    <div class="form-group">
      <input type="text" class="form-control" id="productName" name="productName" value="<?php 
        if (isset($_GET["Status"]) && "SELECT_PRODUCT" == $_GET["Status"]) {
          echo getProductName($_GET["ProductId"]);
        } else echo("");

      ?>" placeholder="Ürün Adı">
    </div>
    <div class="form-group">
      <button type="submit" name="SaveProduct" class="btn btn-default">Kaydet</button>
      <a class="btn btn-primary" href="index.php" role="button">Yeni Ürün</a>
    </div>
  </form>
</div>

<div class="container">
  <h5>Ürün Ara</h5>
  <form class="form-horizontal" action="index.php" method="post" name="searchProduct">
    <div class="form-group">
      <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Aranacak Ürün Adı">
    </div>
    <div class="form-group">
      <button type="submit" name="SearchProduct" class="btn btn-default">Ara</button>
    </div>
  </form>
</div>