<div class="form-group">
    <label for="number-{{ $i }}">{{ $label }}</label>
    <input type="number" id="number-{{ $i }}" class="{{ (isset($class)) ? $class:'form-control' }}" value="{{ $value }}" name="{{ $name }}">
</div>