<script type="text/javascript" src="<?php echo base_url()?>assets/custom_js/porthole.min.js"></script>
<script type="text/javascript">

//	deleteAllCookies();
	function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
	}

  function onMessage(messageEvent) { 
		if (messageEvent.data["color"]) {
	   	setCookie('HRIFA', messageEvent.data['color'], 1);
		}
  }
	
	function deleteAllCookies() {
		var c = document.cookie.split("; ");
		for (i in c) 
		document.cookie =/^[^=]+/.exec(c[i])[0]+"=;expires=Thu, 01 Jan 1970 00:00:00 GMT";    
	}
      
	var windowProxy;
	window.onload = function () {
    windowProxy = new Porthole.WindowProxy("http://home.kmn.kompas.com/Style%20Library/Kompas/proxy.html");
		windowProxy.addEventListener(onMessage);
  }



	</script>
