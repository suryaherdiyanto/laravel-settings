<div class="form-group">
    <label for="number-{{ $i }}">{{ $label }}</label>
    <input type="number" id="number-{{ $i }}" class="form-group" value="{{ $value ?: $default }}" name="value[]">
</div>