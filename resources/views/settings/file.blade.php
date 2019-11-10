<div class="form-group">
    <label for="file-{{ $i }}">{{ $label }}</label>
    <div class="img-preview">
        <img src="{{ getFileUrl($value) }}" style="max-width: 250px" alt="" class="img">
    </div>
    <input type="file" id="file-{{ $i }}" accept="{{ implode(',', $accept) }}" name="{{ $name }}" class="{{ (isset($class)) ? $class : '' }}">
</div>