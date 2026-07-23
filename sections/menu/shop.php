<?php
/** Requiere $nonEmptyCategories (con 'products' anidados), definido en pages/menu.php. */
?>
<?php if ($nonEmptyCategories): ?>

<section class="menu-shop u-section u-section--tight" data-reveal="fade">
  <div class="u-container menu-shop__layout">

    <aside class="menu-filters" aria-label="<?= htmlspecialchars(t($t, 'menu.filters_title')) ?>">
      <h2 class="menu-filters__title"><?= htmlspecialchars(t($t, 'menu.filters_title')) ?></h2>

      <div class="menu-filters__field">
        <label for="menu-search"><?= htmlspecialchars(t($t, 'menu.search_label')) ?></label>
        <input type="search" id="menu-search" placeholder="<?= htmlspecialchars(t($t, 'menu.search_placeholder')) ?>">
      </div>

      <div class="menu-filters__field">
        <label for="menu-filter-category"><?= htmlspecialchars(t($t, 'menu.filter_category')) ?></label>
        <select id="menu-filter-category">
          <option value="all"><?= htmlspecialchars(t($t, 'menu.filter_category_all')) ?></option>
          <?php foreach ($nonEmptyCategories as $navCat): ?>
          <option value="cat-<?= (int) $navCat['id'] ?>"><?= htmlspecialchars($lang === 'fr' ? $navCat['name_fr'] : $navCat['name_en']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="menu-filters__field">
        <label for="menu-filter-sort"><?= htmlspecialchars(t($t, 'menu.filter_sort')) ?></label>
        <select id="menu-filter-sort">
          <option value="featured"><?= htmlspecialchars(t($t, 'menu.sort_featured')) ?></option>
          <option value="name"><?= htmlspecialchars(t($t, 'menu.sort_name')) ?></option>
          <option value="price-asc"><?= htmlspecialchars(t($t, 'menu.sort_price_low')) ?></option>
          <option value="price-desc"><?= htmlspecialchars(t($t, 'menu.sort_price_high')) ?></option>
        </select>
      </div>
    </aside>

    <div class="menu-shop__results">
      <p class="menu-shop__count" id="menu-results-count" data-template="<?= htmlspecialchars(t($t, 'menu.results_found')) ?>"></p>

      <div class="u-grid u-grid--3 menu-shop__grid" id="menu-grid">
        <?php foreach ($nonEmptyCategories as $cat): ?>
          <?php foreach ($cat['products'] as $p): ?>
            <?php include $root . '/sections/menu/product-card.php'; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>

      <p class="menu-shop__empty" id="menu-empty" hidden><?= htmlspecialchars(t($t, 'menu.no_results')) ?></p>
    </div>

  </div>
</section>

<?php else: ?>
<section class="u-container u-section u-text-center">
  <p><?= htmlspecialchars(t($t, 'menu.empty_state')) ?></p>
</section>
<?php endif; ?>
