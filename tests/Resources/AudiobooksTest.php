<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Audiobook;
use Spotify\SingleObjects\Author;
use Spotify\SingleObjects\Chapter;
use Spotify\SingleObjects\Copyright;
use Spotify\SingleObjects\Image;
use Spotify\SingleObjects\Narrator;
use Spotify\SingleObjects\SavedAudiobook;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class AudiobooksTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_a_single_audiobook()
    {
        $client = $this->mockClient('get', 'Audiobooks/Audiobook.json');

        $audiobook = $client->audiobooks()->find('some-id');

        $this->assertInstanceOf(Audiobook::class, $audiobook);
        $this->assertInstanceOf(Author::class, $audiobook->authors[0]);
        $this->assertInstanceOf(Copyright::class, $audiobook->copyrights[0]);
        $this->assertInstanceOf(Narrator::class, $audiobook->narrators[0]);
        $this->assertInstanceOf(Image::class, $audiobook->images[0]);
    }

    /** @test */
    public function it_can_retrieve_multiple_audiobooks()
    {
        $client = $this->mockClient('get', 'Audiobooks/Multiple.json');

        $audiobooks = $client->audiobooks()->findMultiple(['some-id', 'some-id-2']);

        $this->assertInstanceOf(PaginatedResults::class, $audiobooks);
        $this->assertInstanceOf(Audiobook::class, $audiobooks[0]);
    }

    /** @test */
    public function it_can_retrieve_audiobook_chapters()
    {
        $client = $this->mockClient('get', 'Audiobooks/Chapters.json');

        $chapters = $client->audiobooks()->chapters('some-id');

        $this->assertInstanceOf(PaginatedResults::class, $chapters);
        $this->assertInstanceOf(Chapter::class, $chapters[0]);
    }

    /** @test */
    public function it_can_retrieve_user_saved_audiobook()
    {
        $client = $this->mockClient('get', 'Audiobooks/SavedAudiobooks.json');

        $audiobooks = $client->audiobooks()->findSaved();

        $this->assertInstanceOf(PaginatedResults::class, $audiobooks);
        $this->assertInstanceOf(SavedAudiobook::class, $audiobooks[0]);
        $this->assertInstanceOf(Author::class, $audiobooks[0]->authors[0]);
    }
}
