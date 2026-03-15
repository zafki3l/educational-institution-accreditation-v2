document.addEventListener("DOMContentLoaded", function () {

    const deleteModal = document.getElementById("deleteRoleModal");
    const closeBtn = document.getElementById("closeDeleteRoleModal");
    const cancelBtn = document.getElementById("cancelDeleteRoleModal");
    const confirmBtn = document.getElementById("confirmDeleteRoleBtn");
    const modalOverlay = deleteModal?.querySelector(".modal-overlay");
    const deleteNameEl = document.getElementById("delete_role_name");

    document.querySelectorAll(".delete-role-btn").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;

            document.getElementById("delete_role_id").value = id;
            if (deleteNameEl) deleteNameEl.textContent = `"${name}"`;

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

        const id = document.getElementById("delete_role_id").value;
        const csrfToken = document.getElementById("delete_role_csrf_token").value;

        confirmBtn.disabled = true;
        confirmBtn.textContent = "Đang xóa...";

        try {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('CSRF-token', csrfToken);

            const response = await fetch(`/roles/${id}`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Accept": "application/json"
                }
            });

            if (response.ok) {
                window.location.replace("/roles?success=delete");
            } else {
                alert("Không thể xóa vai trò.");
            }

        } catch (err) {
            alert("Lỗi kết nối máy chủ.");
        }

        confirmBtn.disabled = false;
        confirmBtn.textContent = "Xóa";
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'delete') {
        showRoleToast('Xóa vai trò thành công!');
        window.history.replaceState(null, '', window.location.pathname);
    }
});
