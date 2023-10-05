<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form action="{{ url('admin_access') }}" method="POST">
        @csrf
        <label for="pass">Pass admin : </label>
        <input type="password" name="pass" id="pass">
        <input type="submit" value="Envoyer !">
    </form>
</body>
</html>