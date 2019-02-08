<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <input type="text" id="text-{{ $i }}" class="form-group" value="{{ $value ?: $default }}" name="value[]">
</div>