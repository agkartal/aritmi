<?php
session_start();
include_once("sessionControl.php");

function saveProducts()
{
    //including the database connection file
    include_once("config.php");

    if (isset($_POST['SaveProduct'])) {

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $productName = productNameToUpper($_POST['productName']);

        if (isset($_POST['Status']) && "SELECT_PRODUCT" == $_POST['Status']) {
            $productId = $_POST['ProductId'];

            if (empty($productName)) {
                echo ("Ürün Adı girmelisiniz.");
            } else {
                //insert data to database
                $stmt = $mysqli->prepare("UPDATE PRODUCTS SET PRODUCT_NAME = ? WHERE UUID = ?");
    
                $stmt->bind_param('ss', $productName, $productId);
                $stmt->execute();
                $stmt->close();
    
                echo "Ürün güncellendi.";
            }
        } else {
            if (empty($productName)) {
                echo ("Ürün Adı girmelisiniz.");
            } else {
                //insert data to database	
                $stmt = $mysqli->prepare("INSERT INTO PRODUCTS(UUID, PRODUCT_NAME) VALUES (?, ?)");
    
                $uuid = md5(uniqid());
                $stmt->bind_param('ss', $uuid, $productName);
                $stmt->execute();
                $stmt->close();
    
                echo "Ürün eklendi.";
            }
        }
        
        $mysqli->close();
    }
}

function getProductTableHtml()
{
    return getProductTableHtmlBySearchText(null);
}

function getProductTableHtmlBySearchText($searchText)
{
    include("config.php");

    $htmlStr = '
    <div class="container table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col"></th>
              <th scope="col">Id</th>
              <th scope="col">Ürün Adı</th>
            </tr>
          </thead>
          <tbody>';

    $query = "SELECT ID, UUID, PRODUCT_NAME FROM PRODUCTS ";
    if ($searchText != null) {
        $query = $query . "WHERE PRODUCT_NAME LIKE ? ";
    }

    $query = $query . "ORDER BY PRODUCT_NAME";

    if ($stmt = $mysqli->prepare($query)) {
        if ($searchText != null) {
            $searchText = '%' . productNameToUpper($searchText) . '%';
            $stmt->bind_param('s', $searchText);
        }
        $stmt->execute();
        $stmt->bind_result($id, $uuid, $product);
        while ($stmt->fetch()) {
            $selectLink = '<a href="index.php?ProductId=' . $uuid . '&Status=SELECT_PRODUCT">Seç</href>';
            $deleteLink = '<a href="index.php?ProductId=' . $uuid . '&Status=DELETE_PRODUCT">Sil</href>';
            $htmlStr .= '<tr><td>' . $selectLink . '</td><td>' . $deleteLink . '</td><td>' . $id . '</td><td>' . $product . '</td></tr>';
        }
        $stmt->close();
    }
    $mysqli->close();

    $htmlStr .= '</tbody>
        </table>
    </div>';
    return $htmlStr;
}

function searchProducts()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $searchText = $_POST['searchText'];
    return getProductTableHtmlBySearchText($searchText);
}

function getProductName($uuid)
{
    include("config.php");

    $query = "SELECT ID, UUID, PRODUCT_NAME FROM PRODUCTS WHERE UUID = ? ";
    $product = "ÜRÜN SEÇMEDİNİZ";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $uuid);
        $stmt->execute();
        $stmt->bind_result($id, $uuid, $product);
        $stmt->fetch();
        $stmt->close();
    }
    $mysqli->close();
    return $product;
}

function getProductId($uuid)
{
    include("config.php");

    $query = "SELECT ID FROM PRODUCTS WHERE UUID = ? ";
    $id = null;
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $uuid);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
    }
    $mysqli->close();
    return $id;
}

function deleteProduct($uuid)
{
    include("config.php");
    $query = "DELETE FROM PRODUCTS WHERE UUID = ? ";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $uuid);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}

function productNameToUpper($str) {
    return mb_strtoupper(str_replace(array('ı','ğ','ü','ş','i','ö','ç'), array('I','Ğ','Ü','Ş','İ','Ö','Ç'), $str), 'utf-8');
}

?>