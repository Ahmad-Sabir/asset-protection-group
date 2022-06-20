@extends('email-template.layout')
@section('content')
<section style="width: 100%; display: flex; justify-content: center">
    <div style="
          width: 100%;
          max-width: 600px;
          padding: 20px;
          box-sizing: border-box;
          display: flex;
          align-items: center;
          justify-content: space-between;
          flex-direction: column;
        ">
        <!-- email header -->
        @include('email-template.header')
        <!-- email body -->
        <div>
            <h2 style="color: #14212b">Hi Admin</h2>
            @if (isset($success_rows) && $success_rows > 0)
            {{ $success_rows }} rows successfully imported.
            @endif
            @if (isset($failures) && !empty($failures))
            <br><br>
            <h2>Failures in CSV file.</h2><br>

            <table style="width:100%">
                <tr>
                    <th>Row Number</th>
                    <th>Attribute</th>
                    <th>Errors</th>
                    <th>Values</th>
                </tr>
                @foreach($failures as $fail)
                <tr>
                    <td>{{ $fail->row() }}</td>
                    <td>{{ $fail->attribute() }}</td>
                    <td>
                        @foreach($fail->errors() as $error)
                        {{$error}} <br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($fail->values() as $err)
                        {{ isset($err)?$err:'--' }} <br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>
</section>
@endsection
