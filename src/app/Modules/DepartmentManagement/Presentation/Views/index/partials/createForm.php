<div id="createDepartmentModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Thêm Phòng Ban Mới</h2>
            <button class="modal-close" id="closeDepartmentModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="createDepartmentForm" action="/departments" method="post" class="context-form">
            <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="id">Mã phòng ban *</label>
                    <input 
                        type="text" 
                        id="id"
                        name="id" 
                        placeholder="Nhập mã phòng ban" 
                        class="form-input"
                        value="<?= htmlspecialchars($_SESSION['old']['id'] ?? '') ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="name">Tên phòng ban *</label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        placeholder="Nhập tên phòng ban" 
                        class="form-input"
                        value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>"
                    >
                </div>
            </div>

            <div class="error" id="formErrors"></div>
            
            <div class="form-actions">
                <button type="button" class="btn-outline" id="cancelDepartmentModal">Hủy</button>
                <button type="submit" class="btn-primary">Thêm Phòng Ban</button>
            </div>
        </form>
    </div>
</div>
