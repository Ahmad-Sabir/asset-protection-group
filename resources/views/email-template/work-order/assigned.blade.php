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
            A new work order {{ $data['title'] }} is assigned to you with the due date as {{ $data['due_date'] }}.
            </p>
            <p style="margin: 30px 0px">
                Keep aligned!
            </p>
            <p style="margin: 10px 0px">
                More work orders are on the way!
            </p>
          </div>
        </div>
      </section>
    @endsection
