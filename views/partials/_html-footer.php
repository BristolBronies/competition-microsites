
	</div>

	<?php if(FACEBOOK_APP_ID) : ?>
	<!-- Facebook SDK -->
	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '<?php echo FACEBOOK_APP_ID; ?>',
				xfbml      : true,
				cookie     : true,
				version    : 'v2.2'
			});
		};
		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<?php endif; ?>

	<!-- Postload javascript -->
	<script src="dst/js/vendor.js?v=<?php echo ASSET_VERSION; ?>"></script>
	<script src="dst/js/scripts.js?v=<?php echo ASSET_VERSION; ?>"></script>

</body>
</html>