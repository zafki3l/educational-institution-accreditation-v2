<div id="evidenceMilestonesModal" class="modal">
    <div class="modal-overlay"></div>

    <div class="modal-box">
        <!-- Header -->
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <span class="material-icons-round">assignment_turned_in</span>
                </div>
                <div>
                    <h3 class="modal-title">Các tiêu chí đáp ứng</h3>
                    <h3 class="modal-desc" id="evidenceMilestonesModalDesc"></h3>
                </div>
            </div>

            <button type="button" class="modal-close" id="closeEvidenceMilestonesModal">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        <!-- Selection Bar -->
        <div class="modal-body">
            <?php if (isAdmin()): ?>
                <div class="add-milestone-bar">
                    <div class="selection-grid">
                        <select id="selectStandard" class="form-select">
                            <option value="">Chọn tiêu chuẩn</option>
                        </select>
                        <select id="selectCriteria" class="form-select" disabled>
                            <option value="">Chọn tiêu chí</option>
                        </select>
                        <select id="selectMilestone" class="form-select" disabled>
                            <option value="">Chọn mốc đánh giá</option>
                        </select>
                        <button class="btn-primary" type="button" id="addEvidenceMappingBtn" disabled>
                            <span class="material-icons-round">add</span>
                            Thêm
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="error" id="evidenceMilestonesErrors"></div>
            
            <table class="milestones-table">
                <thead>
                    <tr>
                        <th class="w-sm">Mã tiêu chí</th>
                        <th>Tên tiêu chí</th>
                        <th>Tên mốc đánh giá</th>
                        <th class="right w-xs">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="evidenceMilestonesTableBody"></tbody>
            </table>

            <!-- Empty -->
            <div id="emptyEvidenceMilestonesState" class="empty-state">
                <span class="material-icons-round">fact_check</span>
                <p>Chưa có tiêu chí nào được gán</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button type="button" class="btn-outline" id="closeEvidenceMilestonesBtn">Đóng</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/css/evidence/evidenceMilestonesModal.css">

<script>
    window.IS_ADMIN = <?= isAdmin() ? 'true' : 'false' ?>;
</script>
