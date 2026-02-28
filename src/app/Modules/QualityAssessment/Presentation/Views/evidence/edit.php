<form action="/evidences/update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="<?= htmlspecialchars($evidence->id) ?>">

    <input type="text" placeholder="Nhập mã minh chứng" value="<?= htmlspecialchars($evidence->id) ?? '' ?>" readonly>
    <input type="text" name="name" placeholder="Nhập tên minh chứng" value="<?= htmlspecialchars($evidence->name) ?? '' ?>">

    <select id="standardSelect" disabled>
        <option>
            Tiêu chuẩn <?= $evidence->milestone->criteria->standard->name ?>
        </option>
    </select>

    <input type="hidden" 
        name="standard_id" 
        value="<?= $evidence->milestone->criteria->standard_id ?>">

    <select id="criteriaSelect" disabled>
        <option>
            Tiêu chí <?= $evidence->milestone->criteria->name ?>
        </option>
    </select>

    <input type="hidden" 
        name="criteria_id" 
        value="<?= $evidence->milestone->criteria_id ?>">

    <select id="milestoneSelect" disabled>
        <option>
            <?= $evidence->milestone->order ?> - <?= $evidence->milestone->name ?>
        </option>
    </select>

    <input type="hidden" 
        name="milestone_id" 
        value="<?= $evidence->milestone_id ?>">

    <input type="text" name="document_number" placeholder="Quyết định" value="<?= htmlspecialchars($evidence->document_number) ?>">

    <input type="text" name="issued_date" placeholder="YYYY-MM-DD" value="<?= htmlspecialchars($evidence->issued_date) ?>">

    <input type="text" name="issuing_authority" placeholder="nơi phát hành" value="<?= htmlspecialchars($evidence->issuing_authority) ?>">

    <input type="file" id="file" name="file" placeholder="file">
    <button type="submit">Create</button>
</form>

<script src="/js/evidence/selectionOption.js"></script>