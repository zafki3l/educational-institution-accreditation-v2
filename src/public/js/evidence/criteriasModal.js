/* =====================
   GLOBAL STATE
===================== */
let currentCriteriaId = null;

/* =====================
   ELEMENTS
===================== */
const modal = document.getElementById('criteriasModal');
const form = document.getElementById('addCriteriaForm');
const orderInput = document.getElementById('newCriteriaOrder');
const nameInput = document.getElementById('newCriteriaName');
const csrfToken = document.querySelector('input[name="CSRF-token"]')?.value;
const addCriteriaBtn = document.getElementById('addCriteriaBtn');

/* =====================
   FETCH
===================== */
async function fetchCriterias(criteriaId) {
    const res = await fetch(`/criterias/${criteriaId}`);
    if (!res.ok) throw new Error(res.status);

    const data = await res.json();
    return data.criteria.children ?? [];
}

/* =====================
   OPEN MODAL
===================== */
document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.criteria-btn');
    if (!btn) return;

    e.preventDefault();

    const criteriaId = btn.dataset.id;
    const criteriaName = btn.dataset.name;
    const mainCriteria = btn.dataset.mainCriteria;

    document.getElementById('criteriasModalName').textContent = criteriaName;

    document.getElementById('criteriaIdInput').value = criteriaId;
    document.getElementById('mainCriteriaIdInput').value = mainCriteria;

    openCriteriasModal();

});

/* =====================
   RENDER TABLE
===================== */
function renderCriteriasTable(criterias) {

    const tbody = document.getElementById('criteriasTableBody');
    const emptyState = document.getElementById('emptyCriteriasState');

    if (!criterias.length) {
        tbody.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }

    emptyState.style.display = 'none';

    tbody.innerHTML = criterias.map(c => `
        <tr>
            <td>#${c.order}</td>
            <td>${escapeHtml(c.name)}</td>
            <td class="right">
                <button class="icon-btn danger delete-criteria-btn"
                        data-id="${c.id}">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </td>
        </tr>
    `).join('');
}

/* =====================
   DELETE CRITERIA
===================== */
document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.delete-criteria-btn');
    if (!btn) return;

    e.preventDefault();

    const criteriaId = btn.dataset.id;

    if (!confirm('Xóa tiêu chí này?')) return;

    try {

        const res = await fetch(`/criterias/${criteriaId}`, {
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

        btn.closest('tr').remove();

        const tbody = document.getElementById('criteriasTableBody');

        if (!tbody.children.length) {
            document.getElementById('emptyCriteriasState').style.display = 'block';
        }

    } catch (err) {
        alert('Không thể xóa tiêu chí');
    }

});

/* =====================
   MODAL CONTROL
===================== */

function openCriteriasModal() {
    document
        .getElementById('criteriasModal')
        .classList
        .add('show');
}
function closeCriteriasModal() {
    document
        .getElementById('criteriasModal')
        .classList
        .remove('show');
}

document.getElementById('closeCriteriasModal')
?.addEventListener('click', closeCriteriasModal);

document.getElementById('closeCriteriasBtn')
?.addEventListener('click', closeCriteriasModal);

document
.querySelector('#criteriasModal .modal-overlay')
?.addEventListener('click', closeCriteriasModal);

/* =====================
   SUBMIT FORM
===================== */

form.addEventListener('submit', async (e) => {

    e.preventDefault();

    const res = await fetch('/criterias', {
        method: 'POST',
        headers: {
            Accept: 'application/json'
        },
        body: new FormData(form)
    });

    if (!res.ok) {

        const data = await res.json();
        renderCriteriaErrors(data.errors ?? []);
        return;

    }

    const criteria = await res.json();

    appendCriteriaRow(criteria);

    clearCriteriaErrors();

    orderInput.value = '';
    nameInput.value = '';

    orderInput.focus();

});

/* =====================
   INPUT STATE
===================== */

form.addEventListener('input', () => {

    addCriteriaBtn.disabled =
        !orderInput.value.trim() ||
        !nameInput.value.trim();

});

/* =====================
   HELPERS
===================== */

function appendCriteriaRow(c) {

    document.getElementById('emptyCriteriasState').style.display = 'none';

    document
        .getElementById('criteriasTableBody')
        .insertAdjacentHTML('beforeend', `
            <tr>
                <td>#${c.order}</td>
                <td>${escapeHtml(c.name)}</td>
                <td class="right">
                    <button class="icon-btn danger delete-criteria-btn"
                            data-id="${c.id}">
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

/* =====================
   ERROR UI
===================== */

function renderCriteriaErrors(errors = []) {

    const box = document.getElementById('formCriteriasErrors');

    if (!box) return;

    box.innerHTML = '';

    errors.forEach(err => {

        const span = document.createElement('span');

        span.className = 'error-message';
        span.textContent = `- ${err}`;

        box.appendChild(span);

    });

}

function clearCriteriaErrors() {

    const box = document.getElementById('formCriteriasErrors');

    if (!box) return;

    box.innerHTML = '';

}