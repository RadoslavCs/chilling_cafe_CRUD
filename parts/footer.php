<footer>
        <p class="tm-text-white tm-footer-text">
          Copyright &copy; 2020 Company Name 
          . Design:
          <a href="https://www.tooplate.com" class="tm-footer-link">Tooplate</a>
        </p>
      </footer>
    </div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script>
      $(function() {
        // Adjust intro image height based on width.
        $(window).resize(function() {
          var img = $("#tm-intro-img");
          var imgWidth = img.width();

          // 640x425 ratio
          var imgHeight = (imgWidth * 425) / 640;

          if (imgHeight < 300) {
            imgHeight = 300;
          }

          img.css("min-height", imgHeight + "px");
        });
      });
    </script>