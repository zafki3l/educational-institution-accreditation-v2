<div id="criteriasModal" class="modal">
    <div class="modal-overlay"></div>

    <div class="modal-box">
        
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">
                    <span class="material-icons-round">assignment_turned_in</span>
                </div>
                <div>
                    <h3 class="modal-title">Các mốc đánh giá</h3>
                    <h3 class="modal-name" id="criteriasModalName"></h3>
                </div>
            </div>

            <button type="button" class="modal-close" id="closeCriteriasModal">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        
        <div class="modal-body">
            
            <div class="add-criteria-bar">
                <form id="addCriteriaForm" action="/criterias" method="post">
                    <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?? '' ?>">
                    <input type="hidden" name="criteria_id" id="criteriaIdInput">
                    <input type="hidden" name="main_criteria_id" id="mainCriteriaIdInput">

                    <input
                        type="text"
                        name="name"
                        id="newCriteriaName"
                        placeholder="Nhập tên tiêu chí..."
                    />

                    <button class="btn-primary" type="submit" id="addCriteriaBtn">
                        <span class="material-icons-round">add</span>
                        Thêm tiêu chí
                    </button>
                </form>
            </div>

            <div class="error" id="formCriteriasErrors"></div>
            
            <table class="criterias-table">
                <thead>
                    <tr>
                        <th class="w-sm">STT</th>
                        <th>Tên tiêu chí</th>
                        <th class="right w-xs">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="criteriasTableBody"></tbody>
            </table>

            
            <div id="emptyCriteriasState" class="empty-state">
                <span class="material-icons-round">fact_check</span>
                <p>Chưa có tiêu chí nào</p>
            </div>
        </div>

        
        <div class="modal-footer">
            <button type="button" class="btn-outline" id="closeCriteriasBtn">Đóng</button>
        </div>
    </div>
</div>

<style>
    .modal {
    position: fixed;
    inset: 0;
    display: none;
    justify-content: center;
    align-items: center;
    background: rgba(15,23,42,0.45);
    z-index: 999;
}

.modal.show {
    display: flex;
}


.modal-box {
    position: relative;
    z-index: 50;
    width: 100%;
    max-width: 56rem;
    background: 
    border-radius: 16px;
    border: 1px solid 
    box-shadow: 0 20px 25px -5px rgba(0,0,0,.1);
    overflow: hidden;
}

.modal-box {
    max-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
}


.modal-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 24px 32px;
    border-bottom: 1px solid 
}

.modal-header-left {
    display: flex;
    gap: 16px;
}

.modal-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: 
    color: 
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: 
}

.modal-close {
    background: none;
    border: none;
    color: 
    cursor: pointer;
}

.modal-close:hover {
    color: 
}



.modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 8px 32px;
}

.add-criteria-bar form {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
}

.criterias-table {
    width: 100%;
    border-collapse: collapse;
}

.criterias-table th {
    padding: 20px;
    font-size: 11px;
    text-transform: uppercase;
    color: 
    border-bottom: 1px solid 
}

.criterias-table td {
    padding: 16px 20px;
    border-top: 1px solid 
}

.right {
    text-align: right;
}

.w-sm { width: 64px; }
.w-md { width: 192px; }
.w-xs { width: 96px; }


.empty-state {
    display: none;
    padding: 64px 32px;
    text-align: center;
}

.empty-state span {
    font-size: 48px;
    color: 
}

.empty-state p {
    color: 
    font-weight: 500;
}


.modal-footer {
    padding: 24px 32px;
    background: 
    border-top: 1px solid 
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-primary {
    padding: 10px 24px;
    border-radius: 12px;
    border: none;
    background: 
    color: 
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.btn-primary:hover {
    background: 
}

.criterias-table tbody tr {
    transition: background .15s ease, box-shadow .15s ease;
}

.criterias-table tbody tr:hover {
    background: 
}

.criterias-table td:first-child {
    color: 
    font-weight: 600;
}

.criterias-table td {
    padding-top: 20px;
    padding-bottom: 20px;
}


.add-criteria-bar {
    background: 
    border: 1px solid 
    border-radius: 14px;
    padding: 16px;
    margin: 16px 0 24px;
}

.add-criteria-bar form {
    display: flex;
    align-items: center;
    gap: 12px;
}


    width: 160px;
    flex: 0 0 160px;
}


    flex: 1;
    min-width: 0;
}


    margin-left: auto;
    white-space: nowrap;
    flex-shrink: 0;
}
</style>

<script src="/js/criteria/criteriasModal.js"></script>