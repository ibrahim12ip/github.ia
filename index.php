<?php
session_start();

// İsim ve soyisimleri kaydedeceğimiz dosya
$dosya = "ziyaretci_listesi.txt";

// Giriş ve çıkış zamanlarını kaydedeceğimiz dosya
$zaman_dosyasi = "ziyaretci_zamanlari.txt";

// Çıkış işlemini kontrol et
if (isset($_POST['cikis'])) {
    if (isset($_SESSION['isim']) && isset($_SESSION['soyisim'])) {
        $isim = $_SESSION['isim'];
        $soyisim = $_SESSION['soyisim'];
        $cikis_zamani = date("Y-m-d H:i:s");
        
        // Çıkış zamanını kaydet
        $fp = fopen($zaman_dosyasi, "a");
        fwrite($fp, "$isim $soyisim - Çıkış Zamanı: $cikis_zamani\n");
        fclose($fp);
        
        // Oturumu kapat
        session_unset();
        session_destroy();
    }
    exit; // Scripti bitir ve başka işlem yapma
}

// Kullanıcı daha önce adını ve soyadını girdiyse, giriş zamanını kaydet
if (isset($_SESSION['isim']) && isset($_SESSION['soyisim'])) {
    $isim = $_SESSION['isim'];
    $soyisim = $_SESSION['soyisim'];
    
    // Giriş zamanı kaydet
    $giris_zamani = date("Y-m-d H:i:s");
    if (!file_exists($zaman_dosyasi)) {
        file_put_contents($zaman_dosyasi, "");
    }
    $fp = fopen($zaman_dosyasi, "a");
    fwrite($fp, "$isim $soyisim - Giriş Zamanı: $giris_zamani\n");
    fclose($fp);

    echo "<h2>Hoş geldiniz, $isim $soyisim!</h2>";
} else {
    // Kullanıcıdan ad ve soyadını iste
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isim']) && isset($_POST['soyisim'])) {
        $isim = htmlspecialchars($_POST['isim']);
        $soyisim = htmlspecialchars($_POST['soyisim']);

        // Ziyaretçiyi kaydet
        $fp = fopen($dosya, "a");
        fwrite($fp, $isim . " " . $soyisim . "\n");
        fclose($fp);

        // Kullanıcı bilgilerini oturumda sakla
        $_SESSION['isim'] = $isim;
        $_SESSION['soyisim'] = $soyisim;

        // Giriş zamanını kaydet
        $giris_zamani = date("Y-m-d H:i:s");
        $fp = fopen($zaman_dosyasi, "a");
        fwrite($fp, "$isim $soyisim - Giriş Zamanı: $giris_zamani\n");
        fclose($fp);

        echo "<h2>Hoş geldiniz, $isim $soyisim!</h2>";
    } else {
        // Formu göster
        echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .form-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .form-container h2 {
                margin-bottom: 20px;
                color: #333;
            }
            .form-container input[type="text"] {
                width: 80%;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 4px;
                border: 1px solid #ccc;
            }
            .form-container input[type="submit"] {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
            }
            .form-container input[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
        <div class="form-container">
            <h2>Lütfen Adınızı ve Soyadınızı Girin</h2>
            <form method="post">
                Adınız: <br><input type="text" name="isim" required><br>
                Soyadınız: <br><input type="text" name="soyisim" required><br><br>
                <input type="submit" value="Gönder">
            </form>
        </div>';
    }
}
?>
<script>
    // Sayfa kapatıldığında veya kullanıcı başka bir sayfaya geçtiğinde çıkış zamanı kaydedilsin
    window.addEventListener('beforeunload', function() {
        var form = document.getElementById('logoutForm');
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cikis';
        input.value = 'true';
        form.appendChild(input);
        form.submit();
    });
</script>
