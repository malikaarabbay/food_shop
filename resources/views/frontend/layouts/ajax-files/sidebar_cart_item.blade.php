<input type="hidden" value="{{ cartTotal() }}" id="cart_total">
<input type="hidden" value="{{ Cart::count() }}" id="cart_product_count">

@foreach (Cart::content() as $cart)
    <li>
        <div class="menu_cart_img">
            <img src="{{ asset($cart->options->product_info['image']) }}" alt="menu" class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title"
               href="{{ route('product.show', $cart->options->product_info['slug']) }}">{!! $cart->name !!}
            </a>
            <p class="size">Qty: {{ $cart->qty }}</p>
            @if($cart->options->has('product_options'))
                @foreach($cart->options->product_options as $option)
                    <span class="extra">{{ $option['name'] }}
                        ({{ currencyPosition($option['price']) }})</span>
                @endforeach
            @endif
            <p class="price">{{ currencyPosition($cart->price) }}</p>
        </div>
        <span class="del_icon" onclick="removeProductFromSidebar('{{ $cart->rowId }}')"><i class="fal fa-times"></i></span>
    </li>
@endforeach
