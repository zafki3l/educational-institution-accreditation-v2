<table class="criteria-table" id="evidence-milestones-table">
    <thead>
        <tr>
            <th>Mã minh chứng</th>
            <th>Tên minh chứng</th>
            <th>QUyết định</th>
            <th>Ngày văn bản</th>
            <th>Nơi phát hành</th>
            <th class="right">Đáp ứng các tiêu chí</th>
            <th class="right">Xem minh chứng</th>
            <th class="right">Thao tác</th>
        </tr>
    </thead>
    <tbody id="evidence-milestones-tbody">
        <?php foreach ($criteria->milestones as $milestone): ?>
            <tr class="standard-row"
                data-milestone-id="<?= $milestone->id ?>">
                <td colspan="8">
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

            <?php foreach ($evidencesByMilestone[$milestone->id] as $evidence): ?>
                <tr class="criteria-row"
                    data-parent-milestone="<?= htmlspecialchars($milestone->code) ?>">
                    <td><?= htmlspecialchars($evidence->id) ?></td>
                    <td class="evidence-name"
                        title="<?= htmlspecialchars($evidence->name) ?>">
                        <?= htmlspecialchars($evidence->name) ?>
                    </td>
                    <td><?= htmlspecialchars($evidence->document_number ?? '') ?></td>
                    <td><?= htmlspecialchars($evidence->issued_date ?? '') ?></td>
                    <td><?= htmlspecialchars($evidence->issuing_authority) ?></td>
                    <td class="right">
                        <button
                            class="evidence-milestones-btn milestone-btn"
                            data-id="<?= htmlspecialchars($evidence->id) ?>"
                            data-name="<?= htmlspecialchars($evidence->name) ?>"
                            data-milestone-name="<?= htmlspecialchars($milestone->name) ?>"
                            data-criteria-id="<?= htmlspecialchars($milestone->criteria_id) ?>"
                            data-criteria-name="<?= htmlspecialchars($milestone->criteria->name ?? '') ?>"
                            type="button"
                        >
                            <span class="material-symbols-outlined">fact_check</span>
                        </button>
                    </td>
                    <td class="right"><a href="/evidences/<?= htmlspecialchars($evidence->id) ?>/show"><span class="material-symbols-outlined">visibility</span></a></td>
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
                                data-criteria="<?= htmlspecialchars($criteriaId) ?>"
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
<?php include 'evidenceMilestonesModal.php' ?>

<script src="/js/evidence/EvidenceTable.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

    const deleteModal = document.getElementById('deleteConfirmModal');
    if (!deleteModal) {
        console.error('Không tìm thấy #deleteConfirmModal');
        return;
    }

    const closeDeleteBtn   = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn  = document.getElementById('cancelDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const deleteNameEl     = document.getElementById('evidenceDeleteName');
    const modalOverlay     = deleteModal.querySelector('.modal-overlay');

    let deleteEvidenceId = null;
    let deleteCriteriaId = null;  

    // Open modal
    document.querySelectorAll('.delete-evidence-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopImmediatePropagation();   // quan trọng

            deleteEvidenceId = btn.dataset.id;
            deleteCriteriaId = btn.dataset.criteria;
            const evidenceName = btn.dataset.name;

            console.log('Delete clicked - Evidence ID:', deleteEvidenceId); // Debug

            if (deleteNameEl) deleteNameEl.textContent = `"${evidenceName}"`;
            deleteModal.classList.add('active');
        });
    });

    // Close modal
    const closeModal = () => {
        deleteModal.classList.remove('active');
        deleteEvidenceId = null;
    };

    closeDeleteBtn?.addEventListener('click', closeModal);
    cancelDeleteBtn?.addEventListener('click', closeModal);

    modalOverlay?.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
    });

    confirmDeleteBtn?.addEventListener('click', () => {
        console.log('Confirm delete clicked. Evidence ID =', deleteEvidenceId);

        if (!deleteEvidenceId) {
            alert('Không tìm thấy ID minh chứng để xóa!');
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/criterias/${deleteCriteriaId}/evidences/${deleteEvidenceId}`;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = 'CSRF-token';
        tokenInput.value = document.querySelector('input[name="CSRF-token"]')?.value || '';
        form.appendChild(tokenInput);

        console.log('Submitting to:', form.action);   // Debug

        document.body.appendChild(form);
        form.submit();
    });

    console.log('Delete modal script loaded successfully');
});

</script>

<script src="/js/evidence/EvidenceMilestonesModal.js"></script>