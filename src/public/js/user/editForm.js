document.addEventListener("DOMContentLoaded", () => {
    const editUserModal = document.getElementById("editUserModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const cancelEditModal = document.getElementById("cancelEditModal");
    const editUserForm = document.getElementById("editUserForm");

    const editButtons = document.querySelectorAll(".edit-user-btn");

    const roleSelect = document.getElementById('edit-role_id');
    const departmentSelect = document.getElementById('edit-department_id');
    const ROLE_STAFF = '2';

    if (!editUserModal || !editUserForm) return;
    if (!roleSelect || !departmentSelect) return;

    editButtons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;

            try {
                const response = await fetch(`/users/${id}/edit`, {
                    headers: { Accept: 'application/json' }
                });

                if (!response.ok) throw new Error();

                const user = await response.json();
                fillUserForm(user);

                clearEditErrors();
                editUserModal.classList.add("active");
            } catch (e) {
                alert("Không tải được dữ liệu user");
                console.error(e);
            }
        });
    });

    editUserForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const response = await fetch(editUserForm.action, {
            method: "POST",
            body: new FormData(editUserForm),
            headers: { Accept: "application/json" }
        });

        const data = await response.json();

        if (response.ok && !data.errors) {
            editUserModal.classList.remove("active");
            window.location.replace("/users?success=edit");
            return;
        }

        renderEditErrors(data.errors);
        editUserModal.classList.add("active");
    });

    const closeEditForm = () => {
        editUserModal.classList.remove("active");
        clearEditErrors();
    };

    closeEditModal?.addEventListener("click", closeEditForm);
    cancelEditModal?.addEventListener("click", closeEditForm);

    roleSelect.addEventListener('change', function () {
        if (this.value === ROLE_STAFF) {
            departmentSelect.disabled = false;
            departmentSelect.required = true;
        } else {
            departmentSelect.disabled = true;
            departmentSelect.required = false;
            departmentSelect.value = '';
        }
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'edit') {
        showUserToast('Cập nhật thông tin thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});

if (!window.showUserToast) {
    window.showUserToast = function(message) {
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
    };
}

const ROLE_STAFF = 2;

const fillUserForm = (user) => {
    const roleSelect = document.getElementById("edit-role_id");
    const departmentSelect = document.getElementById("edit-department_id");

    document.getElementById("edit-id").value = user.id;
    document.getElementById("edit-first_name").value = user.first_name;
    document.getElementById("edit-last_name").value = user.last_name;
    document.getElementById("edit-email").value = user.email;

    roleSelect.value = String(user.role_id);
    roleSelect.dispatchEvent(new Event('change'));
    departmentSelect.value = user.department_id ?? '';
};

const renderEditErrors = (errors = []) => {
    const box = document.getElementById("editFormErrors");
    if (!box) return;

    box.innerHTML = "";

    errors.forEach(err => {
        const span = document.createElement("span");
        span.className = "error-message";
        span.textContent = `- ${err}`;
        box.appendChild(span);
    });
};

const clearEditErrors = () => {
    const box = document.getElementById("editFormErrors");
    if (box) box.innerHTML = "";
};  