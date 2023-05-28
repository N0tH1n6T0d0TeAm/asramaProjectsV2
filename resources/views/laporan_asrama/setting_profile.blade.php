@extends('layouts.master')
@section('content')

<style>
    .foto_profil{
   height: 30px;
   width: 40px;
   border-radius: 50%;
   cursor: pointer;
}
</style>

<form action="/update_profile/" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" value="{{auth()->user()->id}}" name="ids">

<table style="width: 100%">
    <tr>
        <td></td>
        <td><img src="{{asset('img/mobil.jpg')}}" title="Ubah Foto" class="foto_profil" alt=""> {{$data->name}} <a href="/setting_akun/{{$data->id}}" style="color: blue; font-size: 12px;">Setting Akun</a></td>
    </tr>
    <tr>
        <td></td>
        <td>*Penggantian Foto Profile Masih Dalam Proses Pengembangan*</td>
    </tr>
    <tr>
        <td><b>Username</b></td>
        <td><input type="text" class="form-control nama" name="nama" value="{{$data->name}}" placeholder="username"></td>
    </tr>
    <tr>
        <td><b>Bio</b></td>
        <td><textarea name="bio" id="" class="form-control" cols="30" rows="10">{{$data->active}}</textarea></td>
    </tr>
</table><br>
<button style="float:right" class="btn btn-primary">Simpan</button>

</form>

<script>
    $(document).ready(function(){
        $('.nama').on('input',function(){
            $(this).val($(this).val().replace(/\s+/g,'_'));
        })
    })
</script>
@endsection