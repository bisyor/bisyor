<footer class="help_footer">
	<div class="container">
		<p>
			Bisyor — сайт объявлений Узбекистане. © ООО «Bisyor» 2018 - {{ date('Y') }}. 
			<a href="{{ route('site-terms') }}">Условия использования Bisyor. Политика о данных пользователей.</a>
		</p>
	</div>
	@php
        foreach ($countersList as $counter) {
            if($counter['code_position'] == 0) echo $counter['code'];
        }
    @endphp
</footer>