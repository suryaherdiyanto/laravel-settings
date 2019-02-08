<div class="form-group">
    <label for="text-{{ $i }}">{{ $label }}</label>
    <textarea id="text-{{ $i }}" name="value[]">{{ settings($group.'.'.$name) ?: $default }}</textarea>
</div>