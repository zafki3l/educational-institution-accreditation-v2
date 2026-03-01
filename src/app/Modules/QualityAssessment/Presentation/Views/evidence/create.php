<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/index/index.css"> 
    <link rel="stylesheet" href="/css/index/createUser.css"> 
    <link rel="stylesheet" href="/css/pagination.css"> 
    <link rel="stylesheet" href="/css/criteria/table.css"> 
    <link rel="stylesheet" href="/css/evidence/index.css"> 
    <link rel="stylesheet" href="/css/evidence-create.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" /> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
</head>

<body class="app-bg">

<div class="layout">
    <?php include dirname(__DIR__, 5) . '/Shared/Views/layouts/quality-assessment/sidebar.php' ?>

    <main class="main">
        <div class="container">

            <div class="page-header">
                <h2>Thêm mới minh chứng</h2>
                <p>Vui lòng nhập đầy đủ thông tin minh chứng theo các tiêu chuẩn quy định.</p>
            </div>

            <div class="card">

                <form class="form">

                    <!-- Row 1 -->
                    <div class="grid-2">

                        <div class="form-group">
                            <label>Mã minh chứng <span>*</span></label>
                            <div class="input-icon">
                                <span class="material-icons-round">qr_code</span>
                                <input type="text" placeholder="Nhập mã minh chứng">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tên minh chứng <span>*</span></label>
                            <div class="input-icon">
                                <span class="material-icons-round">description</span>
                                <input type="text" placeholder="Nhập tên minh chứng">
                            </div>
                        </div>

                    </div>

                    <!-- Select -->
                    <div class="form-group">
                        <label>Tiêu chuẩn</label>
                        <select>
                            <option>Tiêu chuẩn 2: Quản trị</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tiêu chí</label>
                        <select>
                            <option>Tiêu chí 2.1: Hệ thống quản trị (bao gồm hội đồng quản trị hoặc hội đồng trường; các tổ chức đảng, đoàn thể; các hội đồng tư vấn...)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Chỉ báo</label>
                        <select>
                            <option>1 - CSGD có thành lập hội đồng quản trị/hội đồng trường; có các tổ chức đảng, đoàn thể, các hội đồng tư vấn theo quy định...</option>
                        </select>
                    </div>

                    <!-- Divider -->
                    <div class="divider"></div>

                    <!-- Row 2 -->
                    <div class="grid-2">

                        <div class="form-group">
                            <label>Số/Ký hiệu/Quyết định</label>
                            <input type="text" placeholder="Nhập số hiệu quyết định">
                        </div>

                        <div class="form-group">
                            <label>Ngày ban hành</label>
                            <div class="input-icon right">
                                <input type="date">
                                <span class="material-icons-round">calendar_today</span>
                            </div>
                        </div>

                        <div class="form-group full">
                            <label>Nơi phát hành/Cơ quan ban hành</label>
                            <input type="text" placeholder="Nhập nơi phát hành">
                        </div>

                    </div>

                    <!-- Upload -->
                    <div class="form-group">
                        <label>Đính kèm minh chứng</label>

                        <div class="upload-box">
                            <span class="material-icons-round upload-icon">cloud_upload</span>
                            <p><strong>Tải tệp lên</strong> hoặc kéo và thả tệp vào đây</p>
                            <small>PDF, PNG, JPG hoặc DOCX tối đa 10MB</small>
                            <input type="file">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel">Hủy bỏ</button>
                        <button type="submit" class="btn-primary">
                            <span class="material-icons-round">save</span>
                            Tạo minh chứng
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </main>

</div>

</body>
</html>