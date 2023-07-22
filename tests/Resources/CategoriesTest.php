<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Category;
use Spotify\SingleObjects\Image;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_category()
    {
        $client = $this->mockClient('get', 'Categories/Category.json');

        $category = $client->categories()->find('some-id');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertInstanceOf(Image::class, $category->icons[0]);
    }

    /** @test */
    public function it_can_retrieve_multiple_categories()
    {
        $client = $this->mockClient('get', 'Categories/Multiple.json');

        $categories = $client->categories()->browse();

        $this->assertInstanceOf(PaginatedResults::class, $categories);
        $this->assertInstanceOf(Category::class, $categories[0]);
        $this->assertInstanceOf(Image::class, $categories[0]->icons[0]);
    }
}
