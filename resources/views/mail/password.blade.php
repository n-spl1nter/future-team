@extends('mail.layouts.main')
@php
    /** @var string $email */
    /** @var string $password */
@endphp
@section('content')
    <tr>
        <td align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="500" align="center"
                   style="margin:0 auto; padding:0; background-color: #ffffff; vertical-align: top;">
                <tr>
                    <td rowspan="10" style="margin: 0; padding: 0; width: 93px;"></td>
                    <td style="margin: 0; padding: 0; height: 53px"></td>
                    <td rowspan="10" style="margin: 0; padding: 0; width: 93px;"></td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #777777;">
                        <b>Login</b>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; height: 7px;"></td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0;">
                  <span style="display: inline-block;background: #ECECEC;border-radius: 5px;text-align:center;width:414px;mso-hide:all;">
                    <span style="text-decoration:none; line-height:52px;color: #6B6767; font-family: Arial, Helvetica, sans-serif; font-size: 16px; -webkit-text-size-adjust:none;">
                      {{ $email }}
                    </span>
                  </span>
                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                                     style="height:52px;v-text-anchor:middle;width:414px;" arcsize="5%"
                                     strokecolor="#ECECEC" fillcolor="#ECECEC">
                            <w:anchorlock/>
                            <center>
                      <span style="display:inline-block;color: #6B6767; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
                        {{ $email }}
                      </span>
                            </center>
                        </v:roundrect>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; height: 38px"></td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; text-align: left; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #777777;">
                        <b>Password</b>
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; height: 7px;"></td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0;">
                  <span style="display: inline-block;background: #ECECEC;color: #6B6767;-webkit-text-size-adjust:none; font-family: Arial, Helvetica, sans-serif; font-size: 16px;border-radius: 5px;line-height:52px;text-align:center;width:414px;mso-hide:all;">
                    {{ $password }}
                  </span>
                        <!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"
                                     style="height:52px;v-text-anchor:middle;width:414px;" arcsize="5%"
                                     strokecolor="#ECECEC" fillcolor="#ECECEC">
                            <w:anchorlock/>
                            <center>
                      <span style="display:inline-block;color: #6B6767; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-size: 16px;">
                        {{ $password }}
                      </span>
                            </center>
                        </v:roundrect>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0; height: 73px;"></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" width="414" align="center" style="margin:0 auto; padding:0; background-color: #ffffff; max-width: 414px; vertical-align: top;">
                            <tbody><tr>
                                <td style="margin: 0; padding: 0; width: 101px;"></td>
                                <td style="margin: 0; padding: 0; vertical-align: top; font-size: 0;">
                                    <a href="{{ env('MAIN_SERVICE_URL') }}" style="background-color:#80B369;border-radius:3px;color:#ffffff;display:inline-block;font-family:Arial, sans-serif;font-size:18px;line-height:48px;text-align:center;text-decoration:none;width:210px;-webkit-text-size-adjust:none;mso-hide:all;">
                                        <b>Go to website</b>
                                    </a>
                                    <!--[if mso]>
                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ env('MAIN_SERVICE_URL') }}" style="height:48px;v-text-anchor:middle;width:210px;" arcsize="5%" strokecolor="#80B369" fillcolor="#80B369">
                                        <w:anchorlock/>
                                        <center style="color:#ffffff;font-family:Arial, sans-serif;font-size:18px;"><b>Go to website</b></center>
                                    </v:roundrect>
                                    <![endif]-->
                                </td>
                                <td style="margin: 0; padding: 0; width: 101px;"></td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@endsection
