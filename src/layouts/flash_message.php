<?php
$messages = $toast_messages ?? [];
?>
<script>
    window.flashMessages = <?= json_encode($messages, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>