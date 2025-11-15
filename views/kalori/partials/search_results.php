<?php foreach ($filteredFoods as $food): ?>
    <?php $calPer100g = round(($food['calories'] / $food['base_grams']) * 100); ?>
    
    <form class="form-add-intake food-item">
        <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
        
        <img src="<?= htmlspecialchars($food['image'] ?? '/SiSehat/public/images/default-plate.jpg') ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="food-item-img" onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
        
        <div class="food-item-content">
            <div class="food-item-name"><?= htmlspecialchars($food['name']) ?></div>
            <div class="food-item-nutrition"><?= $calPer100g ?> kkal / 100g</div>
        </div>
        
        <div class="food-item-actions">
            <div class="food-item-grams-wrapper">
                <input type="number" class="food-item-grams" name="input_grams" value="<?= $food['base_grams'] ?>">
                <span>g</span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm food-item-add">Add</button>
        </div>
    </form>
<?php endforeach; ?>