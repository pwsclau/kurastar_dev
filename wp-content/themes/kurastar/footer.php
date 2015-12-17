<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<div class="block-footer2">
    <div class="defaultWidth center clear-auto block-footer2-wrap">
        <div class="footcountry">
            <h3 class="footlabel">国を選ぶ</h3>
            <?php echo do_shortcode( '[footer_country]' ); ?>
        </div>
        <div class="footcategory">
            <h3 class="footlabel">ジャンルを選ぶ</h3>
            <div>
                <h4>Menu</h4>
                <?php echo do_shortcode( '[footer_category]' ) ?>
            </div>
        </div>
    </div>

    <div class="defaultWidth center clear-auto">
        <ul class="sm-list-footer">
            <li><a href="<?php echo of_get_option('twitter_link', 'no entry'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt=""></a></li>
            <li><a href="<?php echo of_get_option('facebook_link', 'no entry'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt=""></a></li>
            <li><a href="<?php echo of_get_option('google_plus_link', 'no entry'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/gplus.png" alt=""></a></li>
            <li><a href="<?php echo of_get_option('hatena_link', 'no entry'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/hatena.png" alt=""></a></li>

        </ul>
    </div>
    <div class="defaultWidth center clear-auto">
        <div class="footer-menu">
            <?php wp_nav_menu( array('menu' => 'footer-menu')); ?>
        </div>
    </div>
    <div class="defaultWidth center clear-auto">
        <div class="footer-copyright">
            &copy; Copyright Kura-Star 2015. All Right Reserved.
        </div>
    </div>
</div>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js"></script>
<script>

    (function($) {

        var usedItems = [];

        function split(val) {
            return val.split(/,\s*/);
        }

        function extractLast(term) {
            return split(term).pop();
        }


        $("#taggs")
            // don't navigate away from the field on tab when selecting an item
            .bind("keydown", function(event) {
                if (event.keyCode === $.ui.keyCode.TAB && $(this).data("autocomplete").menu.active) {
                    event.preventDefault();
                }
            }).autocomplete({
                minLength: 0,
                source: function(request, response) {
                    var newNonDuplicatetag = $.grep(taggs, function(el){return $.inArray(el, usedItems) == -1});
                    // delegate back to autocomplete, but extract the last term
                    response($.ui.autocomplete.filter(
                        newNonDuplicatetag, extractLast(request.term)));
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    usedItems.push(ui.item.value);
                    //  console.log(usedItems[1]);
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });

        $(document).on('click', '#seemore-button', function(e){
            e.preventDefault();
            $("#seemore").slideToggle( "fast", function() {
                if( $("#seemore-button").text() == "...read more"){
                    $("#seemore-button").text("read less");
                }else{
                    $("#seemore-button").text("...read more");
                }
            });
        });

    })(jQuery);

</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/lightbox/js/lightbox-plus-jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<script src="http://maps.google.com/maps/api/js?v=3.13&sensor=false&libraries=places&language=en"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/location.js"></script>
<?php wp_footer(); ?>
</body>
<!-- Mirrored from 10.20.150.92/template/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 13 Apr 2015 04:22:38 GMT -->
</html>