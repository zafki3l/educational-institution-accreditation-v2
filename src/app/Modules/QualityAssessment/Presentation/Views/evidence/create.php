<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/css/sidebar.css">
    <link rel="stylesheet" href="/css/index/index.css">
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
                    <h2>Thêm minh chứng</h2>
                </div>

                <div class="card">

                    <form class="form" action="/evidences" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">

                        <!-- Row 1 -->
                        <div class="grid-2">

                            <div class="form-group">
                                <label>Mã minh chứng <span>*</span></label>
                                <div class="input-icon">
                                    <span class="material-icons-round">qr_code</span>
                                    <!-- Prefix tự nhập -->
                                    <input type="text" id="prefixInput" placeholder="H1">
                                    <input type="text" id="autoCode" placeholder="01.01" readonly>
                                    <input type="text" id="lastCode" placeholder="01">
                                </div>
                            </div>

                            <input type="hidden" name="id" id="finalCode">

                            <div class="form-group">
                                <label>Tên minh chứng <span>*</span></label>
                                <div class="input-icon">
                                    <input type="text" name="name" placeholder="Nhập tên minh chứng">
                                </div>
                            </div>

                        </div>

                        <!-- Select -->
                        <div class="form-group">
                            <label>Tiêu chuẩn</label>
                            <select name="standard_id" id="standardSelect"  >
                                <option value="">-- Chọn tiêu chuẩn --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tiêu chí</label>
                            <select name="criteria_id" id="criteriaSelect" disabled>
                                <option value="">-- Chọn tiêu chí --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Mốc đánh giá</label>
                            <select name="milestone_id" id="milestoneSelect" disabled>
                                <option value="">-- Chọn mốc đánh giá --</option>
                            </select>
                        </div>

                        <!-- Divider -->
                        <div class="divider"></div>

                        <!-- Row 2 -->
                        <!-- Row 2 -->
                        <div class="grid-3">

                            <div class="form-group">
                                <label>Quyết định</label>
                                <input type="text" name="document_number" placeholder="Nhập quyết định">
                            </div>

                            <div class="form-group">
                                <label>Ngày ban hành</label>

                                <div class="date-group">
                                    <input type="text" id="day" placeholder="Ngày" maxlength="2">
                                    <span>/</span>
                                    <input type="text" id="month" placeholder="Tháng" maxlength="2">
                                    <span>/</span>
                                    <input type="text" id="year" placeholder="Năm" maxlength="4">
                                </div>

                                <input type="hidden" name="issued_date" id="issuedDate">
                            </div>

                            <div class="form-group">
                                <label>Nơi phát hành</label>
                                <input type="text" name="issuing_authority" placeholder="Nhập nơi phát hành">
                            </div>

                        </div>

                        <!-- Upload -->
                        <div class="form-group">
                            <label>Đính kèm minh chứng</label>

                            <div class="upload-box">
                                <span class="material-icons-round upload-icon">cloud_upload</span>
                                <p><strong>Tải tệp lên</strong> hoặc kéo và thả tệp vào đây</p>
                                <small>PDF, PNG, JPG hoặc JPEG tối đa 20MB</small>
                                <p id="fileName" class="file-name">Chưa chọn file</p>
                                <input type="file" name="file" id="fileInput">
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

    <script src="/js/evidence/selectionOption.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const prefixInput    = document.getElementById('prefixInput');
    const standardSelect = document.getElementById('standardSelect');
    const criteriaSelect = document.getElementById('criteriaSelect');
    const lastCodeInput  = document.getElementById('lastCode');
    const autoCode       = document.getElementById('autoCode');
    const finalCode      = document.getElementById('finalCode');

    function pad2(v) {
        return String(v || '').padStart(2, '0');
    }

    function generateCode() {
        const prefix   = prefixInput.value.trim();
        const standard = standardSelect.value;
        const criteria = criteriaSelect.value;
        const lastCode = lastCodeInput.value.trim();

        let mainCode = '';

        // Có tiêu chí: 11.1 → 11.01
        if (criteria) {
            const [std, cri] = criteria.split('.');
            mainCode = `${pad2(std)}.${pad2(cri)}`;
        }
        // Chỉ có tiêu chuẩn: 1 → 01
        else if (standard) {
            mainCode = pad2(standard);
        }

        autoCode.value = mainCode;

        if (prefix && mainCode && lastCode) {
            finalCode.value = `${prefix}.${mainCode}.${pad2(lastCode)}`;
        } else {
            finalCode.value = '';
        }
    }

    prefixInput.addEventListener('input', generateCode);
    standardSelect.addEventListener('change', generateCode);
    criteriaSelect.addEventListener('change', generateCode);
    lastCodeInput.addEventListener('input', generateCode);

});
</script>


<script>
const dayInput   = document.getElementById('day');
const monthInput = document.getElementById('month');
const yearInput  = document.getElementById('year');
const issuedDate = document.getElementById('issuedDate');

function pad2(v) {
    return String(v || '').padStart(2, '0');
}

function updateIssuedDate() {
    const d = dayInput.value;
    const m = monthInput.value;
    const y = yearInput.value;

    if (d && m && y.length === 4) {
        issuedDate.value = `${y}-${pad2(m)}-${pad2(d)}`;
    } else {
        issuedDate.value = '';
    }
}

[dayInput, monthInput, yearInput].forEach(i =>
    i.addEventListener('input', updateIssuedDate)
);
</script>
</body>

</html>