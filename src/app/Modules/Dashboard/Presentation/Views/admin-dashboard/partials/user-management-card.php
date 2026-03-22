<div class="card">
    <div class="card-body">
        <h2>Quản lý người dùng</h2>
        <p class="subtitle">
            Quản lý tài khoản người dùng, phòng ban, nhân viên và cập nhật quyền
        </p>

        <div class="grid-2">
            <a href="/users">
                <div class="item">
                    <h4>Quản lý tài khoản người dùng</h4>
                    <span><?= htmlspecialchars($overview->userManagement->total_users) ?> người dùng</span>
                </div>
            </a>

            <a href="/departments">
                <div class="item">
                    <h4>Quản lý phòng ban</h4>
                    <span><?= htmlspecialchars($overview->userManagement->total_departments) ?> phòng ban</span>
                </div>
            </a>

            <a href="/staffs">
                <div class="item">
                    <h4>Quản lý nhân viên</h4>
                    <span><?= htmlspecialchars($overview->userManagement->total_staffs) ?> nhân viên</span>
                </div>
            </a>

            <a href="/roles">
                <div class="item">
                    <h4>Cập nhật vai trò</h4>
                    <span><?= htmlspecialchars($overview->userManagement->total_roles) ?> vai trò</span>
                </div>
            </a>
        </div>
    </div>
</div>