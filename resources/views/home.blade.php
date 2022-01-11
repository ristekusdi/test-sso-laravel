<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SSO Simulation</title>
</head>
<body>
    <h1>Hello</h1>
    <p>We can do it together. :)</p>
    <a href="{{ route('sso.logout') }}">Log out</a>
    <p>Berikut daftar peran yang dimiliki oleh {{ auth()->user()->name }}</p>
    <ul>
        @foreach (auth()->user()->roles() as $role)
            <li>{{ $role }}</li>
        @endforeach
    </ul>
    <p>Peran aktif: {{ auth()->user()->role_active }}</p>
    <p>Daftar permission: </p>
    <ul>
        @foreach (auth()->user()->role_permissions as $perm)
            <li>{{ $perm }}</li>
        @endforeach
    </ul>
    @if (auth()->user()->hasPermission('manage-settings'))
    <p>This user has permission manage-settings</p>
    @else
    <p>This user doesn't have permission manage-settings</p>
    @endif

    @if (auth()->user()->hasRole('Dosen'))
    <p>This user has role Dosen</p>
    @else
    <p>This user doesn't have role Dosen</p>
    @endif
    <form action="">
        <select name="roles" id="roles-combo">
            <option value="0">Daftar Peran</option>
            @foreach (auth()->user()->roles as $role)
                <option value="{{ $role }}" {{ (auth()->user()->role_active == $role) ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
        </select>
        <input type="hidden" name="url_change_role_active" value="{{ url('/web-session/change-role-active') }}">
        <input type="hidden" name="current_url" value="{{ url()->current() }}">
    </form>
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
    <script>
        document.getElementById('roles-combo').onchange = function (e) {
            const value = e.target.value;
            const url = document.querySelector('input[name="url_change_role_active"]').value;
            const current_url = document.querySelector('input[name="current_url"]').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (value != '0') {
                fetch(url, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': token
                    },
                    method: 'POST',
                    credentials: 'same-origin',
                    body: `role_active=${value}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.code == 200) {
                        window.location.href = current_url;
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    </script>
</body>
</html>