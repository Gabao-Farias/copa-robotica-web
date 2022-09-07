@extends('layouts.master')

@section('content')
    <p id="power">0</p>
@stop

@section('footer')
    <script src="{{ asset('js/socket.io.js') }}"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://192.168.10.10:3000');
        socket.on("test-channel:App\\Events\\Test", function(message){
            // increase the power everytime we load test route
            $('#power').text(JSON.stringify(message));
        });
    </script>
@endsection