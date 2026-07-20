<?php
function password_field(string $id, string $name, string $label, array $errors): void
{
?>
    <div class="form-group">
        <label for="<?= $id ?>"><?= $label ?>:</label>
        <div class="password-wrapper">
            <input type="password" id="<?= $id ?>" name="<?= $name ?>">
            <button type="button" class="toggle-password" data-target="<?= $id ?>">
                <lord-icon
                    class="look-icon"
                    src="https://cdn.lordicon.com/dicvhxpz.json"
                    trigger="hover"
                    stroke="bold"
                    state="hover-look-around"
                    colors="primary:#121331,secondary:#000000"
                    style="width:17px;height:17px">
                </lord-icon>
                <lord-icon
                    class="cross-icon"
                    src="https://cdn.lordicon.com/dicvhxpz.json"
                    trigger="hover"
                    stroke="bold"
                    state="hover-cross"
                    colors="primary:#121331,secondary:#000000"
                    style="width:17px;height:17px">
                </lord-icon>
            </button>

        </div>

        <?php if (isset($errors[$name])): ?>
            <span class="error"><?= $errors[$name] ?></span>
        <?php endif; ?>
    </div>
<?php
}
