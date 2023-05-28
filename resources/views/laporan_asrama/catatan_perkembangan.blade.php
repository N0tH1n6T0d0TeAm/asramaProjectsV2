@extends('layouts.master')
@section('content')
    <div class="card">
  <div class="card-header">
   <a href="/detail_perkembangan/{{$data->nis_siswas}}"><i class="fa-solid fa-arrow-left"></i></a> <b>{{$data->judul_buku}} [{{$data->level_kategori ?? ""}}]</b>
   @if(auth()->user()->id == $data->id_pengguna) <a href="/edit_catatan/{{$data->id_perkembangan}}" style="float:right">Edit</a>@endif
  </div>
  <div class="card-body">
   {!! nl2br($data->isi_buku ?? "Catatan Masih Dalam Proses Pamong") !!}
  </div>
</div>



@endsection