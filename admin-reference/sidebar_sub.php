<div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <h3 class="font-semibold mb-3">Sub-category</h3>
  <div class="flex flex-wrap gap-2">
    <?php foreach ($mainMap[$main] as $s): ?>
      <a class="px-3 py-1.5 rounded-full border text-sm <?= $s===$sub ? 'bg-sand border-sand' : 'border-gray-300 hover:bg-gray-50' ?>"
         href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($s) ?>">
        <?= htmlspecialchars($s) ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
