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
            <p style="
          margin: 30px 0px;
          color: #ff4a17;
          text-align: center;
          font-weight: 600;
        ">
                Find the attachment
            </p>
</section>
@endsection
