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
</head>

<body>
    <div class="layout">
        <?php include 'partials/find/sidebar.php' ?>

        <div class="content">
            <div class="search-container">

                <div class="header">
                    <h1>TÌM KIẾM MINH CHỨNG</h1>
                    <p>
                        Tìm kiếm minh chứng đánh giá theo tiêu chuẩn, tiêu chí.
                    </p>
                </div>

                <?php include 'partials/find/searchBar.php' ?>
                
            </div>
        </div>
    </div>
</body>
</html>