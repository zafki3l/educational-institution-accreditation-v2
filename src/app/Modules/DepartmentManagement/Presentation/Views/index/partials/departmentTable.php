<table>
    <thead>
        <tr>
            <th>Mã phòng ban</th>
            <th>Tên phòng ban</th>
            <th class="right">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($departments as $department): ?>
            <tr>
                <td><?= htmlspecialchars($department->id) ?></td>
                <td><?= htmlspecialchars($department->name) ?></td>
                <td class="right">
                    <div class="action-group">
                        <button class="icon-btn edit-department-btn"
                                type="button"
                                title="Chỉnh sửa"
                                data-id="<?= htmlspecialchars($department->id) ?>"
                                data-name="<?= htmlspecialchars($department->name) ?>">
                            <span class="material-symbols-outlined">edit</span>
                        </button>

                        <button class="icon-btn danger delete-department-btn" 
                                type="button" 
                                title="Xóa" 
                                data-id="<?= htmlspecialchars($department->id) ?>" 
                                data-name="<?= htmlspecialchars($department->name) ?>">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>