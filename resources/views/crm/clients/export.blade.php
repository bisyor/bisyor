<table>
    <thead>
    <tr>
        <td>
            Пример для заполнения клиентской базы с помощью таблиц Excel. Обратите внимание на правила при заполнении
            таблицы!
        </td>
    </tr>
    <tr>
        <th>
            Тип клиента
            1 <=> Юридическое лицо
            2 <=> Физическое лицо
            (обязательный)
        </th>
        <th>
            Фамилия Имя Отчество (обязательный)
        </th>
        <th>
            Название компании (Обязательно только для юридических лиц)
        </th>
        <th>
            Телефонный номер (обязательный)
        </th>
        <th>
            ИНН номер
        </th>
        <th>
            Адрес
        </th>
        <th>
            Адрес электронной почты
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td>{{ $client->type }}</td>
            <td>{{ $client->fio }}</td>
            <td>{{ $client->company_name }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->inn }}</td>
            <td>{{ $client->address }}</td>
            <td>{{ $client->email }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
