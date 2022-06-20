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
          <h2 style="color: #14212b">Hi  {{ $user->user['first_name'] }}</h2>
          <p
            style="
              margin: 30px 0px;
              color: #ff4a17;
              text-align: center;
              font-weight: 600;
            "
          >
            Your APG Account is Ready To Go!
          </p>

          <p style="margin: 30px 0px">
            Welcome to APG Team - We are excited that you are here! You will be a
            part of APG Admin Team to manage and run all the operations related
            to APG assets & companies work orders
          </p>
          <p style="margin: 10px 0px">
            Please click on the login button to login the application
          </p>
          <div
            style="
              width: 100%;
              display: flex;
              justify-content: center;
              align-items: center;
            "
          >
            <a
              style="
                background-color: #ff4a17;
                color: white;
                margin: 20px 0px;
                outline: none;
                border: none;
                padding: 10px 30px;
                border-radius: 4px;
                font-size: 15px;text-decoration: none;
              "
              href="{{ $url }}"
            >
            Set Password
            </a>
          </div>
        </div>
    </section>
    @endsection
