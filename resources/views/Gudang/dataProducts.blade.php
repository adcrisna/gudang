@extends('layouts.gudang')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        img.zoom {
            width: 130px;
            height: 100px;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
        }

        .transisi {
            -webkit-transform: scale(1.8);
            -moz-transform: scale(1.8);
            -o-transform: scale(1.8);
            transform: scale(1.8);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('home.gudang') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Barang</li>
        </ol>
        <br />
    </section>
    <section class="content">
        @if (\Session::has('msg_success'))
            <h5>
                <div class="alert alert-info">
                    {{ \Session::get('msg_success') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_error'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_error') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Data Barang</h3>
                        <div class="box-tools pull-right">
                            {{-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exportModal"><i
                                    class="fa fa-download"></i>
                                Laporan</button> --}}
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#modal-form-tambah-product"><i class="fa fa-user-plus"> Tambah Barang
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-product">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Stok Awal</th>
                                    <th>Stok</th>
                                    <th style="display: none">Lokasi ID</th>
                                    <th>Lokasi</th>
                                    <th>Updated By</th>
                                    <th>Created At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$product as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id }}</td>
                                        <td><img class="zoom" src="{{ asset('gambar/' . $value->gambar) }}"></td>
                                        <td>{{ @$value->name }}</td>
                                        <td>{{ @$value->merk }}</td>
                                        <td>{{ @$value->stok_awal }}</td>
                                        <td>{{ @$value->stok }}</td>
                                        <td style="display: none">{{ @$value->Lokasi->id }}</td>
                                        <td>{{ @$value->Lokasi->name }}</td>
                                        <td>{{ @$value->User->name }}</td>
                                        <td>{{ @$value->created_at }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-primary btn-transaksi-product"><i
                                                    class="fa fa-edit">
                                                    In/Out</i></button> &nbsp;
                                            <button class="btn btn-xs btn-success btn-edit-product"><i class="fa fa-edit">
                                                    Ubah</i></button> &nbsp;
                                            <a href="{{ route('hapus.product', @$value->id) }}"><button
                                                    class=" btn btn-xs btn-danger"
                                                    onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                        class="fa fa-trash"> Hapus</i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-form-tambah-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Data Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tambah.product') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="merk" class="form-control" placeholder="Merk" required>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="number" name="stok" min="0" class="form-control"
                                placeholder="Stok Barang" required>
                        </div>
                        <div class="form-group has-feedback">
                            <select name="lokasi" id="lokasi" class="form-control" required>
                                <option value="">Pilih</option>
                                @foreach (@$lokasi as $key => $item)
                                    <option value="{{ @$item->id }}">{{ @$item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gambar Barang :</label>
                            <input type="file" name="gambar" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Export</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.cetak') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tanggalAwal" class="form-control" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tanggalAkhir" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="modal fade" id="modal-form-edit-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Update Data Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ubah.product') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="text" name="id" readonly class="form-control" placeholder="ID" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Barang :</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Merk :</label>
                            <input type="text" name="merk" class="form-control" placeholder="Merk" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Stok Awal :</label>
                            <input type="number" name="stok_awal" min="0" class="form-control"
                                placeholder="Stok Awal" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Stok Saat ini :</label>
                            <input type="number" name="stok" min="0" class="form-control"
                                placeholder="Stok Barang" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <select name="lokasi" id="lokasi" class="form-control" required>
                                <option value="">Pilih</option>
                                @foreach ($lokasi as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gambar Barang Baru:</label>
                            <input type="file" name="gambar" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-form-transaksi-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Barang Masuk/Keluar</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gudang.transaksi') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group has-feedback">
                                    <label>Barang : </label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group has-feedback">
                                    <label>Merk : </label>
                                    <input type="text" name="merk" class="form-control" placeholder="Merk"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group has-feedback">
                                    <label>Stok : </label>
                                    <input type="number" name="stok" min="0" class="form-control"
                                        placeholder="Stok Barang" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Kondisi : </label>
                                    <select name="kondisi" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Status Barang : </label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="Peminjaman">Peminjaman</option>
                                        <option value="Pengembalian">Pengembalian</option>
                                        <option value="Keluar">Keluar</option>
                                        <option value="Masuk">Masuk</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Jumlah : </label>
                                    <input type="number" name="jumlah" min="1" class="form-control"
                                        placeholder="Jumlah Barang">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Lokasi Barang : </label>
                                    <select name="lokasi" id="lokasi" class="form-control" required>
                                        <option value="">Pilih</option>
                                        @foreach ($lokasi as $key => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="notes">Notes</label>
                                <textarea name="notes" cols="10" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-product').DataTable();

        $('#data-product').on('click', '.btn-edit-product', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=name]').val(row[2]);
            $('input[name=merk]').val(row[3]);
            $('input[name=stok_awal]').val(row[4]);
            $('input[name=stok]').val(row[5]);
            $('select[name=lokasi]').val(row[6]);
            $('#modal-form-edit-product').modal('show');
        });
        $('#data-product').on('click', '.btn-transaksi-product', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=name]').val(row[2]);
            $('input[name=merk]').val(row[3]);
            $('input[name=stok]').val(row[5]);
            $('#modal-form-transaksi-product').modal('show');
        });
        $('#modal-form-tambah-product').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=name]').val('');
            $('input[name=merk]').val('');
            $('input[name=stok]').val('');
            $('input[name=stok_awal]').val('');
            $('select[name=lokasi]').val('');
            $('input[name=gambar]').val('');
        });

        $(document).ready(function() {
            $('.zoom').hover(function() {
                $(this).addClass('transisi');
            }, function() {
                $(this).removeClass('transisi');
            });
        });
    </script>
@endsection
