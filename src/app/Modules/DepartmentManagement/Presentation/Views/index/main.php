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
</head>
<body>

<div class="layout">
    <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/user-management/sidebar.php' ?>

    <main class="main">
        <div class="container">
            <div class="page-header">
                <h1>Quản lý phòng ban</h1>
                <form action="/departments" method="post">
                    <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?>">

                    <input type="text" name="id" placeholder="Nhập mã phòng ban" class="text-input">
                    <input type="text" name="name" placeholder="Nhập tên phòng ban" class="text-input">

                    <button class="primary-btn" type="submit">
                        </span>THÊM PHÒNG BAN
                    </button>
                </form>
            </div>

            <div class="table-box">
                <?php include 'partials/departmentTable.php' ?>
            </div>
        </div>
    </main>
<script src="/js/department/createForm.js"></script>
<script src="/js/department/deleteForm.js"></script>

<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 10px;"></div>

</body>
</html>