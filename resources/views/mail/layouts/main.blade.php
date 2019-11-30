<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body style="padding: 0; margin: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center"
       style="margin:0 auto; padding: 50px 0; background-color: #191919; vertical-align: top;">
    <tr>
        <td style="margin: 0; padding: 0;">
            <table border="0" cellpadding="0" cellspacing="0" width="600" align="center"
                   style="margin:0 auto; padding:0; background-color: #ffffff; max-width: 600px; vertical-align: top;">
                <!--  header-->
                <tr>
                    <td colspan="3" style="margin: 0; padding: 0; font-size: 0;">
                        <img src="{{ asset('storage/gmail-ios-fix.png') }}" alt="" width="600" height="1">
                    </td>
                </tr>
                <tr>
                    <td rowspan="20" style="margin: 0; padding: 0; width: 43px; border-bottom: 1px solid #AAAAAA;"></td>
                    <td style="margin: 0; padding: 0; height: 46px"></td>
                    <td rowspan="20" style="margin: 0; padding: 0; width: 30px; border-bottom: 1px solid #AAAAAA;"></td>
                </tr>
                <tr>
                    <td style="margin: 0; padding: 0;">
                        <a href="{{ env('MAIN_SERVICE_URL') }}" style="text-decoration: none; font-size: 0; line-height: 0.000001px;">
                            <img src="{{ asset('storage/logo.png') }}" alt="logo" width="144" height="70">
                        </a>
                    </td>
                </tr>
                @yield('content')
                <!--  footer-->
                <tr>
                    <td colspan="3" style="margin: 0; padding: 0; height: 164px;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding: 0; text-align: center; vertical-align: top; font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #6B6767;">
                        ©{{ now()->year }} Future Team
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 0; padding: 0; height: 24px;"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
