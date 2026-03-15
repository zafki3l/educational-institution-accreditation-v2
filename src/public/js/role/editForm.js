document.addEventListener("DOMContentLoaded", () => {
    const editRoleModal = document.getElementById("editRoleModal");
    const closeEditRoleModal = document.getElementById("closeEditRoleModal");
    const cancelEditRoleModal = document.getElementById("cancelEditRoleModal");
    const editRoleForm = document.getElementById("editRoleForm");
    const modalOverlay = editRoleModal?.querySelector(".modal-overlay");

    if (!editRoleModal || !editRoleForm) return;

    document.querySelectorAll(".edit-role-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;

            document.getElementById("edit_role_id").value = id;
            document.getElementById("edit_role_name").value = name;

            clearEditErrors();
            editRoleModal.classList.add("active");
        });
    });

    editRoleForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const response = await fetch(editRoleForm.action, {
            method: "POST",
            body: new FormData(editRoleForm),
            headers: { Accept: "application/json" }
        });

        const data = await response.json();

        if (response.ok && !data.errors) {
            editRoleModal.classList.remove("active");
            window.location.replace("/roles?success=edit");
            return;
        }

        renderEditErrors(data.errors);
        editRoleModal.classList.add("active");
    });

    const closeEditForm = () => {
        editRoleModal.classList.remove("active");
        clearEditErrors();
    };

    closeEditRoleModal?.addEventListener("click", closeEditForm);
    cancelEditRoleModal?.addEventListener("click", closeEditForm);
    modalOverlay?.addEventListener("click", (e) => {
        if (e.target.classList.contains("modal-overlay")) closeEditForm();
    });

    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    if (success === 'edit') {
        showRoleToast('Cập nhật vai trò thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    } else if (success === 'create') {
        showRoleToast('Thêm vai trò mới thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});

const renderEditErrors = (errors = []) => {
    const box = document.getElementById("editRoleFormErrors");
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
    const box = document.getElementById("editRoleFormErrors");
    if (box) box.innerHTML = "";
};

if (!window.showRoleToast) {
    window.showRoleToast = function(message) {
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
                setTimeout(() => { if (document.body.contains(toast)) toast.remove(); }, 400);
            }
        }, 4000);
    };
}
