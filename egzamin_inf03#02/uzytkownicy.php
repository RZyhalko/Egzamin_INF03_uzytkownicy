<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Portal społecznościowy</title>
    <link rel="stylesheet" href="styl5.css">
</head>
<body>
    <header>
            <section class="baner1"><br>
                <h2>Nasze osiedle</h2>
            </section>
            <section class="baner2">
                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'portal');
                $qrr = "SELECT count(*) FROM dane";
                $result = mysqli_query($conn, $qrr);
                $number = "<br>Liczba użytkowników portalu:&nbsp;";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h5>$number{$row['count(*)']}</h5>";
                }
                ?>
            </section>
    </header>
            <section class="lewy"><br>
                <h3>Logowanie</h3><br>
                <form method="post">
                    <label for="login">login:</label><br>
                    <input type="text" id="login" name="login"><br>
                    <label for="haslo">hasło:</label><br>
                    <input type="password" id="haslo" name="haslo"><br>
                    <input type="submit" value="Zaloguj" name="btn">
                </form>
            </section>
            <section class="prawy"><br>
                <h3>Wizytówka</h3>
                <?php
                $baza = mysqli_connect('localhost', 'root', '', 'portal');
                $login_nie = "login nie istnieje";
                $haslo_nie = "hasło nieprawidłowe";
                if (!empty($_POST['login']) && !empty($_POST['haslo'])) {
                    $login = mysqli_real_escape_string($baza, $_POST['login']);
                    $haslo = mysqli_real_escape_string($baza, $_POST['haslo']);
                    $haslo = sha1($haslo);
                    $za = "SELECT haslo FROM uzytkownicy WHERE login='$login'";
                    $wy = mysqli_query($baza, $za);
                    if (mysqli_num_rows($wy) == 1) {
                        $row = mysqli_fetch_assoc($wy);
                        if ($haslo == $row['haslo']) {
                            $za2 = "SELECT uzytkownicy.login, dane.rok_urodz, dane.przyjaciol, dane.hobby, dane.zdjecie FROM uzytkownicy Inner JOIN dane ON dane.id=uzytkownicy.id WHERE uzytkownicy.login='$login'";
                            $wy2 = mysqli_query($baza, $za2);
                            while ($row = mysqli_fetch_assoc($wy2)) {
                                $wiek = 2023 - $row['rok_urodz'];
                                echo "<section class='wizytowka'>";
                                echo "<img src=\"{$row['zdjecie']}\" alt='osoba'>";
                                echo "<h4><br>{$row['login']} ({$wiek})</h4><br>";
                                echo "<p>hobby: {$row['hobby']}</p><br>";
                                echo "<h1><img src='icon-on.png'>{$row['przyjaciol']}</h1><br>";
                                echo "<a href='dane.html'><button>Więcej informacji</button></a>";
                                echo "</section>";
                            }
                        } else {
                            echo $haslo_nie;
                        }
                    } else {
                        echo $login_nie;
                    }
                }
                mysqli_close($baza);
                ?>
            </section>
    <footer>
        Stronę wykonał: 0000000000
    </footer>
</body>
</html>
