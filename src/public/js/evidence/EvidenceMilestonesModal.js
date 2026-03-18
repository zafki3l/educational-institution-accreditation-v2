let currentEvidenceId = null;

const evModal = document.getElementById('evidenceMilestonesModal');
const evTBody = document.getElementById('evidenceMilestonesTableBody');
const evEmptyState = document.getElementById('emptyEvidenceMilestonesState');
const evCsrfToken = document.querySelector('input[name="CSRF-token"]')?.value;

const selectStandard = document.getElementById('selectStandard');
const selectCriteria = document.getElementById('selectCriteria');
const selectMilestone = document.getElementById('selectMilestone');
const addMappingBtn = document.getElementById('addEvidenceMappingBtn');

const evError = document.getElementById('evidenceMilestonesErrors');

function showEvError(msg) {
    if (!evError) return;
    evError.innerHTML = `<span class="material-icons-round">error_outline</span> ${msg}`;
    evError.classList.add('show');
}

function clearEvError() {
    if (evError) {
        evError.innerHTML = '';
        evError.classList.remove('show');
    }
}

async function fetchEvidenceMilestones(evidenceId) {
    const res = await fetch(`/api/evidences/${evidenceId}/criterias`);
    if (!res.ok) throw new Error('Failed to fetch');

    const data = await res.json();

    const criterias = data.allCriterias || [];

    return criterias.flatMap(c =>
        (c.milestones || []).map(m => ({
            id: m.id,
            criteria_id: c.id,
            criteria_name: c.name,
            milestone_name: m.name,
            is_primary: m.is_primary
        }))
    );
}

async function fetchStandards() {
    if (!selectStandard) return;
    try {
        const res = await fetch('/api/standards');
        const data = await res.json();
        let standards = data.standards || [];
        selectStandard.innerHTML = '<option value="">Chọn tiêu chuẩn</option>' + 
            standards.map(s => `<option value="${s.id}">Tiêu chuẩn ${s.id}: ${s.name}</option>`).join('');
    } catch (err) {
        console.error('Error fetching standards:', err);
    }
}

selectStandard?.addEventListener('change', async () => {
    clearEvError();
    const standardId = selectStandard.value;
    selectCriteria.innerHTML = '<option value="">Chọn tiêu chí</option>';
    selectMilestone.innerHTML = '<option value="">Chọn mốc đánh giá</option>';
    selectCriteria.disabled = true;
    selectMilestone.disabled = true;
    if (addMappingBtn) addMappingBtn.disabled = true;

    if (!standardId) return;

    try {
        const res = await fetch(`/api/standards/${standardId}/criterias`);
        const data = await res.json();
        const criterias = data.criterias || [];
        selectCriteria.innerHTML = '<option value="">Chọn tiêu chí</option>' + 
            criterias.map(c => `<option value="${c.id}">${c.id}: ${c.name}</option>`).join('');
        selectCriteria.disabled = false;
    } catch (err) {
        console.error('Error fetching criterias:', err);
    }
});

selectCriteria?.addEventListener('change', async () => {
    const criteriaId = selectCriteria.value;
    selectMilestone.innerHTML = '<option value="">Chọn mốc đánh giá</option>';
    selectMilestone.disabled = true;
    if (addMappingBtn) addMappingBtn.disabled = true;

    if (!criteriaId) return;

    try {
        const res = await fetch(`/api/criterias/${criteriaId}/milestones`);
        const data = await res.json();
        const milestones = data.milestones || [];
        selectMilestone.innerHTML = '<option value="">Chọn mốc đánh giá</option>' + 
            milestones.map(m => `<option value="${m.id}">${m.name}</option>`).join('');
        selectMilestone.disabled = false;
    } catch (err) {
        console.error('Error fetching milestones:', err);
    }
});

selectMilestone?.addEventListener('change', () => {
    if (addMappingBtn) addMappingBtn.disabled = !selectMilestone.value;
});

