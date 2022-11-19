<nav class="hidden 2xl:flex gap-8">
{{--    <a href="{{ route('home') }}" class="text-white hover:text-pink font-bold">Главная</a>--}}
{{--    <a href="#" class="text-white hover:text-pink font-bold">Каталог товаров</a>--}}
{{--    <a href="#" class="text-white hover:text-pink font-bold">Корзина</a>--}}

    @foreach($menu->all() as $item)
        <a href="{{ $item->link() }}"
           class="text-white hover:text-pink @if($item->isActive()) font-bold @endif">
            Главная
        </a>
    @endforeach
</nav>
