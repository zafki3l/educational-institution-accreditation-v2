<table>
    <thead>
        <tr>
            <th>Mã vai trò</th>
            <th>Tên vai trò</th>
            <th class="right">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
            <tr>
                <td><?= htmlspecialchars($role->id) ?></td>
                <td><span class="badge"><?= htmlspecialchars($role->name) ?></span></td>
                <td class="right">
                    <div class="action-group">
                        <button class="icon-btn edit-role-btn"
                                type="button"
                                title="Chỉnh sửa"
                                data-id="<?= $role->id ?>"
                                data-name="<?= htmlspecialchars($role->name) ?>">
                            <span class="material-symbols-outlined">edit</span>
                        </button>

                        <button class="icon-btn danger delete-role-btn"
                                type="button"
                                title="Xóa"
                                data-id="<?= $role->id ?>"
                                data-name="<?= htmlspecialchars($role->name) ?>">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>