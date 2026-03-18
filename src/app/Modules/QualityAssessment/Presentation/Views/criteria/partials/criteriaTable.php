<table class="criteria-table">
    <thead>
        <tr>
            <th>Mã tiêu chí</th>
            <th>Tên tiêu chí</th>
            <th class="right">Các mốc đánh giá</th>
            <?php if (isAdmin()): ?>
                <th class="right">Thao tác</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($standards as $standard): ?>
            
            <tr class="standard-row"
                data-standard-id="<?= $standard->id ?>">
                <td colspan="4">
                    <span style="font-weight: 600;">
                        Tiêu chuẩn <?= $standard->id ?>:
                        <?= htmlspecialchars($standard->name) ?>
                    </span>

                    <button class="toggle-btn"
                            data-standard-id="<?= $standard->id ?>"
                            aria-expanded="true">
                        <span class="material-symbols-outlined toggle-icon">
                            expand_more
                        </span>
                    </button>
                </td>
            </tr>

            
            <?php foreach ($standard->criteria as $criteria): ?>
                <tr class="criteria-row"
                    data-parent-standard="<?= $standard->id ?>">
                    <td>Tiêu chí <?= htmlspecialchars($criteria->id) ?></td>
                    <td class="criteria-name"
                        title="<?= htmlspecialchars($criteria->name) ?>">
                        <?= htmlspecialchars($criteria->name) ?>
                    </td>
                    <td class="right">
                        <button 
                        class="milestone-btn" 
                        data-id="<?= $criteria->id ?>"
                        data-desc="<?= htmlspecialchars($criteria->name) ?>"
                        type="button"><span 
                        class="material-symbols-outlined">fact_check</span></button>
                    </td>
                    <?php if (isAdmin()): ?>
                        <td class="right">
                            <div class="action-group">
                                <button class="icon-btn edit-criteria-btn"
                                        type="button"
                                        title="Chỉnh sửa"
                                        data-id="<?= $criteria->id ?>">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>

                                <button class="icon-btn danger delete-criteria-btn"
                                        type="button"
                                        title="Xóa"
                                        data-id="<?= $criteria->id ?>"
                                        data-name="<?= htmlspecialchars($criteria->name) ?>">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'deleteModal.php' ?>
<?php include 'milestonesModal.php' ?>

<script src="/js/criteria/criteriaTable.js"></script>