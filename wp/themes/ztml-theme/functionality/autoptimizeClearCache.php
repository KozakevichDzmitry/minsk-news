<?php

/*-------------------------------*/
/*  # Automatically clear autoptimizeCache if it goes beyond 256MB
/*-------------------------------*/

if (class_exists('autoptimizeCache')) {
    $myMaxSize = 256000; # You may change this value to lower like 100000 for 100MB if you have limited server space
    $statArr=autoptimizeCache::stats();
    $cacheSize=round($statArr[1]/1024);

    if ($cacheSize>$myMaxSize){
        autoptimizeCache::clearall();

        // Clear all W3 Total Cache
        if( class_exists('W3_Plugin_TotalCacheAdmin') )
        {
            $plugin_totalcacheadmin = & w3_instance('W3_Plugin_TotalCacheAdmin');
            $plugin_totalcacheadmin->flush_all();
            # echo __('<div class="updated"><p>All <strong>W3 Total Cache</strong> caches successfully emptied.</p></div>');
        }

        header("Refresh:0"); # Refresh the page so that autoptimize can create new cache files and it does break the page after clearall.

    }
}