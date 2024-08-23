@if(count($dynpropValues) > 0)
    <div class="table_estete">
        <table>
            @php $i=0; @endphp
            @foreach($dynpropValues as $value)
                @php
                    $i++;
                    if($i % 2 == 1) echo "<tr>";
                @endphp
                    <td>{{ $value['title'] }}:</td>
                    <td>{!! $value['dynpropMulti']/* . ' ' . $value['description']*/ !!}</td>
                @php
                    if($i % 2 == 0) echo "</tr>";
                @endphp
            @endforeach
        </table>
    </div>
@endif
    <div class="description_estete" itemscope itemtype="https://schema.org/Thing" itemprop="description">
        <h4>{{ trans('messages.Description') }}</h4>
        {!! $item['description'] !!}
    </div>

@if($item['video'] != null && count(explode("=", $item['video'])) == 2)
@php
    $embed = explode("=", $item['video']);
@endphp
    <div class="description_estete">
        <h4>{{ trans('messages.Link video') }}</h4>
        <iframe width="100%" height="350" src="https://www.youtube.com/embed/{{ $embed[1] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen itemprop="contentUrl"
                itemscope itemtype="https://schema.org/MediaObject"></iframe>
    </div>
@endif
