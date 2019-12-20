@extends('mail.layouts.main')
@php
    /** @var string $email */
    /** @var string $url */
@endphp
@section('content')
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="500" align="center"
                   style="margin:0 auto; padding:0; background-color: #ffffff; vertical-align: top;">
                <tr>
                    <td style="margin: 0; padding: 0; height: 44px; border-bottom: 1px solid #AAAAAA;"></td>
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
                                <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1E1E1E;">
                                    We received a request to reset a password for the following user account:
                                </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 45px;"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" width="564" align="center"
                                           style="margin:0 auto; padding:0; background-color: #ffffff; max-width: 564px; vertical-align: top;">
                                        <tr>
                                            <td style="margin: 0; padding: 0; width: 71px;"></td>
                                            <td style="margin: 0; padding: 0;">
                        <span
                            style="display: inline-block;line-height:52px;background: #ECECEC;border-radius: 5px;text-align:center;width:413px;mso-hide:all;">
                            <span
                               style="text-decoration:none; line-height:52px;color: #6B6767; font-family: Arial, Helvetica, sans-serif; font-size: 16px; -webkit-text-size-adjust:none;">
                              {{ $email }}
                            </span>
                        </span>
                                                <!--[if mso]>
                                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                             xmlns:w="urn:schemas-microsoft-com:office:word"
                                                             style="height:52px;v-text-anchor:middle;width:413px;"
                                                             arcsize="5%"
                                                             strokecolor="#ECECEC" fillcolor="#ECECEC">
                                                    <w:anchorlock/>
                                                    <center>
                            <span
                                style="display:inline-block;color: #6B6767; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
                                {{ $email }}
                            </span>
                                                    </center>
                                                </v:roundrect>
                                                <![endif]-->
                                            </td>
                                            <td style="margin: 0; padding: 0; width: 80px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 38px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1E1E1E;">
                                    If you <b>didn’t request</b> to reset your password, ignore this email and nothing will happen.
                                </td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; height: 45px;"></td>
                            </tr>
                            <tr>
                                <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1E1E1E;">
                                    Use the button “Reset password” below to reset your password.
                                </td>
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
                                                    <b>Reset password</b>
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
                                                        <b>Reset password</b></center>
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
            </table>
        </td>
    </tr>
@endsection
