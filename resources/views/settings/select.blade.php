<div class="form-group">
    <label for="select-{{ $i }}">{{ $label }}</label>
    <select name="{{ $name }}" id="select-{{ $i }}" class="{{ (isset($class)) ? $class:'form-control' }}">
        @foreach($options as $key => $label)
            <option {{ ($value == $key) ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>
</div>