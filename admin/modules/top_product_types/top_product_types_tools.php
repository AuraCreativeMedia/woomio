
<form id="woomio-tools-top-product-types" class="woomio-settings woomio-module-form mb-6" method="POST" action="">

<!-- Nonce field -->
<?php wp_nonce_field('woomio_save_csv_top_product_types', 'woomio_tpt_csv_nonce'); ?>
<?php wp_nonce_field('woomio_save_tools_top_product_types', 'woomio_tpt_rebuild_nonce'); ?>

    <div class="woomio-table">
        <div class="mt-2 flex items-center justify-start gap-x-6">
            <button type="submit" name="woomio_save_csv_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export CSV</button>
        </div>
        <div class="mt-2 flex items-center justify-start gap-x-6">
            <button type="submit" name="woomio_save_tools_top_product_types" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Rebuild User Database</button>
            <span style="color:red;">Warning: Intensive operation</span>
        </div>
    </div>
   
</form>