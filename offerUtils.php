<?php
session_start();
include_once("sessionControl.php");

function saveProductOffer() {
    //including the database connection file
    include("config.php");
    include_once("productUtils.php");


    if (isset($_POST['SaveProductOffer'])) {

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $productId = getProductId($_POST['uuid']);
        $brandName = toUpper($_POST['brandName']);
        $companyName = toUpper($_POST['companyName']);
        $contactName = toUpper($_POST['contactName']);
        $contactPhone = $_POST['contactPhone'];
        $comment = toUpper($_POST['comment']);
        $offer = $_POST['offer'];

        $productOfferId = $_POST['ProductOfferId'];

        if (empty($brandName)) {
            echo ("Marka girmelisiniz.");
        } else if (empty($companyName)) {
            echo ("Firma girmelisiniz.");
        } else if (empty($offer)) {
            echo ("Teklif girmelisiniz.");
        } else {
            if (isset($productOfferId) && $productOfferId != null) {
                $query = 
                "
                UPDATE  PRODUCT_OFFERS 
                SET     BRAND_NAME = ?, 
                        COMPANY_NAME = ?, 
                        CONTACT_NAME = ?, 
                        CONTACT_PHONE = ?, 
                        OFFER = ?, 
                        COMMENT = ?
                WHERE ID = ?";
                $stmt = $mysqli->prepare($query);

                $stmt->bind_param('ssssdsd', $brandName, $companyName, $contactName, $contactPhone, $offer, $comment, $productOfferId);
                $stmt->execute();
                $stmt->close();

                echo "Teklif güncellendi.";
            } else {
                //insert data to database
                $query = 
                "INSERT INTO PRODUCT_OFFERS(ID_PRODUCT, BRAND_NAME, COMPANY_NAME, CONTACT_NAME, CONTACT_PHONE, OFFER, COMMENT) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($query);

                $stmt->bind_param('dssssds', $productId, $brandName, $companyName, $contactName, $contactPhone, $offer, $comment);
                $stmt->execute();
                $stmt->close();

                echo "Teklif eklendi.";
            }
        }
        $mysqli->close();
    }
}

function getProductOfferTableHtml()
{
    include("config.php");

    $uuid = $_SESSION["ProductId"];

    $htmlStr = '
    <div class="container table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-bordered table-striped mb-0">
          <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">Id</th>
                <th scope="col">Marka</th>
                <th scope="col">Firma Adı</th>
                <th scope="col">Yetkili Adı</th>
                <th scope="col">Yetkili Telefon</th>
                <th scope="col">Teklif</th>
                <th scope="col">Not</th>
            </tr>
          </thead>
          <tbody>';

    $query = 
            "SELECT 
                    PO.ID, P.PRODUCT_NAME, PO.BRAND_NAME, 
                    PO. COMPANY_NAME, PO.CONTACT_NAME, PO.CONTACT_PHONE, 
                    PO.OFFER, PO.COMMENT
            FROM    PRODUCT_OFFERS PO 
            LEFT JOIN PRODUCTS P ON PO.ID_PRODUCT = P.ID 
            WHERE   P.UUID = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('s', $uuid);
        $stmt->execute();
        $stmt->bind_result($id, $productName, $brandName, $companyName, $contactName, $contactPhone, $offer, $comment);
        while ($stmt->fetch()) {
            $selectLink = '<a href="index.php?ProductOfferId=' . $id . '&Status=SELECT_OFFER">Seç</href>';
            $deleteLink = '<a href="index.php?ProductOfferId=' . $id . '&Status=DELETE_OFFER">Sil</href>';
            $htmlStr .= 
            '<tr>
                <td>' . $selectLink . '</td>
                <td>' . $deleteLink . '</td>
                <td>' . $id . '</td>
                <td>' . $brandName . '</td>
                <td>' . $companyName . '</td>
                <td>' . $contactName . '</td>
                <td>' . $contactPhone . '</td>
                <td>' . $offer . '</td>
                <td>' . $comment . '</td>
            </tr>';
        }
        $stmt->close();
    }
    $mysqli->close();
     $htmlStr .= '</tbody>
        </table>
    </div>';
    return $htmlStr;
}

function deleteProductOffer($productOfferId)
{
    include("config.php");
    $query = "DELETE FROM PRODUCT_OFFERS WHERE ID = ? ";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('d', $productOfferId);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}

function getProductOfferById($productOfferId)
{
    include("config.php");

    $query = 
            "SELECT 
                    PO.ID, P.PRODUCT_NAME, PO.BRAND_NAME, 
                    PO. COMPANY_NAME, PO.CONTACT_NAME, PO.CONTACT_PHONE, 
                    PO.OFFER, PO.COMMENT
            FROM    PRODUCT_OFFERS PO 
            LEFT JOIN PRODUCTS P ON PO.ID_PRODUCT = P.ID 
            WHERE   PO.ID = ?
            ORDER BY PO.OFFER";

    $row = null;
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('d', $productOfferId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array();
        $stmt->close();
    }
    $mysqli->close();
    return $row;
}

function toUpper($str) {
    return mb_strtoupper(str_replace(array('ı','ğ','ü','ş','i','ö','ç'), array('I','Ğ','Ü','Ş','İ','Ö','Ç'), $str), 'utf-8');
}

?>