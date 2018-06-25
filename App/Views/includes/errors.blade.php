@if(isset($errors))
    @foreach($errors as $type => $typeerrors)
        @foreach($typeerrors as $index => $error)
        @if($index === 0)
            <p style="color: red">{{ $error }}</p>
        @endif
        @endforeach
    @endforeach
@endif