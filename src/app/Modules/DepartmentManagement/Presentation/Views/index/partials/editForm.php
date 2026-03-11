<div id="editDepartmentModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Sửa Phòng Ban</h2>
            <button class="modal-close" id="closeEditDepartmentModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editDepartmentForm" method="post" class="context-form">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="edit_id">Mã phòng ban</label>
                    <input 
                        type="text" 
                        id="edit_id"
                        name="id" 
                        class="form-input"
                        readonly
                    >
                </div>

                <div class="form-group">
                    <label for="edit_name">Tên phòng ban *</label>
                    <input 
                        type="text" 
                        id="edit_name"
                        name="name" 
                        placeholder="Nhập tên phòng ban" 
                        class="form-input"
                    >
                </div>
            </div>

            <div class="error" id="editFormErrors"></div>
            
            <div class="form-actions">
                <button type="button" class="btn-outline" id="cancelEditDepartmentModal">Hủy</button>
                <button type="submit" class="btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
