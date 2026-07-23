(function () {
  var grid = document.getElementById('menu-grid');
  if (!grid) return;

  var cards = Array.prototype.slice.call(grid.querySelectorAll('.menu-card'));
  var searchInput = document.getElementById('menu-search');
  var categorySelect = document.getElementById('menu-filter-category');
  var sortSelect = document.getElementById('menu-filter-sort');
  var countEl = document.getElementById('menu-results-count');
  var emptyEl = document.getElementById('menu-empty');
  var countTemplate = countEl ? countEl.dataset.template : '';

  function applyFilters() {
    var query = searchInput.value.trim().toLowerCase();
    var category = categorySelect.value;
    var visible = 0;

    cards.forEach(function (card) {
      var matchesSearch = !query || card.dataset.name.indexOf(query) !== -1;
      var matchesCategory = category === 'all' || card.dataset.category === category;
      var show = matchesSearch && matchesCategory;
      card.hidden = !show;
      if (show) visible++;
    });

    if (countEl) {
      countEl.textContent = countTemplate.replace('{count}', String(visible));
    }
    if (emptyEl) {
      emptyEl.hidden = visible !== 0;
    }
  }

  function applySort() {
    var sortedCards = cards.slice().sort(function (a, b) {
      switch (sortSelect.value) {
        case 'price-asc':
          return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
        case 'price-desc':
          return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
        case 'name':
          return a.dataset.name.localeCompare(b.dataset.name);
        default:
          return Number(b.dataset.featured) - Number(a.dataset.featured);
      }
    });
    sortedCards.forEach(function (card) { grid.appendChild(card); });
  }

  searchInput.addEventListener('input', applyFilters);
  categorySelect.addEventListener('change', applyFilters);
  sortSelect.addEventListener('change', applySort);

  applyFilters();
})();
