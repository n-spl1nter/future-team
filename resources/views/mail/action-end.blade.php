@extends('mail.layouts.main')
@php
    /** @var string $actionName */
    /** @var string $url */
@endphp
@section('content')
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="500" align="center"
                   style="margin:0 auto; padding:0; background-color: #ffffff; vertical-align: top;">
                <tr>
                    <td style="margin: 0; padding: 0; height: 44px;"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table border="0" cellpadding="0" cellspacing="0" width="500" align="center"
                               style="margin:0 auto; padding:0; background-color: #ffffff; max-width: 600px; vertical-align: top;">
                            <tr>
                                <td rowspan="9" style="margin: 0; padding: 0; width: 22px;"></td>
                                <td style="margin: 0; padding: 0; height: 20px"></td>
                                <td rowspan="9" style="margin: 0; padding: 0; width: 14px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #1E1E1E;">
                                    <b>Please share awesome moments from completed challenge:</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 15px; border-bottom: 1px solid #AAAAAA;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 45px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #1E1E1E;">
                                    The challenge
                                    &laquo;{{ $actionName }}&raquo;
                                    completed. Please share members’ photos and videos if the challenge have gone successfully.
                                </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 38px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 45px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 82px;"></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table border="0" cellpadding="0" cellspacing="0" width="414" align="center"
                                           style="margin:0 auto; padding:0; background-color: #ffffff; max-width: 414px; vertical-align: top;">
                                        <tr>
                                            <td style="margin: 0; padding: 0; width: 101px;"></td>
                                            <td style="margin: 0; padding: 0; vertical-align: top; font-size: 0;">
                                                <a href="{{ $url }}"
                                                   style="background-color:#80B369;border-radius:3px;color:#ffffff;display:inline-block;font-family:Arial, sans-serif;font-size:18px;line-height:48px;text-align:center;text-decoration:none;width:210px;-webkit-text-size-adjust:none;mso-hide:all;">
                                                    <b>Upload photo</b>
                                                </a>
                                                <!--[if mso]>
                                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                             xmlns:w="urn:schemas-microsoft-com:office:word"
                                                             href="{{ $url }}"
                                                             style="height:48px;v-text-anchor:middle;width:210px;"
                                                             arcsize="5%" strokecolor="#80B369" fillcolor="#80B369">
                                                    <w:anchorlock/>
                                                    <center
                                                        style="color:#ffffff;font-family:Arial, sans-serif;font-size:18px;">
                                                        <b>Upload photo</b></center>
                                                </v:roundrect>
                                                <![endif]-->
                                            </td>
                                            <td style="margin: 0; padding: 0; width: 101px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; height: 45px; border-bottom: 1px solid #AAAAAA;"></td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
