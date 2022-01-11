<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSO Simulation</title>
</head>
<body>
    <h1>Hello</h1>
    <p>We can do it together. :)</p>
    <p>Berikut daftar peran yang dimiliki oleh {{ auth()->user()->name }}</p>
    <ul>
        @foreach (auth()->user()->roles() as $role)
            <li>{{ $role }}</li>
        @endforeach
    </ul>
    <a href="{{ route('sso.logout') }}">Log out</a>
    <p>Atribut yang bisa di akses sebagai berikut</p>
    <table width="100%" style="border: 1px solid black;">
        <thead>
            <th style="border: 1px solid black;">Atribut</th>
            <th style="border: 1px solid black;">Nilai atribut</th>
        </thead>
        <tbody>
            @foreach (auth()->user()->getAttributes() as $key => $value)
            <tr>
                <td style="border: 1px solid black;">{{ $key }}</td>
                <td style="border: 1px solid black;">
                    @if (is_array($value))
                        {{ collect($value)->implode(', ') }}
                    @else
                        {{ $value }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>