<p>您的订单号：{{ $order->order_no }}，已成功发出</p>

<h4>包含的商品有：</h4>

<ul>
    @foreach($order->orderDetails()->with('goods')->get() as $details)
        <li>{{ $details->goods->title }},单价为：{{  $details->price }},数量：{{ $details->num }}</li>
    @endforeach
</ul>

<h5>总付款：{{ $order->amount }} 元</h5>
