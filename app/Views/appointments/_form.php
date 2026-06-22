<div class="form-row">
    <label for="appointment_code">Appointment code</label>
    <input id="appointment_code" type="text" name="appointment_code" value="<?= e(old($old, 'appointment_code')) ?>" placeholder="APT-2026-0001">
    <?php if (isset($errors['appointment_code'])): ?><div class="error"><?= e($errors['appointment_code']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="patient_name">Patient name</label>
    <input id="patient_name" type="text" name="patient_name" value="<?= e(old($old, 'patient_name')) ?>">
    <?php if (isset($errors['patient_name'])): ?><div class="error"><?= e($errors['patient_name']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="patient_email">Patient email</label>
    <input id="patient_email" type="email" name="patient_email" value="<?= e(old($old, 'patient_email')) ?>">
    <?php if (isset($errors['patient_email'])): ?><div class="error"><?= e($errors['patient_email']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="appointment_date">Appointment date</label>
    <input id="appointment_date" type="datetime-local" name="appointment_date" value="<?= e(str_replace(' ', 'T', old($old, 'appointment_date'))) ?>">
    <?php if (isset($errors['appointment_date'])): ?><div class="error"><?= e($errors['appointment_date']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="status">Status</label>
    <?php $currentStatus = old($old, 'status', 'scheduled'); ?>
    <select id="status" name="status">
        <option value="scheduled" <?= selected('scheduled', $currentStatus) ?>>scheduled</option>
        <option value="completed" <?= selected('completed', $currentStatus) ?>>completed</option>
        <option value="cancelled" <?= selected('cancelled', $currentStatus) ?>>cancelled</option>
        <option value="no_show" <?= selected('no_show', $currentStatus) ?>>no_show</option>
    </select>
    <?php if (isset($errors['status'])): ?><div class="error"><?= e($errors['status']) ?></div><?php endif; ?>
</div>
<div class="form-row">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="4"><?= e(old($old, 'note')) ?></textarea>
</div>
