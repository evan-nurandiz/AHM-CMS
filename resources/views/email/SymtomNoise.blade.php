@component('mail::message')
@if($details['status'] == 'confirmed')
</br>
<h5>Greetings Mr {{ $details['user_name'] }} </h5>
<br />
<br />
<p>Symtoms Noise Yang ditambahkan pada</p>
<br />
<p>{{$details['date_at']}}</p>
<br />
<p>
    telah di konfirmasi oleh {{ $details['head_name'] }}</p>
<br />
<p>Pada Tanggal</p>
<br />
<p>{{$details['update_at']}}</p>
<br />
<p>Silahkan Di Publish</p>
@component('mail::button',['url' => env('APP_URL')])
Publish
@endcomponent
<br>
<p>Terima Kasih</p>
@else
<h5>Greetings Mr {{ $details['user_name'] }} </h5>
<br />
<p>Silahkan Revisi</p>
<br />
<p>Symtoms Noise Yang ditambahkan pada</p>
<br />
<p>{{$details['date_at']}}</p>
<br />
<p>dengan Detail Sebagai Berikut</p>
<br />
<p>{!!$details['revision']!!}</p>
@component('mail::button',['url' => env('APP_URL')])
Verifikasi
@endcomponent
<br />
<p>Terima Kasih</p>
@endif
@endcomponent