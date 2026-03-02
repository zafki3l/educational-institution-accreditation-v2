/* =====================
   GLOBAL STATE
===================== */
let currentCriteriaId = null;

/* =====================
   ELEMENTS
===================== */
const modal = document.getElementById('milestonesModal');
const form = document.getElementById('addMilestoneForm');
const orderInput = document.getElementById('newMilestoneOrder');
const nameInput = document.getElementById('newMilestoneName');
const csrfToken = document.querySelector('input[name="CSRF-token"]')?.value;
const addMilestoneBtn = document.getElementById('addMilestoneBtn');

/* =====================
   FETCH
===================== */
async function fetchMilestones(criteriaId) {
    const res = await fetch(`/criterias/${criteriaId}/milestones`);
    if (!res.ok) throw new Error(res.status);
    const data = await res.json();
    return data.criteria.milestones ?? [];
}

/* =====================
   OPEN MODAL
===================== */
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.milestone-btn');
    if (!btn) return;

    e.preventDefault();
    
    currentCriteriaId = btn.dataset.id;
    document.getElementById('criteriaIdInput').value = currentCriteriaId;

    document.getElementById('milestonesModalDesc').textContent =
        btn.dataset.desc || 'Chưa có mô tả';

    try {
        const milestones = await fetchMilestones(currentCriteriaId);
        renderMilestonesTable(milestones);
        openMilestonesModal();
        if (window.IS_ADMIN && orderInput) {
            orderInput.focus();
        }
    } catch (err) {
        alert('Không thể tải mốc đánh giá');
    }
});

/* =====================
   RENDER TABLE
===================== */
function renderMilestonesTable(milestones) {
    const tbody = document.getElementById('milestonesTableBody');
    const emptyState = document.getElementById('emptyMilestonesState');

    if (!milestones.length) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }

    emptyState.style.display = 'none';

    tbody.innerHTML = milestones.map(m => `
        <tr>
            <td>#${m.order}</td>
            <td>${escapeHtml(m.name)}</td>
            ${window.IS_ADMIN ? `
                <td class="right">
                    <button class="icon-btn danger delete-milestone-btn"
                            data-id="${m.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            ` : ''}
        </tr>
    `).join('');
}

document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.delete-milestone-btn');
    if (!btn) return;

    e.preventDefault();

    const milestoneId = btn.dataset.id;

    if (!confirm('Xóa mốc đánh giá này?')) return;

    try {
        const res = await fetch(`/milestones/${milestoneId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        if (!res.ok) {
            const text = await res.text();
            console.error(text);
            throw new Error(res.status);
        }

        // Xóa dòng khỏi table
        btn.closest('tr').remove();

        // Nếu hết milestone → hiện empty state
        const tbody = document.getElementById('milestonesTableBody');
        if (!tbody.children.length) {
            document.getElementById('emptyMilestonesState').style.display = 'block';
        }

    } catch (err) {
        alert('Không thể xóa mốc đánh giá');
    }
});

/* =====================
   MODAL CONTROL
===================== */
function openMilestonesModal() {
    modal.classList.add('show');
}

function closeMilestonesModal() {
    modal.classList.remove('show');
    clearMilestonesErrors();
    form.reset();
}

document.getElementById('closeMilestonesModal')?.addEventListener('click', closeMilestonesModal);
document.getElementById('closeMilestonesBtn')?.addEventListener('click', closeMilestonesModal);
modal.querySelector('.modal-overlay')?.addEventListener('click', closeMilestonesModal);

/* =====================
   SUBMIT FORM
===================== */
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const res = await fetch('/milestones', {
        method: 'POST',
        headers: {
            Accept: 'application/json'
        },
        body: new FormData(form)
    });

    if (!res.ok) {
        const data = await res.json();
        renderMilestonesErrors(data.errors ?? []);
        return;
    }

    const milestone = await res.json();
    appendMilestoneRow(milestone);

    clearMilestonesErrors();
    
    orderInput.value = '';
    nameInput.value = '';
    orderInput.focus();
});

/* =====================
   INPUT STATE
===================== */
form.addEventListener('input', () => {
    addMilestoneBtn.disabled =
        !orderInput.value.trim() || !nameInput.value.trim();
});

/* =====================
   HELPERS
===================== */
function appendMilestoneRow(m) {
    document.getElementById('emptyMilestonesState').style.display = 'none';
    document.getElementById('milestonesTableBody')
        .insertAdjacentHTML('beforeend', `
            <tr>
                <td>#${m.order}</td>
                <td>${escapeHtml(m.name)}</td>
                <td class="right">
                    <button class="icon-btn danger delete-milestone-btn"
                            data-id="${m.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </td>
            </tr>
        `);
}

function escapeHtml(text = '') {
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function renderMilestonesErrors(errors = []) {
    const box = document.getElementById('formMilestonesErrors');
    if (!box) return;

    box.innerHTML = '';

    errors.forEach(err => {
        const span = document.createElement('span');
        span.className = 'error-message';
        span.textContent = `- ${err}`;
        box.appendChild(span);
    });
}

function clearMilestonesErrors() {
    const box = document.getElementById('formMilestonesErrors');
    if (!box) return;
    box.innerHTML = '';
}