document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.evidence-milestones-btn');
    if (!btn) return;

    e.preventDefault();

    currentEvidenceId = btn.dataset.id;
    const modalDesc = document.getElementById('evidenceMilestonesModalDesc');
    if (modalDesc) {
        modalDesc.textContent = btn.dataset.name || 'Chưa có tên minh chứng';
    }

    openEvidenceMilestonesModal();
    clearEvError();
    if (evTBody) evTBody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:24px">Đang tải...</td></tr>';

    try {
        const mappings = await fetchEvidenceMilestones(currentEvidenceId);
        renderEvidenceMilestonesTable(mappings);
    } catch (err) {
        console.error(err);
        if (evTBody) evTBody.innerHTML = '<tr><td colspan="4" style="text-align:center;color:red">Không thể tải dữ liệu</td></tr>';
    }

    await fetchStandards();
});

function renderEvidenceMilestonesTable(mappings) {
    if (!evTBody) return;

    if (!mappings.length) {
        evTBody.innerHTML = '';
        if (evEmptyState) evEmptyState.style.display = 'block';
        return;
    }

    if (evEmptyState) evEmptyState.style.display = 'none';

    evTBody.innerHTML = mappings.map(m => `
        <tr data-mapping-id="${m.id}">
            <td>${escapeEvHtml(m.criteria_id)}</td>
            <td>${escapeEvHtml(m.criteria_name || '')}</td>
            <td>${escapeEvHtml(m.milestone_name || '')}</td>
            ${window.IS_ADMIN && !m.is_primary ? `
                <td class="right">
                    <button class="icon-btn danger delete-evidence-mapping-btn">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            ` : `<td></td>`}
        </tr>
    `).join('');
}

addMappingBtn?.addEventListener('click', async () => {
    const milestoneId = selectMilestone.value;
    if (!milestoneId || !currentEvidenceId) return;

    clearEvError();

    if (addMappingBtn) {
        addMappingBtn.disabled = true;
        addMappingBtn.innerHTML = '<span class="material-icons-round spinner">sync</span> Đang lưu...';
    }

    try {
        const formData = new FormData();
        formData.append('evidence_id', currentEvidenceId);
        formData.append('criteria_id', selectCriteria.value);
        formData.append('milestone_id', milestoneId);
        if (evCsrfToken) formData.append('CSRF-token', evCsrfToken);

        const res = await fetch(`/api/evidences/${currentEvidenceId}/criterias`, {
            method: 'POST',
            body: formData
        });

        const result = await res.json();
        if (!res.ok || !result.success) throw new Error(result.message || 'Failed to save milestone');

        const mappings = await fetchEvidenceMilestones(currentEvidenceId);
        renderEvidenceMilestonesTable(mappings);

        showEvidenceToast('Thêm mốc đánh giá thành công!');

        selectStandard.value = '';
        selectCriteria.innerHTML = '<option value="">Chọn tiêu chí</option>';
        selectCriteria.disabled = true;
        selectMilestone.innerHTML = '<option value="">Chọn mốc đánh giá</option>';
        selectMilestone.disabled = true;
    } catch (err) {
        console.error(err);
        showEvError(err.message);
    } finally {
        if (addMappingBtn) {
            addMappingBtn.disabled = !selectMilestone.value;
            addMappingBtn.innerHTML = '<span class="material-icons-round">add</span> Thêm';
        }
    }
});

// Tìm đến đoạn xử lý click xóa (delete-evidence-mapping-btn)
const deleteMappingModal = document.getElementById('deleteMappingModal');
const confirmDeleteMappingBtn = document.getElementById('confirmDeleteMappingBtn');
const cancelDeleteMappingModal = document.getElementById('cancelDeleteMappingModal');
const closeDeleteMappingModal = document.getElementById('closeDeleteMappingModal');
const deleteMappingNameEl = document.getElementById('delete_mapping_name');

const closeDeleteModal = () => {
    deleteMappingModal?.classList.remove('active');
};

