document.addEventListener("DOMContentLoaded", () => {
    const editStaffModal = document.getElementById("editStaffModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const cancelEditModal = document.getElementById("cancelEditModal");
    const editStaffForm = document.getElementById("editStaffForm");

    const editButtons = document.querySelectorAll(".edit-staff-btn");

    if (!editStaffModal || !editStaffForm) return;

    editButtons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;

            try {
                const response = await fetch(`/staffs/${id}/edit`, {
                    headers: { Accept: 'application/json' }
                });

                if (!response.ok) throw new Error();

                const staff = await response.json();
                fillStaffForm(staff);

                clearEditErrors();
                editStaffModal.classList.add("active");
            } catch (e) {
                alert("Không tải được dữ liệu nhân viên");
                console.error(e);
            }
        });
    });

    editStaffForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const response = await fetch(editStaffForm.action, {
            method: "POST",
            body: new FormData(editStaffForm),
            headers: { Accept: "application/json" }
        });

        const data = await response.json();

        if (response.ok && !data.errors) {
            editStaffModal.classList.remove("active");
            window.location.replace('/staffs?success=edit');
            return;
        }

        renderEditErrors(data.errors);
        editStaffModal.classList.add("active");
    });

    const closeEditForm = () => {
        editStaffModal.classList.remove("active");
        clearEditErrors();
    };

    closeEditModal?.addEventListener("click", closeEditForm);
    cancelEditModal?.addEventListener("click", closeEditForm);

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'edit') {
        showStaffToast('Cập nhật nhân viên thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});

const fillStaffForm = (staff) => {
    document.getElementById("edit-id").value = staff.id;
    document.getElementById("edit-first_name").value = staff.first_name;
    document.getElementById("edit-last_name").value = staff.last_name;
    document.getElementById("edit-email").value = staff.email;
    document.getElementById("edit-department_id").value = staff.department_id ?? '';
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

if (!window.showStaffToast) {
    window.showStaffToast = function(message) {
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
            margin-bottom: 10px;
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
