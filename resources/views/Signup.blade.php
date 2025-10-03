<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Signup - Fintrack Style</title>
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
  input[type="email"],
  input[type="password"],
  input[type="text"] {
    padding: 0.65rem 1rem;
    font-size: 1rem;
    border-radius: 0.375rem;
    border: 1.5px solid var(--input-border);
    background: var(--input-bg);
    transition: border-color 0.3s ease;
    outline-offset: 2px;
  }
  input[type="email"]:focus,
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
  }
  .toggle-link:hover,
  .toggle-link:focus-visible {
    text-decoration: underline;
    outline: none;
  }
  .error {
    color: var(--error-color);
    font-size: 0.875rem;
  }
</style>
</head>
<body>

<header>Fintrack</header>

<main>
  <section id="signup-section">
    <h2>Create New Account</h2>
    <form id="signup-form" novalidate>
      <label for="signup-name">Username</label>
      <input type="text" id="signup-name" name="signup-name"  required minlength="2" />

      <label for="signup-email">Email Address</label>
      <input type="email" id="signup-email" name="signup-email" required />

      <label for="signup-password">Password</label>
      <input type="password" id="signup-password" name="signup-password" required minlength="6" />

      <label for="signup-password-confirm">Confirm Password</label>
      <input type="password" id="signup-password-confirm" name="signup-password-confirm" required minlength="6" />

      <button type="submit">Sign Up</button>
    </form>
    <p class="toggle-link">Already have an account? Log in</p>
  </section>
</main>

<script>

  document.getElementById('signup-form').addEventListener('submit', e => {
    e.preventDefault();
    const name = e.target['signup-name'].value.trim();
    const email = e.target['signup-email'].value.trim();
    const password = e.target['signup-password'].value;
    const confirmPassword = e.target['signup-password-confirm'].value;
    if (!name || !email || !password || !confirmPassword) {
      alert('Please fill out all fields to sign up.');
      return;
    }
    if (password !== confirmPassword) {
      alert('Passwords do not match. Please try again.');
      return;
    }
    alert('Signup successful! (This is a demo alert)');
    e.target.reset();
    window.location.href = 'login.html';
  });
</script>

</body>
</html>
