<aside class="sidebar">
    <nav>
        <p class="sidebar-title">TÌM KIẾM MINH CHỨNG</p>
        <div class="sidebar-group">
            <?php if (isset($standards) && !empty($standards)): ?>
                <ul class="sidebar-tree">
                    <?php foreach ($standards as $standard): ?>
                        <li class="sidebar-standard">
                            <button
                                type="button"
                                class="sidebar-standard-toggle"
                                data-target="standard-<?= htmlspecialchars($standard->id) ?>">
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
                                    class="sidebar-criteria-list">
                                    <?php foreach ($criterias as $sidebarCriteria): ?>
                                        <li class="sidebar-criteria">
                                            <a
                                                class="sidebar-criteria-link"
                                                href="/evidences/results?standard_id=<?= htmlspecialchars($standard->id) ?>&criteria_id=<?= htmlspecialchars($sidebarCriteria->id) ?>">
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
    </nav>
</aside>

<script src="/js/sidebar.js"></script>