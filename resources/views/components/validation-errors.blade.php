@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <div><strong>{{ __('Whoops! Something went wrong.') }}</strong></div>
        <ul style="margin: 6px 0 0 16px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
