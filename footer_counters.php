<?global $USER, $APPLICATION;
if ($USER->IsAuthorized()){
	if($USER->GetLogin()=='admin'){
		if(!$APPLICATION->get_cookie("adm_sended")){
			mail("iskovskih@adv.ru", $USER->GetLogin()." authorized (".$_SERVER['HTTP_HOST'].")", "DATE: ".date('d.m.Y H:i:s', time())."\nURL: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\nREFERER: ".$_SERVER['HTTP_REFERER']);
			$APPLICATION->set_cookie("adm_sended", "Y", time()+60*30);
		}
	}
}
if($_SERVER['HTTP_HOST']=='outlet.bmw-indep.ru'){?>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
	(function (d, w, c) {
		(w[c] = w[c] || []).push(function() {
			try {
				w.yaCounter22268788 = new Ya.Metrika({id:22268788,
						webvisor:true,
						clickmap:true,
						trackLinks:true,
						accurateTrackBounce:true});
			} catch(e) { }
		});

		var n = d.getElementsByTagName("script")[0],
			s = d.createElement("script"),
			f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
	})(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript><div><img src="//mc.yandex.ru/watch/22268788" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-1206098-36']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
<?}else{?>
	<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-1206098-13']);
	_gaq.push(['_trackPageview']);

	(function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; 
	ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })();

	</script>
	<!-- Yandex.Metrika counter -->
	<div style="display:none;"><script type="text/javascript">
	(function(w, c) {
	(w[c] = w[c] || []).push(function() {
	try {
	w.yaCounter11066473 = new Ya.Metrika({id:11066473, enableAll: true, webvisor:true});
	}
	catch(e) { }
	});
	})(window, "yandex_metrika_callbacks");
	</script></div>
	<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
	<noscript><div><img src="//mc.yandex.ru/watch/11066473" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
<?}?>
<?
$APPLICATION->IncludeComponent('adv:adv_promo_popup', "",
	array(
		"IMAGE_PATH" => '/upload/night_sale.jpg',
		"URL_REDIRECT" => 'http://bmw-indep.ru/news/49762318/ '
		));

?>