<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidence Search</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/pagination.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/css/evidence-search.css">

    <style>
        

.search-results {
    margin-top: 40px;
}



.result-meta {
    font-size: 13px;
    color: 
    margin-bottom: 20px;
}



.result-list {
    display: flex;
    flex-direction: column;
    gap: 26px;
}



.result-item {
    padding-bottom: 20px;
    border-bottom: 1px solid 
}



.result-title {
    font-size: 20px;
    font-weight: 700;
    color: 
    margin-bottom: 6px;
    cursor: pointer;
}

.result-title:hover {
    text-decoration: underline;
}



.result-path {
    font-size: 13px;
    color: 
    margin-bottom: 8px;
}



.result-snippet {
    font-size: 15px;
    color: 
    line-height: 1.6;
    max-width: 800px;
}



.result-actions {
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.view-link {
    font-size: 14px;
    font-weight: 600;
    color: 
    text-decoration: none;
}

.view-link:hover {
    text-decoration: underline;
}

.year {
    font-size: 12px;
    color: 
}
    </style>
</head>

<body>
    <div class="layout">
        <?php include 'partials/find/sidebar.php' ?>

        <div class="content">
            <div class="search-container">

                <?php include 'partials/find/searchBar.php' ?>

                <div class="search-results">
                    <div class="result-list">
                        <?php if ($pagination->total > 0): ?>
                            <p>Hiển thị <?= htmlspecialchars($pagination->total) ?> Kết quả</p>
                            <?php foreach ($evidences as $evidence): ?>
                                <div class="result-item">
                                    <h3 class="result-title">
                                        <a href="/evidences/results/<?= htmlspecialchars($evidence['id']) ?>/view">
                                            <?= htmlspecialchars("Tiêu chuẩn {$evidence['id']}: {$evidence['name']}") ?>
                                        </a>
                                    </h3>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="result-item">
                                <p>Không tìm thấy minh chứng</p>
                            </div>
                        <?php endif; ?>

                        <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/parts/pagination.php'?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>