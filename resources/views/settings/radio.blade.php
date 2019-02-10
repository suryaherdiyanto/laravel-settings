<div class="form-check">
    <label for="radio-{{ $i }}" class="form-check-label">{{ $label }}</label>
    @foreach ($options as $key => $option)
        <input type="radio" {{ ($value == $key) ? "checked": ($default == $key) ? "checked":'' }} id="radio-{{ $key }}" name="value[]" value="{{ $key }}" class="form-check-input">
        <label for="radio-{{ $key }}" class="form-check-label">{{ $option }}</label>
    @endforeach
</div>