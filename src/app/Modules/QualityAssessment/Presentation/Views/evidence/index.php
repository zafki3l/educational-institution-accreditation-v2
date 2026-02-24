<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="staff-management.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/index/index.css">
    <link rel="stylesheet" href="/css/index/createUser.css">
    <link rel="stylesheet" href="/css/pagination.css">
    <link rel="stylesheet" href="/css/criteria/table.css">
    <link rel="stylesheet" href="/css/evidence/index.css">
</head>
<body>

<div class="layout">
    <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/quality-assessment/sidebar.php' ?>

    <main class="main">
        <div class="container">

            <div class="page-header">
                <h1>Quản lý minh chứng đánh giá</h1>

                <a href="/evidences/create" class="primary-btn" id="openCriteriaModal">
                    </span>THÊM MINH CHỨNG ĐÁNH GIÁ
                </a>
            </div>

            <h2 class="criteria-subtitle"><?= htmlspecialchars("Tiêu chí {$criteriaId}: {$criteriaName}") ?></h2>

            <div class="table-box">
                <?php include_once 'partials/evidenceTable.php' ?>
            </div>
        </div>
    </main>
</div>

</body>
</html>