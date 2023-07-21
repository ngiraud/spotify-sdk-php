<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Audiobook;
use Spotify\SingleObjects\Chapter;
use Spotify\SingleObjects\Image;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class ChaptersTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_chapter()
    {
        $client = $this->mockClient('get', 'Chapters/Chapter.json');

        $chapter = $client->chapters()->find('some-id');

        $this->assertInstanceOf(Chapter::class, $chapter);
        $this->assertInstanceOf(Image::class, $chapter->images[0]);
        $this->assertInstanceOf(Audiobook::class, $chapter->audiobook);
    }

    /** @test */
    public function it_can_retrieve_multiple_chapters()
    {
        $client = $this->mockClient('get', 'Chapters/Multiple.json');

        $chapters = $client->chapters()->findMultiple(['some-id-1', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $chapters);
        $this->assertInstanceOf(Chapter::class, $chapters[0]);
        $this->assertInstanceOf(Audiobook::class, $chapters[0]->audiobook);
        $this->assertInstanceOf(Image::class, $chapters[0]->images[0]);
    }
}
