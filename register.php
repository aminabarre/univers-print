<?php
require 'includes/db.php';
require 'includes/header.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = trim($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if(!$nom || !$email || !$password || !$confirm){
        $error = "⚠️ Remplissez tous les champs.";
    } elseif($password !== $confirm){
        $error = "❌ Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()){
            $error = "🚫 Cet email est déjà utilisé.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $hash]);
            $success = "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
        }
    }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h2 class="text-center text-primary fw-bold mb-4">🧍‍♀️ Créez votre compte</h2>

          <?php if(!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
          <?php endif; ?>

          <?php if(!empty($success)): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label class="form-label">Nom complet</label>
              <input type="text" name="nom" class="form-control" 
                     value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Adresse email</label>
              <input type="email" name="email" class="form-control" 
                     value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmez le mot de passe</label>
              <input type="password" name="confirm" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 mt-3">S’inscrire</button>

            <p class="text-center mt-3">
              Déjà inscrit ? 
              <a href="login.php" class="text-decoration-none text-primary fw-semibold">Se connecter</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
