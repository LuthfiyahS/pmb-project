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
    Pengguna
@endsection

@section('menu')
    @auth
        <ul class="metismenu" id="menu">
            <li><a href="dashboard">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Pengguna</span>
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
                        <li><a href="{{route('data-registration')}}">Pendaftaran</a></li>
                        <li><a href="{{route('data-pembayaran')}}">Pembayaran</a></li>
                    </ul>
                </li>
                <li><a href="{{route('data-pengumuman')}}" aria-expanded="false">
                        <i class="fa fa-file"></i>
                        <span class="nav-text">Pengumuman</span>
                    </a>
                </li>
            @else
               <li><a href="{{route('data-registration')}}" aria-expanded="false">
                    <i class="fa fa-database"></i>
                        <span class="nav-text">Pendaftaran</span>
                    </a>
                </li>
            @endif
        </ul>
    @endauth
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Data</h4>

                    <!-- center modal -->
                    <div>
                        <button class="btn btn-info waves-effect waves-light mb-4" onclick="printDiv('cetak')"><i
                                class="fa fa-print"> </i></button>
                        <!--<button class="btn btn-secondary waves-effect waves-light mb-4"><i class="fas fa-eye"
                                title="Mode grid"> </i></button>-->
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".modal"
                            style="margin-bottom: 1rem;"><i class="mdi mdi-plus me-1"></i>Tambahkan Pengguna</button>
                    </div>


                    <div class="modal fade modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="save-user" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="userid" value="{{ auth()->user()->id}}">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <label for="iduser">Nama</label>
                                                    <input type="text" class="form-control" id="nama"
                                                        placeholder="Masukkan Nama" name="nama" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="iduser">Email</label>
                                            <input type="email" class="form-control" id="nama"
                                                placeholder="Masukkan Email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="iduser">Kata Sandi</label>
                                            <input type="password" class="form-control" id="nama"
                                                placeholder="Masukkan Kata Sandi" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label for="iduser">Jenis Kelamin</label>
                                                    <select class="default-select form-control wide" title="Jenis Kelamin"
                                                        name="gender" required>
                                                        <option value="Laki-laki" disabled>Pilih Jenis Kelamin</option>
                                                        <option value="Perempuan">Female</option>
                                                        <option value="Laki-laki">Male</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="iduser">Telepon</label>
                                                    <input type="number" class="form-control" placeholder="Enter Telepon"
                                                        name="nohp" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label for="iduser">Role Pengguna</label>
                                                    <select class="default-select form-control wide" title="Country" aria-placeholder="Pilih role"
                                                        name="level" required>
                                                        <option value="Calon Mahasiswa" disabled>Pilih Role</option>
                                                        <option value="Administrator">Administrator</option>
                                                        <option value="Calon Mahasiswa">Calon Mahasiswa</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label for="iduser">Foto Profil</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Upload</span>
                                                        <div class="form-file">
                                                            <input type="file" class="form-file-input form-control"
                                                                name="foto">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 d-flex">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" name="add" class="btn btn-primary">Tambah Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="cetak">
                        {{ csrf_field() }}
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUser as $x)
                                    <tr>
                                        <td>
                                            @if ($x->profile->foto != null)
                                                <img class=" rounded-circle img-thumbnail" src="{{ url('/' . $x->profile->foto) }}"
                                                    alt="" width="45px" />
                                            @else
                                                <img class="rounded-circle img-thumbnail"
                                                    src="{{ asset('sipenmaru/images/ava.png') }}" alt="" width="45px" />
                                            @endif
                                        </td>
                                        <td>{{ $x->profile->nama }}</td>
                                        <td>
                                            @if ($x->profile->gender == 'Perempuan')
                                                <span class="badge badge-secondary">Perempuan</span>
                                            @elseif($x->profile->gender == 'Laki-laki')
                                                <span class="badge"
                                                    style="background-color: rgb(81, 171, 255)">Laki-Laki</span>
                                            @else
                                                <span class="badge badge-warning">?</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $x->profile->no_hp }}</strong></a></td>
                                        <td><a href="javascript:void(0);"><strong>{{ $x->email }}</strong></a></td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-light shadow btn-xs sharp me-1" title="Data Registration"
                                                    href="data-user/edit/{{ $x->id }}"><i class="fa fa-file-alt"></i></a>
                                                <a class="btn btn-primary shadow btn-xs sharp me-1" title="Edit"
                                                    href="data-user/edit/{{ $x->id }}"><i
                                                        class="fa fa-pencil-alt"></i></a>
                                                <a href="data-user/delete/{{ $x->id }}"
                                                    class="btn btn-danger shadow btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                                    <div class="modal fade delete{{ $x->id }}" tabindex="-1"
                                                        role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hapus Data</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center"><i
                                                                        class="fa fa-trash"></i><br> Apakah anda yakin ingin
                                                                    menghapus data ini?<br> {{ $x->id }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger light"
                                                                        data-bs-dismiss="modal">Batalkan</button>
                                                                    <a href="delete-user/{{ $x->id }}">
                                                                        <button type="submit" class="btn btn-danger shadow">
                                                                            Ya, Hapus Data!
                                                                        </button></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
