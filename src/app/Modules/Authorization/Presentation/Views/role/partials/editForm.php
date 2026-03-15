<div id="editRoleModal" class="modal">
    <div class="modal-overlay"></div>

    <div class="modal-content">
        <div class="modal-header">
            <h2>Sửa Vai Trò</h2>
            <button class="modal-close" id="closeEditRoleModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="editRoleForm" class="context-form" action="/roles/update" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="edit_role_id" name="id">
            <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?>">

            <div class="form-group">
                <label for="edit_role_name">Tên Vai Trò</label>
                <input
                    type="text"
                    id="edit_role_name"
                    name="name"
                    class="form-input"
                    placeholder="Nhập tên vai trò"
                    required
                >
            </div>

            <div class="error" id="editRoleFormErrors"></div>

            <div class="form-actions">
                <button type="button" class="btn-outline" id="cancelEditRoleModal">
                    Hủy
                </button>
                <button type="submit" class="btn-primary">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>
