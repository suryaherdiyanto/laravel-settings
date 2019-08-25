<div class="form-group">
    <label for="check-{{ $i }}" class="form-check-label">{{ $label }}</label>
    @if (settingExists($group, $name))
        @if ($value == 1)
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  checked value="1" name="{{ $name }}">
        @else
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  value="1" name="{{ $name }}">
        @endif
    @else
        @if ($default == 1)
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  checked value="1" name="{{ $name }}">
        @else
            <input type="checkbox" id="check-{{ $i }}" class="form-check-input"  value="1" name="{{ $name }}">
        @endif
    @endif
</div>