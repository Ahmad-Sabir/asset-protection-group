@extends('email-template.layout')
    @section('content')
    <section style="width: 100%; display: flex; justify-content: center">
        <div
          style="
            width: 100%;
            max-width: 600px;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: column;
          "
        >
          <!-- email header -->
          @include('email-template.header')
          <!-- email body -->
          <div>
            <h2 style="color: #14212b">Hi {{ $user['full_name'] ?? '' }}</h2>
            <p
            style="margin: 30px 0px"
            >
            Your coming work order {{ $data['title'] }} is due for tomorrow i.e. {{ $data['due_date']->format('Y-m-d') }}. So please be aligned to perform it and not to miss it.
            </p>
          </div>
        </div>
      </section>
    @endsection
