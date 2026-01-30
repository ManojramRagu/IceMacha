<!-- Promotions list -->
<div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
    <h2 class="text-xl font-semibold">Promotions</h2>
    <div class="relative w-full sm:w-64">
      <input id="promoSearch" type="text" placeholder="Search promotions…"
             class="w-full rounded-xl border border-gray-300 px-3 py-2 pr-8 bg-white focus:ring-2 focus:ring-brand/30 focus:border-brand">
      <svg class="pointer-events-none absolute right-2 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.15 13.15z"/></svg>
    </div>
  </div>

  <div class="overflow-x-auto rounded-2xl border border-brand/20">
    <table id="promoTable" class="min-w-full text-sm">
      <thead class="bg-gray-50 text-gray-700">
      <tr>
        <th class="px-3 py-2 text-left">#</th>
        <th class="px-3 py-2 text-left">Title</th>
        <th class="px-3 py-2 text-left">Price</th>
        <th class="px-3 py-2 text-left">ImagePath</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach (($promotions ?? []) as $pr): ?>
        <?php $isSel = isset($_GET['promoid']) && (int)$_GET['promoid'] === (int)$pr['PromotionId']; ?>
        <tr class="border-t cursor-pointer <?= $isSel ? 'bg-sand/40' : 'hover:bg-gray-50' ?>"
            data-row data-id="<?= (int)$pr['PromotionId'] ?>" data-type="promo"
            data-k="<?= htmlspecialchars(strtolower($pr['Title'])) ?>">
          <td class="px-3 py-2"><?= (int)$pr['PromotionId'] ?></td>
          <td class="px-3 py-2 font-medium"><?= htmlspecialchars($pr['Title']) ?></td>
          <td class="px-3 py-2">LKR <?= number_format($pr['Price'],2) ?></td>
          <td class="px-3 py-2"><?= htmlspecialchars($pr['ImagePath']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($promotions)): ?>
        <tr class="border-t"><td class="px-3 py-3 text-gray-600" colspan="4">No promotions yet.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
