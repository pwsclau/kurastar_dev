<?php 

/*Template Name: Test */

get_header(); ?>
<div class="defaultWidth center clear-auto bodycontent registration-page">
<div class="contentbox nosidebar">

<label>Admin</label>      <br />
<label>My life...</label> <br />
<label>Profile</label>    <br />
<input type="button" value="View" id="View" />
<input type="button" value="Edit" id="Edit" />

<?php 
?>

</div>
</div>
<script type="text/javascript">
(document).ready(function(){
    $( "#Edit" ).click( function() {
        $( "label" ).replaceWith( function() {
            return "<input type=\"text\" value=\"" + $( this ).html() + "\" />";
        });
    });
    $( "#View" ).click( function() {
        $( "input[type=text]" ).replaceWith( function() {
            return "<label>" + $( this ).val() + "</label>";
        });
    });
});
</script>
<?php get_footer(); ?>