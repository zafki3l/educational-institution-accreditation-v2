<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="/css/login/main.css">
    <link rel="stylesheet" href="/css/login/error.css">
</head>

<body>

    <div class="container">
        <div class="left">
            <h1><a href="/" class="home-btn">QUAY VỀ TRANG CHỦ</a></h1>
            <br>
            <br>
            <hr>
            <br>
            <br>
            <div class="brand">
                <h1>HỆ THỐNG KIỂM ĐỊNH CHẤT LƯỢNG CƠ SỞ GIÁO DỤC </h1>
            </div>

            <br>
            <br>
            <form method="POST" action="/login">
                <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?>">
                <div class="input-group">
                    <input type="text" name="identifier" placeholder="Nhập email">
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder="Nhập mật khẩu">
                </div>
                <br>
                <button class="login-btn">ĐĂNG NHẬP</button>
            </form>

            <?php if (!empty($_SESSION['login_errors'])): ?>
                <div class="error-msg">
                    <?= htmlspecialchars($_SESSION['login_errors']) ?>
                </div>
                <?php unset($_SESSION['login_errors']); ?>
            <?php endif; ?>
        </div>

        <div class="right">
            <img src="/assets/banner/thhazspn.png">
        </div>
    </div>

</body>

</html>