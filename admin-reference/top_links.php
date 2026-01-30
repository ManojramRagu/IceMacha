<!-- Top links -->
<div class="flex justify-center mb-10">
  <div class="inline-flex bg-sand/90 px-4 py-2 rounded-full gap-3 shadow-sm ring-1 ring-black/5">
    <a href="<?= BASE_URL ?>/?r=admin&tab=inventory&main=<?= urlencode($main) ?>&sub=<?= urlencode($sub) ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold <?= $currentTab === 'inventory' ? 'bg-brand text-white' : 'text-cocoa hover:text-brand' ?>">
      Manage Inventory
    </a>
    <a href="<?= BASE_URL ?>/?r=admin&tab=orders"
       class="px-5 py-2 rounded-full text-sm font-semibold <?= $currentTab === 'orders' ? 'bg-brand text-white' : 'text-cocoa hover:text-brand' ?>">
      View Orders / Feedback
    </a>
  </div>
</div>
