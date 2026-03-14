document.addEventListener("DOMContentLoaded", function () {

    const deleteModal = document.getElementById("deleteStaffModal");
    const closeBtn = document.getElementById("closeDeleteModal");
    const cancelBtn = document.getElementById("cancelDeleteModal");
    const confirmBtn = document.getElementById("confirmDeleteBtn");
    const modalOverlay = deleteModal?.querySelector(".modal-overlay");
    const deleteNameEl = document.getElementById("delete_staff_name");

    document.querySelectorAll(".delete-staff-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const staffId = this.dataset.id;
            const staffName = this.dataset.name;

            document.getElementById("delete_staff_id").value = staffId;
            if (deleteNameEl) deleteNameEl.textContent = `"${staffName}"`;

            deleteModal.classList.add("active");
        });
    });

    const closeModal = () => {
        deleteModal?.classList.remove("active");
    };

    closeBtn?.addEventListener("click", closeModal);
    cancelBtn?.addEventListener("click", closeModal);

    modalOverlay?.addEventListener("click", function (e) {
        if (e.target.classList.contains("modal-overlay")) {
            closeModal();
        }
    });

    confirmBtn.addEventListener("click", async function () {
        const staffId = document.getElementById("delete_staff_id").value;
        const csrfToken = document.getElementById("delete_csrf_token").value;

        confirmBtn.disabled = true;
        confirmBtn.textContent = "Đang xóa...";

        try {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('CSRF-token', csrfToken);

            const response = await fetch(`/staffs/${staffId}`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                }
            });

            if (response.ok) {
                window.location.replace("/staffs?success=delete");
            } else {
                alert("Không thể xóa nhân viên.");
            }

        } catch (err) {
            alert("Lỗi kết nối máy chủ.");
        }

        confirmBtn.disabled = false;
        confirmBtn.textContent = "Xóa";
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'delete') {
        showStaffToast('Xóa nhân viên thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});

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
