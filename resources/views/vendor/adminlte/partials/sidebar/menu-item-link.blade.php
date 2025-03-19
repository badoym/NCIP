@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
@php( $profile_url = Auth::user()->adminlte_profile_url() )
@endif

@if (config('adminlte.use_route_url', false))
@php( $profile_url = $profile_url ? route($profile_url) : '' )
@php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
@php( $profile_url = $profile_url ? url($profile_url) : '' )
@php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
        href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset
        {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}

            @isset($item['label'])
            <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">
                {{ $item['label'] }}
            </span>
            @endisset
        </p>
    </a>

</li>



<style scoped>
    .nav-item .active {
        background-color: #f29f05 !important;
        color: white !important;
    }
</style>