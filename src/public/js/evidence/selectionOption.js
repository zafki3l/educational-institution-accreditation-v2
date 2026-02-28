async function getStandards() {
    const response = await fetch('/api/standards');
    const result = await response.json();

    result.standards.forEach(standard => {
        const option = document.createElement('option');
        option.value = standard.id;
        option.textContent = `Tiêu chuẩn ${standard.id}: ${standard.name}`;

        if (standard.id == oldStandardId) {
            option.selected = true;
        }

        standardSelect.appendChild(option);
    });

    if (oldStandardId) {
        standardSelect.dispatchEvent(new Event('change'));
    }
}


const standardSelect = document.getElementById('standardSelect');
const criteriaSelect = document.getElementById('criteriaSelect');
const milestoneSelect = document.getElementById('milestoneSelect');

const oldStandardId = standardSelect.dataset.selected;
const oldCriteriaId = criteriaSelect.dataset.selected;
const oldMilestoneId = milestoneSelect.dataset.selected;

getStandards();

standardSelect.addEventListener('change', async () => {
    const standardId = standardSelect.value;

    criteriaSelect.innerHTML = '<option value="">-- Chọn tiêu chí --</option>';
    milestoneSelect.innerHTML = '<option value="">-- Chọn mốc đánh giá --</option>';
    milestoneSelect.disabled = true;

    if (!standardId) return;

    const response = await fetch(`/api/standards/${standardId}/criterias`);
    const result = await response.json();

    result.criterias.forEach(criteria => {
        const option = document.createElement('option');
        option.value = criteria.id;
        option.textContent = `Tiêu chí ${criteria.id}: ${criteria.name}`;

        if (criteria.id == oldCriteriaId) {
            option.selected = true;
        }

        criteriaSelect.appendChild(option);
    });

    criteriaSelect.disabled = false;

    if (oldCriteriaId) {
        criteriaSelect.dispatchEvent(new Event('change'));
    }
});

criteriaSelect.addEventListener('change', async () => {
    const criteriaId = criteriaSelect.value;
    const oldMilestoneId = milestoneSelect.dataset.selected;

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

        if (milestone.id == oldMilestoneId) {
            option.selected = true;
        }

        milestoneSelect.appendChild(option);
    });

    milestoneSelect.disabled = false;
});