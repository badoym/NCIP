<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item has-treeview {{ $item['submenu_class'] }}">

    {{-- Menu toggler --}}
    <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
        href="" {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}
            <i class="fas fa-angle-left right"></i>

            @isset($item['label'])
            <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">
                {{ $item['label'] }}
            </span>
            @endisset
        </p>

    </a>

    {{-- Menu items --}}
    <ul class="nav nav-treeview">
        @each('adminlte::partials.sidebar.menu-item', $item['submenu'], 'item')
    </ul>

</li>

<style scoped>
    .nav-treeview .active {
        color: rgb(255, 188, 73) !important;
        background-color: transparent !important;
        /* border-bottom: 1px solid rgb(255, 188, 73) !important; */
    }
</style>