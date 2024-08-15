<!-- resources/views/layouts/footer.blade.php -->
<footer>
    <div class="footer-content">
        <div class="footer-section about">
            <h2>SUIGENOS EN FACEBOOK</h2>
            <div class="social-container">
                <a href="https://www.facebook.com/people/Comedores-Industriales-De-La-Fuente/61558344330763/?checkpoint_src=any" target="_blank">
                    <img src="{{ asset('img/feisluk.png') }}" alt="Facebook Logo" style="width: 70px; height: 70px;">
                </a>
            </div>
        </div>
        <div class="footer-section links">
            <h2>Enlaces</h2>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('menu') }}">Menu</a></li>
                <li><a href="{{ route('inventory') }}">Login</a></li>
            </ul>
        </div>
        <div class="footer-section contact">
            <h2>Contactanos</h2>
            <p>
                <strong>E-mail:</strong> comedoresrg@yahoo.com.mx
            </p>
            <p>
                <strong>Telefono:</strong> +52 8711551686
            </p>
            <p>
                <strong>Direccion:</strong> Puerta Real, Paseo Borbon #102
            </p>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2024 Comedores de la Fuente. Todos Los Derechos Reservados.
    </div>
</footer>

<!-- CSS -->
<style>
    footer {
        background: #333;
        color: #fff;
        padding: 20px 0;
        text-align: center;
    }
    .footer-content {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
    .footer-section {
        flex: 1;
        padding: 10px;
        min-width: 200px;
    }
    .footer-section h2 {
        margin-bottom: 10px;
        font-size: 20px;
        color: #ff9900;
    }
    .footer-section ul {
        list-style: none;
        padding: 0;
    }
    .footer-section ul li {
        margin-bottom: 5px;
    }
    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
    }
    .footer-section ul li a:hover {
        text-decoration: underline;
    }
    .footer-bottom {
        margin-top: 20px;
        font-size: 14px;
    }
    .social-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px; 
    }
</style>
