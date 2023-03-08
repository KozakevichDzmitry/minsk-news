<?php

function subscribe_form()
{
	return '<div class="subscribe-form"><iframe src="https://www.belpressa.by/Subscription/ESubscribe/91297f76-1907-4fe7-9457-3b352b4c58ed" width="670" height="500" align="center"></iframe></div>';
}

add_shortcode("subscribe_form_scn", "subscribe_form");
