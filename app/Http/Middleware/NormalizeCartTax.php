<?php

namespace App\Http\Middleware;

use Closure;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizeCartTax
{
    /**
     * Align cart items restored from older sessions with the configured tax rate.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $taxRate = (int) config('cart.tax');

        foreach (Cart::content() as $item) {
            if ((int) $item->taxRate !== $taxRate) {
                Cart::setTax($item->rowId, $taxRate);
            }
        }

        return $next($request);
    }
}
