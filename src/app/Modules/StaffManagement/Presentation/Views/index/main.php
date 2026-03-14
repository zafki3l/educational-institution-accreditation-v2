<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management Dashboard</title>
    <link rel="stylesheet" href="staff-management.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/index/index.css">
    <link rel="stylesheet" href="/css/index/createUser.css">
    <link rel="stylesheet" href="/css/pagination.css">
</head>
<body>

<div id="toast-container" style="position: fixed; top: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 9999;"></div>

<div class="layout">
    <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/user-management/sidebar.php' ?>

    <main class="main">
        <div class="container">

            <div class="page-header">
                <h1>Quản lý nhân viên</h1>
                <button class="primary-btn" id="openStaffModal">
                    THÊM NHÂN VIÊN MỚI
                </button>
            </div>

           <?php include 'partials/searchStaff.php' ?>

            <div class="table-box">
                <?php include 'partials/staffTable.php' ?>

                <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/parts/pagination.php'?>
            </div>
        </div>
    </main>
</div>

<?php include 'partials/createForm.php' ?>
<?php include 'partials/editForm.php' ?>
<?php include 'partials/deleteForm.php' ?>


<script src="/js/staff/createForm.js"></script>
<script src="/js/staff/editForm.js"></script>
<script src="/js/staff/deleteForm.js"></script>

</body>
</html>