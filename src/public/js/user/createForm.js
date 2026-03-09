document.addEventListener('DOMContentLoaded', () => {
    const createUserForm = document.getElementById('createUserForm');
    const createUserModal = document.getElementById('createUserModal');
    const openBtn = document.getElementById('openUserModal');
    const closeBtn = document.getElementById('closeUserModal');
    const cancelBtn = document.getElementById('cancelUserModal');

    const roleSelect = document.getElementById('role_id');
    const departmentSelect = document.getElementById('department_id');
    const ROLE_STAFF = '2';

    if (!createUserForm || !createUserModal || !openBtn) return;
    if (!roleSelect || !departmentSelect) return;

    openBtn.addEventListener('click', () => {
        createUserModal.classList.add('active');
    });

    const close = () => {
        createUserModal.classList.remove('active');
        clearErrors();
        createUserForm.reset();
    }

    closeBtn?.addEventListener('click', close);
    cancelBtn?.addEventListener('click', close);

    createUserForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const response = await fetch(createUserForm.action, {
            method: 'POST',
            body: new FormData(createUserForm),
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
            window.location.replace("/users?success=create");
            return;
        }

        renderErrors(data.errors);
        createUserModal.classList.add('active');
    });

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
    if (urlParams.get('success') === 'create') {
        showUserToast('Thêm người dùng thành công!');
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