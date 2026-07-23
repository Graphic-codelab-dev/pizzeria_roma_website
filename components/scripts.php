<?php
/**
 * Carga JS global (scroll-reveal, main) + JS específico de página
 * declarado en $seo['js']. Todo con <script defer> y cache-busting.
 */
foreach (['scroll-reveal.js', 'main.js'] as $_js): ?>
<script src="/js/<?= $_js ?>?v=<?= filemtime(ROOT_PATH . '/js/' . $_js) ?>" defer></script>
<?php endforeach; ?>
<?php foreach ($seo['js'] ?? [] as $_pageJs): ?>
<script src="/js/<?= htmlspecialchars($_pageJs) ?>?v=<?= filemtime(ROOT_PATH . '/js/' . $_pageJs) ?>" defer></script>
<?php endforeach; ?>
