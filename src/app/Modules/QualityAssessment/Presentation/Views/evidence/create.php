<form action="/evidences" method="post">
    <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">

    <input type="text" name="id" placeholder="Nhập mã minh chứng">
    <input type="text" name="name" placeholder="Nhập tên minh chứng">

    <select id="standardSelect">
        <option value="">-- Chọn tiêu chuẩn --</option>
    </select>

    <select name="criteria_id" id="criteriaSelect" disabled>
        <option value="">-- Chọn tiêu chí --</option>
    </select>

    <select name="milestone_id" id="milestoneSelect" disabled>
        <option value="">-- Chọn minh chứng --</option>
    </select>

    <input type="text" name="document_number" placeholder="Quyết định">

    <input type="text" name="issued_date" placeholder="YYYY-MM-DD">

    <input type="text" name="issuing_authority" placeholder="nơi phát hành">

    <button type="submit">Create</button>
</form>

<script src="/js/evidence/selectionOption.js"></script>