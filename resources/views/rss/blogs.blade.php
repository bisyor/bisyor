<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
    <channel>
        <title>{{ $site['title'] }}</title>
        <link>{{ $site['link'] }}</link>
        <description>{{ $site['description'] }}</description>
        <language>{{ $site['language'] }}</language>
        <pubDate>{{ $site['pubDate'] }}</pubDate>
        <lastBuildDate>{{ $site['lastBuildDate'] }}</lastBuildDate>
        <image>
            <url>{{ $site['image_url'] }}</url>
            <title>{{ $site['image_title'] }}</title>
            <link>{{ $site['image_link'] }}</link>
        </image>
        @foreach($result as $blog)
            <item>
                <title>{{ $blog['title'] }}</title>
                <link>{{ route('blogs-view', $blog['slug']) }}</link>
                <image>{{ $blog['image'] }}</image>
                <category>{{ $blog['catName'] }}</category>
                <pubDate>{{ $blog['date_cr'] }}</pubDate>
                <shorttext>{{ strip_tags($blog['short_text']) }}</shorttext>
                <description>{{ strip_tags($blog['text']) }}</description>
            </item>
        @endforeach
    </channel>
</rss>