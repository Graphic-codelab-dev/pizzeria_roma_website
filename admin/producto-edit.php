<?php

require_once __DIR__ . '/includes/auth_guard.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/upload.php';

$pdo = require ROOT_PATH . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$product = [
    'id' => 0, 'category_id' => '', 'name_en' => '', 'name_fr' => '',
    'description_en' => '', 'description_fr' => '', 'price' => '',
    'image_path' => '', 'is_featured' => 0, 'display_order' => 0, 'is_active' => 1,
];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $existing = $stmt->fetch();
    if (!$existing) {
        admin_flash_set('Product not found.', 'error');
        admin_redirect('/admin/productos.php');
    }
    $product = $existing;
}

$categories = $pdo->query('SELECT * FROM categories ORDER BY display_order ASC')->fetchAll();
$errors     = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_require_or_die();

    $product['category_id']    = (int) ($_POST['category_id'] ?? 0);
    $product['name_en']        = trim((string) ($_POST['name_en'] ?? ''));
    $product['name_fr']        = trim((string) ($_POST['name_fr'] ?? ''));
    $product['description_en'] = trim((string) ($_POST['description_en'] ?? ''));
    $product['description_fr'] = trim((string) ($_POST['description_fr'] ?? ''));
    $product['price']          = (string) ($_POST['price'] ?? '');
    $product['display_order']  = (int) ($_POST['display_order'] ?? 0);
    $product['is_featured']    = isset($_POST['is_featured']) ? 1 : 0;
    $product['is_active']      = isset($_POST['is_active']) ? 1 : 0;

    if ($product['name_en'] === '' || $product['name_fr'] === '') {
        $errors[] = 'Name (English and French) is required.';
    }
    if (!$product['category_id']) {
        $errors[] = 'Please choose a category.';
    }
    if (!is_numeric($product['price']) || (float) $product['price'] < 0) {
        $errors[] = 'Please enter a valid price.';
    }

    if (!$errors) {
        try {
            $uploadedPath = handle_product_image_upload($_FILES['image'] ?? []);
            if ($uploadedPath) {
                $product['image_path'] = $uploadedPath;
            }
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
    }

    if (!$errors) {
        $params = [
            'category_id'    => $product['category_id'],
            'name_en'        => $product['name_en'],
            'name_fr'        => $product['name_fr'],
            'description_en' => $product['description_en'],
            'description_fr' => $product['description_fr'],
            'price'          => $product['price'],
            'image_path'     => $product['image_path'],
            'is_featured'    => $product['is_featured'],
            'display_order'  => $product['display_order'],
            'is_active'      => $product['is_active'],
        ];

        if ($id) {
            $stmt = $pdo->prepare(
                'UPDATE products SET category_id=:category_id, name_en=:name_en, name_fr=:name_fr,
                 description_en=:description_en, description_fr=:description_fr, price=:price,
                 image_path=:image_path, is_featured=:is_featured, display_order=:display_order,
                 is_active=:is_active WHERE id=:id'
            );
            $params['id'] = $id;
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO products (category_id, name_en, name_fr, description_en, description_fr,
                 price, image_path, is_featured, display_order, is_active)
                 VALUES (:category_id, :name_en, :name_fr, :description_en, :description_fr,
                 :price, :image_path, :is_featured, :display_order, :is_active)'
            );
        }

        $stmt->execute($params);

        admin_flash_set($id ? 'Product updated.' : 'Product created.');
        admin_redirect('/admin/productos.php');
    }
}

$pageTitle = $id ? 'Edit Product' : 'New Product';
include __DIR__ . '/includes/layout-header.php';
?>
<h1><?= htmlspecialchars($pageTitle) ?></h1>

<?php if ($errors): ?>
<div class="admin-flash admin-flash--error">
  <ul><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err) ?></li><?php endforeach; ?></ul>
</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="admin-form">
  <?= csrf_field() ?>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="name_en">Name (English)</label>
      <input id="name_en" name="name_en" type="text" required value="<?= htmlspecialchars($product['name_en']) ?>">
    </div>
    <div class="admin-form__field">
      <label for="name_fr">Name (French)</label>
      <input id="name_fr" name="name_fr" type="text" required value="<?= htmlspecialchars($product['name_fr']) ?>">
    </div>
  </div>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="description_en">Description (English)</label>
      <textarea id="description_en" name="description_en" rows="3"><?= htmlspecialchars($product['description_en']) ?></textarea>
    </div>
    <div class="admin-form__field">
      <label for="description_fr">Description (French)</label>
      <textarea id="description_fr" name="description_fr" rows="3"><?= htmlspecialchars($product['description_fr']) ?></textarea>
    </div>
  </div>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="category_id">Category</label>
      <select id="category_id" name="category_id" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $cat): ?>
        <option value="<?= (int) $cat['id'] ?>" <?= (int) $product['category_id'] === (int) $cat['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name_en']) ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="admin-form__field">
      <label for="price">Price ($)</label>
      <input id="price" name="price" type="number" step="0.01" min="0" required value="<?= htmlspecialchars((string) $product['price']) ?>">
    </div>
  </div>

  <div class="admin-form__row">
    <div class="admin-form__field">
      <label for="display_order">Display order</label>
      <input id="display_order" name="display_order" type="number" min="0" value="<?= (int) $product['display_order'] ?>">
    </div>
    <div class="admin-form__field">
      <label for="image">Photo (JPG, PNG or WEBP, max 5MB)</label>
      <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
      <?php if ($product['image_path']): ?>
      <img src="/<?= htmlspecialchars($product['image_path']) ?>" alt="" width="120" class="admin-form__current-image">
      <?php endif; ?>
    </div>
  </div>

  <div class="admin-form__row admin-form__row--checkboxes">
    <label class="admin-checkbox">
      <input type="checkbox" name="is_featured" value="1" <?= $product['is_featured'] ? 'checked' : '' ?>>
      Feature on homepage
    </label>
    <label class="admin-checkbox">
      <input type="checkbox" name="is_active" value="1" <?= $product['is_active'] ? 'checked' : '' ?>>
      Active (visible on site)
    </label>
  </div>

  <div class="admin-form__actions">
    <button type="submit" class="btn btn--primary">Save product</button>
    <a href="/admin/productos.php" class="btn btn--outline">Cancel</a>
  </div>
</form>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
