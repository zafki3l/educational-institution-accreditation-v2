<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= HOST ?>/css/dashboard/admin.dashboard.css">
</head>
<body>

    <main class="layout">
        <section class="card-grid">
            <?php include 'partials/user-management-card.php' ?>

            <?php include 'partials/standard-management-card.php' ?>
        </section>

        <section class="stats-section">
            <?php include 'partials/stats-section.php' ?>
        </section>
    </main>
</body>
</html>
