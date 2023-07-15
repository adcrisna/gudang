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
            <li><a href="{{ route('home.admin') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data History Barang</li>
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
                        <h3 class="box-title">Data History Barang</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-product">
                            <thead>
                                <tr>
                                    <th style="display: none">ID</th>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Nama User</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi</th>
                                    <th>Notes</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$product as $key => $value)
                                    <tr>
                                        <td style="display: none">{{ @$value->id }}</td>
                                        <td>{{ @$value->Product->id }}</td>
                                        <td>{{ @$value->Product->name }}</td>
                                        <td>{{ @$value->User->name }}</td>
                                        <td>{{ @$value->status }}</td>
                                        <td>{{ @$value->jumlah }}</td>
                                        <td>{{ @$value->kondisi }}</td>
                                        <td>{{ @$value->Lokasi->id }}</td>
                                        <td>{{ @$value->notes }}</td>
                                        <td>{{ @$value->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
            $('input[name=stok]').val(row[4]);
            $('#modal-form-edit-product').modal('show');
        });
        $('#modal-form-tambah-product').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=name]').val('');
            $('input[name=merk]').val('');
            $('input[name=stok]').val('');
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