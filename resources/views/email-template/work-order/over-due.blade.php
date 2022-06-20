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
            <h2 style="color: #14212b">Hi {{ $user['full_name'] ?? ''}}</h2>
            <p
            style="margin: 30px 0px"
            >
            You are being notified that the due date of the following work orders is passed but these are still pending to be completed
            </p>
            <table class="admin-table mt-4" aria-label="">
                <th></th>
                <tbody>
                    <tr class="border-b">
                        <td class="gray3">Work Order Title</td>
                        <td class="text-right">
                           {{ $data['title'] }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="gray3">Asset</td>
                        <td class="text-right">
                            {{ $data['asset']['name'] ?? '' }}
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="gray3">Due Date</td>
                        <td class="text-right">
                            {{ $data['due_date']->format('Y-m-d') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p
            style="margin: 30px 0px"
            >
            Please get these completed asap in order to get work orders.
            </p>
          </div>
        </div>
      </section>
    @endsection
