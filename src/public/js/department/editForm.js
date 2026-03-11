document.addEventListener('DOMContentLoaded', () => {
    const editDepartmentForm = document.getElementById('editDepartmentForm');
    const editDepartmentModal = document.getElementById('editDepartmentModal');
    const closeBtn = document.getElementById('closeEditDepartmentModal');
    const cancelBtn = document.getElementById('cancelEditDepartmentModal');
    const modalOverlay = editDepartmentModal?.querySelector(".modal-overlay");

    const editIdInput = document.getElementById('edit_id');
    const editNameInput = document.getElementById('edit_name');

    if (!editDepartmentForm || !editDepartmentModal) return;

    document.querySelectorAll(".edit-department-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;

            editIdInput.value = id;
            editNameInput.value = name;
            editDepartmentForm.action = `/departments/${id}`;

            editDepartmentModal.classList.add("active");
        });
    });

    const closeEditModal = () => {
        editDepartmentModal.classList.remove('active');
        clearEditErrors();
        editDepartmentForm.reset();
        editDepartmentForm.action = '';
    }

    closeBtn?.addEventListener('click', closeEditModal);
    cancelBtn?.addEventListener('click', closeEditModal);

    modalOverlay?.addEventListener("click", function (e) {
        if (e.target.classList.contains("modal-overlay")) {
            closeEditModal();
        }
    });

    editDepartmentForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const response = await fetch(editDepartmentForm.action, {
            method: 'POST',
            body: new FormData(editDepartmentForm),
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
            closeEditModal();
            window.location.replace("/departments?success=edit");
            return;
        }

        renderEditErrors(data.errors);
        editDepartmentModal.classList.add('active');
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'edit') {
        showDepartmentToast('Cập nhật phòng ban thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});

function renderEditErrors(errors = []) {
    const box = document.getElementById('editFormErrors');
    if (!box) return;

    box.innerHTML = '';

    errors.forEach(err => {
        const span = document.createElement('span');
        span.className = 'error-message';
        span.textContent = `- ${err}`;
        box.appendChild(span);
    });
}

function clearEditErrors() {
    const box = document.getElementById('editFormErrors');
    if (!box) return;
    box.innerHTML = '';
}
