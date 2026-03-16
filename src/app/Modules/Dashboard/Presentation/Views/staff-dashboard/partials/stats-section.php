<div class="stats-grid">
    <div class="stats-card large">
        <div class="stats-card-header">
            <div>
                <h4>Thống kê tiêu chí và minh chứng theo tiêu chuẩn</h4>
                <small style="color:#94a3b8;">Dữ liệu theo các tiêu chuẩn của phòng ban của bạn quản lý</small>
            </div>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-dot criterias-dot"></span>Tiêu chí</span>
                <span class="legend-item"><span class="legend-dot evidences-dot"></span>Minh chứng</span>
            </div>
        </div>

        <div id="staff-bar-chart-container" class="custom-bar-chart">
        </div>
    </div>
</div>

<script>
fetch('/api/staff/standards')
.then(res => res.json())
.then(data => {

    const container = document.getElementById('staff-bar-chart-container');

    if (!data.standards || data.standards.length === 0) {
        container.innerHTML = '<p style="text-align:center;color:#94a3b8;padding:40px;">Phòng ban của bạn chưa có tiêu chuẩn nào.</p>';
        return;
    }

    const maxVal = Math.max(
        ...data.standards.map(s =>
            Math.max(s.criteria_count || 0, s.evidences_count || 0)
        ),
        8
    );

    const tickCount = 8;
    const roundedMax = Math.ceil(maxVal / tickCount) * tickCount;

    let yAxisHtml = '<div class="chart-y-axis">';
    for(let i = 0; i <= tickCount; i++) {
        const val = Math.round((roundedMax / tickCount) * i);
        const bottomPct = (i / tickCount) * 100;
        yAxisHtml += `<div class="chart-y-tick" style="position: absolute; bottom: ${bottomPct}%; right: 16px; transform: translateY(50%);">${val}</div>`;
    }
    yAxisHtml += '</div>';

    let gridHtml = '<div class="chart-main-area"><div class="chart-grid-bg" aria-hidden="true">';
    for(let i = 0; i < tickCount; i++) {
        gridHtml += '<div class="chart-grid-line"></div>';
    }
    gridHtml += '<div class="chart-grid-line last"></div></div>';

    let barsHtml = '<div class="chart-bars-container">';
    window.staffChartTooltipData = {};

    data.standards.forEach((s, idx) => {
        const pctCriterias = ((s.criteria_count || 0) / roundedMax) * 100;
        const pctEvidences = ((s.evidences_count || 0) / roundedMax) * 100;

        const ttKey = 'std_' + idx;
        window.staffChartTooltipData[ttKey] = s;

        barsHtml += `
            <div class="chart-col" data-tooltip-key="${ttKey}">
                <div class="chart-track">

                    <div class="chart-bar-fill criterias"
                        data-height="${pctCriterias}%"
                        data-type="criterias"
                        data-label="Tiêu chí"
                        data-count="${s.criteria_count || 0}">
                    </div>

                    <div class="chart-bar-fill evidences"
                        data-height="${pctEvidences}%"
                        data-type="evidences"
                        data-label="Minh chứng"
                        data-count="${s.evidences_count || 0}">
                    </div>

                </div>
                <div class="chart-col-label">Tiêu chuẩn ${s.id || (idx+1)}</div>
            </div>
            `;
    });

    barsHtml += '</div></div>';

    container.innerHTML = yAxisHtml + gridHtml + barsHtml;

    setTimeout(() => {
        document.querySelectorAll('#staff-bar-chart-container .chart-bar-fill').forEach(bar => {
            bar.style.height = bar.dataset.height;
        });
    }, 100);

    let tooltip = document.getElementById('staff-chart-tooltip');
    if (!tooltip) {
        tooltip = document.createElement('div');
        tooltip.id = 'staff-chart-tooltip';
        tooltip.className = '';
        tooltip.style.cssText = 'position:fixed;z-index:10000;pointer-events:none;opacity:0;transition:opacity 0.2s ease;background-color:#0f172a;color:#f8fafc;padding:12px 16px;border-radius:8px;font-size:13px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);white-space:nowrap;';
        document.body.appendChild(tooltip);
    }

    const bars = container.querySelectorAll('.chart-bar-fill');
    bars.forEach(bar => {
        bar.addEventListener('mouseenter', () => {
            const col = bar.closest('.chart-col');
            const key = col.getAttribute('data-tooltip-key');
            const stdData = window.staffChartTooltipData[key];
            if (!stdData) return;

            const label = bar.getAttribute('data-label');
            const count = bar.getAttribute('data-count');
            const stdName = stdData.name || stdData.id || 'Tiêu chuẩn';

            tooltip.innerHTML = `
                <div style="font-weight:600;font-size:14px;border-bottom:1px solid rgba(255,255,255,0.15);padding-bottom:6px;margin-bottom:6px;color:#e2e8f0;">
                    ${stdName}
                </div>
                <div style="color:#94a3b8;font-size:13px;">
                    ${label}: <strong style="color:#f8fafc;">${count}</strong>
                </div>
            `;
            tooltip.style.opacity = '1';
        });

        bar.addEventListener('mousemove', (e) => {
            let x = e.clientX + 15;
            let y = e.clientY + 15;
            if (x + 250 > window.innerWidth) x = e.clientX - 220;
            if (y + 80 > window.innerHeight) y = e.clientY - 80;
            tooltip.style.left = x + 'px';
            tooltip.style.top = y + 'px';
        });

        bar.addEventListener('mouseleave', () => {
            tooltip.style.opacity = '0';
        });
    });
})
.catch(() => {
    document.getElementById('staff-bar-chart-container').innerHTML =
        '<p style="text-align:center;color:#94a3b8;padding:40px;">Không thể tải dữ liệu biểu đồ.</p>';
});
</script>
