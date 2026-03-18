<div id="milestonesModal" class="modal">
    <div class="modal-overlay"></div>

    <div class="modal-box">
        
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <span class="material-icons-round">assignment_turned_in</span>
                </div>
                <div>
                    <h3 class="modal-title">Các mốc đánh giá</h3>
                    <h3 class="modal-desc" id="milestonesModalDesc"></h3>
                </div>
            </div>

            <button type="button" class="modal-close" id="closeMilestonesModal">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        
        <div class="modal-body">
            
            <div class="add-milestone-bar">
                <form id="addMilestoneForm" action="/milestones" method="post">
                    <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
                    <input type="hidden" name="criteria_id" id="criteriaIdInput">
                    <?php if (isAdmin()): ?>
                        <input
                            type="text"
                            id="newMilestoneOrder"
                            name="order"
                            placeholder="Số thứ tự (VD: 1, 2, 3...)"
                        />

                        <input
                            type="text"
                            name="name"
                            id="newMilestoneName"
                            placeholder="Nhập tên mốc đánh giá..."
                        />

                        <button class="btn-primary" type="submit" id="addMilestoneBtn">
                            <span class="material-icons-round">add</span>
                            Thêm mốc đánh giá
                        </button>
                    <?php endif; ?>
                </form>
            </div>

            <div class="error" id="formMilestonesErrors"></div>
            
            <table class="milestones-table">
                <thead>
                    <tr>
                        <th class="w-sm">Mốc</th>
                        <th>Tên mốc đánh giá</th>
                        <th class="right w-xs">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="milestonesTableBody"></tbody>
            </table>

            
            <div id="emptyMilestonesState" class="empty-state">
                <span class="material-icons-round">fact_check</span>
                <p>Chưa có mốc đánh giá nào</p>
            </div>
        </div>

        
        <div class="modal-footer">
            <button type="button" class="btn-outline" id="closeMilestonesBtn">Đóng</button>
        </div>
    </div>
</div>

<style>
/* Hiển thị Modal */
.modal {
    display: none; /* Mặc định ẩn */
    position: fixed;
    inset: 0;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal.show {
    display: flex;
}

.modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-box {
    position: relative;
    z-index: 50;
    width: 95%;
    max-width: 56rem;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,.1);
    overflow: hidden;
    max-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
}

/* Header */
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 32px;
    border-bottom: 1px solid #f3f4f6;
}

.modal-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #eff6ff;
    color: #1c3e95;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-title { font-size: 18px; font-weight: 700; color: #111827; margin: 0; }
.modal-desc { font-size: 13px; color: #6b7280; margin: 4px 0 0; }

/* Body & Table */
.modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px 32px;
}

.add-milestone-bar {
    background: #f9fafb;
    border: 1px solid #f3f4f6;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 24px;
}

.add-milestone-bar form {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Fix input layout */
#newMilestoneOrder { width: 200px; }
#newMilestoneName { flex: 1; }

.add-milestone-bar input {
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    outline: none;
}

.add-milestone-bar input:focus { border-color: #1c3e95; ring: 2px #bfdbfe; }

.milestones-table { width: 100%; border-collapse: collapse; }
.milestones-table th {
    text-align: left;
    padding: 12px 16px;
    font-size: 12px;
    color: #6b7280;
    border-bottom: 2px solid #f3f4f6;
}

.milestones-table td { padding: 16px; border-bottom: 1px solid #f3f4f6; }

/* Buttons */
.btn-primary {
    background: #1c3e95;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover { background: #1c3e95; }
.btn-outline {
    padding: 8px 20px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background: white;
    cursor: pointer;
}
</style>
<script>
    window.IS_ADMIN = <?= isAdmin() ? 'true' : 'false' ?>;
</script>
<script src="/js/criteria/milestonesModal.js"></script>