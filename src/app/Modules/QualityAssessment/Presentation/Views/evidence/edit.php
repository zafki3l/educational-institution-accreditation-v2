<?php
$prefix = '';
$mainCode = '';
$lastCode = '';

if (!empty($evidence->id)) {
    $parts = explode('.', $evidence->id);

    $prefix   = $parts[0] ?? '';
    $mainCode = ($parts[1] ?? '') . '.' . ($parts[2] ?? '');
    $lastCode = $parts[3] ?? '';
}

$day = '';
$month = '';
$year = '';

if (!empty($evidence->issued_date)) {
    $dateParts = explode('-', $evidence->issued_date);
    $year  = $dateParts[0] ?? '';
    $month = $dateParts[1] ?? '';
    $day   = $dateParts[2] ?? '';
}
?>

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

                    <form class="form" action="/evidences/update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($evidence['id']) ?>">

                        
                        <div class="grid-2">

                            <div class="form-group">
                                <label>Mã minh chứng </label>
                                <div class="input-icon">
                                    <span class="material-icons-round">qr_code</span>
                                    
                                    <input type="text" id="prefixInput" value="<?= $prefix ?>" readonly>

                                    <input type="text" id="autoCode" value="<?= $mainCode ?>" readonly>

                                    <input type="text" id="lastCode" value="<?= $lastCode ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Tên minh chứng </label>
                                <div class="input-icon">
                                    <input type="text" name="name" placeholder="Nhập tên minh chứng"
                                    value="<?= htmlspecialchars($evidence['name'] ?? '') ?>">
                                </div>
                            </div>

                        </div>

                        
                        <div class="form-group">
                            <label>Tiêu chuẩn</label>
                            <select name="standard_id" id="standardSelect"  disabled>
                                <option>
                                    Tiêu chuẩn <?= $evidence['milestone']->criteria->standard->name ?>
                                </option>
                            </select>
                        </div>

                        <input type="hidden" 
                        name="standard_id" 
                        value="<?= $evidence['milestone']->criteria->standard_id ?>">

                        <div class="form-group">
                            <label>Tiêu chí</label>
                            <select id="criteriaSelect" disabled>
                            <option>
                                Tiêu chí <?= $evidence['milestone']->criteria->name ?>
                            </option>
                        </select>
                        </div>

                        <input type="hidden" 
                        name="criteria_id" 
                        value="<?= $evidence['milestone']->criteria_id ?>">

                        <div class="form-group">
                            <label>Mốc đánh giá</label>
                            <select name="milestone_id" id="milestoneSelect" disabled>
                                <option>
                                    <?= $evidence['milestone']->order ?> - <?= $evidence['milestone']->name ?>
                                </option>
                            </select>
                        </div>

                        <input type="hidden" 
                                name="milestone_id" 
                                value="<?= $evidence['milestone_id'] ?>">

                        
                        <div class="divider"></div>

                        
                        <div class="grid-3">

                            <div class="form-group">
                                <label>Quyết định</label>
                                <input type="text" name="document_number" placeholder="Nhập quyết định"
                                value="<?= htmlspecialchars($evidence['document_number'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label>Ngày ban hành</label>

                                <div class="date-group">
                                    <input type="text" id="day" value="<?= $day ?>" maxlength="2">
                                    <span>/</span>
                                    <input type="text" id="month" value="<?= $month ?>" maxlength="2">
                                    <span>/</span>
                                    <input type="text" id="year" value="<?= $year ?>" maxlength="4">
                                </div>

                                <input type="hidden" name="issued_date" id="issuedDate">
                            </div>

                            <div class="form-group">
                                <label>Nơi phát hành</label>
                                <input type="text" name="issuing_authority" placeholder="Nhập nơi phát hành"
                                value="<?= htmlspecialchars($evidence['issuing_authority']) ?>">
                            </div>

                        </div>

                        
                        <div class="form-group">
                            <label>Đính kèm minh chứng</label>

                            <div class="upload-box">
                                <span class="material-icons-round upload-icon">cloud_upload</span>
                                <p><strong>Tải tệp lên</strong> hoặc kéo và thả tệp vào đây</p>
                                <small>PDF, PNG, JPG, JPEG hoặc WEBP tối đa 20MB</small>
                                <p id="fileName" class="file-name">Chưa chọn file</p>
                                <input type="file" name="file" id="fileInput">
                            </div>
                        </div>

                        
                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="history.back()">
                                Hủy bỏ
                            </button>

                            <button type="submit" class="btn-primary">
                                <span class="material-icons-round">save</span>
                                Tạo minh chứng
                            </button>
                        </div>

                        <?php if (!empty($_SESSION['errors'])): ?>
                            <div class="error">
                                <?php foreach ($_SESSION['errors'] as $err): ?>
                                    <p class="error-message"><?= htmlspecialchars($err) ?></p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                            
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

        
        if (criteria) {
            const [std, cri] = criteria.split('.');
            mainCode = `${pad2(std)}.${pad2(cri)}`;
        }
        
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

document.addEventListener('DOMContentLoaded', updateIssuedDate);
</script>

<script>
    const fileInput = document.getElementById('fileInput');
const fileName  = document.getElementById('fileName');

fileInput.addEventListener('change', function () {
    if (this.files && this.files.length > 0) {
        fileName.textContent = this.files[0].name;
    } else {
        fileName.textContent = 'Chưa chọn file';
    }
});
</script>
</body>

</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old']);

?>