<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Virtual DM</title>

	<!-- load header CSS/JS files -->
	<?php echo $html_head; ?>
	 
  </head>
  <body>
	<?php echo $nav_bar; ?>
  
	<div class="container">
		<div id="vdm-app">
			<vdm-component></dm-component>
		</div>
		<?php echo $content; ?>
    </div>

	    <!-- load footer JS files -->
	<?php echo $html_footer; ?>
	<script>
		var vdm_main = new Vue({
			el:'#vdm-app',
		})
	</script>
	<script>
		$(document).ready(function(){
			init_basics();
		});
		function init_basics(){
			$('[data-toggle="tooltip"]').tooltip(); 
		}
	</script>
  </body>
</html>