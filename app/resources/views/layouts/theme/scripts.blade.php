<script src="{{ asset('theme/js/loader.js') }}" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer></script>
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
<script src="{{ asset('theme/plugins/nicescroll/nicescroll.min.js') }}" defer></script>
<script src="{{ asset('theme/plugins/currency/currency.min.js') }}" defer></script>

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