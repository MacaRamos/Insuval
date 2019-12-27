@if ($item["submenu"] == [])
<li class="dd-item dd3-item" data-id="{{$item["Men_id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["Men_url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="{{url("admin/menu/". $item["Men_id"] . "/editar")}}">{{$item["Men_nombre"] . " | Url -> " . $item["Men_url"]}} Icono -> <i style="font-size:20px;" class="fa fa-fw {{isset($item["Men_icono"]) ? $item["Men_icono"] : ""}}"></i></a>
    </div>
</li>
@else
<li class="dd-item dd3-item" data-id="{{$item["Men_id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["Men_url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="{{url("admin/menu/". $item["Men_id"] . "/editar") }}">{{ $item["Men_nombre"] . " | Url -> " . $item["Men_url"]}} Icono -> <i style="font-size:20px;" class="fa fa-fw {{isset($item["Men_icono"]) ? $item["Men_icono"] : ""}}"></i></a>
    </div>
    <ol class="dd-list">
        @foreach ($item["submenu"] as $submenu)
        @include("admin.menu.menu-item",[ "item" => $submenu ])
        @endforeach
    </ol>
</li>
@endif