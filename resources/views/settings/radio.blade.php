<div class="form-group">
    <label for="radio-{{ $i }}">{{ $label }}</label> <br>
    <div class="form-check-inline">
        @foreach ($options as $key => $option)    
            <input type="radio" {{ ($value == $key) ? "checked": '' }} id="radio-{{ $key }}-{{ $loop->iteration }}" name="{{ $name }}" value="{{ $key }}" class="form-check-input">
            <label for="radio-{{ $key }}-{{ $loop->iteration }}" class="form-check-label mr-2">{{ $option }}</label>
        @endforeach
    </div>
</div>