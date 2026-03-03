<aside class="sidebar">
    <nav>
        <p class="sidebar-title">QUẢN LÝ BỘ TIÊU CHUẨN ĐÁNH GIÁ</p>

        <?php if (isAdmin()): ?>
            <a class="sidebar-item" href="/standards">Quản lý tiêu chuẩn đánh giá</a>
            <a class="sidebar-item" href="/criterias">Quản lý tiêu chí đánh giá</a>
        <?php else: ?>
            <a class="sidebar-item" href="/standards">Danh sách tiêu chuẩn đánh giá</a>
            <a class="sidebar-item" href="/criterias">Danh sách tiêu chí đánh giá</a>
        <?php endif; ?>

        <div class="sidebar-group">
            <div class="sidebar-item sidebar-toggle">
                Quản lý minh chứng đánh giá
                <span class="material-symbols-outlined toggle-icon">
                    expand_more
                </span>
            </div>

            <div class="sidebar-sub">
                <?php if (isset($sidebarStandards) && !empty($sidebarStandards)): ?>
                    <ul class="sidebar-tree">
                        <?php foreach ($sidebarStandards as $standard): ?>
                            <li class="sidebar-standard">
                                <button
                                    type="button"
                                    class="sidebar-standard-toggle"
                                    data-target="standard-<?= htmlspecialchars($standard->id) ?>"
                                >
                                    <span class="material-symbols-outlined toggle-icon">
                                        expand_more
                                    </span>
                                    <span class="sidebar-standard-code">
                                        Tiêu chuẩn <?= htmlspecialchars($standard->id) ?>
                                    </span>
                                </button>

                                <?php $criterias = $standard->criteria ?? []; ?>
                                <?php if (!empty($criterias)): ?>
                                    <ul
                                        id="standard-<?= htmlspecialchars($standard->id) ?>"
                                        class="sidebar-criteria-list"
                                    >
                                        <?php foreach ($criterias as $sidebarCriteria): ?>
                                            <li class="sidebar-criteria">
                                                <a
                                                    class="sidebar-criteria-link"
                                                    href="/criterias/<?= htmlspecialchars($sidebarCriteria->id) ?>/evidences"
                                                >
                                                    <span class="sidebar-criteria-code">
                                                        Tiêu chí <?= htmlspecialchars($sidebarCriteria->id) ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="sidebar-empty">
                        Chưa có dữ liệu tiêu chuẩn/tiêu chí để hiển thị.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</aside>

<script src="/js/sidebar.js"></script>