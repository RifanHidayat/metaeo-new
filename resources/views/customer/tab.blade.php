<div class="card-toolbar">
    <ul class="nav nav-light-success nav-bold nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('customer/payment/*') ? 'active' : '' }}" href="/customer/payment/{{ $customer->id }}">
                <span class="nav-icon"><i class="flaticon2-list"></i></span>
                <span class="nav-text">Pembayaran</span>
            </a>
        </li>
        <!-- <li class="nav-item">
                <a class="nav-link {{ request()->is('customer/warehouse/*') ? 'active' : '' }}" href="/customer/warehouse/{{ $customer->id }}">
                    <span class="nav-icon"><i class="flaticon2-shelter"></i></span>
                    <span class="nav-text">Gudang</span>
                </a>
            </li> -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('customer/warehouse/*') ? 'active' : '' }}" href="/customer/warehouse/{{ $customer->id }}">
                <span class="nav-icon"><i class="flaticon2-shelter"></i></span>
                <span class="nav-text">Gudang</span>
            </a>
            <!-- <div class="dropdown-menu">
                <a class="dropdown-item" href="/warehouse/create?customer={{ $customer->id }}"><i class="flaticon2-plus icon-sm"></i> &nbsp;&nbsp;Tambah</a>
            </div> -->
        </li>
    </ul>
</div>
<div class="card-toolbar">
    <div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-hover-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ki ki-bold-more-hor "></i>
        </button>
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
        </div>
    </div>
</div>