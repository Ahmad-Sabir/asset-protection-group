
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body
    style="
      font-family: Roboto, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
    "
  >
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
            <td class="content-cell">
            {{ Illuminate\Mail\Markdown::parse($slot) }}
            {{ $subcopy ?? '' }}
            </td>
        </div>
        <!-- email footer -->
        <div style="width: 100%; margin-top: 20px">
          <p style="margin: 2px 0px">Thank you,</p>
          <p style="margin: 2px 0px">Your APG Team</p>
        </div>
      </div>
    </section>
  </body>
</html>
