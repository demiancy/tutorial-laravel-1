<script src="{{ asset('theme/js/loader.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous" defer></script>
<script src="{{ asset('theme/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" defer></script>
<script src="{{ asset('theme/js/app.js') }}" defer></script>

<script>
    window.onload = function() {
        App.init();
    };
</script>

<script src="{{ asset('theme/js/custom.js') }}" defer></script>

<script src="{{ asset('theme/plugins/sweetalerts/sweetalert2.min.js') }}" defer></script>
<script src="{{ asset('theme/plugins/notification/snackbar/snackbar.min.js') }}" defer></script>
<script src="{{ asset('theme/plugins/nicescroll/nicescroll.js') }}" defer></script>
<script src="{{ asset('theme/plugins/currency/currency.js') }}" defer></script>

<script src="{{ asset('js/app.js') }}" defer></script>

<script>
    function noty(msg, option = 1) {
        Snackbar.show({
            text: msg.toUpperCase(),
            actionText: 'Cerrar',
            actionTextColor: '#fff',
            backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
            pos: 'top-right'
        });
    }
</script>