<table class="criteria-table" id="evidence-milestones-table">
    <thead>
        <tr>
            <th>Mã minh chứng</th>
            <th>Tên minh chứng</th>
            <th>QUyết định</th>
            <th>Ngày văn bản</th>
            <th>Nơi phát hành</th>
            <th class="right">Xem minh chứng</th>
            <th class="right">Thao tác</th>
        </tr>
    </thead>
    <tbody id="evidence-milestones-tbody">
        <?php foreach ($criteria->milestones as $milestone): ?>
            <tr class="standard-row"
                data-milestone-id="<?= $milestone->id ?>">
                <td colspan="7">
                    <span style="font-weight: 600;">
                        Mốc đánh giá <?= $milestone->code ?>:
                        <?= htmlspecialchars($milestone->name) ?>
                    </span>

                    <button class="toggle-btn"
                            data-milestone-id="<?= htmlspecialchars($milestone->code) ?>"
                            aria-expanded="true">
                        <span class="material-symbols-outlined toggle-icon">
                            expand_more
                        </span>
                    </button>
                </td>
            </tr>

            <?php foreach ($milestone->evidences as $evidence): ?>
                <tr class="criteria-row"
                    data-parent-milestone="<?= htmlspecialchars($milestone->code) ?>">
                    <td><?= htmlspecialchars($evidence->id) ?></td>
                    <td class="evidence-name"
                        title="<?= htmlspecialchars($evidence->name) ?>">
                        <?= htmlspecialchars($evidence->name) ?>
                    </td>
                    <td><?= htmlspecialchars($evidence->document_number) ?></td>
                    <td><?= htmlspecialchars($evidence->issued_date) ?></td>
                    <td><?= htmlspecialchars($evidence->issuing_authority) ?></td>
                    <td class="right"><a>Xem</a></td>
                    <td class="right">
                        <div class="action-group">
                            <a class="icon-btn edit-evidence-btn"
                                href="/evidences/<?= htmlspecialchars($evidence->id) ?>/edit"
                                title="Chỉnh sửa">
                                <span class="material-symbols-outlined">edit</span>
                            </a>

                            <button
                                type="button"
                                class="icon-btn danger delete-evidence-btn"
                                data-id="<?= htmlspecialchars($evidence->id) ?>"
                                data-name="<?= htmlspecialchars($evidence->name) ?>"
                            >
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'deleteModal.php' ?>

<script src="/js/evidence/EvidenceTable.js"></script>