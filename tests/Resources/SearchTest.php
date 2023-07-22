<?php

namespace Tests\Resources;

use Spotify\SingleObjects\Search;
use Spotify\Support\PaginatedResults;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /** @test */
    public function can_search_for_albums()
    {
        $client = $this->mockClient('get', 'Search/Albums.json');

        $search = $client->search('my search here', Search::TYPE_ALBUM);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->albums());
        $this->assertCount(3, $search->albums()->results());
    }

    /** @test */
    public function can_search_for_artists()
    {
        $client = $this->mockClient('get', 'Search/Artists.json');

        $search = $client->search('my search here', Search::TYPE_ARTIST);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->artists());
        $this->assertCount(3, $search->artists()->results());
    }

    /** @test */
    public function can_search_for_playlists()
    {
        $client = $this->mockClient('get', 'Search/Playlists.json');

        $search = $client->search('my search here', Search::TYPE_PLAYLIST);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->playlists());
        $this->assertCount(20, $search->playlists()->results());
    }

    /** @test */
    public function can_search_for_tracks()
    {
        $client = $this->mockClient('get', 'Search/Tracks.json');

        $search = $client->search('my search here', Search::TYPE_TRACK);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->tracks());
        $this->assertCount(20, $search->tracks()->results());
    }

    /** @test */
    public function can_search_for_shows()
    {
        $client = $this->mockClient('get', 'Search/Shows.json');

        $search = $client->search('my search here', Search::TYPE_SHOW);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->shows());
        $this->assertCount(20, $search->shows()->results());
    }

    /** @test */
    public function can_search_for_episodes()
    {
        $client = $this->mockClient('get', 'Search/Episodes.json');

        $search = $client->search('my search here', Search::TYPE_EPISODE);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->episodes());
        $this->assertCount(20, $search->episodes()->results());
    }

    /** @test */
    public function can_search_for_audiobooks()
    {
        $client = $this->mockClient('get', 'Search/Audiobooks.json');

        $search = $client->search('my search here', Search::TYPE_AUDIOBOOK);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->audiobooks());
        $this->assertCount(1, $search->audiobooks()->results());
    }

    /** @test */
    public function can_search_with_mutliple_types()
    {
        $client = $this->mockClient('get', 'Search/MultipleTypes.json');

        $search = $client->search('my search here', [Search::TYPE_ALBUM, Search::TYPE_ARTIST]);

        $this->assertInstanceOf(Search::class, $search);
        $this->assertInstanceOf(PaginatedResults::class, $search->albums());
        $this->assertInstanceOf(PaginatedResults::class, $search->artists());
        $this->assertCount(3, $search->albums()->results());
        $this->assertCount(3, $search->artists()->results());
        $this->assertCount(0, $search->tracks()->results());
        $this->assertCount(0, $search->shows()->results());
        $this->assertCount(0, $search->episodes()->results());
        $this->assertCount(0, $search->audiobooks()->results());
        $this->assertCount(0, $search->playlists()->results());
    }
}
