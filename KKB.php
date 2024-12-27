<?php include_once "api/db.php"; ?>

<?php
    if (!isset($_SESSION['login'])) {
        echo "請從登入頁登入<a href='index.php?do=login'>管理登入</a>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>卓越科技大學校園資訊系統</title>
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
                    style="background:url('./upload/<?= $Title->find(['sh'=>1])['img']; ?>'); background-size:cover; height:200px;">
                </div>
            </a>
        </header>

        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-3 col-lg-2">
                <div class="card mb-3">
                    <div class="card-header text-center">
                        <h5 class="mb-0">後台管理選單</h5>
                    </div>
                    <div class="card-body">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="?do=title">網站標題管理</a>
                            <a class="nav-link" href="?do=ad">動態文字廣告管理</a>
                            <a class="nav-link" href="?do=mvim">動畫圖片管理</a>
                            <a class="nav-link" href="?do=image">校園映象資料管理</a>
                            <a class="nav-link" href="?do=total">進站總人數管理</a>
                            <a class="nav-link" href="?do=bottom">頁尾版權資料管理</a>
                            <a class="nav-link" href="?do=news">最新消息資料管理</a>
                            <a class="nav-link" href="?do=admin">管理者帳號管理</a>
                            <a class="nav-link" href="?do=menu">選單管理</a>
                        </nav>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body text-center">
                        <p class="mb-0">進站總人數 : <?= $Total->find(1)['total']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Main Content Section -->
            <div class="col-md-9 col-lg-10">
                <?php
                    $do = $_GET['do'] ?? 'title';
                    $file = "./backend/{$do}.php";

                    if (file_exists($file)) {
                        include $file;
                    } else {
                        include "./backend/title.php";
                    }
                ?>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="bg-warning text-center py-3 mt-4">
            <span class="t"><?= $Bottom->find(1)['bottom']; ?></span>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>