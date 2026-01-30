<?php?>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
  <!-- Orders box -->
  <section class="lg:col-span-12 space-y-4">
    <div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-xl font-semibold">Orders</h2>
      </div>

      <div class="overflow-x-auto rounded-2xl border border-brand/20">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-3 py-2 text-left">#</th>
            <th class="px-3 py-2 text-left">Name</th>
            <th class="px-3 py-2 text-left">Total</th>
            <th class="px-3 py-2 text-left">Payment</th>
            <th class="px-3 py-2 text-left">Address</th>
            <th class="px-3 py-2 text-left">Date</th>
            <th class="px-3 py-2 text-right">Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach (($orders ?? []) as $o): ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-3 py-2"><?= (int)$o['OrderId'] ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($o['UserName']) ?></td>
              <td class="px-3 py-2">LKR <?= number_format($o['TotalAmount'], 2) ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($o['PaymentMethod']) ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($o['DeliveryAddress']) ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($o['OrderDate']) ?></td>
              <td class="px-3 py-2 text-right">
                <div class="flex items-center gap-2 justify-end">
                  <button
                    class="px-3 py-1 rounded-full border border-brand/30 text-brand hover:bg-brand/10 js-view-order"
                    type="button"
                    data-oid="<?= (int)$o['OrderId'] ?>"
                  >View</button>

                  <form method="post" action="<?= BASE_URL ?>/?r=admin/order/delete" class="inline" data-confirm="Delete this order?">
                    <input type="hidden" name="OrderId" value="<?= (int)$o['OrderId'] ?>">
                    <button class="px-3 py-1 rounded-full border border-red-300 text-red-600 hover:bg-red-50" type="submit">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($orders)): ?>
            <tr class="border-t"><td class="px-3 py-3 text-gray-600" colspan="7">No orders yet.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- SEPARATE DETAILS PANEL (hidden until "View" is clicked) -->
      <div id="orderDetailsPanel" class="hidden mt-4 rounded-2xl border border-brand/20 bg-white p-4">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold">
            Order <span id="odpId">#–</span>
          </h3>
          <button
            id="odpClose"
            class="px-3 py-1 rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50"
            type="button"
          >Close</button>
        </div>

        <div id="odpMeta" class="mt-1 text-sm text-gray-600"></div>

        <div id="odpBody" class="mt-3 text-sm text-gray-700">
          Select an order to view its items.
        </div>
      </div>
      <!-- /details panel -->
    </div>

    <!-- Feedback box -->
    <div class="bg-white rounded-3xl shadow-md ring-1 ring-brand/30 border border-brand/10 p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-xl font-semibold">Feedback</h2>
      </div>

      <div class="overflow-x-auto rounded-2xl border border-brand/20">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-3 py-2 text-left">#</th>
            <th class="px-3 py-2 text-left">Name</th>
            <th class="px-3 py-2 text-left">Email</th>
            <th class="px-3 py-2 text-left">Subject</th>
            <th class="px-3 py-2 text-left">Message</th>
            <th class="px-3 py-2 text-left">Date</th>
            <th class="px-3 py-2 text-right">Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach (($messages ?? []) as $m): ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="px-3 py-2"><?= (int)$m['MessageId'] ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars(trim(($m['FirstName'] ?? '').' '.($m['LastName'] ?? ''))) ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($m['Email'] ?? '') ?></td>
              <td class="px-3 py-2"><?= htmlspecialchars($m['Subject'] ?? '') ?></td>
              <td class="px-3 py-2">
                <?php $msg = (string)($m['Message'] ?? ''); echo htmlspecialchars(mb_strimwidth($msg, 0, 80, '…', 'UTF-8')); ?>
              </td>
              <td class="px-3 py-2"><?= htmlspecialchars($m['CreatedAt'] ?? '') ?></td>
              <td class="px-3 py-2 text-right">
                <form method="post" action="<?= BASE_URL ?>/?r=admin/feedback/delete" class="inline" data-confirm="Delete this message?">
                  <input type="hidden" name="MessageId" value="<?= (int)$m['MessageId'] ?>">
                  <button class="px-3 py-1 rounded-full border border-red-300 text-red-600 hover:bg-red-50" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php if (empty($messages)): ?>
            <tr class="border-t"><td class="px-3 py-3 text-gray-600" colspan="7">No messages yet.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>