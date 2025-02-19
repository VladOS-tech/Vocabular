<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phraseologies</title>
</head>
<body>
    <h1>Добавление фразеологизма</h1>
    <form action="{{ url('/phraseologies') }}" method="POST">
        @csrf
        <label for="content">Фразеологизм:</label>
        <input type="text" id="content" name="content" required>
        <br><br>
        
        <label for="meaning">Значение:</label>
        <textarea id="meaning" name="meaning" required></textarea>
        <br><br>
        
        <label for="status">Статус:</label>
        <select id="status" name="status" required>
            <option value="pending">На проверке</option>
            <option value="approved">Одобрено</option>
            <option value="rejected">Отклонено</option>
        </select>
        <br><br>
        
        <button type="submit">Добавить</button>
    </form>
</body>
</html>

