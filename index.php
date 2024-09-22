<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    
    // Verileri .txt dosyasına kaydetme
    $file = fopen("bilgiler.txt", "a");
    fwrite($file, "Ad: $name\nSoyad: $surname\nTelefon: $phone\n\n");
    fclose($file);
    
    // Giriş başarılı mesajı
    echo "<p class='success'>Giriş başarılı! Bilgiler kaydedildi.</p>";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Formu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Giriş Yap</h2>
    <form action="" method="post">
        <label for="name">Ad:</label>
        <input type="text" id="name" name="name" required>

        <label for="surname">Soyad:</label>
        <input type="text" id="surname" name="surname" required>

        <label for="phone">Telefon Numarası:</label>
        <input type="tel" id="phone" name="phone" required>

        <input type="submit" value="Giriş Yap">
    </form>
</div>

</body>
</html>
