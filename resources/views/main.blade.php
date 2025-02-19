<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
</head>
<body>
    <h1>Добро пожаловать на сайт!</h1>
    <p>Этот сайт предназначен для неавторизованных пользователей. Здесь вы можете...</p>
    <form method="POST" action="{{ route('phraseologies.store') }}">
    @csrf
    <h2>Добавить фразеологизм</h2>
    <div>
        <label for="content">Фразеологизм:</label>
        <input type="text" id="content" name="content" required>
    </div>
    <div>
        <label for="meaning">Значение:</label>
        <textarea id="meaning" name="meaning" required></textarea>
    </div>
     <div>
        <label for="context">Контекст:</label>
        <textarea id="context" name="context" required></textarea>
    </div>
    <div>
        <label for="tags">Выберите теги:</label>
        <select id="tags" name="tags[]" multiple>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->content }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit">Добавить</button>
</form>

</body>
</html>

