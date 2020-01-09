<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            td{
                color:#000;
            }
        </style>
    </head>
    <body>
            <table class="table striped" cellspacing="0" cellpadding="2" style="margin: 30px">
                <tr>
                    <td>
                        <table class="table striped" border="1" cellspacing="0" cellpadding="1">
                            <tr>
                                <th>Week</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Total</th>
                            </tr>
                            @php $amount = 200; $total=0; $date = \Carbon\Carbon::parse('2020-01-05') @endphp
                            @for($i=1; $i<=26; $i++)
                                @php $amount = 200*$i; $total+=$amount; @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $date->format('d - m - Y') }}</td>
                                    <td align="right">{{ number_format($amount) }}</td>
                                    <td align="right">{{ number_format($total) }}</td>
                                    @php $date->addDays(7); @endphp
                                </tr>
                            @endfor
                        </table>
                    </td>
                    <td>
                        <table class="table striped" border="1" cellspacing="0">
                            <tr>
                                <th>Week</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Total</th>
                            </tr>
                            @for($i=27; $i<=52; $i++)
                                @php $amount = 200*$i; $total+=$amount; @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $date->format('d - m - Y') }}</td>
                                    <td align="right">{{ number_format($amount) }}</td>
                                    <td align="right">{{ number_format($total) }}</td>
                                    @php $date->addDays(7); @endphp
                                </tr>
                            @endfor
                        </table>
                    </td>
                </tr>
            </table>
            
    </body>
</html>
