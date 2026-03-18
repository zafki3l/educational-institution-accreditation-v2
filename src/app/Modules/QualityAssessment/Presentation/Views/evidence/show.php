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

    <style>
        .evidence-fullscreen {
            position: absolute;
            inset: 0;
        }

        .evidence-fullscreen iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }

        .evidence-fullscreen img {
            max-width: 100vw;
            max-height: 100vh;
            margin: auto;
            display: block;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div class="layout">
        <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/quality-assessment/sidebar.php' ?>

        <?php if (isset($evidence->file_url)): ?>
            <main class="main" style="position: relative;">
                <div class="evidence-fullscreen">
                    <?php if (str_ends_with($evidence->file_url, '.pdf')): ?>
                        <iframe
                            src="/assets/evidences/<?= htmlspecialchars($evidence->file_url) ?>">
                        </iframe>
                    <?php else: ?>
                        <img
                            src="/assets/evidences/<?= htmlspecialchars($evidence->file_url) ?>">
                    <?php endif; ?>
                </div>
            </main>
        <?php else: ?>
            <main class="main" style="position: relative;">
                <div class="evidence-fullscreen">
                    <h1>Chưa có file upload!</h1>
                </div>
            </main>
            
        <?php endif; ?>
    </div>

</body>

</html>