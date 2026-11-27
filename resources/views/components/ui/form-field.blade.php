@props([
    'name',
    'label',
    'value' => null,
    'type' => 'text',
    'required' => false,
])

<div class="mb-3">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <input
        type="{{$type}}"
        class="form-control @error($name) is-invalid @enderror"
        id="{{$name}}"
        name="{{$name}}"
        value="{{old($name, $value)}}"
        @if ($required) required @endif
        {{$attributes}}
    />
    @error ($name)
        <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>
