<div class="form-group">
    <label for="check-{{ $i }}" class="form-check-label">{{ $label }}</label>
    @if (settingExists($group, $name))
        @if ($value == 1)
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  checked value="1" name="value[]">
        @else
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  value="1" name="value[]">
        @endif
    @else
        @if ($default == 1)
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  checked value="1" name="value[]">
        @else
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  value="1" name="value[]">
        @endif
    @endif
</div>