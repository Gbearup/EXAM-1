<?php include_once "api/db.php"; ?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>卓越科技大學校園資訊系統</title>

    <!-- 引入Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/js.js"></script>
</head>

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <header class="mb-4">
            <a href="index.php" title="<?= $Title->find(['sh'=>1])['text']; ?>">
                <div class="ti"
                    style="background:url('./upload/<?= $Title->find(['sh'=>1])['img']; ?>'); background-size:cover; height: 200px;">
                </div>
            </a>
        </header>

        <!-- Main Content Section -->
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-2">
                <div class="card mb-3">
                    <div class="card-header">主選單區</div>
                    <div class="card-body">
                        <?php 
                            $mains = $Menu->all(['sh'=>1, 'main_id'=>0]);
                            foreach($mains as $main){
                                echo "<div class='mb-2'>";
                                echo "<a href='{$main['href']}' class='d-block'>{$main['text']}</a>";

                                echo "<div class='ms-3'>";
                                if($Menu->count(['main_id'=>$main['id']]) > 0){
                                    $subs = $Menu->all(['main_id'=>$main['id']]);
                                    foreach($subs as $sub){
                                        echo "<a href='{$sub['href']}' class='d-block'>{$sub['text']}</a>";
                                    }
                                }
                                echo "</div>"; // Close sub-menu
                                echo "</div>"; // Close main menu item
                            }
                        ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <p class="mb-0">進站總人數 : <?= $Total->find(1)['total']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-7">
                <?php
                    $do = $_GET['do'] ?? 'main';
                    $file = "./front/{$do}.php";

                    if(file_exists($file)){
                        include $file;
                    } else {
                        include "./front/main.php";
                    }
                ?>
            </div>

            <!-- Right Sidebar (校園映像區) -->
            <div class="col-md-3">
                <?php 
                    if(!isset($_SESSION['login'])){
                ?>
                <button class="btn btn-primary w-100 mb-2" onclick="lo('index.php?do=login')">管理登入</button>
                <?php 
                    } else {
                ?>
                <button class="btn btn-secondary w-100 mb-2" onclick="lo('admin.php')">返回管理</button>
                <?php 
                    }
                ?>
                <div class="card">
                    <div class="card-header">校園映象區</div>
                    <div class="card-body">
                        <div class="text-center">
                            <button id="up" class="btn btn-info mb-3" onclick="pp(1)">上一頁</button>
                            <div class="row" id="image-gallery">
                                <?php 
                                    $imgs = $Image->all(['sh'=>1]);
                                    foreach($imgs as $idx => $img){
                                        echo "<div class='col-4 mb-2' id='ssaa{$idx}'>";
                                        echo "<img src='./upload/{$img['img']}' class='img-fluid' style='border: 3px solid orange;'>";
                                        echo "</div>";
                                    }
                                ?>
                            </div>
                            <button id="dn" class="btn btn-info mt-3" onclick="pp(2)">下一頁</button>
                        </div>
                    </div>
                </div>
                <script>
                var nowpage = 0,
                    num = <?= $Image->count(['sh'=>1]); ?>;

                function pp(x) {
                    var s, t;
                    if (x == 1 && nowpage - 1 >= 0) {
                        nowpage--;
                    }
                    if (x == 2 && (nowpage + 1) <= num - 3) {
                        nowpage++;
                    }
                    $(".col-4").hide();
                    for (s = 0; s <= 2; s++) {
                        t = s + nowpage;
                        $("#ssaa" + t).show();
                    }
                }
                pp(1);
                </script>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="bg-warning text-center py-3 mt-4">
            <span class="t"><?= $Bottom->find(1)['bottom']; ?></span>
        </footer>
    </div>

    <!-- 引入Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>