<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <input type="text" id="text-{{ $i }}" class="{{ (isset($class)) ? $class:'form-control' }}" value="{{ $value }}" name="{{ $name }}">
</div>