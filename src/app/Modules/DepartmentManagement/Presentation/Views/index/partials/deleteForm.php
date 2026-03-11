<div id="deleteDepartmentModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-content modal-small">
        <div class="modal-header">
            <h2>Xác nhận xóa</h2>
            <button class="modal-close" id="closeDeleteDepartmentModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc chắn muốn xóa phòng ban này?</p>
            <p class="criteria-delete-name" id="delete_department_name"></p>
            <p class="warning-text">Hành động này không thể hoàn tác.</p>

            <input type="hidden" id="delete_department_id">
            <input type="hidden" id="delete_department_csrf_token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-outline" id="cancelDeleteDepartmentModal">Hủy</button>
            <button type="button" class="btn-danger" id="confirmDeleteDepartmentBtn">Xóa</button>
        </div>
    </div>
</div>
