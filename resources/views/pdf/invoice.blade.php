<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        body {
            margin: 20px;
        }

        .brand-logo {
            margin-top: 35px;
        }
    </style>
</head>

<body>
    <div class="text-center mb-3">
        <div>{{ siteName() }}</div>
        <div>{{ settings('address') }}</div>
        <div>{{ settings('topbar_mobile') }}, {{ settings('topbar_email') }}</div>

    </div>
    <div>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td>
                        <h6>Billing Address</h6>
                        <div>{{ $order->address->name }}</div>
                        @if ($order->address->mobile)
                            <div>{{ $order->address->mobile }}</div>
                        @endif
                        <div>{{ $order->address->email }}</div>
                        <div>{{ $order->address->city }}, {{ $order->address->region }}</div>
                        <div>{{ $order->address->address_line_one }}</div>
                        @if ($order->address->address_line_two)
                            <div>{{ $order->address->address_line_two }}</div>
                        @endif
                    </td>
                    <td>
                        <div>Order No: {{ $order->id }}</div>
                        <div>Order Date: {{ $order->created_at }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Description</th>
                    <th class="text-center">Qty.</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $item)
                    <tr>
                        <td>{{ $item->name }}c</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-center">{{ priceUnit() }} {{ $item->price }}</td>
                        <td class="text-center">{{ priceUnit() }} {{ number_format($item->priceTotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Subtotal</td>
                    <td class="text-center">{{ priceUnit() }} {{ number_format((int) $order->total_price) }}</td>
                </tr>
                @if ($order->discount_amount)
                    <tr>
                        <td colspan="3" class="text-right">Discount</td>
                        <td class="text-center">{{ priceUnit() }} {{ number_format((int) $order->discount_amount) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" class="text-right">Shipping Cost</td>
                    <td class="text-center">{{ priceUnit() }} {{ number_format($order->shipping_charge) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-right">Total</td>
                    <td class="text-center">{{ priceUnit() }} {{ number_format($order->billAmount()) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
