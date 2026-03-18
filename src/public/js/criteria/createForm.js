document.addEventListener('DOMContentLoaded', () => {
    const createCriteriaForm = document.getElementById('createCriteriaForm');
    const createCriteriaModal = document.getElementById('createCriteriaModal');
    const openBtn = document.getElementById('openCriteriaModal');
    const closeBtn = document.getElementById('closeCriteriaModal');
    const cancelBtn = document.getElementById('cancelCriteriaModal');

    if (!createCriteriaForm || !createCriteriaModal || !openBtn) return;

    openBtn.addEventListener('click', () => {
        createCriteriaModal.classList.add('active');
    });

    const close = () => {
        createCriteriaModal.classList.remove('active');
        clearErrors();
        createCriteriaForm.reset();
    }

    closeBtn?.addEventListener('click', close);
    cancelBtn?.addEventListener('click', close);

    createCriteriaForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const response = await fetch(createCriteriaForm.action, {
            method: 'POST',
            body: new FormData(createCriteriaForm),
            headers: { Accept: 'application/json' }
        });

        const text = await response.text();

        let data = {};
        try {
            data = JSON.parse(text);
        } catch {
            console.error('Invalid JSON:', text);
            return;
        }

        if (response.ok && !data.errors) {
            close();
            location.reload();
            return;
        }

        renderErrors(data.errors);
        createCriteriaModal.classList.add('active');
    });
});

function renderErrors(errors = []) {
    const box = document.getElementById('formErrors');
    if (!box) return;

    box.innerHTML = '';

    errors.forEach(err => {
        const span = document.createElement('span');
        span.className = 'error-message';
        span.textContent = `- ${err}`;
        box.appendChild(span);
    });
}

function clearErrors() {
    const box = document.getElementById('formErrors');
    if (!box) return;
    box.innerHTML = '';
}

document.addEventListener('DOMContentLoaded', () => {
    const standardSelect = document.getElementById('standard_id');
    const criteriaInput = document.getElementById('id');

    let prefix = '';

    standardSelect.addEventListener('change', () => {
        if (!standardSelect.value) return;

        prefix = standardSelect.value + '.';

        if (!criteriaInput.value || !criteriaInput.value.startsWith(prefix)) {
            criteriaInput.value = prefix;
        }

        criteriaInput.focus();
        criteriaInput.setSelectionRange(prefix.length, prefix.length);
    });

    criteriaInput.addEventListener('keydown', (e) => {
        // chặn backspace xóa prefix
        if (
            e.key === 'Backspace' &&
            criteriaInput.selectionStart <= prefix.length
        ) {
            e.preventDefault();
        }
    });

    criteriaInput.addEventListener('input', () => {
        // nếu ai đó paste / sửa bậy
        if (!criteriaInput.value.startsWith(prefix)) {
            criteriaInput.value = prefix;
            criteriaInput.setSelectionRange(prefix.length, prefix.length);
        }
    });

    criteriaInput.addEventListener('click', () => {
        // không cho click vào trước prefix
        if (criteriaInput.selectionStart < prefix.length) {
            criteriaInput.setSelectionRange(prefix.length, prefix.length);
        }
    });
});