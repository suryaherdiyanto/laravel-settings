<div class="custom-control custom-switch">
    <input type="checkbox" class="{{ (isset($class)) ? $class:'form-check-input' }}" id="switch-{{ $i }}" value="1" name="{{ $name }}" {{ ((bool)$value === true) ? 'checked':'' }}>
    <label class="custom-control-label" for="switch-{{ $i }}">{{ $label }}</label>
</div>