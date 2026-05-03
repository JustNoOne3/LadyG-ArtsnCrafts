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
