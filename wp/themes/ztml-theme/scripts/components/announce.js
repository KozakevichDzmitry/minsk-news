jQuery(document).ready(function ($) {
const announce = $('.announce');
   if($(announce).length) {
       $(announce).each(function() {
           const time = $( this ).data('publication')
           const postid = $( this ).data('postid')
           const now = new Date();
           const delay = new Date(time) - now;
           const dataRequest = {
               action: "announce_link",
               id: postid,
           };
           const ajaxRequest = () =>{
               $.ajax({
                   url: "/wp-admin/admin-ajax.php",
                   data: dataRequest,
                   type: "POST",
                   success: (data) => {
                       if (data) {
                           $('.announce').closest('.box').replaceWith(data)
                       }
                   }
               });
           }
           if(delay<0) ajaxRequest()
           else setTimeout(ajaxRequest, delay);
       });
   }

})