
    <!-- ================================
         END FOOTER AREA
================================= -->
<section class="footer-area pt-40px bg-dark position-relative">

        
        <div class="container">
            <div class="row align-items-center pb-4 copyright-wrap">
                <div class="col-lg-6">
                    <a href="index.php" class="d-inline-block">
                        <img src="images\logo-white.png" alt="footer logo" class="footer-logo">
                    </a>
                </div><!-- end col-lg-6 -->
                <div class="col-lg-6">
                    <p class="copyright-desc text-right fs-14">Copyright &copy; 2021</p>
                </div><!-- end col-lg-6 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end footer-area -->
    <!-- ================================
          END FOOTER AREA
================================= -->

    <!-- start back to top -->
    <div id="back-to-top" data-toggle="tooltip" data-placement="top" title="Return to top">
        <i class="la la-arrow-up"></i>
    </div>
    <!-- end back to top -->

    


    <!-- template js files -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.lazy.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/leaflet.js"></script>
    <script src="js/map.js"></script>
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/intlTelInput-jquery.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery-te-1.4.0.min.js"></script>
    <script src="js/jquery.multi-file.min.js"></script>
    <script src="js/chosen.min.js"></script>
    <script src="js/bootstrap-tagsinput.min.js"></script>
    <script src="js/tagsinput.js"></script>

<script src="js\upvote.vanilla.js"></script>
<script src="js\upvote-script.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="js/main.js"></script>

    <script>

$(document).ready(function(){
    $("#votecount").on('DOMSubtreeModified',function(){
        var voted = $( "#voted" ).hasClass( "upvote-on" );
        if(voted === true){
            $('#votecountinput').val('0');
        }
        elseif(voted === false)
        {
            $('#votecountinput').val('1');
        }

     });

 });

        if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$("#type").select2({
  maximumSelectionLength: 1
});

// $('form input').keydown(function (e) {
//     if (e.keyCode == 13) {
//         e.preventDefault();
//         return false;
//     }
// });

$("#tags").keypress(preventSubmit);


</script>


    

</body>

</html>
