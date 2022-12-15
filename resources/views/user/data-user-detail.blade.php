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
    Detail Pengguna
@endsection

@section('menu')
@auth
        <ul class="metismenu" id="menu">
            <li><a href="dashboard">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Detail Pengguna</span>
                </a>
            </li>
            @if (auth()->user()->role == 'Administrator')
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-book"></i>
                        <span class="nav-text">Data Master </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('data-user')}}">Pengguna</a></li>
                        <li><a href="{{route('data-sekolah')}}">Sekolah</a></li>
                        <li><a href="{{route('data-prodi')}}">Program Studi</a></li>
                        <li><a href="{{route('data-jadwal')}}">Jadwal Kegiatan</a></li>
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
                            <li><a href="data-registration" aria-expanded="false">
                                    <i class="fa fa-database"></i>
                                    <span class="nav-text">Pendaftaran</span>
                                </a>
                            </li>
            @endif
        </ul>
    @endauth
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="dropdown float-end">
                            <a class="text-body dropdown-toggle font-size-18" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true"> <i class="uil uil-ellipsis-v"></i> </a>
                            <div class="dropdown-menu dropdown-menu-end"> <a class="dropdown-item"
                                    href="#profile-settings">Perbaharui Data</a> <a class="dropdown-item"
                                    href="profile">Segarkan</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div>
                                    @if ($viewData->foto != null)
                                        <img class="avatar-lg rounded-circle img-thumbnail"
                                            src="{{ url('/' . $viewData->foto) }}" alt="" width="100px" />
                                    @else
                                        <img class="avatar-lg rounded-circle img-thumbnail"
                                            src="{{ asset('sipenmaru/images/ava.png') }}" alt=""
                                            width="100px" />
                                    @endif
                        </div>
                        <h5 class="mt-3 mb-1">
                            {{ $viewData->nama }}
                        </h5>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary btn-sm"><i class="uil uil-envelope-alt me-2"></i>
                                Kirim Pesan</button>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-muted">
                        <div class="table-responsive mt-4">
                            @auth

                                <div>
                                    <p class="mb-1">Nama :</p>
                                    <h5 class="font-size-16">
                                        {{ $viewData->nama }}
                                    </h5>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">No Hp :</p>
                                    <h5 class="font-size-16">
                                                {{ $viewData->no_hp }}
                                    </h5>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">E-mail :</p>
                                    <h5 class="font-size-16">{{ $viewData->email }}</h5>
                                </div>

                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="profile-tab">
                        <div class="custom-tab-1">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                        class="nav-link active show">Profil</a>
                                </li>
                                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                                        class="nav-link">Pengaturan</a>
                                </li>
                            </li>
                            </ul>
                            <div class="tab-content">
                                <div id="about-me" class="tab-pane fade active show">
                                    <div class="profile-personal-info">
                                            <br>
                                                @if ($viewData->no_hp == null || $viewData->tempat_lahir == null || $viewData->gender == null || $viewData->alamat == null)
                                                    <div class="alert alert-warning alert-dismissible fade show">
                                                        <svg viewbox="0 0 24 24" width="24" height="24"
                                                            stroke="currentColor" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="me-2">
                                                            <path
                                                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                                            </path>
                                                            <line x1="12" y1="9" x2="12" y2="13"></line>
                                                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                                        </svg>
                                                        <strong>Peringatan!</strong> Data belum lengkap. Silahkan lengkapi data akun sekarang.
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="btn-close">
                                                        </button>
                                                    </div>
                                                @endif
                                                <br>
                                                <h4 class="text-primary mb-4">Informasi Pribadi</h4>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Nama </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">{{ $viewData->nama }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Jenis Kelamin </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        {{ $viewData->gender }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Tempat Lahir</h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        {{ $viewData->tempat_lahir }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Tanggal Lahir</h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        {{ $viewData->tanggal_lahir }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-sm-3 col-5">
                                                        <h5 class="f-w-500">Alamat
                                                        </h5>
                                                    </div>
                                                    <div class="col-sm-9 col-7">
                                                        {{ $viewData->alamat }}
                                                    </div>
                                                </div>
                                    </div>
                                    <div class="profile-about-me">
                                        <div class="pt-4 border-bottom-1 pb-3">
                                            <h4 class="text-primary">Kontak Pribadi</h4>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-6 col-6">
                                                <h5 class="f-w-500"><i class="fas fa-phone-alt"></i>
                                                    {{ $viewData->no_hp }}

                                                </h5>
                                            </div>
                                            <div class="col-sm-6 col-6">
                                                <h5 class="f-w-500"><i class="fas fa-envelope"></i>
                                                    {{ $viewData->email }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-about-me">
                                        <div class="pt-4 border-bottom-1 pb-3">
                                            <h4 class="text-primary">Sosial Media</h4>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-3 col-5">
                                                <h2>
                                                            <a href="https://www.instagram.com/{{ $viewData->instagram }}/"><i
                                                                    class="fab fa-instagram" style="width: 50px"></i></a>
                                                    
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="profile-settings" class="tab-pane fade">
                                    <div class="pt-3">
                                        <div class="settings-form">
                                            <br>
                                            <h4 class="text-primary">Pengaturan Profil</h4>
                                            <form action="../update-user/{{ $viewData->user_id }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="userid" value="{{ auth()->user()->user_id}}">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" value="{{ $viewData->nama }}"
                                                            class="form-control" name="nama" readonly>
                                                        
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" value="{{ $viewData->email }}"
                                                            class="form-control" name="email" readonly>
                                                    </div>
                                                </div>
                                                        <input type="hidden" name="id" class="form-control-file"
                                                            value="{{ $viewData->user_id }}">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Jenis Kelamin</label>
                                                                @if ($viewData->gender != null)
                                                        @if ($viewData->gender == 'Perempuan')
                                                            <select class="form-control wide" name="jk"
                                                                value="{{ old('jk') }}">
                                                                <option value="{{ $viewData->gender }}" selected>
                                                                    {{ $viewData->gender }}</option>
                                                                <option value="Laki-laki">Laki-laki</option>
                                                            </select>
                                                        @else
                                                            <select class="form-control wide" name="jk"
                                                                value="{{ old('jk') }}">
                                                                <option value="{{ $viewData->gender }}" selected>
                                                                    {{ $viewData->gender }}</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                        @endif
                                                    @else
                                                        <select class="form-control wide" name="jk"
                                                            value="{{ old('jk') }}">
                                                            <option value="{{ old('jk') }}" disabled selected>Pilih
                                                                Jenis Kelamin </option>
                                                            <option value="Laki-laki">Laki-aki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    @endif
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Foto Profil</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Upload</span>
                                                                    <div class="form-file">
                                                                        <input type="file"
                                                                            class="form-file-input form-control"
                                                                            name="foto">
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="pathFoto"
                                                                    class="form-control-file" value="{{ $viewData->foto }}">
                                                                <img class="avatar-lg rounded-circle img-thumbnail"
                                                                    src="{{ url('/' . $viewData->foto) }}" width="75px"
                                                                    height="auto" alt="">
                                                                @error('foto')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Warning!</strong>
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Tempat Lahir</label>
                                                                <input type="text" value="{{ $viewData->tempat_lahir }}" value="{{ old('tempat') }}"
                                                                    class="form-control" name="tempat">
                                                                @error('tempat')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Warning!</strong>
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Tanggal Lahir</label>
                                                                <input type="date" value="{{ $viewData->tanggal_lahir }}" value="{{ old('tanggal') }}"
                                                                    class="form-control" name="tanggal">
                                                                @error('tanggal')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Warning!</strong>
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alamat</label>
                                                            <textarea name="alamat" id="" cols="30" rows="5"
                                                                class="form-control">{{ $viewData->alamat }}</textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">No HP</label>
                                                                <input type="text" value="{{ $viewData->no_hp }}" value="{{ old('hp') }}"
                                                                    class="form-control" name="hp">
                                                                 @error('hp')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Warning!</strong>
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Sosial Media
                                                                    Instagram</label>
                                                                <input type="text" value="{{ $viewData->instagram }}" value="{{ old('ig') }}"
                                                                    class="form-control" name="ig">
                                                                @error('ig')
                                                                    <div class="alert alert-warning" role="alert">
                                                                        <strong>Warning!</strong>
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                <button class="btn btn-primary" type="submit">Perbaharui Data</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection

@section('footer')
@endsection
