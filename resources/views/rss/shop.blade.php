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
        @foreach($result as $item)
            <item>
                <title>{{ $item['title'] }}</title>
                <link>{{ route('view-item', $item['link']) }}</link>
                <image>{{ $item['image'] }}</image>
                <category>{{ $item['categoryName'] }}</category>
                <pubDate>{{ $item['date_cr'] }}</pubDate>
                <address>{{ $item['address'] }}</address>
                <description>{{ $item['description'] }}</description>
            </item>
        @endforeach
    </channel>
</rss>