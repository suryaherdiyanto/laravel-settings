<div class="form-group">
    <label for="">{{ $label }}</label> <br>
    <div class="form-check-inline">
        @foreach ($options as $key => $option)
            <input type="checkbox" id="check-{{ $key }}" class="form-check-input" {{ (in_array($key, $value)) ? 'checked': '' }}  value="1" name="{{ $name."[".$key."]" }}">
            <label for="check-{{ $key }}" class="form-check-label mr-2">{{ $option }}</label>
        @endforeach
    </div>
</div>