<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login - Fintrack</title>
<style>
  :root {
    --gradient-start: #9146ff;
    --gradient-end: #c454e5;
    --purple: #7e56da;
    --background: #f9f9fb;
    --text-primary: #1f2937;
    --text-muted: #6b7280;
    --input-bg: #fff;
    --input-border: #d1d5db;
    --input-focus: #9146ff;
    --button-bg: #9146ff;
    --button-bg-hover: #7e56da;
    --link-color: #9146ff;
    --error-color: #dc2626;
    --success-color: #16a34a;
  }
  * { box-sizing: border-box; }
  body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
      Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    background: var(--background);
    color: var(--text-primary);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem 1rem;
  }
  header {
    width: 100%;
    max-width: 480px;
    padding: 1.5rem 2rem;
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    border-radius: 0.5rem 0.5rem 0 0;
    text-align: center;
    user-select: none;
  }
  main {
    width: 100%;
    max-width: 480px;
    background: white;
    border-radius: 0 0 0.5rem 0.5rem;
    padding: 2rem 2.5rem 3rem;
    box-shadow: 0 8px 16px rgb(142 142 142 / 0.1);
  }
  h2 {
    margin: 0 0 1.5rem 0;
    font-weight: 700;
    color: var(--purple);
    font-size: 1.75rem;
  }
  form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
  }
  label {
    font-size: 0.9rem;
    color: var(--text-muted);
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
  }
  input[type="password"],
  input[type="text"],
  input[type="email"] {
    padding: 0.65rem 1rem;
    font-size: 1rem;
    border-radius: 0.375rem;
    border: 1.5px solid var(--input-border);
    background: var(--input-bg);
    transition: border-color 0.3s ease;
    outline-offset: 2px;
    width: 100%;
  }
  input[type="password"]:focus,
  input[type="text"]:focus {
    border-color: var(--input-focus);
    outline: none;
  }
  button {
    background: var(--button-bg);
    color: white;
    font-weight: 700;
    padding: 0.85rem 0;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background-color 0.3s ease;
    width: 100%;
  }
  button:hover,
  button:focus-visible {
    background: var(--button-bg-hover);
    outline: none;
  }
  .toggle-link {
    margin-top: 1rem;
    font-size: 0.95rem;
    color: var(--link-color);
    text-align: center;
    cursor: pointer;
    user-select: none;
    text-decoration: none;
    display: block;
  }
  .toggle-link:hover,
  .toggle-link:focus-visible {
    text-decoration: underline;
    outline: none;
  }
  .error {
    color: var(--error-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }
  .alert {
    padding: 0.75rem 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
  }
  .alert-success {
    background-color: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: var(--success-color);
  }
  .alert-error {
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    color: var(--error-color);
  }
  .info-box {
    background-color: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 0.375rem;
    padding: 1rem;
    margin-bottom: 1rem;
  }
  .info-box h3 {
    margin: 0 0 0.5rem 0;
    color: #0369a1;
    font-size: 0.9rem;
    font-weight: 600;
  }
  .info-box p {
    margin: 0.25rem 0;
    color: #0c4a6e;
    font-size: 0.8rem;
  }
</style>
</head>
<body>

<header>Fintrack</header>

<main>
  <section id="login-section">
    <h2>Login to Your Account</h2>
    <!-- Alert Success -->
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
      <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 1rem;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('auth.login') }}" method="POST">
      @csrf
      <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required />
      </div>

      <div>
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required />
      </div>

      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>

      <button type="submit">Log In</button>
    </form>
    <a href="{{ route('signup.index') }}" class="toggle-link">Don't have an account? Sign up</a>
  </section>
</main>

</body>
</html>
