<div id="deleteConfirmModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Xác nhận xóa</h2>
            <button class="modal-close" id="closeDeleteModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc chắn muốn xóa tiêu chí này?</p>
            <p class="criteria-delete-name" id="evidenceDeleteName"></p>
            <p class="warning-text">Hành động này không thể hoàn tác.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-outline" id="cancelDelete">Hủy</button>
            <button type="button" class="btn-danger" id="confirmDelete">Xóa</button>
        </div>
    </div>
</div>