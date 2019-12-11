@php
/** @var int $id */
/** @var string $accessToken */
/** @var bool $emailVerified */
/** @var bool $hasProfile */
/** @var bool $fullName */
@endphp
<script type="text/javascript">
    @if (!empty($accessToken))
    window.opener.postMessage(JSON.stringify({
      token: '{{ $accessToken }}',
      id: {{ $id }},
      emailVerified: Boolean({{ $emailVerified }}),
      hasProfile: Boolean({{ $hasProfile }}),
      fullName: Boolean({{ $fullName }}),
    }), '*');
    @endif
    window.close();
</script>
