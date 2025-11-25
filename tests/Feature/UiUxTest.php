<?php

use function Pest\Laravel\get;

it('has a consistent header and footer', function () {
    get('/')->assertSee('<header', false)->assertSee('</header>', false);
    get('/')->assertSee('<footer', false)->assertSee('</footer>', false);
});

it('has a responsive layout', function () {
    // This is a basic check. More thorough checks would require a browser-based testing tool.
    get('/')->assertSee('max-w-7xl');
});

it('has no broken links on the homepage', function () {
    $response = get('/');
    $response->assertOk();

    $content = $response->content();
    preg_match_all('/<a href="(.*?)"/', $content, $matches);

    foreach ($matches[1] as $url) {
        if (str_starts_with($url, 'http')) {
            // External link, skip
            continue;
        }
        if (str_starts_with($url, '#')) {
            // Anchor link, skip
            continue;
        }
        if (str_starts_with($url, 'javascript')) {
            // Javascript link, skip
            continue;
        }

        if (in_array($url, ['/cart', '/cart/count'])) {
            continue;
        }

        get($url)->assertOk();
    }
});
