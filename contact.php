<?php
include("inc/header.php");
include("inc/menu.php");
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-wrapper">
    <div class="main-content">
        <h1>📞 Contact Us</h1>
        <p class="page-intro">We'd love to hear from you! Reach out to us through any of the channels below.</p>

        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <h4>Address</h4>
                <p>Kigali, Gasabo<br>Street KK 508 ST<br>P.O Box 6392 Kigali, Rwanda</p>
            </div>
        </div>

        <div class="contact-item">
            <i class="fas fa-phone-alt"></i>
            <div>
                <h4>Phone</h4>
                <p><a href="tel:+250791591773">+250 791 591 773</a></p>
            </div>
        </div>

        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h4>Email</h4>
                <p><a href="mailto:info@musicstore.com">info@musicstore.com</a></p>
            </div>
        </div>

        <div class="contact-item">
            <i class="fab fa-whatsapp"></i>
            <div>
                <h4>WhatsApp</h4>
                <p><a href="https://wa.me/250791591773">+250 791 591 773</a></p>
            </div>
        </div>

        <div class="contact-item">
            <i class="fas fa-clock"></i>
            <div>
                <h4>Office Hours</h4>
                <p>Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 1:00 PM<br>Sunday: Closed</p>
            </div>
        </div>

        <h3 style="margin-top:30px; color:#0a2a2a;">Send Us a Message</h3>
        <form action="#" method="post">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Your Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Your Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group">
                <label for="subject"><i class="fas fa-tag"></i> Subject:</label>
                <input type="text" id="subject" name="subject" placeholder="Subject of your message">
            </div>

            <div class="form-group">
                <label for="message"><i class="fas fa-comment"></i> Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Send Message</button>
        </form>
    </div>
    <?php include("inc/sidebar.php"); ?>
</div>

<?php include("inc/footer.php"); ?>