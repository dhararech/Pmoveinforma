<?php

session_start();
//se a pessoa já estiver logada - não mostra o login
if(!empty($_SESSION['admin_id'])){
  header('Location: painel.php');
  exit;
}
require __DIR__ . '/../config/db.php';

$erro = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? ''; 
    if ($email === '' || $senha === ''){
      $erro = "Preencha e-mail e senha.";
    }
    else{
      $stmt = $pdo->prepare('SELECT * FROM administradores WHERE email = ?');
      $stmt->execute([$email]);
      $admin = $stmt->fetch();
    
    if($admin && password_verify($senha, $admin['senha_hash'])){
      $_SESSION['admin_id']   = $admin['id'];
      $_SESSION['admin_nome'] = $admin['nome'];

      header('Local: painel.php');
      exit;
    }
    $erro = "E-mail ou senha incorretos";
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Move Informa — Entrar</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

   <link rel="icon" type="image/png" href="../img/favicon.png">
  <style>
    body {
      font-family: "Inter", "Segoe UI", sans-serif;
      color: #221B33;
      background-color: #FAF8FF;
      background-image:
        radial-gradient(circle at 8% 8%, rgba(124, 58, 237, 0.08), transparent 40%),
        radial-gradient(circle at 92% 18%, rgba(34, 211, 211, 0.10), transparent 38%);
      min-height: 100vh;
    }

    h1, h2, h3, h4, h5, .brand-name {
      font-family: "Fredoka", "Segoe UI", sans-serif;
      font-weight: 600;
    }

    .login-shell {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .login-card {
      width: 100%;
      max-width: 920px;
      background: #FFFFFF;
      border-radius: 20px;
      box-shadow: 0 10px 30px -12px rgba(124, 58, 237, 0.25);
      overflow: hidden;
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

    .login-side {
      background: linear-gradient(150deg, #7C3AED, #5B21B6 55%, #22D3D3 130%);
      color: #fff;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .login-side .brand-name {
      display: flex;
      align-items: center;
      gap: .6rem;
      font-size: 1.35rem;
    }

    .login-side .logo-badge {
      width: 2.25rem;
      height: 2.25rem;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.18);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .login-side .logo-badge svg { width: 1.35rem; height: 1.35rem; }

    .login-side h2 {
      font-size: 1.6rem;
      line-height: 1.25;
      margin-top: 2rem;
    }

    .login-side p {
      color: rgba(255, 255, 255, 0.85);
      max-width: 32ch;
    }

    .login-side .side-footer {
      font-size: .8rem;
      color: rgba(255, 255, 255, 0.7);
    }

    .login-form-area {
      padding: 3rem 2.75rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .eyebrow {
      text-transform: uppercase;
      letter-spacing: .12em;
      font-size: .75rem;
      font-weight: 700;
      color: #7C3AED;
    }

    .form-label {
      font-weight: 500;
      font-size: .9rem;
    }

    .form-control {
      border-radius: 10px;
      border: 1.5px solid #E7E1F5;
      padding: .65rem .9rem;
    }

    .form-control:focus {
      border-color: #7C3AED;
      box-shadow: 0 0 0 .2rem rgba(124, 58, 237, 0.15);
    }

    .btn-move-primary {
      background: linear-gradient(135deg, #7C3AED, #5B21B6);
      border: none;
      color: #fff;
      border-radius: 999px;
      padding: .65rem 1.4rem;
      font-weight: 600;
      box-shadow: 0 4px 14px -6px rgba(34, 27, 51, 0.15);
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .btn-move-primary:hover {
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 10px 30px -12px rgba(124, 58, 237, 0.25);
    }

    .link-muted {
      color: #6B6478;
      text-decoration: none;
      font-size: .875rem;
    }

    .link-muted:hover { color: #7C3AED; }

    a.link-brand { color: #7C3AED; font-weight: 600; text-decoration: none; }
    a.link-brand:hover { text-decoration: underline; }

    .divider {
      display: flex;
      align-items: center;
      gap: .75rem;
      color: #6B6478;
      font-size: .8rem;
      margin: 1.5rem 0;
    }

    .divider::before, .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #E7E1F5;
    }

    @media (max-width: 767px) {
      .login-card { grid-template-columns: 1fr; }
      .login-side { display: none; }
    }
  </style>
</head>
<body>

  <div class="login-shell">
    <div class="login-card">

      <!-- Painel de marca -->
      <div class="login-side">
        <div class="brand-name">
          <span class="logo-badge">
            <svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 30V14L22 24L32 14V30" fill="none" stroke="#FFFFFF" stroke-width="4.2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          Move Informa
        </div>
        <div>
          <h2>Tecnologia acessível em Libras, sempre à mão.</h2>
          <p>Entre para continuar de onde parou no glossário, nos favoritos e no conteúdo offline.</p>
        </div>
        <div class="side-footer">© 2026 Move Informa — projeto acadêmico.</div>
      </div>
      <?php if($erro): ?>
        <div class="alert alert-danger py-2 small"><?= htmlspecialchars($erro)?></div>
      <?php endif; ?>
      <!-- Formulário -->
      <div class="login-form-area">
        <p class="eyebrow mb-1">Bem-vindo de volta</p>
        <h1 class="h3 mb-1">Entrar na sua conta</h1>
        <p class="text-muted mb-4">Acesse o Move Informa com seu e-mail e senha.</p>

        <form method="post" onsubmit="return false;" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>

          <div class="mb-2">
            <label for="senha" class="form-label">Senha</label>
            <div class="input-group">
              <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required autocomplete="current-password">
              <button class="btn btn-outline-secondary" type="button" id="toggleSenha" aria-label="Mostrar senha">
                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="lembrar">
              <label class="form-check-label link-muted" for="lembrar">Lembrar de mim</label>
            </div>
            <a href="#" class="link-muted">Esqueci minha senha</a>
          </div>

          <button type="submit" class="btn btn-move-primary w-100">Entrar</button>
        </form>

        <div class="divider">ou</div>

        <p class="text-center text-muted small mb-0">
          Ainda não tem conta? <a href="#" class="link-brand">Criar conta</a>
        </p>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById("toggleSenha");
    const senhaInput = document.getElementById("senha");
    toggleBtn.addEventListener("click", () => {
      const isPassword = senhaInput.getAttribute("type") === "password";
      senhaInput.setAttribute("type", isPassword ? "text" : "password");
      toggleBtn.setAttribute("aria-label", isPassword ? "Ocultar senha" : "Mostrar senha");
    });
  </script>
</body>
</html>
