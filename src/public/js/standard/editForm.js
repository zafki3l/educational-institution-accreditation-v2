document.addEventListener('DOMContentLoaded', () => {
    const editStandardModal = document.getElementById('editStandardModal');
    const editStandardForm = document.getElementById('editStandardForm');
    const closeBtn = document.getElementById('closeEditStandardModal');
    const cancelBtn = document.getElementById('cancelEditStandardModal');
    const errorBox = document.getElementById('editStandardFormErrors');

    if (!editStandardModal || !editStandardForm) return;

    const close = () => {
        editStandardModal.classList.remove('active');
        editStandardForm.reset();
        clearErrors();
    };

    closeBtn?.addEventListener('click', close);
    cancelBtn?.addEventListener('click', close);

    document.querySelectorAll('.edit-standard-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const departmentId = btn.dataset.departmentId;

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_department_id').value = departmentId;

            editStandardForm.action = `/standards/${id}`;
            editStandardModal.classList.add('active');
        });
    });

    editStandardForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const response = await fetch(editStandardForm.action, {
            method: 'POST',
            body: new FormData(editStandardForm),
            headers: { Accept: 'application/json' }
        });

        const text = await response.text();
        let data = {};
        try {
            data = JSON.parse(text);
        } catch {
            console.error('Invalid JSON:', text);
            // Optionally show general error in errorBox
            errorBox.innerHTML = '<span class="error-message">- Có lỗi hệ thống xảy ra. Vui lòng thử lại sau.</span>';
            return;
        }

        if (response.ok && !data.errors) {
            close();
            window.location.replace("/standards?success=update");
            return;
        }

        renderErrors(data.errors);
    });

    function renderErrors(errors = []) {
        errorBox.innerHTML = '';
        errors.forEach(err => {
            const span = document.createElement('span');
            span.className = 'error-message';
            span.textContent = `- ${err}`;
            errorBox.appendChild(span);
        });
    }

    function clearErrors() {
        errorBox.innerHTML = '';
    }
});
