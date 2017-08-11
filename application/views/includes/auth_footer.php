</div> <!-- wrapper ends -->

</div> <!-- #hld ends -->
<?php
if (isset($framework_error)){
	echo '
	<script>
	$( document ).ready(function() {
  	$("#error-invalid").focus();
	});
	</script>
	';
}
?>
</body>
</html>