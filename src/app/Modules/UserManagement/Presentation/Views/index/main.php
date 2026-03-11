<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Management Dashboard</title>
    <link rel="stylesheet" href="user-management.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/index/index.css">
    <link rel="stylesheet" href="/css/index/createUser.css">
    <link rel="stylesheet" href="/css/components/modal.css">
    <link rel="stylesheet" href="/css/pagination.css">
</head>
<body>

<div class="layout">
    <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/user-management/sidebar.php' ?>

    <main class="main">
        <div class="container">

            <div class="page-header">
                <h1>Quản lý tài khoản người dùng</h1>
                <button class="primary-btn" id="openUserModal">
                    </span>THÊM NGƯỜI DÙNG MỚI
                </button>
            </div>

           <?php include 'partials/searchUser.php' ?>

            <div class="table-box">
                <?php include 'partials/userTable.php' ?>

                <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/parts/pagination.php'?>
            </div>
        </div>
    </main>
</div>

<?php include 'partials/createForm.php' ?>
<?php include 'partials/editForm.php' ?>
<?php include 'partials/deleteForm.php' ?>

<script src="/js/user/createForm.js"></script>
<script src="/js/user/editForm.js"></script>
<script src="/js/user/deleteForm.js"></script>

<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 10px;"></div>

</body>
</html>