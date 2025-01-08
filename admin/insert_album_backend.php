<?php
require_once '../db/get_user_by_cookie.php';
require_once '../vendor/autoload.php'; // PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../layout-elements/no_permiss.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Otteniamo i dati dal form
    $title = trim($_POST["title"]);
    $artist_id = $_POST['artist_id'];
    $release_date = $_POST['release_date'];
    $cover = filter_var(trim($_POST["cover"]), FILTER_SANITIZE_URL);
    $link = filter_var(trim($_POST["link"]), FILTER_SANITIZE_URL);

    $errors = [];

    if (empty($title)) {
        $errors[] = "Il titolo dell'album è obbligatorio.";
    } elseif (strlen($title) > 50) {
        $errors[] = "Il titolo non può superare i 50 caratteri.";
    }

    if (empty($artist_id)) {
        $errors[] = "L'artista è obbligatorio.";
    }

    if (empty($release_date)) {
        $errors[] = "La data di uscita è obbligatoria.";
    }

    if (empty($cover) || !filter_var($cover, FILTER_VALIDATE_URL)) {
        $errors[] = "La cover dell'album non è valida.";
    } elseif (strlen($link) > 255) {
        $errors[] = "Link della cover troppo lungo.";
    }

    if (empty($link) || !filter_var($link, FILTER_VALIDATE_URL)) {
        $errors[] = "Il link dell'album non è valido.";
    } elseif (strlen($link) > 255) {
        $errors[] = "Link troppo lungo.";
    }

    if (!empty($errors)) {
        echo "<p>" . implode("<br>", $errors) . "</p>";
        echo "<p>Riprova a inserire i dati correttamente.</p>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'insert_album.php';
                }, 2000);
              </script>";
        exit();
    }

    $query = "INSERT INTO albums (title, artist_id, release_date, cover, link) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $title, $artist_id, $release_date, $cover, $link);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Album inserito con successo!</p>";
            sendNewsletter($title, $release_date, $link, $artist_id);
            echo "<script>setTimeout(function() { window.location.href = 'album_list.php'; }, 2000);</script>";
        } else {
            echo "<p>Errore durante l'inserimento dell'album.</p>";
            echo "<script>setTimeout(function() { window.history.back(); }, 2000);</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p>Errore del server. Riprova più tardi.</p>";
        echo "<script>setTimeout(function() { window.history.back(); }, 2000);</script>";
    }

    mysqli_close($conn);
}
?>
<?
// GESTIONE DELLA NEWSLETTER
function sendNewsletter($title, $release_date, $link, $artist_id) {
    global $conn;

    // Ottieni gli utenti iscritti alla newsletter
    $sql = "SELECT email, first_name FROM users WHERE newsletter = 1";
    $result = mysqli_query($conn, $sql);

    $artist_sql = "SELECT name FROM artists WHERE id = ?";
    $stmt = mysqli_prepare($conn, $artist_sql);
    mysqli_stmt_bind_param($stmt, "s", $artist_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $artist_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Crea il contenuto della newsletter
    $newsletter_subject = "Nuovo Album in uscita: $title!";
    $newsletter_body = "
    <p>Ciao {first_name},</p>
    <p>Siamo felici di annunciarti che il nuovo album <b>$title</b> di <b>$artist_name</b> uscirà il <b>$release_date</b>.</p>
    <p>Corri ad ascoltarlo su spotify,<a href='$link'> cliccando qui! </a>.</p>
    <p>E non appena hai finito, <a href='https://saw.dibris.unige.it/~s5721355/homepage.php'>vieni a recensirlo sul nostro sito!</a></p>
    <p>Non vediamo l'ora di sentire la tua opinione!</p>
    <p>Grazie,</p>
    <p>Il Team di Hip-Adviser</p>
    ";

    // Invia email agli utenti
    while ($row = mysqli_fetch_assoc($result)) {
        $mail = new PHPMailer(true);
        try {
            // Configura il server SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; // Server SMTP di esempio
            $mail->SMTPAuth = true;
            $mail->Username = 'your_username';
            $mail->Password = 'your_password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Impostazioni email
            $mail->setFrom('newsletter@hipadviser.com', 'Hip-Adviser');
            $mail->addAddress($row['email'], $row['first_name']);
            $mail->Subject = $newsletter_subject;
            $mail->Body = str_replace("{first_name}", $row['first_name'], $newsletter_body);
            $mail->isHTML(true);

            $mail->send();
        } catch (Exception $e) {
            echo "Errore nell'invio della newsletter: {$mail->ErrorInfo}";
        }
    }
}
?>
