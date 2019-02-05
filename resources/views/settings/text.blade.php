<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <input type="text" id="text-{{ $i }}" value="{{ settings('general.'.$name) ?: $default }}" name="value[]">
</div>