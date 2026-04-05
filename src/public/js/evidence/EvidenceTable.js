document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('evidence-milestones-table');
    if (!table) return;

    const tbody = document.getElementById('evidence-milestones-tbody');
    const toggleRows = (milestoneId, expanded) => {
        if (!tbody || milestoneId == null || milestoneId === '') return;
        tbody
            .querySelectorAll(
                `.criteria-row[data-parent-milestone="${milestoneId}"]`
            )
            .forEach(row => {
                row.style.display = expanded ? '' : 'none';
            });
    };

    table.querySelectorAll('.toggle-btn').forEach(btn => {
        const milestoneId = btn.dataset.milestoneId;

        const saved = localStorage.getItem(`evidence-milestone-${milestoneId}-expanded`);
        const expanded = saved !== 'false';

        btn.setAttribute('aria-expanded', String(expanded));
        toggleRows(milestoneId, expanded);

        btn.addEventListener('click', (e) => {
            e.preventDefault();

            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            const nextState = !isExpanded;
            btn.setAttribute('aria-expanded', String(nextState));

            toggleRows(milestoneId, nextState);
            localStorage.setItem(
                `evidence-milestone-${milestoneId}-expanded`,
                String(nextState)
            );
        });
    });
});

document.querySelectorAll('.evidence-name').forEach(el => {
    el.addEventListener('click', () => {
        el.classList.toggle('expanded');
    });
});