<div class="stats-header">
    <h3>Thống kê hệ thống</h3>
    <div class="filter-buttons">
        <button>7 ngày qua</button>
        <button class="active">Tháng này</button>
    </div>
</div>

<div class="stats-grid">
    <div class="stats-card large">
        <div class="stats-card-header">
            <div>
                <h4>Thống kê số lượng tiêu chuẩn theo phòng ban quản lý</h4>
            </div>
        </div>

        <div class="bar-chart">
            <canvas id="departmentChart"></canvas>
        </div>
    </div>

    <div class="stats-card">
        <h4>Minh chứng đánh giá</h4>
        <p class="subtitle">Trạng thái phê duyệt tài liệu</p>

        <div class="donut">
            <div class="donut-inner">
                <strong>75%</strong>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div class="donut-info">
            <div>
                <small>Duyệt</small>
                <strong>106</strong>
            </div>
            <div>
                <small>Chờ</small>
                <strong>24</strong>
            </div>
            <div>
                <small>Từ chối</small>
                <strong class="danger">12</strong>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    fetch('/api/departments/standards')
.then(res => res.json())
.then(data => {

    const labels = data.department.map(d => d.name);
    const values = data.department.map(d => d.standards_count);

    new Chart(document.getElementById('departmentChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderRadius: 12,
                barThickness: 20,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            const standards = data.department[context.dataIndex].standards;
                            return standards.map(s => '• ' + s.name);
                        }
                    }
                }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
});
</script>