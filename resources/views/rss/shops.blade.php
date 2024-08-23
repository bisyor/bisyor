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
        @foreach($result as $shop)
            <item>
                <title>{{ $shop['name'] }}</title>
                <link>{{ route('shops-view', $shop['keyword']) }}</link>
                <image>{{ $shop['logo'] }}</image>
                <category>{{ $shop['catNames'] }}</category>
                <dateCr>{{ $shop['date_cr'] }}</dateCr>
                <address>{{ $shop['address'] }}</address>
                <description>{{ $shop['description'] }}</description>
            </item>
        @endforeach
    </channel>
</rss>