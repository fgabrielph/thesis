<?php

namespace Tests\Feature;

use App\Category;
use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_lists_items_with_prices(): void
    {
        $this->seed();
        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->get(route('site.shop'))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('₱ '.number_format($item->price_stocks, 2));
    }

    public function test_product_page_shows_price(): void
    {
        $this->seed();
        $item = Item::where('stocks', '>', 0)->firstOrFail();

        $this->get(route('site.product', $item))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('₱ '.number_format($item->price_stocks, 2));
    }

    public function test_category_lists_items_with_prices(): void
    {
        $this->seed();
        $category = Category::whereHas('items')->firstOrFail();
        $item = Item::where('category_id', $category->id)->where('stocks', '>', 0)->firstOrFail();

        $this->get(route('site.categories', $category))
            ->assertOk()
            ->assertSee('data-storefront', false)
            ->assertSee('₱ '.number_format($item->price_stocks, 2));
    }
}
