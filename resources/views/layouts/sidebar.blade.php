<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('image/user/'.auth()->user()->foto)}}" class="img-circle" style="object-fit: cover; width:50px; height: 45px;" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="header">MASTER</li>
            <li>
                <a href="{{route('lokasi.index')}}">
                    <i class="fa fa-money"></i> <span>Data Barang</span>
                </a>
            </li>
            <li class="header">TRANSAKSI</li>
            <li>
                <a href="{{route('peminjaman.index')}}">
                    <i class="fa fa-money"></i> <span>Peminjaman</span>
                </a>
            </li>
        
            <li class="header">AKUN</li>
            @if (auth()->user()->level == 'manajer')
            <li>
                <a href="{{route('user.index')}}">
                    <i class="fa fa-money"></i> <span>Data Pengguna</span>
                </a>
            </li>
            @endif
            <li>
                <a href="{{route('pass.edit')}}">
                    <i class="fa fa-money"></i> <span>Ganti Password</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="$('#logout-form').submit()">
                    <i class="fa fa-money"></i> <span>Log Out</span>
                </a>
            </li>
            
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>