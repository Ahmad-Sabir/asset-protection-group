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
          <h2 style="color: #14212b">Hi</h2>
          <p
            style="
              margin: 30px 0px;
              color: #ff4a17;
              text-align: center;
              font-weight: 600;
            "
          >
            We are glad to onboard {{ $company['name'] }}. We're excited that you are
            here!
          </p>
          <p style="margin: 30px 0px">
            We'll make sure to manage company's operations smoothly & put our
            efforts for your company's betterment & growth.
          </p>
          <p style="margin: 10px 0px">
            Remember, we always welcome feedback from our valuable customers.
          </p>
          <p style="margin: 10px 0px">
            If you ever find anything to discuss, please email us at {{ $company['manager_email'] }}
          </p>
        </div>
      </div>
    </section>
    @endsection
