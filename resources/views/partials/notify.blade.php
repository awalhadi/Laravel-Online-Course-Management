    <!-- iziToast -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/iziToast.min.css') }}">
    <script src="{{ asset('assets/admin/js/iziToast.min.js') }}"></script> --}}
    <link href="{{ asset('css/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('js/iziToast.min.js') }}" rel="stylesheet">

    @if(session()->has('notify'))
      @foreach(session('notify') as $msg)
        <script type="text/javascript">  iziToast.{{ $msg[0] }}({message:"{{ $msg[1] }}", position: "topRight"}); </script>
        @endforeach
    @endif

    @if ($errors->any())
        <script>

        @foreach ($errors->all() as $error)
            iziToast.error({
                message: '{{ $error }}',
            position: "topRight"
            });
        @endforeach
    </script>

    @endif

