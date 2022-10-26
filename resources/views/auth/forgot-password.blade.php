@extends('layouts.auth')

@section('title', __("Забыли пароль"))

@section('content')
    <x-forms.auth-forms
        title="Забыли пароль"
        method="POST"
        action="{{ route('password.email') }}"
    >

        <x-forms.email-input/>

        <x-forms.primary-button>Отправить</x-forms.primary-button>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="#" class="text-white hover:text-white/70 font-bold">Забыли пароль?</a></div>
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">Вспомнил пароль</a></div>
            </div>
        </x-slot:buttons>

    </x-forms.auth-forms>
@endsection
