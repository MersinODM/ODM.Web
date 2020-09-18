<!doctype html>
<html lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style type="text/css">
        /*@page {*/
        /*    margin: 0 !important;*/
        /*}*/

        /*body {*/
        /*    margin: 0;*/
        /*}*/

        * {
            font-family: "DejaVu Sans", serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            font-size: x-small;
            border-collapse: collapse;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .content table {
            margin: 15px;
        }

        .content h3 {
            margin-left: 15px;
        }

        .information {
            background-color: white;
            color: black;
        }

        .information .logo {
            margin: 5px;
        }

        .information table {
            padding: 10px;
        }

        .bottomBorder {
            border-bottom: 1px solid #ddd;
        }

        .topBorder {
            border-top: 1px solid #ddd;
        }

        .fullBorder {
            border: 1px solid #ddd;
        }

        div.sticky {
            position: sticky;
            width: 100%;
            bottom: 10px;
            border-top: 1px solid #ddd;
        }

    </style>
</head>
<body>
<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 20%;">
{{--                <img src="@yield('memLogo')" alt="Logo" width="64" class="logo"/>--}}
                <img src="./images/MEM-Logo.jpg" alt="Logo" width="64" class="logo"/>
            <td align="center">
                <h3 style="margin:0;">T.C.</h3>
                <h3 style="margin:0;">@yield('city') VALİLİĞİ</h3>
                <h3 style="margin:0;">@yield('city') MİLLİ EĞİTİM MÜDÜRLÜĞÜ</h3>
                <h4 style="margin:0;">Ölçme Değerlendirme Merkezi</h4>
            </td>
            <td align="right" style="width: 20%;">
                <img src="./images/Logo.jpg" alt="Logo" width="64" class="logo"/>
            </td>
        </tr>
    </table>
</div>
<br/>
@yield('content')
<div class="sticky" style="position: absolute; bottom: 0;">
    <table width="100%">
        <tr>
            <td style="text-align: justify; width: 50%; padding-right: 10px;">
                &copy; {{ date('Y') }} - Bu raporda yer alan bilgilerin tüm hakları saklıdır.
            </td>
            <td style="text-align: justify; width: 50%; padding-left: 10px;">
                Ölçme tekniği, evrende var olan olayları kontrol altına almanın ve bu olayları yönetebilmenin temel bilimidir.
            </td>
        </tr>

    </table>
</div>
</body>
</html>