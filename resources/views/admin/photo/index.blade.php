@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Kumpulan Foto</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Foto</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable with default features</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('admin.photo.index') }}" method="GET">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            {{-- @can('posts.create') --}}
                                            <div class="input-group-prepend">
                                                <a href="{{ route('admin.photo.create') }}" class="btn btn-primary"
                                                    style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                            </div>
                                            {{-- @endcan --}}
                                            <input type="text" class="form-control" name="q"
                                                placeholder="cari berdasarkan judul berita">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                                    CARI
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                                <th scope="col">Judul photo</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Satus</th>
                                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($photos as $no => $photo)
                                                <tr>
                                                    <th scope="row" style="text-align: center">
                                                        {{ ++$no + ($photos->currentPage() - 1) * $photos->perPage() }}
                                                    </th>
                                                    <td>{{ $photo->title }}</td>
                                                    <td>{{ $photo->galeri->title }}</td>
                                                    <td><img src="{{ asset($photo->image) }}" style="width: 150px">
                                                    </td>
                                                    <td style="width: 15%;text-align: center">
                                                        @if ($photo->is_active == '0')
                                                            <a class="btn btn-sm btn-warning">
                                                                Tidak Aktif
                                                            </a>
                                                        @else
                                                            <a class="btn btn-sm btn-success">
                                                                Aktif
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.photo.edit', $photo->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"
                                                            id="{{ $photo->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div style="text-align: center">
                                        {{ $photos->links('vendor.pagination.bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>


            <!-- /.modal -->

            <!-- modal tambah -->
    </div>




    </section>
    <!-- /.content -->
    </div>
    <script>
        //ajax delete
        function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    // console.log("{{ asset('/post/hapus/') }}/" + id);

                    //ajax delete
                    jQuery.ajax({
                        // url: "/admin/event/"+id,
                        // url: "{{ asset('/photo/delete/') }}/" + id,
                        url: "{{ asset('/photo/') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            // console.log(response);
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }
    </script>
@stop
