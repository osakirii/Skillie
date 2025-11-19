@php
    // expects $imagem variable in scope; produces $img
    if (!empty($imagem)) {
        $parsed = parse_url($imagem);
        $qs = [];
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $qs);
        }

        $candidate = null;
        if (!empty($qs['url'])) {
            $candidate = urldecode($qs['url']);
        } else {
            $candidate = $imagem;
        }

        $lower = strtolower($candidate);
        if (str_starts_with($lower, 'http://') || str_starts_with($lower, 'https://')) {
            $img = $candidate;
        } elseif (str_starts_with($candidate, '//')) {
            $img = (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'https') . ':' . $candidate;
        } else {
            $img = asset(ltrim($candidate, '/'));
        }
    } else {
        $img = asset('placeholder-card.png');
    }
@endphp
