{{ $value }}
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="switch-{{ $i }}" value="1" name="{{ $name }}" {{ ((bool)$value === true) ? 'checked':'' }}>
    <label class="custom-control-label" for="switch-{{ $i }}">{{ $label }}</label>
</div>