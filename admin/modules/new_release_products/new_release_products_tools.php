


<?php


$timestamp = wp_next_scheduled('woomio_mod_new_release_send_data_growmio_Tuesday');

if ($timestamp) {
    $date = date("Y-m-d", $timestamp);
    $cron_next_html = $date . ' at 12am';
} else {
    $cron_next_html = 'Unknown';
}

?>
<div class="woomio-table">
    <div id="woomio-tools-run-order-total" class="woomio-settings mb-6" method="POST" action="">
        <div class="pt-2 pb-2 space-y-6">
        
            <div class="mt-2 flex items-center justify-start gap-x-6">
                <p class="mt-1 text-lg leading-6 text-gray-600">Newly Released Products - this week:  <span class="text-green-600 p-2 inline-block bg-white"><?php echo get_option('_woomio_mod_new_prod'); ?></span></p>
            </div>
            <div class="mt-2 flex items-center justify-start gap-x-6">
                <p class="mt-1 text-lg leading-6 text-gray-600">Data will be sent to Growmio on: <span class="text-green-600 p-2 inline-block bg-white"> <?php echo $cron_next_html; ?></span></p>
            </div>
            
        </div>
    </div>
</div>