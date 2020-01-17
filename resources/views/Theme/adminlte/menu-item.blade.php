@if ($item["submenu"] == [])
<li class="nav-item">
    <a href="{{url($item['Men_url'])}}" class="nav-link">
        <i class="nav-icon {{$item["Men_icono"]}}"></i>
        <p>
            {{$item["Men_nombre"]}}
        </p>
    </a>
</li>
@else
<li class="nav-item has-treeview">
    <a href=" javascript:;" class="nav-link">
    <i class="nav-icon {{$item["Men_icono"]}}"></i>
    <p>
        {{$item["Men_nombre"]}}
        <i class="right fas fa-angle-left"></i>
    </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach ($item["submenu"] as $submenu) 
        @include("theme.$theme.menu-item", ["item"=> $submenu])
        @endforeach
    </ul>
</li>
@endif