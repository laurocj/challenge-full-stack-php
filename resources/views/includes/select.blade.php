@php
/**
 * Element select
 *
 * @select([
 *   name required
 *   label required
 *   id optional
 *   class optional Note: but form-control will always be put
 *   help optional ,  help text by placing below the input
 *   placeholder optional
 *   url_search optional Note: if you want a select with search, pass the data source url
 *   options optional the string like the options, or array value => text
 * ])
 */

$id = isset($id) ? $id : Str::random(10);

$value = old($name) ?? ($value ?? null);

$class = isset($class) ? "form-control $class" : "form-control ";

if($errors->has($name)) {
    $class .= " is-invalid ";
} else if(old($name) !== null) {
    $class .= " is-valid ";
}

$url = '';
if(isset($url_search)) {
    $class .= " select2-defaul";
    $url = "data-url=$url_search";
}

if(isset($options) && is_array($options)) {
    $op = '';
    $optionSelected = $value ?? '';
    foreach ($options as $value => $text) {
        $selected = $optionSelected == $value ? 'selected' : '';
        $op .= "<option value='$value' $selected>$text</option>";
    }
    $options = $op;
}

if(!isset($options) && isset($value)) {
    $options = "<option value='$value' selected></option>";
}
@endphp

<div class="form-group">
    <label for="{{ $id }}">{!! __($label) !!}</label>

        <select
            id="{{ $id }}"
            name="{{ $name }}"
            class="{{ $class }}"
            {{ $url }}
            @isset($help) aria-describedby="{{ $id }}Help" @endisset
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            {{ $attributes ?? null }}>
            {!! $options ?? '' !!}
        </select>

    @isset($help)
        <small id="{{ $id }}Help" class="form-text text-muted">{{ $help }}</small>
    @endisset

    <div class="invalid-feedback">
        @foreach($errors->get($name) as $msg)
        {{$msg}}<br />
        @endforeach
    </div>
</div>
