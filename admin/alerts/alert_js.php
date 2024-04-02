<script type="text/javascript">
$(function() {
setTimeout(function() { $("#testdiv").fadeOut(1500); }, 3000)
$('#btnclick').click(function() {
$('#testdiv').show();
setTimeout(function() { $("#testdiv").fadeOut(1500); }, 3000)
})
})
</script>