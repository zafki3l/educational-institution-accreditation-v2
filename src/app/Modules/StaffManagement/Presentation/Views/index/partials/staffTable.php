<table>
    <thead>
        <tr>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Phòng ban</th>
            <th class="right">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($staffs as $staff): ?>
            <tr>
                <td><?= htmlspecialchars("{$staff->first_name} {$staff->last_name}") ?></td>
                <td><?= htmlspecialchars($staff->email) ?></td>
                <td><span class="badge"><?= htmlspecialchars($staff->role_name) ?></span></td>
                <td><?= htmlspecialchars($staff->department_name ?? '') ?></td>
                <td class="right">
                    <div class="action-group">
                        <button class="icon-btn edit-staff-btn"
                                type="button"
                                title="Chỉnh sửa"
                                data-id="<?= $staff->id ?>">
                            <span class="material-symbols-outlined">edit</span>
                        </button>

                        <button class="icon-btn danger delete-staff-btn" 
                                title="Xóa" 
                                type="button"
                                data-id="<?= $staff->id ?>"
                                data-name="<?= htmlspecialchars("{$staff->first_name} {$staff->last_name}") ?>">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>