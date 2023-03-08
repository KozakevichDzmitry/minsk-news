jQuery(document).ready(function ($) {
    $scrollPost = $('.whole-post-scroll');
	$scrollPost.scroll(function() {
        if($(this).height()+ $(this).scrollTop()>= this.scrollHeight){
            $(this).css('');
        }
    })

});
