
<form id="woomio-tools-top-product-types" class="woomio-settings mb-6" method="POST" action="">

<!-- Nonce field -->
<?php wp_nonce_field('woomio_save_csv_top_product_types', 'woomio_tpt_csv_nonce'); ?>
<?php wp_nonce_field('woomio_save_tools_top_product_types', 'woomio_tpt_rebuild_nonce'); ?>

    <div class="pt-20 space-y-6">
        <div class="border-b border-gray-900/10 pb-6">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Top Product Types - Tools</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600"></p>
        </div>
        <div class="mt-2 flex items-center justify-start gap-x-6">
            <button type="submit" name="woomio_save_csv_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export CSV</button>
        </div>
        <div class="mt-2 flex items-center justify-start gap-x-6">
            <button type="submit" name="woomio_save_tools_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Rebuild User Database</button>
            <span style="color:red;">Warning: Intensive operation</span>
        </div>
    </div>
</form>