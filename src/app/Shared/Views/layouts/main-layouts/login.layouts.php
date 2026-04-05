<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= HOST ?>/css/parts/header.css">
    <link rel="stylesheet" href="<?= HOST ?>/css/main.css">
    <link rel="shortcut icon" href="<?= HOST ?>/assets/icon/fbu.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/components/buttons.css">
    <title><?= $data['title'] ?></title>
</head>
<body>
    <!-- MAIN CONTENT -->
    <?= $data['content']; ?>
</body>
</html>