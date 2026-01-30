<?php $promomode = $_GET['promomode'] ?? ''; ?>
<div id="editor-promo" class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <h3 class="text-lg font-semibold mb-3"><?= $promomode === 'create' ? 'Add Promotion' : 'Update / Delete Promotion' ?></h3>

  <?php if ($promomode === 'create'): ?>
    <form method="post" action="<?= BASE_URL ?>/?r=admin/promotion/create"
      class="grid sm:grid-cols-2 gap-4" data-guard enctype="multipart/form-data">
      <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
      <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">

      <div>
        <label class="block text-sm mb-1">Title</label>
        <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Title" required>
      </div>
      <div class="sm:col-span-2">
        <label class="block text-sm mb-1">Description</label>
        <textarea class="w-full rounded-xl border border-gray-300 px-3 py-2 h-24 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Description"></textarea>
      </div>

      <div class="sm:col-span-2 grid sm:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Image Name (For spaces use "-")</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="ImageName" placeholder="Midnight Snacks" required>
        </div>
        <div>
          <label class="block text-sm mb-1">Ext</label>
          <select class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="ImageExt">
            <option>webp</option><option>jpg</option><option>jpeg</option><option>png</option>
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
    <?php if (empty($promoSelected)): ?>
      <p class="text-sm text-gray-600">Click a promotion row above to edit, add items, or set discount.</p>
    <?php else: ?>

      <!-- UPDATE PROMO -->
      <form id="promoUpdateForm" method="post" action="<?= BASE_URL ?>/?r=admin/promotion/update"
            class="grid sm:grid-cols-2 gap-4 mb-0" data-guard>
        <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
        <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
        <input type="hidden" name="PromotionId" value="<?= (int)$promoSelected['PromotionId'] ?>">

        <div>
          <label class="block text-sm mb-1">Title</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                 name="Title" value="<?= htmlspecialchars($promoSelected['Title']) ?>" required>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Description</label>
          <textarea class="w-full rounded-xl border border-gray-300 px-3 py-2 h-24 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                    name="Description"><?= htmlspecialchars($promoSelected['Description']) ?></textarea>
        </div>
        <div class="sm:col-span-2">
          <label class="block text-sm mb-1">Image Path</label>
          <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-100 shadow-sm"
                 value="<?= htmlspecialchars($promoSelected['ImagePath']) ?>" disabled>
        </div>
      </form>

      <!-- Included products -->
      <div class="rounded-3xl border border-brand/20 p-4 mb-6">
        <h4 class="font-semibold mb-3">Included products</h4>

        <?php if (!empty($bundleItems)): ?>
          <div class="overflow-x-auto rounded-xl border border-brand/20">
            <table class="min-w-full text-sm">
              <thead class="bg-gray-50"><tr>
                <th class="px-3 py-2 text-left">Product</th>
                <th class="px-3 py-2 text-left">Unit Price</th>
                <th class="px-3 py-2 text-left">Qty</th>
                <th class="px-3 py-2 text-left">Line Total</th>
                <th class="px-3 py-2 text-right">Actions</th>
              </tr></thead>
              <tbody>
                <?php foreach ($bundleItems as $bi): ?>
                  <tr class="border-t">
                    <td class="px-3 py-2"><?= htmlspecialchars($bi['ProductName']) ?></td>
                    <td class="px-3 py-2">LKR <?= number_format($bi['Price'],2) ?></td>
                    <td class="px-3 py-2"><?= (int)$bi['Quantity'] ?></td>
                    <td class="px-3 py-2">LKR <?= number_format($bi['Price'] * $bi['Quantity'],2) ?></td>
                    <td class="px-3 py-2 text-right">
                      <form method="post" action="<?= BASE_URL ?>/?r=admin/promotion/items/remove" data-confirm="Remove this product?">
                        <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
                        <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
                        <input type="hidden" name="PromotionId" value="<?= (int)$promoSelected['PromotionId'] ?>">
                        <input type="hidden" name="ProductId" value="<?= (int)$bi['ProductId'] ?>">
                        <button class="px-3 py-1 rounded-full border border-red-300 text-red-600 hover:bg-red-50" type="submit">Remove</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-sm text-gray-600 mb-2">No products in this bundle yet.</p>
        <?php endif; ?>

        <!-- Add product to bundle -->
        <?php $allProducts = ProductModel::allForSelect(); ?>
        <form method="post" action="<?= BASE_URL ?>/?r=admin/promotion/items/add" class="mt-3 flex flex-wrap items-center gap-2" data-guard>
          <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
          <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
          <input type="hidden" name="PromotionId" value="<?= (int)$promoSelected['PromotionId'] ?>">
          <select name="ProductId" class="rounded-xl border border-gray-300 px-3 py-2 min-w-[260px] bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30">
            <?php
            $group = null;
            foreach ($allProducts as $p):
              if ($group !== $p['Category']) {
                if ($group !== null) echo "</optgroup>";
                $group = $p['Category'];
                echo '<optgroup label="'.htmlspecialchars($group).'">';
              }
              echo '<option value="'.(int)$p['ProductId'].'">'.htmlspecialchars($p['ProductName']).' — LKR '.number_format($p['Price'],2).'</option>';
            endforeach;
            if ($group !== null) echo "</optgroup>";
            ?>
          </select>
          <input class="w-24 rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30" name="Quantity" inputmode="numeric" value="1">
          <button class="inline-flex items-center px-4 py-2 rounded-full bg-brand text-white hover:opacity-90" type="submit">Add Product</button>
        </form>
      </div>

      <!-- Bundle price & discount -->
      <div class="rounded-3xl border border-brand/20 p-4">
        <h4 class="font-semibold mb-3">Bundle price</h4>
        <div class="grid sm:grid-cols-3 gap-4 items-end">
          <div>
            <label class="block text-sm mb-1">Original total</label>
            <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-100 shadow-sm"
                   value="LKR <?= number_format($bundleOriginal,2) ?>" disabled>
          </div>
          <form method="post" action="<?= BASE_URL ?>/?r=admin/promotion/discount"
                class="sm:col-span-2 grid sm:grid-cols-3 gap-3 items-end" data-guard id="discountForm"
                data-original="<?= htmlspecialchars($bundleOriginal) ?>">
            <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
            <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
            <input type="hidden" name="PromotionId" value="<?= (int)$promoSelected['PromotionId'] ?>">
            <div>
              <label class="block text-sm mb-1">Discount (%)</label>
              <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-50 shadow-sm focus:ring-2 focus:ring-brand/30"
                     id="discountPercent" name="DiscountPercent" inputmode="numeric" value="<?= (int)$currentDiscount ?>">
            </div>
            <div>
              <label class="block text-sm mb-1">Discounted price</label>
              <input class="w-full rounded-xl border border-gray-300 px-3 py-2 bg-gray-100 shadow-sm"
                     id="discountedPrice" value="LKR <?= number_format(max(0,$bundleOriginal * (1 - $currentDiscount/100)),2) ?>" disabled>
            </div>
            <div class="flex justify-end">
              <button class="inline-flex items-center px-4 py-2 rounded-full bg-brand text-white hover:opacity-90" type="submit">Save Discount</button>
            </div>
          </form>
        </div>
      </div>

      <!-- ACTIONS -->
      <div class="sm:col-span-2 flex justify-between gap-2 mb-6 mt-4">
        <a class="inline-flex items-center px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-50"
           href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($sub) ?>">Cancel</a>

        <div class="flex gap-2">
          <button class="inline-flex items-center px-4 py-2 rounded-full bg-brand text-white hover:opacity-90"
                  type="submit" form="promoUpdateForm">Update</button>

          <form method="post" action="<?= BASE_URL ?>/?r=admin/promotion/delete" class="inline" data-confirm="Delete this promotion?">
            <input type="hidden" name="MainCategory" value="<?= htmlspecialchars($main) ?>">
            <input type="hidden" name="SubCategory" value="<?= htmlspecialchars($sub) ?>">
            <input type="hidden" name="PromotionId" value="<?= (int)$promoSelected['PromotionId'] ?>">
            <button class="inline-flex items-center px-4 py-2 rounded-full border border-red-300 text-red-600 hover:bg-red-50" type="submit">
              Delete
            </button>
          </form>
        </div>
      </div>

    <?php endif; ?>
  <?php endif; ?>
</div>
