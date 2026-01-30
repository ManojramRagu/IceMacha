<!-- Products list -->
<div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
    <h2 class="text-xl font-semibold">
      Products · <span class="text-gray-600"><?= htmlspecialchars($main) ?> / <?= htmlspecialchars($sub) ?></span>
    </h2>
    <div class="relative w-full sm:w-64">
      <input id="productSearch" type="text" placeholder="Search products…"
             class="w-full rounded-xl border border-gray-300 px-3 py-2 pr-8 bg-white focus:ring-2 focus:ring-brand/30 focus:border-brand">
      <svg class="pointer-events-none absolute right-2 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.15 13.15z"/></svg>
    </div>
  </div>

  <div class="overflow-x-auto rounded-2xl border border-brand/20">
    <table id="productTable" class="min-w-full text-sm">
      <thead class="bg-gray-50 text-gray-700">
      <tr>
        <th class="px-3 py-2 text-left">#</th>
        <th class="px-3 py-2 text-left">Name</th>
        <th class="px-3 py-2 text-left">Price</th>
        <th class="px-3 py-2 text-left">Stock</th>
        <th class="px-3 py-2 text-left">ImagePath</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach (($products ?? []) as $row): ?>
        <?php $isSel = isset($_GET['pid']) && (int)$_GET['pid'] === (int)$row['ProductId']; ?>
        <tr class="border-t cursor-pointer <?= $isSel ? 'bg-sand/40' : 'hover:bg-gray-50' ?>"
            data-row data-id="<?= (int)$row['ProductId'] ?>" data-type="product"
            data-k="<?= htmlspecialchars(strtolower($row['ProductName'])) ?>">
          <td class="px-3 py-2"><?= (int)$row['ProductId'] ?></td>
          <td class="px-3 py-2 font-medium"><?= htmlspecialchars($row['ProductName']) ?></td>
          <td class="px-3 py-2">LKR <?= number_format($row['Price'],2) ?></td>
          <td class="px-3 py-2"><?= (int)$row['Stock'] ?></td>
          <td class="px-3 py-2"><?= htmlspecialchars($row['ImagePath']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($products)): ?>
        <tr class="border-t"><td class="px-3 py-3 text-gray-600" colspan="5">No products in this sub-category.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
