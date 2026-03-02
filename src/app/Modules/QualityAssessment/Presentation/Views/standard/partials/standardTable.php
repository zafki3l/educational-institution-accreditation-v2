<table>
    <thead>
        <tr>
            <th>Mã tiêu chuẩn</th>
            <th>Tên tiêu chuẩn</th>
            <th>Phòng ban</th>
            <?php if (isAdmin()): ?>
                <th class="right">Thao tác</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($standards as $standard): ?>
            <tr>
                <td><?= htmlspecialchars($standard->id) ?></td>
                <td><?= htmlspecialchars($standard->name) ?></td>
                <td><?= htmlspecialchars($standard->department->name ?? '') ?></td>

                <?php if (isAdmin()): ?>
                    <td class="right">
                        <div class="action-group">
                            <button class="icon-btn edit-standard-btn"
                                    type="button"
                                    title="Chỉnh sửa"
                                    data-id="<?= $standard->id ?>">
                                <span class="material-symbols-outlined">edit</span>
                            </button>

                            <form action="/standards/<?= htmlspecialchars($standard->id) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="CSRF-token" value="<?= $_SESSION['CSRF-token'] ?>">

                                <button class="icon-btn danger" title="Xóa" type="submit">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>