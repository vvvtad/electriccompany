<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<style>

.login-page {
    min-height: calc(100vh - 80px);
    background: #f6f8fb;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 60px 20px;
}

.login-box {
    width: 100%;
    max-width: 520px;

    background: #ffffff;

    border-radius: 18px;

    padding: 45px 48px;

    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.10);

    text-align: center;
}

.login-logo {
    font-size: 52px;
    color: #ffc400;

    line-height: 1;

    margin-bottom: 20px;
}

.login-title {
    color: #2850b5;

    font-size: 30px;

    font-weight: 700;

    margin-bottom: 8px;
}

.login-description {
    color: #777;

    font-size: 16px;

    margin-bottom: 30px;
}

.login-form {
    text-align: left;
}

.login-label {
    display: block;

    color: #333;

    font-size: 15px;

    margin-bottom: 8px;

    font-weight: 500;
}

.login-input {
    width: 100%;

    height: 48px;

    border: 1px solid #d8dde5;

    border-radius: 8px;

    padding: 0 15px;

    font-size: 16px;

    outline: none;

    transition: 0.2s;
}

.login-input:focus {
    border-color: #2850b5;

    box-shadow: 0 0 0 3px rgba(40, 80, 181, 0.10);
}

.login-group {
    margin-bottom: 22px;
}

.login-button {
    width: 100%;

    height: 50px;

    border: none;

    border-radius: 28px;

    background: #f6a000;

    color: white;

    font-size: 16px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s;

    margin-top: 3px;
}

.login-button:hover {
    background: #e89100;
}

.login-button i {
    margin-right: 8px;
}

.login-home {
    display: block;

    text-align: center;

    margin-top: 28px;

    color: #3284d6;

    font-size: 16px;

    text-decoration: underline;
}

.login-home:hover {
    color: #1d63a8;
}

.login-alert {
    text-align: left;

    border-radius: 8px;

    margin-bottom: 20px;
}


/* Mobile */

@media (max-width: 576px) {

    .login-page {
        padding: 30px 15px;
    }

    .login-box {
        padding: 35px 25px;
    }

    .login-title {
        font-size: 26px;
    }

}

</style>


<section class="login-page">

    <div class="login-box">

        <!-- Lightning Logo -->

        <div class="login-logo">
            ⚡
        </div>


        <!-- Title -->

        <h1 class="login-title">
            Dashboard Login
        </h1>


        <p class="login-description">
            Enter your username and password.
        </p>


        <!-- Error Message -->

        <?php if (!empty($error)): ?>

            <div class="alert alert-danger login-alert">
                <?= esc($error) ?>
            </div>

        <?php endif; ?>


        <!-- Success Message -->

        <?php if (!empty($success)): ?>

            <div class="alert alert-success login-alert">
                <?= esc($success) ?>
            </div>

        <?php endif; ?>


        <!-- Login Form -->

        <form
            class="login-form"
            method="POST"
            action="<?= base_url('login') ?>"
        >

            <?= csrf_field() ?>


            <!-- Username -->

            <div class="login-group">

                <label
                    for="email"
                    class="login-label"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="login-input"
                    placeholder="Enter your email"
                    value="<?= old('email') ?>"
                    required
                >

            </div>


            <!-- Password -->

            <div class="login-group">

                <label
                    for="password"
                    class="login-label"
                >
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="login-input"
                    placeholder="Enter your password"
                    required
                >

            </div>


            <!-- Login Button -->

            <button
                type="submit"
                class="login-button"
            >
                <i>↪</i>
                Login
            </button>

        </form>


        <!-- Home Link -->

        <a
            href="<?= base_url('/') ?>"
            class="login-home"
        >
            Return to Home
        </a>

    </div>

</section>


<?= $this->endSection() ?>