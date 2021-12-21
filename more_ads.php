<?php
require "db.php";

$query = "SELECT AdCode FROM ad";
$max_ad_code = $connection->query($query);
$max_ad_code = $max_ad_code->fetchAll();
$max_ad_code = end($max_ad_code)['AdCode'];
$ads_size = 2;

$current_page = (int)($_GET['page']);
$last_ad_code = ($current_page - 1) * $ads_size; //4

$query = "SELECT * FROM ad WHERE AdCode > $last_ad_code LIMIT $ads_size";
$ads = $connection->query($query);

foreach ($ads as $ad) :
?>
    <div class="ad">
        <div class="ad-image"><img src=<?= $ad['AdPhoto'] ?>></div>
        <a href="/adObj.php?AdCode=<?= $ad['AdCode'] ?>">
            <?= $ad['AdHeader'] ?></a>
        </a>
        <p><?= $ad['AdPrice'] ?></p>
    </div>
<?php endforeach; ?>