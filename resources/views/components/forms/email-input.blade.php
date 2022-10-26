@props([
    'value' => old('email')
])

<x-forms.text-input
    type="email"
    name="email"
    placeholder="E-mail"
    required="true"
    value="{{ $value }}"
    :isError="$errors->has('email')"
/>

@error('email')
    <x-forms.error>
        {{ $message }}
    </x-forms.error>
@enderror
