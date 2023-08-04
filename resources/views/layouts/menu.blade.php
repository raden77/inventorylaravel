@inject('menus', 'App\Models\menus')
@inject('userMenu', 'App\Models\userMenu')
<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
@php
    $userdata= session('userdata');

    $listsubmenu=$userMenu->with('User:id,name','subMenu:subMenusId,subMenuName')
                ->where('id',$userdata['id'])->get();

    $datasubmenu=[];
    foreach ($listsubmenu as $key => $value) {
        array_push($datasubmenu, $value->subMenusId);
    }

    $setmenu = $menus->select('menus.*', 'submenus.*')
                        ->join('submenus', 'menus.menuId', '=', 'submenus.menuId')
                        ->where('submenus.tipeMenu', 1)
                        ->whereIn('submenus.subMenusId', $datasubmenu)
                        ->orderBy('menus.menuId')
                        ->get();

@endphp
@foreach($setmenu as $idx => $item)
    @if($idx==0)
        <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
                <i class="nav-icon {{ $item->menuIcon }}"></i>
                <p>
                    {{ $item->menuName }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item" style="padding-left:10px">
                    <a href="{{'/'.$item->subMenuUrl}}" class="nav-link {{ Request::is($item->subMenuUrl) ? 'active' : '' }}">
                        <i class="{{ $item->subMenuIcon }} nav-icon"></i>
                        <p>  {{ $item->subMenuName }}</p>
                    </a>
                </li>
            </ul>
    @elseif($item->menuId==$setmenu[$idx-1]->menuId)
            <ul class="nav nav-treeview">
                <li class="nav-item" style="padding-left:10px">
                    <a href="{{'/'.$item->subMenuUrl}}" class="nav-link {{ Request::is($item->subMenuUrl) ? 'active' : '' }}">
                        <i class="{{ $item->subMenuIcon }} nav-icon"></i>
                        <p>  {{ $item->subMenuName }}</p>
                    </a>
                </li>
            </ul>
    @else
        </li>
        <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
                <i class="nav-icon {{ $item->menuIcon }}"></i>
                <p>
                    {{ $item->menuName }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item" style="padding-left:10px">
                    <a href="{{'/'.$item->subMenuUrl}}" class="nav-link {{ Request::is($item->subMenuUrl) ? 'active' : '' }}">
                        <i class="{{ $item->subMenuIcon }} nav-icon"></i>
                        <p>  {{ $item->subMenuName }}</p>
                    </a>
                </li>
            </ul>
    @endif


@endforeach

{{-- @foreach($list as $item)
        <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
                <i class="nav-icon {{ $item->menuIcon }}"></i>
                <p>
                    {{ $item->menuName }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
            @foreach($item->submenus as $subitem)
                <li class="nav-item" style="padding-left:10px">
                    <a href="{{'/'.$subitem->subMenuUrl}}" class="nav-link {{ Request::is($subitem->subMenuUrl) ? 'active' : '' }}">
                        <i class="{{ $subitem->subMenuIcon }} nav-icon"></i>
                        <p>  {{ $subitem->subMenuName }}</p>
                    </a>
                </li>
            @endforeach

            </ul>
        </li>
@endforeach --}}

{{-- <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-circle"></i>
      <p>
        Level 1
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Level 2</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>
            Level 2
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-dot-circle nav-icon"></i>
              <p>Level 3</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-dot-circle nav-icon"></i>
              <p>Level 3</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-dot-circle nav-icon"></i>
              <p>Level 3</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Level 2</p>
        </a>
      </li>
    </ul>
</li> --}}
