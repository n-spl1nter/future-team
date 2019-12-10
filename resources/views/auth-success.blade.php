@php
/** @var int $id */
/** @var string $accessToken */
/** @var bool $hasProfile */
@endphp
<script type="text/javascript">
    @if (!empty($accessToken))
    window.opener.postMessage(JSON.stringify({
      token: '{{ $accessToken }}',
      id: {{ $id }},
      hasProfile: Boolean({{ $hasProfile }}),
    }), '*');
    @endif
    window.close();
</script>
