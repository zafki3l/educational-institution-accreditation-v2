<div class="card">
    <div class="card-body">
        <h2>Bộ tiêu chuẩn đánh giá</h2>
        <p class="subtitle">
            Danh sách tiêu chuẩn, tiêu chí, mốc đánh giá và minh chứng
        </p>

        <div class="grid-2">
            <a href="/standards">
                <div class="item">
                    <h4>Danh sách tiêu chuẩn đánh giá</h4>
                    <span><?= htmlspecialchars($total_standards) ?> tiêu chuẩn</span>
                </div>
            </a>

            <a href="/criterias">
                <div class="item">
                    <h4>Danh sách tiêu chí đánh giá</h4>
                    <span><?= htmlspecialchars($total_criterias) ?> tiêu chí</span>
                </div>
            </a>
    
            <a href="/criterias">
                <div class="item">
                    <h4>Danh sách mốc đánh giá</h4>
                    <span><?= htmlspecialchars($total_milestones) ?> Mốc đánh giá</span>
                </div>
            </a>
            
            <a href="/criterias/<?= htmlspecialchars($first_criteria_id) ?>/evidences">
                <div class="item">
                    <h4>Quản lý minh chứng</h4>
                    <span><?= htmlspecialchars($total_evidences) ?> Minh chứng</span>
                </div>
            </a>
        </div>
    </div>
</div>