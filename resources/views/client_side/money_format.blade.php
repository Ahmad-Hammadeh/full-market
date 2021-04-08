<script type="application/javascript">
    function moneyFormat(money) {
        return '{{ config('app.currency', '$') }}' + Number( money ).toFixed(2);
    }
</script>
