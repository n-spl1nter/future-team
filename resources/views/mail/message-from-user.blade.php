@extends('mail.layouts.main')

@php
    /** @var string $text */
    /** @var string $mailFrom */
    /** @var string $mailFromName */
@endphp

@section('content')
    <!-- body -->
    <tr>
        <td style="margin: 0; padding: 0; height: 89px"></td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #1E1E1E;">
            У вас новое сообщение от <b>{{ $mailFromName }}:</b>
        </td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; height: 17px; border-bottom: 1px solid #AAAAAA;"></td>
    </tr>
    <tr>
        <td rowspan="7" style="margin: 0; padding: 0; width: 43px; border-bottom: 1px solid #AAAAAA;"></td>
        <td style="margin: 0; padding: 0; height: 46px;"></td>
        <td rowspan="7" style="margin: 0; padding: 0; width: 30px; border-bottom: 1px solid #AAAAAA;"></td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; line-height: 1.23; color: #6B6767;">
            {{ $text }}
        </td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; height: 27px"></td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; text-align: right; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 16px; color: #232323;">
            <b>Свяжитесь со мной по почте</b>
        </td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; height: 20px"></td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; text-align: right; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
            <a href="mailto:{{ $mailFrom }}"
               style="color: #6B6767; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 18px;">{{ $mailFrom }}</a>
        </td>
    </tr>
    <tr>
        <td style="margin: 0; padding: 0; height: 33px; border-bottom: 1px solid #AAAAAA;"></td>
    </tr>
    <!-- /body -->
@endsection
