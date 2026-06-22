<div class="form-row">
    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="<?= e(old($old, 'name')) ?>">
    <?php if (isset($errors['name'])): ?><div class="error"><?= e($errors['name']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?= e(old($old, 'email')) ?>">
    <?php if (isset($errors['email'])): ?><div class="error"><?= e($errors['email']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="phone">Phone</label>
    <input id="phone" type="text" name="phone" value="<?= e(old($old, 'phone')) ?>">
    <?php if (isset($errors['phone'])): ?><div class="error"><?= e($errors['phone']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="gender">Gender</label>
    <?php $currentGender = old($old, 'gender', 'female'); ?>
    <select id="gender" name="gender">
        <option value="female" <?= selected('female', $currentGender) ?>>female</option>
        <option value="male" <?= selected('male', $currentGender) ?>>male</option>
        <option value="other" <?= selected('other', $currentGender) ?>>other</option>
    </select>
    <?php if (isset($errors['gender'])): ?><div class="error"><?= e($errors['gender']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="4"><?= e(old($old, 'note')) ?></textarea>
</div>
