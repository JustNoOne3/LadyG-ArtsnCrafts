<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Waiting for Payment</title>
</head>
<body style="font-family: Arial, sans-serif; background: #faf5f0; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #e6d9cb; padding: 32px;">
        <h2 style="color: #7a4025;">Thank you for purchasing!</h2>
        <p>The shop has now validated your order <strong>#{{ $order->order_reference }}</strong>.</p>
        <div style="margin: 24px 0;">
            <h3 style="color: #7a4025; margin-bottom: 8px;">Order Summary</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                <tr>
                    <td style="padding: 6px 0;">Order Reference:</td>
                    <td style="padding: 6px 0; font-weight: bold;">#{{ $order->order_reference }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0;">Order Date:</td>
                    <td style="padding: 6px 0;">{{ $order->created_at ? $order->created_at->format('F j, Y') : '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0;">Total Amount:</td>
                    <td style="padding: 6px 0;">₱{{ number_format($order->order_total, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; color: #7a4025;">Shipping Fee:</td>
                    <td style="padding: 6px 0; font-weight: bold; color: #fff; background: #7a4025; border-radius: 4px; display:flex; justify-content: center; text-align: center; align-items: center;">₱{{ number_format($order->order_shippingFee, 2) }}</td>
                </tr>
            </table>
            @if($order->order_products)
                <div style="margin-bottom: 8px;">
                    <strong>Items:</strong>
                    <ul style="padding-left: 18px; margin: 6px 0;">
                        @foreach(json_decode($order->order_products, true) as $item)
                            <li>
                                {{ $item['product_name'] ?? '' }}
                                @if(!empty($item['variant_name']))<span style="color:#7a4025;"> ({{ $item['variant_name'] }})</span>@endif
                                @if(!empty($item['subvariant_name']))<span style="color:#7a4025;"> ({{ $item['subvariant_name'] }})</span>@endif
                                — x{{ $item['quantity'] ?? 1 }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <p>In order to proceed, please visit the link below to access the shipping fee payment page, or visit your <a href="{{ url('/my-orders') }}">My Orders</a> page.</p>
        <div style="margin: 24px 0;">
            <a href="{{ $paymentLink }}" style="background: #7a4025; color: #fff; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-weight: bold;">Pay Shipping Fee</a>
        </div>
        <p>If you have any questions, feel free to reply to this email.</p>
        <hr style="margin: 32px 0; border: none; border-top: 1px solid #e6d9cb;">
        <p style="font-size: 12px; color: #aaa;">&copy; {{ date('Y') }} LadyG Arts &amp; Crafts</p>
    </div>
</body>
</html>
