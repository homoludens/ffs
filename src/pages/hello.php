<!-- example.com/src/pages/hello.php -->
Hello <?= htmlspecialchars(isset($name) ? $name : 'World', ENT_QUOTES, 'UTF-8') ?>