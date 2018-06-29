@if(isset($errors))
<div class="errors">
    @foreach($errors as $type => $typeerrors)
        @foreach($typeerrors as $index => $error)
        @if($index === 0)
            <p class="errors__message" style="color: red">{{ $error }}</p>
        @endif
        @endforeach
    @endforeach
</div>
@endif