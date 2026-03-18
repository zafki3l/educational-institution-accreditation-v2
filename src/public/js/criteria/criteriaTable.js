document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        const standardId = btn.dataset.standardId;

        const saved = localStorage.getItem(`standard-${standardId}-expanded`);
        const expanded = saved !== 'false';

        btn.setAttribute('aria-expanded', String(expanded));
        toggleRows(standardId, expanded);

        btn.addEventListener('click', e => {
            e.preventDefault();

            const isExpanded =
                btn.getAttribute('aria-expanded') === 'true';

            const nextState = !isExpanded;
            btn.setAttribute('aria-expanded', String(nextState));

            toggleRows(standardId, nextState);
            localStorage.setItem(
                `standard-${standardId}-expanded`,
                String(nextState)
            );
        });
    });

    function toggleRows(standardId, expanded) {
        document
            .querySelectorAll(
                `.criteria-row[data-parent-standard="${standardId}"]`
            )
            .forEach(row => {
                row.style.display = expanded ? '' : 'none';
            });
    }
});

document.querySelectorAll('.criteria-name').forEach(el => {
    el.addEventListener('click', () => {
        el.classList.toggle('expanded');
    });
});

// Delete Modal Functionality
document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('deleteConfirmModal');
    const closeDeleteBtn = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const deleteNameEl = document.getElementById('criteriaDeleteName');
    const modalOverlay = deleteModal?.querySelector('.modal-overlay');
    let deleteId = null;

    // Open delete modal
    document.querySelectorAll('.delete-criteria-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            deleteId = btn.dataset.id;
            const criteriaName = btn.dataset.name;
            deleteNameEl.textContent = `"${criteriaName}"`;
            deleteModal.classList.add('active');
        });
    });

    // Close modal
    const closeModal = () => {
        deleteModal.classList.remove('active');
        deleteId = null;
    };

    closeDeleteBtn.addEventListener('click', closeModal);
    cancelDeleteBtn.addEventListener('click', closeModal);

    // Close modal when clicking overlay
    modalOverlay?.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    });

    // Confirm delete
    confirmDeleteBtn.addEventListener('click', () => {
        if (deleteId) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/criterias/${deleteId}`;

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = 'CSRF-token';
            tokenInput.value = document.querySelector('input[name="CSRF-token"]')?.value || '';

            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
