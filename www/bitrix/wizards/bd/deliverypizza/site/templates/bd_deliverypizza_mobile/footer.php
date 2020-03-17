           </div>
    <script type="text/javascript">var ga;</script>
        <?php
        $metrika = \COption::GetOptionString('bd.deliverypizza','BD_DELIVER_M','',SITE_ID);
        $ga = \COption::GetOptionString('bd.deliverypizza','BD_DELIVER_GA','',SITE_ID);
        if(!empty($metrika) && \COption::GetOptionString('bd.deliverypizza', 'BD_CF_SHOP_COUNTRY', '', SITE_ID)!='ua'):?>
	        <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter = new Ya.Metrika({id:<?=$metrika;?>, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/30164019" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
        <?php endif; ?>
        <?php if(!empty($ga)):?>
	        <!--Google analytics-->
	        <script>
		        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		        ga('create', '<?=$ga;?>', 'auto');
		        ga('send', 'pageview');

	        </script>
	        <!--Google analytics-->
        <?php endif; ?>
  </body>
</html>