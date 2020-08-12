@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Activation') }}</div>
                <div class="card-body">
                    <div class="alert alert-{{ $message['status'] }} col-12 text-center" id="alert-message">
                        {{ $message['text'] }}
                    </div>
                    @if ($message['status'] == 'success')
                    <script>
                        setTimeout(function() {
                            window.location.href = "{{ route('login') }}";
                        }, 5000);
                    </script>
                    {{ __('You will be redirected to login page in 5 seconds or ') }}
                    <a class="txt2" href="{{ route('login') }}">
                        click here
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection