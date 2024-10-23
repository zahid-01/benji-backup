<div class="dropdown dropdown-end">
    <button type="button"
        class="btn btn-link hover:opacity-60 {{ (empty($userCarts) or count($userCarts) < 1) ? 'disabled' : '' }}">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M7.2502 9.0002C7.2502 8.58599 7.58599 8.2502 8.0002 8.2502H11.0002C11.4144 8.2502 11.7502 8.58599 11.7502 9.0002C11.7502 9.41442 11.4144 9.7502 11.0002 9.7502H8.0002C7.58599 9.7502 7.2502 9.41442 7.2502 9.0002Z"
                fill="black" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M1.28869 2.76303C1.41968 2.37008 1.84442 2.15771 2.23737 2.28869L2.54176 2.39015C3.16813 2.59892 3.69746 2.77534 4.1137 2.96898C4.55613 3.1748 4.94002 3.42989 5.23112 3.83377C5.52222 4.23764 5.64282 4.6825 5.69817 5.16732C5.70129 5.19459 5.70421 5.22221 5.70696 5.2502L16.511 5.2502C17.4869 5.25016 18.3034 5.25013 18.9278 5.34257C19.5793 5.43901 20.2076 5.66069 20.6038 6.2616C21 6.8625 20.9563 7.52731 20.7883 8.16406C20.6273 8.77441 20.3057 9.52483 19.9212 10.4218L19.4544 11.5111C19.2778 11.9232 19.1224 12.2857 18.961 12.5727C18.7862 12.8834 18.5728 13.1656 18.2497 13.3786C17.9266 13.5916 17.5832 13.6766 17.2288 13.7149C16.9014 13.7503 16.507 13.7502 16.0587 13.7502H6.15378C6.22758 13.8842 6.31252 13.9945 6.40921 14.0912C6.68598 14.368 7.07455 14.5484 7.80832 14.6471C8.56367 14.7486 9.56479 14.7502 11.0002 14.7502H19.0002C19.4144 14.7502 19.7502 15.086 19.7502 15.5002C19.7502 15.9144 19.4144 16.2502 19.0002 16.2502H10.9453C9.57776 16.2502 8.47541 16.2502 7.60845 16.1337C6.70834 16.0127 5.95047 15.7538 5.34855 15.1519C4.74664 14.5499 4.48774 13.7921 4.36673 12.892C4.25017 12.025 4.25018 10.9227 4.2502 9.55508L4.2502 6.88324C4.2502 6.17024 4.24907 5.69848 4.20785 5.33747C4.16883 4.99562 4.10068 4.83074 4.01426 4.71083C3.92784 4.59093 3.79296 4.47414 3.481 4.32901C3.15155 4.17575 2.70435 4.02549 2.02794 3.80002L1.76303 3.71172C1.37008 3.58073 1.15771 3.15599 1.28869 2.76303ZM5.80693 12.2502H16.022C16.5179 12.2502 16.8305 12.2492 17.0678 12.2236C17.287 12.1999 17.3713 12.161 17.424 12.1263C17.4766 12.0916 17.5455 12.0294 17.6537 11.8373C17.7707 11.6292 17.8948 11.3423 18.0901 10.8865L18.5187 9.88652C18.9332 8.91932 19.2087 8.27152 19.3379 7.78145C19.4636 7.30522 19.3999 7.16069 19.3515 7.08734C19.3032 7.01398 19.1954 6.89853 18.7082 6.8264C18.2068 6.75218 17.5029 6.7502 16.4506 6.7502H5.7502C5.75021 6.78044 5.75021 6.81091 5.7502 6.84159L5.7502 9.5002C5.7502 10.6722 5.75127 11.5546 5.80693 12.2502Z"
                fill="black" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M7.5002 21.7502C6.25756 21.7502 5.2502 20.7428 5.2502 19.5002C5.2502 18.2576 6.25756 17.2502 7.5002 17.2502C8.74284 17.2502 9.7502 18.2576 9.7502 19.5002C9.7502 20.7428 8.74284 21.7502 7.5002 21.7502ZM6.7502 19.5002C6.7502 19.9144 7.08599 20.2502 7.5002 20.2502C7.91442 20.2502 8.2502 19.9144 8.2502 19.5002C8.2502 19.086 7.91442 18.7502 7.5002 18.7502C7.08599 18.7502 6.7502 19.086 6.7502 19.5002Z"
                fill="black" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M14.2502 19.5003C14.2502 20.7429 15.2576 21.7503 16.5002 21.7503C17.7428 21.7503 18.7502 20.7429 18.7502 19.5003C18.7502 18.2576 17.7428 17.2503 16.5002 17.2503C15.2576 17.2503 14.2502 18.2576 14.2502 19.5003ZM16.5002 20.2503C16.086 20.2503 15.7502 19.9145 15.7502 19.5003C15.7502 19.0861 16.086 18.7503 16.5002 18.7503C16.9144 18.7503 17.2502 19.0861 17.2502 19.5003C17.2502 19.9145 16.9144 20.2503 16.5002 20.2503Z"
                fill="black" />
        </svg>
        @if (!empty($userCarts) and count($userCarts))
            <span class="badge badge-circle-primary flex items-center justify-center">{{ count($userCarts) }}</span>
        @endif
    </button>

    <ul tabindex="0" class="dropdown-content z-50 bg-white shadow-2xl w-64 p-4 rounded-lg">

        {{-- <div class="d-mhidden border-bottom mb-20 pb-10 text-right">
            <i class="close-dropdown" data-feather="x" width="32" height="32" class="mr-10"></i>
        </div> --}}
        <div class="max-h-96" data-simplebar>
            @if (!empty($userCarts) and count($userCarts) > 0)
                <div class="mb-auto">
                    @foreach ($userCarts as $cart)
                        @php
                            $cartItemInfo = $cart->getItemInfo();
                            $cartTaxType = !empty($cartItemInfo['isProduct']) ? 'store' : 'general';
                        @endphp

                        @if (!empty($cartItemInfo))
                            <div class="flex gap-4">

                                <a href="{{ $cartItemInfo['itemUrl'] }}" target="_blank" class="w-1/3">
                                    <img src="{{ $cartItemInfo['imgPath'] }}" alt="product title" class="w-full rounded-lg" />
                                </a>

                                <div class="w-2/3">
                                    <a href="{{ $cartItemInfo['itemUrl'] }}" target="_blank">
                                        <h4 class="text-sm">{{ $cartItemInfo['title'] }}</h4>
                                    </a>
                                    <div class="price mt-1">
                                        @if (!empty($cartItemInfo['discountPrice']))
                                            <span
                                                class="text-primary font-bold">{{ handlePrice($cartItemInfo['discountPrice'], true, true, false, null, true, $cartTaxType) }}</span>
                                            <span
                                                class="off ml-15">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                                        @else
                                            <span
                                                class="text-primary font-bold">{{ handlePrice($cartItemInfo['price'], true, true, false, null, true, $cartTaxType) }}</span>
                                        @endif

                                        @if (!empty($cartItemInfo['quantity']))
                                            <span
                                                class="text-sm text-warning font-medium ml-10">({{ $cartItemInfo['quantity'] }}
                                                {{ trans('update.product') }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="divider"></div>
                <div class="">
                    <div class="navbar-cart-total mt-15 border-top flex items-center justify-between">
                        <strong class="total-text">{{ trans('cart.total') }}</strong>
                        <strong
                            class="text-primary font-bold">{{ !empty($totalCartsPrice) ? handlePrice($totalCartsPrice, true, true, false, null, true, $cartTaxType) : 0 }}</strong>
                    </div>

                    <a href="/cart/"
                        class="btn btn-sm btn-primary btn-block mt-6">{{ trans('cart.go_to_cart') }}</a>
                </div>
            @else
                <div class="flex items-center text-center py-50">
                    <i data-feather="shopping-cart" width="20" height="20" class="mr-10"></i>
                    <span class="">{{ trans('cart.your_cart_empty') }}</span>
                </div>
            @endif
        </div>
    </ul>
</div>
