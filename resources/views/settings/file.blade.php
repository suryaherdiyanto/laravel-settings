<div class="form-group">
    <label for="file-{{ $i }}">{{ $label }}</label>
    <input type="file" id="file-{{ $i }}" value="{{ $value }}" accept="{{ implode(',', $accept) }}" name="{{ $name }}">
</div>