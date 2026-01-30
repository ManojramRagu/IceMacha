<div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4 space-y-3">
  <h3 class="font-semibold">Quick actions</h3>
  <div class="flex flex-col gap-2">
    <?php if ($main !== 'Promotions'): ?>
      <a class="inline-flex items-center justify-center px-3 py-2 rounded-full bg-brand text-white hover:opacity-90"
         href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($sub) ?>&mode=create#editor-product">
        + Add Product
      </a>
    <?php endif; ?>

    <?php if ($main === 'Promotions'): ?>
      <a class="inline-flex items-center justify-center px-3 py-2 rounded-full bg-brand text-white hover:opacity-90"
         href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=Promotions&sub=Promotions&promomode=create#editor-promo">
        + Add Promotion
      </a>
    <?php endif; ?>
  </div>
</div>
