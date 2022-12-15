@extends('master.master-admin')

@section('title')
    PMB PEI
@endsection

@section('header')
@endsection

@section('navbar')
    @parent
@endsection


@section('menunya')
    Beranda
@endsection

@section('menu')
    @auth
        <ul class="metismenu" id="menu">
            <li class="mm-active"><a href="index">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Beranda</span>
                </a>
            </li>
            @if (auth()->user()->role == 'Administrator')
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-book"></i>
                        <span class="nav-text">Data Master </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="data-user">Pengguna</a></li>
                        <li><a href="data-school">Sekolah</a></li>
                        <li><a href="data-studyProgram">Program Studi</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-database"></i>
                        <span class="nav-text">Data Transaksi</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="data-registration">Pendaftaran</a></li>
                        <li><a href="data-payment">Pembayaran</a></li>
                    </ul>
                </li>

                <li><a href="data-announcement" aria-expanded="false">
                        <i class="fa fa-file"></i>
                        <span class="nav-text">Pengumuman</span>
                    </a>
                </li>
            @else
                @php
                    $no = 1;
                @endphp
                @foreach ($viewDataUser as $x)
                    @if ($no == 1)
                        <li><a href="data-registration" aria-expanded="false">
                                <i class="fa fa-database"></i>
                                <span class="nav-text">Pendaftaran</span>
                            </a>
                        </li>
                    @endif
                    @php
                        $no++;
                    @endphp
                @endforeach
            @endif
            <!--<li><a href="#" aria-expanded="false">
                    <i class="fa fa-download"></i>
                    <span class="nav-text">Pusat Unduhan</span>
                </a>
            </li>-->
        </ul>
    @endauth
@endsection

@section('content')
    <!--Buat Admin-->
    @auth
        @if (auth()->user()->role == 'Administrator')
            @include('dashboard.dashboard-admin')
        @elseif(auth()->user()->role == 'Calon Mahasiswa')
            @include('dashboard.dashboard-user')
        @endif
    @endauth
@endsection

@section('footer')
@endsection
