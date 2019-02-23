<div class="form-group">
    <label for="number-{{ $i }}">{{ $label }}</label>
    <select name="value[]" id="select-{{ $i }}">
        @foreach($options as $key => $label)
            <option {{ ($value === $key) ? 'selected':'' }} value="{{ $key }}">{{ $label }}</option>
        @endforeach
    </select>
</div>