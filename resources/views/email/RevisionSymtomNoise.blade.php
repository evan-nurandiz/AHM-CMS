@component('mail::message')
</br>
<h5>Greetings Mr {{ $details['head_name'] }} </h5>
<br />
<br />
<p>Revisi Symtoms Noise oleh {{$details['user_name']}} </p> 
<br/>
<p> pada no engine {{$details['no_engine']}} telah dikirim pada</p>
<br />
<p>{{$details['update_at']}}</p>
<br />
@component('mail::button',['url' => env('APP_URL')])
Verifikasi
@endcomponent
<br />
<p>Terima Kasih</p>
@endcomponent