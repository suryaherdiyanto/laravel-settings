<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <input type="text" id="text-{{ $i }}" class="{{ (isset($class)) ? $class:'form-control' }}" value="{{ (isset($value)) ? $value:$default }}" name="{{ $name }}">
</div>