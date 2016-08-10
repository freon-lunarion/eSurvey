$(document).ready(function () {
  $(".fancybox").fancybox({
    closeClick  : false,
    afterClose  : function() {
        parent.location.reload(true);
    },
    helpers   : { 
      overlay : {closeClick: false}
    }

  });
  $(".fancybox-nonrefresh").fancybox({
    closeClick  : false,
    helpers   : { 
      overlay : {closeClick: false}
    }
  });
  $(".fancybox-gallery").fancybox();
});