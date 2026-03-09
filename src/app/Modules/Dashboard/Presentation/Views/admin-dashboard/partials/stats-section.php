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
            Math.max(d.standards_count || 0, d.criteria_count || 0, d.evidences_count || 0)
        ),
        8
    );

    const tickCount = 8;
    const roundedMax = Math.ceil(maxVal / tickCount) * tickCount;

    let yAxisHtml = '<div class="chart-y-axis">';
    for(let i=0; i<=tickCount; i++) {
        const val = Math.round((roundedMax / tickCount) * i);
        const bottomPct = (i / tickCount) * 100;
        yAxisHtml += `<div class="chart-y-tick" style="position: absolute; bottom: ${bottomPct}%; right: 16px; transform: translateY(50%);">${val}</div>`;
    }
    yAxisHtml += '</div>';

    let gridHtml = '<div class="chart-main-area"><div class="chart-grid-bg" aria-hidden="true">';
    for(let i=0; i<tickCount; i++) {
        gridHtml += '<div class="chart-grid-line"></div>';
    }
    gridHtml += '<div class="chart-grid-line last"></div></div>';

    let barsHtml = '<div class="chart-bars-container">';
    window.chartTooltipData = {};

    data.departments.forEach((d, idx) => {

        const pctStandards = ((d.standards_count || 0) / roundedMax) * 100;
        const pctCriterias = ((d.criteria_count || 0) / roundedMax) * 100;
        const pctEvidences = ((d.evidences_count || 0) / roundedMax) * 100;

        const ttKey = 'dept_' + idx;
        window.chartTooltipData[ttKey] = d;

        barsHtml += `
            <div class="chart-col" data-tooltip-key="${ttKey}">
                <div class="chart-track">

                    <div class="chart-bar-fill standards"
                        data-height="${pctStandards}%"
                        data-type="standards"
                        data-label="Tiêu chuẩn"
                        data-count="${d.standards_count || 0}">
                    </div>

                    <div class="chart-bar-fill criterias"
                        data-height="${pctCriterias}%"
                        data-type="criterias"
                        data-label="Tiêu chí"
                        data-count="${d.criteria_count || 0}">
                    </div>

                    <div class="chart-bar-fill evidences"
                        data-height="${pctEvidences}%"
                        data-type="evidences"
                        data-label="Minh chứng"
                        data-count="${d.evidences_count || 0}">
                    </div>

                </div>

                <div class="chart-col-label">${d.id || d.department_id || 'P' + (idx+1)}</div>
            </div>
            `;
    });

    barsHtml += '</div></div>'; 

    container.innerHTML = yAxisHtml + gridHtml + barsHtml;

    setTimeout(() => {
        document.querySelectorAll('.chart-bar-fill').forEach(bar => {
            bar.style.height = bar.dataset.height;
        });
    }, 100);

    let tooltip = document.getElementById('chart-tooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id = 'chart-tooltip';
        document.body.appendChild(tooltip);
    }

    const bars = container.querySelectorAll('.chart-bar-fill');
    bars.forEach(bar => {
        bar.addEventListener('mouseenter', (e) => {
            const col = bar.closest('.chart-col');
            const key = col.getAttribute('data-tooltip-key');
            const deptData = window.chartTooltipData[key];
            if (!deptData) return;

            const type = bar.getAttribute('data-type'); 
            const label = bar.getAttribute('data-label');
            const count = bar.getAttribute('data-count');

            bar.removeAttribute('title');

            const deptName = deptData.name || deptData.department_name || deptData.id || 'Phòng ban';

            tooltip.innerHTML = `
                <div class="chart-tooltip-title" style="border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 6px; margin-bottom: 6px;">
                    Phòng ban: ${deptName}
                </div>
                <div class="chart-tooltip-value" style="font-size: 14px;">
                    ${label}: <strong>${count}</strong>
                </div>
            `;
            tooltip.classList.add('visible');
            tooltip.style.position = 'fixed'; 
        });

        bar.addEventListener('mousemove', (e) => {
            let x = e.clientX + 15;
            let y = e.clientY + 15;
            
            if (x + 250 > window.innerWidth) {
                x = e.clientX - Math.max(200, tooltip.offsetWidth + 15);
            }
            if (y + tooltip.offsetHeight + 15 > window.innerHeight) {
                y = e.clientY - (tooltip.offsetHeight + 15);
            }

            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        });

        bar.addEventListener('mouseleave', () => {
            tooltip.classList.remove('visible');
        });
    });
});
</script>