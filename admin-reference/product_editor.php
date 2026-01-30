<?php $mode = $_GET['mode'] ?? ''; ?>

<?php
$oldProduct = $_SESSION['old_product'] ?? null;
unset($_SESSION['old_product']);
?>


<div id="editor-product" class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <h3 class="text-lg font-semibold mb-3"><?= $mode === 'create' ? 'Add Product' : 'Update / Delete Product' ?></h3>

  <?php if ($mode === 'create'): ?>
    <form method="post" action="<?= BASE_URL ?>/?r=admin/product/create"
      class="grid sm:grid-cols-2 gap-4" data-guard enctype="multipart/form-data">
      <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
      <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">

      <div>
        <label class="block text-sm mb-1">Product Name</label>
        <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="ProductName" value="<?= htmlspecialchars($oldProduct['ProductName'] ?? '') ?>" required>
      </div>
      <div>
        <label class="block text-sm mb-1">Price</label>
        <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Price" value="<?= htmlspecialchars($oldProduct['Price'] ?? '') ?>" inputmode="decimal" required>
      </div>
      <div class="sm:col-span-2">
        <label class="block text-sm mb-1">Description</label>
        <textarea class="w-full rounded-xl border border-gray-300 px-3 py-2 h-24 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Description"><?= htmlspecialchars($oldProduct['Description'] ?? '') ?></textarea>
      </div>
      <div>
        <label class="block text-sm mb-1">Stock</label>
        <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Stock" inputmode="numeric" value="<?= htmlspecialchars($oldProduct['Stock'] ?? '0') ?>">
      </div>

      <div class="sm:col-span-2 grid sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Image Name (For spaces use "-")</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="ImageName" placeholder="cafe latte" value="<?= htmlspecialchars($oldProduct['ImageName'] ?? '') ?>"required>
        </div>
        <div>
          <label class="block text-sm mb-1">Ext</label>
          <select class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="ImageExt">
            <?php
              $ext = $oldProduct['ImageExt'] ?? 'webp';
              foreach (['webp','jpg','jpeg','png'] as $x) {
                $sel = $x === $ext ? 'selected' : '';
                echo "<option $sel>".htmlspecialchars($x)."</option>";
              }
            ?>
          </select>
        </div>
          <!-- NEW: file upload -->
        <div class="sm:col-span-2">
            <label class="block text-sm mb-1">Upload image</label>
            <input type="file" name="ImageFile" accept="image/*"
                class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-white shadow-sm focus:ring-2 focus:ring-brand/30" required>
            <p class="text-xs text-gray-500 mt-1">Max 6MB. Types: webp, jpg, jpeg, png</p>
        </div>
      </div>

      <div class="sm:col-span-2 flex justify-end gap-2">
        <a class="inline-flex items-center px-3 py-2 rounded-full border border-gray-300 hover:bg-gray-50"
           href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($sub) ?>">Cancel</a>
        <button class="inline-flex items-center px-4 py-2 rounded-full bg-brand text-white hover:opacity-90" type="submit">Create</button>
      </div>
    </form>

  <?php else: ?>
    <?php if (empty($pSelected)): ?>
      <p class="text-sm text-gray-600">Click a product row above to edit or delete.</p>
    <?php else: ?>

      <!-- UPDATE: standalone form -->
      <form id="productUpdateForm" method="post" action="<?= BASE_URL ?>/?r=admin/product/update"
            class="grid sm:grid-cols-2 gap-4" data-guard>
        <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
        <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
        <input type="hidden" name="ProductId"    value="<?= (int)$pSelected['ProductId'] ?>">

        <div>
          <label class="block text-sm mb-1">Product Name</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                 name="ProductName" value="<?= htmlspecialchars($pSelected['ProductName']) ?>" required>
        </div>
        <div>
          <label class="block text-sm mb-1">Price</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                 name="Price" inputmode="decimal" value="<?= htmlspecialchars($pSelected['Price']) ?>" required>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Description</label>
          <textarea class="w-full rounded-xl border border-gray-300 px-3 py-2 h-24 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                    name="Description"><?= htmlspecialchars($pSelected['Description']) ?></textarea>
        </div>
        <div>
          <label class="block text-sm mb-1">Stock</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                 name="Stock" inputmode="numeric" value="<?= (int)$pSelected['Stock'] ?>">
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Image Path</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-100 shadow-sm"
                 value="<?= htmlspecialchars($pSelected['ImagePath']) ?>" disabled>
        </div>
      </form>

      <!-- ACTIONS: Update + Delete -->
      <div class="mt-4 sm:col-span-2 flex flex-wrap justify-between gap-2">
        <a class="inline-flex items-center px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-50"
           href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($sub) ?>">Cancel</a>

        <div class="flex gap-2">
          <button class="inline-flex items-center px-4 py-2 rounded-full bg-brand text-white hover:opacity-90"
                  type="submit" form="productUpdateForm">Update</button>

          <form method="post" action="<?= BASE_URL ?>/?r=admin/product/delete" class="inline" data-confirm="Delete this product?">
            <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
            <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
            <input type="hidden" name="ProductId"    value="<?= (int)$pSelected['ProductId'] ?>">
            <button class="inline-flex items-center px-4 py-2 rounded-full border border-red-300 text-red-600 hover:bg-red-50" type="submit">
              Delete
            </button>
          </form>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
