<script>
$('#myForm').submit(function () {
    $(this)
        .find('input[name]')
        .filter(function () {
            return !this.value;
        })
        .attr('disabled', true);
});
</script>

/* Prevent null value from submit*/
