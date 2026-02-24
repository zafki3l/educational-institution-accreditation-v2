async function getStandards() {
    const response = await fetch('/api/standards');

    if (!response.ok) {
        throw new Error('Failed to fetch standards');
    }

    const result = await response.json();
    const select = document.getElementById('standardSelect');

    result.standards.forEach(standard => {
        const option = document.createElement('option');
        option.value = standard.id;
        option.textContent = `Tiêu chuẩn ${standard.id}: ${standard.name}`;
        select.appendChild(option);
    });
}

getStandards();

const standardSelect = document.getElementById('standardSelect');
const criteriaSelect = document.getElementById('criteriaSelect');
const milestoneSelect = document.getElementById('milestoneSelect');

standardSelect.addEventListener('change', async () => {
    const standardId = standardSelect.value;

    // reset
    criteriaSelect.innerHTML = '<option value="">-- Chọn tiêu chí --</option>';
    milestoneSelect.innerHTML = '<option value="">-- Chọn minh chứng --</option>';
    milestoneSelect.disabled = true;

    if (!standardId) {
        criteriaSelect.disabled = true;
        return;
    }

    const response = await fetch(`/api/standards/${standardId}/criterias`);

    if (!response.ok) {
        throw new Error('Failed to fetch criterias');
    }

    const result = await response.json();

    result.criterias.forEach(criteria => {
        const option = document.createElement('option');
        option.value = criteria.id;
        option.textContent = `Tiêu chí ${criteria.id}: ${criteria.name}`;
        criteriaSelect.appendChild(option);
    });

    criteriaSelect.disabled = false;
});

criteriaSelect.addEventListener('change', async () => {
    const criteriaId = criteriaSelect.value;

    milestoneSelect.innerHTML = '<option value="">-- Chọn mốc đánh giá --</option>';

    if (!criteriaId) {
        milestoneSelect.disabled = true;
        return;
    }

    const response = await fetch(`/api/criterias/${criteriaId}/milestones`);

    if (!response.ok) {
        throw new Error('Failed to fetch milestones');
    }

    const result = await response.json();

    result.milestones.forEach(milestone => {
        const option = document.createElement('option');
        option.value = milestone.id;
        option.textContent = `${milestone.order} - ${milestone.name}`;
        milestoneSelect.appendChild(option);
    });

    milestoneSelect.disabled = false;
});