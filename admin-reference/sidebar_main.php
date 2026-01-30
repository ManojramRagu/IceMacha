<div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
  <h3 class="font-semibold mb-3">Main</h3>
  <div class="flex flex-wrap gap-2">
    <?php foreach ($mainMap as $m => $subs): ?>
      <a class="px-3 py-1.5 rounded-full border text-sm <?= $m===$main ? 'bg-brand text-white border-brand' : 'border-gray-300 hover:bg-gray-50' ?>"
         href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($m) ?>&sub=<?= urlencode($subs[0]) ?>">
        <?= htmlspecialchars($m) ?>
      </a>
    <?php endforeach; ?>
  </div>
</div>
