<div class="form-group">
    <label for="textarea-{{ $i }}">{{ $label }}</label>
    <textarea id="textarea-{{ $i }}" class="{{ (isset($class)) ? $class:'form-control' }}" name="{{ $name }}">{{ $value }}</textarea>
</div>