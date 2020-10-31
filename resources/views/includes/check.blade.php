<div class="form-group">

    @php
    $id = $id ?? Str::random(10);
    if(isset($name))
        $nameErrors = strstr($name,'[',true) !== false ? strstr($name,'[',true) : $name;
    @endphp

    <div class="form-check">
        <input type="{{ $type ?? 'radio' }}"
            class="form-check-input {{ $class ?? "" }} {{ isset($nameErrors) && $errors->has($nameErrors) ? 'is-invalid' :'' }}"
            id="{{ $id }}"
            value="{{ $value ?? true }}"
            {{ $name ? 'name=' . $name : '' }}
            {{ $elements ?? '' }}>
        <label class="form-check-label" for="{{ $id }}">{!! $label !!}</label>

        @isset($nameErrors)
        <div class="invalid-feedback">
            @foreach($errors->get($nameErrors) as $msg)
                {{$msg}}<br />
            @endforeach
        </div>
        @endisset
    </div>
</div>
