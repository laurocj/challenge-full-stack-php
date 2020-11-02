@php
$id = isset($id) ? $id : Str::random(10);

$value = old($name) ?? ($value ?? null);

$class = isset($class) ? "form-control $class" : "form-control ";

if($errors->has($name)) {
    $class .= " is-invalid ";
} else if(old($name) !== null) {
    $class .= " is-valid ";
}
@endphp

<div class="form-group">
    <label for="{{ $id }}">{!! __($label) !!}</label>

    @if(isset($type) && $type == 'textarea')
        <textarea id="{{ $id }}"
            name="{{ $name }}"
            class="{{ $class }}"
            @isset($help) aria-describedby="{{ $id }}Help" @endisset
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            {{ $attributes ?? null }}>{{ $value }}</textarea>
    @else
        <input id="{{ $id }}"
            name="{{ $name }}"
            class="{{ $class }}"
            value="{{ $value }}"
            type="{{ $type ?? 'text' }}"
            @isset($help) aria-describedby="{{ $id }}Help" @endisset
            @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
            {{ $attributes ?? null }}>
    @endif
    @isset($help)
        <small id="{{ $id }}Help" class="form-text text-muted">{{ $help }}</small>
    @endisset

    <div class="invalid-feedback">
        @foreach($errors->get($name) as $msg)
        {{$msg}}<br />
        @endforeach
    </div>
</div>
