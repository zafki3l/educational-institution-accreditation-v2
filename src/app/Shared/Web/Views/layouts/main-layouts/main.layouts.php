<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/css/parts/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="shortcut icon" href="/assets/icon/fbu.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/components/buttons.css">
    <link rel="stylesheet" href="/css/components/modal.css">
    <link rel="stylesheet" href="/css/components/errorMessage.css">
    <link rel="stylesheet" href="/css/components/form.css">
    <link rel="stylesheet" href="/css/components/pagination.css">
    <link rel="stylesheet" href="/css/layouts/layouts.css">
    <title><?= $data['title'] ?></title>
</head>
<body>
    <?php include_once dirname(__DIR__) . '/parts/header.layouts.php' ?>

    <?= $data['content']; ?>
</body>
</html>