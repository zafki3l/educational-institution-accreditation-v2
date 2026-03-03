<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <style>
        .wrapper {
            width: 100%;
            padding: 30px 240px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            padding: 60px 100px;
        }

        .card h2 {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #333;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #1e40af;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
        }

        .btn:hover {
            background: #183288;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">
        <h2>Thông tin cá nhân</h2>

        <form action="/profile/update" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?>">

            <div class="form-group">
                <label>Họ</label>
                <input type="text" name="first_name" placeholder="Nhập họ" 
                value="<?= htmlspecialchars($user->first_name ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Tên</label>
                <input type="text" name="last_name" placeholder="Nhập tên" 
                value="<?= htmlspecialchars($user->last_name ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" placeholder="Nhập email"
                value="<?= htmlspecialchars($user->email ?? '') ?>">
            </div>

            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="error">
                    <?php foreach ($_SESSION['errors'] as $err): ?>
                        <p class="error-message"><?= htmlspecialchars($err) ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <button class="btn">Cập nhật thông tin</button>
        </form>
    </div>

    <div class="card">
        <h2>Đổi mật khẩu</h2>

        <div class="form-group">
            <label>Mật khẩu hiện tại</label>
            <input type="password" placeholder="Nhập mật khẩu hiện tại">
        </div>

        <div class="form-group">
            <label>Mật khẩu mới</label>
            <input type="password" placeholder="Nhập mật khẩu mới">
        </div>

        <div class="form-group">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" placeholder="Nhập lại mật khẩu mới">
        </div>

        <button class="btn">Đổi mật khẩu</button>
    </div>

</div>

</body>
</html>


<?php
unset($_SESSION['errors']);
?>