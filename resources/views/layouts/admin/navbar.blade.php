<nav class="navbar navbar-secondary navbar-expand-lg">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item {{Request::routeIs('dashboard') ? 'active' : ''}}">
                <a href="{{route('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item {{Request::routeIs('designer') ? 'active' : ''}}">
                <a href="{{route('designer')}}" class="nav-link"><i class="fas fa-users"></i><span>Data Designer</span></a>
            </li>
            <li class="nav-item {{Request::routeIs('admin.product*') ? 'active' : ''}}">
                <a href="{{route('admin.product')}}" class="nav-link"><i class="fas fa-tshirt"></i><span>Data Produk</span></a>
            </li>
            <li class="nav-item {{Request::routeIs('admin.order*') ? 'active' : ''}}">
                <a href="{{route('admin.order')}}" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Data Penyewaan</span></a>
            </li>
            <li class="nav-item {{Request::routeIs('admin.rented*') ? 'active' : ''}}">
                <a href="{{route('admin.rented')}}" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Data Pengembalian</span></a>
            </li>
            <li class="nav-item {{Request::routeIs('admin.report*') ? 'active' : ''}}">
                <a href="{{route('admin.report')}}" class="nav-link"><i class="fas fa-file"></i><span>Laporan Bulanan</span></a>
            </li>
        </ul>
    </div>
</nav>