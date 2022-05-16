<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} | {{ setting('site.title') }}</title>

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

    <style>
        body{
            margin: 0px;
            padding: 0px;
            font-family: Arial, Helvetica, sans-serif
        }
        #watermark {
            position: fixed;
            top: 300px;
            opacity: 0.1;
            z-index:  -1;
        }
        #watermark img{
            position: relative;
            width: 300px;
            left: 220px;
        }
    </style>
    @yield('css')
</head>
<body>
    @php
        $icon = url('storage').'/'.setting('admin.icon_image') ?? asset('images/icon.png');
    @endphp
    <div id="watermark">
        <img src="{{ $icon }}" /> 
    </div>

    <div>
        <table width="100%">
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td>
                                <div style="margin-right:10px">
                                    <img src="{{ $icon }}" width="60px" />
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h1 style="margin: 0px; padding: 0px; font-size: 20px; font-weight: bold;">
                                        {{ setting('site.title') }}
                                    </h1>
                                    <h3 style="margin: 0px; padding: 0px; font-size: 14px; font-weight: 100;">
                                        {{ setting('site.address') }}
                                    </h3>
                                    <h3 style="margin: 0px; padding: 0px; font-size: 14px; font-weight: 100;">
                                        {{ setting('site.phones') }}
                                    </h3>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <div>
                        <h1 style="margin: 0px; padding: 0px;">{{ $title }}</h1>
                        <small>Generado por {{ Auth::user()->name }}</small> <br>
                        <small>{{ date('d/m/Y H:i') }}</small>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @yield('content')

</body>
</html>