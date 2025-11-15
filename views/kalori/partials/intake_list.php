<?php if (empty($intakeItems)): ?>
    <p class="empty-meal">Belum ada makanan yang ditambahkan hari ini.</p>
<?php else: ?>
    <div class="food-grid">
        <?php foreach ($intakeItems as $item): ?>
            <div class="food-item">
                <img src="<?= htmlspecialchars($item['image'] ?? '/SiSehat/public/images/default-plate.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="food-item-img" onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
                <div class="food-item-content">
                    <div class="food-item-name"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="food-item-nutrition"><?= round($item['calories'] * $item['portion_multiplier']) ?> kkal (<?= round($item['portion_multiplier'] * $item['base_grams']) ?>g)</div>
                </div>
                <div class="food-item-actions-intake">
                    <button class="btn-edit" data-id="<?= $item['id'] ?>">Edit</button>
                    <form class="form-delete-intake" style="display:inline;">
                        <input type="hidden" name="intake_id" value="<?= $item['id'] ?>">
                        <button type="submit" class="btn-delete">&times;</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>