

<form id="woomio-tools-run-order-total" class="woomio-settings woomio-module-form mb-6" method="POST" action="">

        <!-- Nonce field -->
        <?php wp_nonce_field('woomio_save_rebuild_run_order_total', 'woomio_run_order_total_nonce'); ?>
        <div class="woomio-table">
            <div class="pt-2 pb-2 space-y-6">

                <div class="mt-2 flex items-center justify-start gap-x-6">
                    <button type="submit" name="woomio_save_rebuild_run_order_total" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Rebuild Running Order Totals</button>
                    <span style="color:red;">Warning: Intensive operation</span>
                </div>
                
            </div>
        </div>
</form>