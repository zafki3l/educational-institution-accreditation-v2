<div class="card">
    <div class="card-body">
        <h2>Quản lý bộ tiêu chuẩn đánh giá</h2>
        <p class="subtitle">
            Quản lý tiêu chuẩn, tiêu chí, mốc đánh giá và minh chứng
        </p>

        <div class="grid-2">
            <a href="/standards">
                <div class="item">
                    <h4>Quản lý tiêu chuẩn đánh giá</h4>
                    <span><?= htmlspecialchars($total_standards) ?> tiêu chuẩn</span>
                </div>
            </a>

            <a href="/criterias">
                <div class="item">
                    <h4>Quản lý tiêu chí đánh giá</h4>
                    <span><?= htmlspecialchars($total_criterias) ?> tiêu chí</span>
                </div>
            </a>
    
            <a href="/criterias">
                <div class="item">
                    <h4>Quản lý mốc đánh giá</h4>
                    <span><?= htmlspecialchars($total_milestones) ?> Mốc đánh giá</span>
                </div>
            </a>
            
            <a href="/criterias/1.1/evidences">
                <div class="item">
                    <h4>Quản lý minh chứng</h4>
                    <span><?= htmlspecialchars($total_evidences) ?> Minh chứng</span>
                </div>
            </a>
        </div>
    </div>
</div>