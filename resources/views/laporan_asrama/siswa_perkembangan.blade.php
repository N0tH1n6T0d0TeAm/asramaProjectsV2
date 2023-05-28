@extends('layouts.master')
@section('content')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

    <div class="container ">
        <div class="card mb-3">
            <form action="{{ route('siswa_perkembangan') }}" method="GET">
                <div class="card-header pb-2">
                    <h5>Filter</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row mb-3">
                        <div class="col-6">
                            <input type="text" placeholder="Nama Siswa" class="form-control" name="nama">
                        </div>
                        <div class="col-3">
                            <select class="form-select" name="angkatan">
                                <option value="">Angkatan</option>
                                @foreach ($data3 as $d)
                                <option value="{{$d->id_angkatan}}">{{$d->id_angkatan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-select" name="jurusan">
                                <option value="">Jurusan</option>
                                @foreach ($data2 as $t)
                                    <option value="{{ $t->id_jurusan }}">{{ $t->jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row py-0">
                        <div class="col">
                            <button class="btn btn-primary">Cari</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach ($data as $d)
            <div class="col-md-3 p-3 item">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('siswa/' . $d->foto_profil) }}" class="card-img-top" alt="..."
                        style="object-fit: cover; height: 20rem">
                        <a href="#" class="btn btn-danger status" id_siswa="{{$d->nis}}"><i class="fas fa-arrow-down"></i></a>
                         <a href="#" class="btn btn-success alumni" id_siswas="{{$d->nis}}"><i class="fas fa-arrow-up"></i></a>
                        <input type="hidden" id="status_siswa" value="tidak aktif">
                    <div class="card-body">
                        <h5 class="card-title">{{ $d->nama_siswa }}</h5>
                        <p class="card-text">{{ $d->jurusan->jurusan }} | A-{{ $d->angkatan->id_angkatan }}</p>
                        <a href="/detail_perkembangan/{{$d->nis}}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    
    </div>
    

  
    <script>

        $('.status').on('click',function(){
            var ids = $(this).attr('id_siswa');
            var status_siswa = $('#status_siswa').val();
            
            swal({
                icon: "warning",
                title: "Anda Yakin?",
                text: "Apakah Anda Yakin Anak Ini Telah Dikeluarkan?",
                buttons: true,
                dangerMode: true,
            }).then((kalauDikeluarkan) => {
                if(kalauDikeluarkan){
                    window.location = "/update_status/" +ids+'/'+status_siswa+'/',
                    swal('Status Anak Berhasil Dikeluarkan!',{icon:"success"})
                }else{
                    swal('Anak Tidak Jadi Dikeluarkan',{icon:"info"})
                }
            })
        })

        $('.alumni').on('click',function(){
            var id_alumni = $(this).attr('id_siswas');
            
            swal({
                icon: "warning",
                title: "Anda Yakin?",
                text: "Apakah Anda Yakin Anak Ini Telah Telah Lulus?",
                buttons: true,
                dangerMode: true,
            }).then((kalauDikeluarkan) => {
                if(kalauDikeluarkan){
                    window.location = "/update_status_alumni/" +id_alumni+'/',
                    swal('Status Anak Berhasil Diluluskan!',{icon:"success"})
                }else{
                    swal('Anak Tidak Jadi Dikeluarkan',{icon:"info"})
                }
            })
            
        })

    </script>
@endsection
