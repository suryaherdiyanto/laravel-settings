<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <input type="text" id="text-{{ $i }}" class="form-group" value="{{ settings($group.'.'.$name) ?: $default }}" name="value[]">
</div>