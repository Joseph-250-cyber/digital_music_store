    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>🎵 Digital Music Store</h4>
                    <p>Discover and manage your music collection</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="services.php">Services</a></li>
                        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'artist') { ?>
                            <li><a href="register.php">Add Music</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Kigali, Rwanda</p>
                    <p><i class="fas fa-phone"></i> +250 791 591 773</p>
                    <p><i class="fas fa-envelope"></i> info@musicstore.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Digital Music Store. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

  </body>
</html>