@component('mail::message')
<p>
<h5>Greetings Mr {{ $details['head_name'] }} </h5>
<br />
<br />
<p>Admin dengan Nama {{$details['user_name']}}</p>
<br />
<p>telah menambahkan sympton noise </p>
<br />
<p>pada tanggal {{$details['date_at']}}</p>
<br />
<p>Silahkan Konfirmasi</p>
<br />
<p>Terima Kasih</p>
<br />
</p>
@endcomponent