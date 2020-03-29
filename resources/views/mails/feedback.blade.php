<p>
    {!! nl2br(html_entity_decode($msg->message)) !!}
</p>
<p>
    {{ $msg->face }}<br>
    {{ $msg->email }}
</p>
<p>
    Status: {{ $msg->recaptcha_response }}
</p>
<p>
    {{ $useragent }}<br>
    {{ $ip }}
</p>
