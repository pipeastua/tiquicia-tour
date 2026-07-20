<?php
function swiper(array $imgs): void
{
?>
    <div class="login-swiper-side">
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php foreach ($imgs as $img): ?>
                    <div class="swiper-slide">
                        <img src="<?= htmlspecialchars($img) ?>" alt="Costa Rica">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
<?php
}