document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.delete-evidence-mapping-btn');
    if (!btn) return;

    e.preventDefault();

    const row = btn.closest('tr');
    const milestoneId = row?.dataset.mappingId; // Đây là milestone_id
    const criteriaId = row?.children[0].textContent.trim(); // Lấy ID tiêu chí từ cột đầu tiên
    const milestoneName = row?.children[2].textContent.trim();

    if (!milestoneId || !currentEvidenceId) return;

    document.getElementById('delete_mapping_milestone_id').value = milestoneId;
    document.getElementById('delete_mapping_criteria_id').value = criteriaId;
    if (deleteMappingNameEl) deleteMappingNameEl.textContent = `"${milestoneName}"`;

    deleteMappingModal?.classList.add('active');
});

cancelDeleteMappingModal?.addEventListener('click', closeDeleteModal);
closeDeleteMappingModal?.addEventListener('click', closeDeleteModal);
deleteMappingModal?.querySelector('.modal-overlay')?.addEventListener('click', closeDeleteModal);

confirmDeleteMappingBtn?.addEventListener('click', async () => {
    const milestoneId = document.getElementById('delete_mapping_milestone_id').value;
    const criteriaId = document.getElementById('delete_mapping_criteria_id').value;

    if (!milestoneId || !criteriaId || !currentEvidenceId) return;

    confirmDeleteMappingBtn.disabled = true;
    confirmDeleteMappingBtn.textContent = 'Đang xóa...';

    try {
        const formData = new FormData();
        formData.append('evidence_id', currentEvidenceId);
        formData.append('criteria_id', criteriaId);
        formData.append('milestone_id', milestoneId);
        formData.append('_method', 'DELETE'); // Method spoofing cho PHP

        if (evCsrfToken) {
            formData.append('CSRF-token', evCsrfToken);
        }

        const res = await fetch('/api/evidences/criterias', {
            method: 'POST', 
            body: formData
        });

        const result = await res.json(); 

        if (res.ok && result.success) {
            const mappings = await fetchEvidenceMilestones(currentEvidenceId);
            renderEvidenceMilestonesTable(mappings);
            showEvidenceToast('Xóa mốc đánh giá thành công!');
            closeDeleteModal();
        } else {
            throw new Error(result.message || 'Lỗi từ server');
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('Không thể xóa: ' + err.message);
    } finally {
        confirmDeleteMappingBtn.disabled = false;
        confirmDeleteMappingBtn.textContent = 'Xóa';
    }
});

function openEvidenceMilestonesModal() {
    if (evModal) evModal.classList.add('show');
}

function closeEvidenceMilestonesModal() {
    if (evModal) evModal.classList.remove('show');
}

document.getElementById('closeEvidenceMilestonesModal')?.addEventListener('click', closeEvidenceMilestonesModal);
document.getElementById('closeEvidenceMilestonesBtn')?.addEventListener('click', closeEvidenceMilestonesModal);
evModal?.querySelector('.modal-overlay')?.addEventListener('click', closeEvidenceMilestonesModal);

function escapeEvHtml(text = '') {
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}



function showEvidenceToast(message) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.style.cssText = `
        background-color: #2e7d32;
        color: #ffffff;
        padding: 12px 16px;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        min-width: 250px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        z-index: 10001;
    `;
    
    toast.innerHTML = `
        <div style="background-color: rgba(255,255,255,0.2); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <span class="material-symbols-outlined" style="font-size: 18px; color: white; font-weight: bold;">check</span>
        </div>
        <span>${message}</span>
    `;
    container.appendChild(toast);
    
    requestAnimationFrame(() => toast.style.transform = 'translateX(0)');
    
    toast.addEventListener('click', () => {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 400);
    });
    
    setTimeout(() => {
        if (document.body.contains(toast)) {
            toast.style.transform = 'translateX(120%)';
            setTimeout(() => {
                if (document.body.contains(toast)) toast.remove();
            }, 400); 
        }
    }, 4000);
}
