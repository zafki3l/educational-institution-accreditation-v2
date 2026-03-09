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
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars("{$user->first_name} {$user->last_name}") ?></td>
                <td><?= htmlspecialchars($user->email) ?></td>
                <td><span class="badge"><?= htmlspecialchars($user->role_name) ?></span></td>
                <td><?= htmlspecialchars($user->department_name ?? '') ?></td>
                <td class="right">
                    <div class="action-group">
                        <button class="icon-btn edit-user-btn"
                                type="button"
                                title="Chỉnh sửa"
                                data-id="<?= $user->id ?>">
                            <span class="material-symbols-outlined">edit</span>
                        </button>

                        <button class="icon-btn danger delete-user-btn" 
                                type="button" 
                                title="Xóa" 
                                data-id="<?= $user->id ?>" 
                                data-name="<?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?>">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>