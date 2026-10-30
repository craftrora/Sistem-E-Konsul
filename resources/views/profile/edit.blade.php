@extends('layouts.app')

@section('title','Profil')


@push('styles')
<style>

.profile-header{
    background:white;
    border-radius:22px;
    padding:35px;
    text-align:center;
    box-shadow:0 10px 30px rgba(15,23,42,.08);
    margin-bottom:25px;
    position:relative;
    overflow:hidden;
}

.profile-header:before{
    content:"";
    position:absolute;
    inset:0;
    background-image:radial-gradient(#dbeafe 1px,transparent 1px);
    background-size:18px 18px;
    opacity:.6;
}


.avatar{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#165DFF;
    color:white;
    font-size:36px;
    font-weight:800;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    position:relative;
}


.profile-name{
    margin-top:15px;
    font-size:22px;
    font-weight:800;
    color:#102a56;
}


.profile-opd{
    color:#2563eb;
    font-weight:600;
}


.profile-role{

display:inline-block;
margin-top:8px;

padding:6px 20px;

background:#eef4ff;

border-radius:20px;

color:#2563eb;

}



.box-profile{

background:white;

border-radius:20px;

padding:25px;

box-shadow:
0 10px 30px rgba(15,23,42,.06);

height:100%;

}



.box-title{

display:flex;

gap:10px;

align-items:center;

font-weight:800;

color:#102a56;

padding-bottom:15px;

border-bottom:1px solid #edf2f7;

margin-bottom:20px;

}



.item-profile{

display:flex;

gap:15px;

align-items:center;

padding:15px 0;

border-bottom:1px solid #f1f5f9;

}



.item-icon{

width:40px;

height:40px;

border-radius:12px;

background:#eef4ff;

color:#2563eb;

display:flex;

align-items:center;

justify-content:center;

}



.item-text{

flex:1;

}


.item-text small{

display:block;

color:#64748b;

margin-bottom:4px;

}



.item-text strong{

color:#0f172a;

}



.security-item{

padding:18px 0;

border-bottom:1px solid #f1f5f9;

}



.security-left{

display:flex;

align-items:center;

gap:15px;

}



.security-icon{

width:40px;

height:40px;

border-radius:12px;

background:#eef4ff;

color:#2563eb;

display:flex;

align-items:center;

justify-content:center;

}



.password-wrapper{

display:flex;

align-items:center;

gap:10px;

}


.password-wrapper input{

flex:1;

}


.btn-eye{

border:none;

background:white;

color:#2563eb;

font-size:18px;

}



.save-btn{

width:100%;

padding:14px;

border-radius:14px;

font-weight:700;

}


</style>
@endpush



@section('content')


<h4 class="fw-bold mb-4">
Profil Saya
</h4>



<div class="profile-header">


<div class="avatar">

{{ strtoupper(substr($user->name,0,1)) }}

</div>


<div class="profile-name">
{{ $user->name }}
</div>


<div class="profile-opd">

{{ $user->opd?->nama_opd }}

</div>


<div class="profile-role">

{{ $user->jabatan ?? 'Pegawai' }}

</div>


</div>




<form method="POST" action="{{ route('opd.profil.update') }}">

@csrf
@method('PUT')



<div class="row g-4">



<!-- INFORMASI -->

<div class="col-lg-6">


<div class="box-profile">


<div class="box-title">

<i class="bi bi-person"></i>

Informasi Profil

</div>



<div class="item-profile">

<div class="item-icon">
<i class="bi bi-envelope"></i>
</div>

<div class="item-text">

<small>Email</small>

<strong>
{{ $user->email }}
</strong>

</div>

</div>




<div class="item-profile">

<div class="item-icon">
<i class="bi bi-building"></i>
</div>


<div class="item-text">

<small>Perangkat Daerah</small>

<strong>
{{ $user->opd?->nama_opd }}
</strong>

</div>

</div>




<div class="item-profile">

<div class="item-icon">
<i class="bi bi-person"></i>
</div>


<div class="item-text">

<small>Nama Lengkap</small>


<input 
class="form-control"
name="name"
value="{{ old('name',$user->name) }}"
>


</div>

</div>




<div class="item-profile">

<div class="item-icon">
<i class="bi bi-briefcase"></i>
</div>


<div class="item-text">

<small>Jabatan</small>


<input 
class="form-control"
name="jabatan"
value="{{ old('jabatan',$user->jabatan) }}"
>


</div>

</div>




<div class="item-profile">

<div class="item-icon">
<i class="bi bi-envelope"></i>
</div>


<div class="item-text">

<small>Email Kontak</small>


<input 
class="form-control"
name="email"
value="{{ old('email',$user->email) }}"
>


</div>

</div>




<div class="item-profile">

<div class="item-icon">
<i class="bi bi-lock"></i>
</div>


<div class="item-text">

<small>Password</small>

<strong>
••••••••
</strong>


</div>

</div>



</div>


</div>





<!-- KEAMANAN -->

<div class="col-lg-6">


<div class="box-profile">


<div class="box-title">

<i class="bi bi-shield-check"></i>

Keamanan Akun

</div>




<div class="security-item">


<div class="security-left">


<div class="security-icon">

<i class="bi bi-lock"></i>

</div>


<div>

<strong>
Ubah Kata Sandi
</strong>


<br>

<small>
Perbarui kata sandi akun Anda
</small>


</div>


</div>


</div>




<div class="mt-4">


<label class="fw-bold mb-2">
Password Baru
</label>



<div class="password-wrapper">


<input
type="password"
id="passwordBaru"
name="password"
class="form-control"
placeholder="Minimal 8 karakter"
>


<button type="button"
class="btn-eye"
onclick="lihatPassword()">

<i class="bi bi-eye"
id="iconPassword">
</i>

</button>


</div>


</div>





<div class="mt-3">


<label class="fw-bold mb-2">

Ulangi Password Baru

</label>


<input

type="password"

name="password_confirmation"

class="form-control"

placeholder="Ulangi password"

>


</div>



</div>


</div>


</div>





<button class="btn btn-primary save-btn mt-4">

<i class="bi bi-save"></i>

Simpan Perubahan

</button>




</form>




<script>

function lihatPassword(){

let input=document.getElementById('passwordBaru');

let icon=document.getElementById('iconPassword');


if(input.type==="password"){

input.type="text";

icon.className="bi bi-eye-slash";


}else{


input.type="password";

icon.className="bi bi-eye";


}

}


</script>


@endsection