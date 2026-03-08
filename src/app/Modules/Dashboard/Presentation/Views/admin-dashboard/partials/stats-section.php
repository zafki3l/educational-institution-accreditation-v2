<div class="stats-grid">
    <div class="stats-card large">
        <div class="stats-card-header">
            <div>
                <h4>Thống kê số lượng tiêu chuẩn theo phòng ban quản lý</h4>
            </div>
        </div>

        <div id="custom-bar-chart-container" class="custom-bar-chart">
        </div>
    </div>
</div>

<script>
fetch('/api/departments/standards')
.then(res => res.json())
.then(data => {

    const container = document.getElementById('custom-bar-chart-container');

    if (!data.departments || data.departments.length === 0) {
        container.innerHTML = '<p style="text-align:center;color:#94a3b8">Chưa có dữ liệu</p>';
        return;
    }

    const maxVal = Math.max(
        ...data.departments.map(d =>
            Math.max(d.standards_count, d.criteria_count, d.evidences_count)
        ),
        8
    );

    const tickCount = 8;
    const roundedMax = Math.ceil(maxVal / tickCount) * tickCount;

    let html = '<div class="chart-bars-container">';

    data.departments.forEach((d, idx) => {

        const pctStandards = ((d.standards_count || 0) / roundedMax) * 100;
        const pctCriterias = ((d.criteria_count || 0) / roundedMax) * 100;
        const pctEvidences = ((d.evidences_count || 0) / roundedMax) * 100;

        html += `
            <div class="chart-col">
                <div class="chart-track">

                    <div class="chart-bar-fill standards"
                        data-height="${pctStandards}%"
                        title="Tiêu chuẩn: ${d.standards_count}">
                    </div>

                    <div class="chart-bar-fill criterias"
                        data-height="${pctCriterias}%"
                        title="Tiêu chí: ${d.criteria_count}">
                    </div>

                    <div class="chart-bar-fill evidences"
                        data-height="${pctEvidences}%"
                        title="Minh chứng: ${d.evidences_count}">
                    </div>

                </div>

                <div class="chart-col-label">${d.id}</div>
            </div>
            `;
    });

    html += '</div>';

    container.innerHTML = html;

    setTimeout(() => {
        document.querySelectorAll('.chart-bar-fill').forEach(bar => {
            bar.style.height = bar.dataset.height;
        });
    }, 100);

    document.querySelectorAll('.chart-bar-fill').forEach(bar => {
    console.log(bar.dataset.height);
});
});
</script>