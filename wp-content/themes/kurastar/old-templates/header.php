<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<!DOCTYPE html>
<html class="no-js" lang="ja">
    
<!-- Mirrored from 10.20.150.92/template/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 13 Apr 2015 04:21:48 GMT -->
<head>
<!-- Le Meta Config -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="ですくりぷしょんですくりぷしょんですくりぷしょん">
<meta name="keywords" content="キーワード1,キーワード2,キーワード3,キーワード4">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Le Favicons -->
<link href="<?php echo get_template_directory_uri(); ?>/ico/favicon.ico" rel="icon" type="image/x-icon" />
<link href="<?php echo get_template_directory_uri(); ?>/ico/apple-touch-icon-144-precomposed.png" rel="apple-touch-icon-precomposed" />
<link href="<?php echo get_template_directory_uri(); ?>/ico/apple-touch-icon-114-precomposed.png" rel="apple-touch-icon-precomposed" />
<link href="<?php echo get_template_directory_uri(); ?>/ico/apple-touch-icon-72-precomposed.png" rel="apple-touch-icon-precomposed" />
<link href="<?php echo get_template_directory_uri(); ?>/ico/apple-touch-icon-57-precomposed.png" rel="apple-touch-icon-precomposed" />

<!-- Le Assets -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/common.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bonix.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/vendor/font-awesome-4.3.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/flexslider.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom.css" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" />

<script type='text/javascript'>
/* <![CDATA[ */
var ajaxurl = "<?php echo site_url() ?>/wp-admin/admin-ajax.php";
/* ]]> */
</script>
<?php wp_head(); ?>
</head>
	<body>
		<div class="box100 mainWrap">
			<div class="contentWrap">
		<div class="head1">
			<div class="defaultWidth center headwrap">
				<a class="menu-sp"></a>
				<div class="logo">
					<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="株式会社 デュナレイト" title="株式会社 デュナレイト" /></a>
				</div>

				<div class="searchform">
					<?php get_search_form();?>
				</div>

				<div class="actions">
					<?php if (!is_user_logged_in()): ?>

						<a href="<?php echo site_url() ?>/user-login"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_login.png" />LOGIN</a>
						<a href="<?php echo site_url() ?>/user-registration"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_signup.png" />REGISTER</a>
						<a href="<?php echo site_url() ?>/create-article"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_write.png" />POST</a>
						
					<?php else: ?>
						<a href="<?php echo wp_logout_url('$index.php'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_login.png" />LOGOUT</a>
						<?php  
							$current_user = wp_get_current_user(); 
							$profile = getCurrentProfile(array( 'user_id' => $current_user->ID )); 
						?>

						<a href="<?php echo site_url() ?>/curator-detail/?id=<?php echo $current_user->ID ?>">
						<img src="<?php echo $profile; ?>" class="avatar avatar-96 photo" height="96" width="96">
						<?php echo $current_user->user_login ?></a>
						<a href="<?php echo site_url() ?>/create-article"><img src="<?php echo get_template_directory_uri(); ?>/images/icon_write.png" />POST</a>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<div class="head2">
			<div class="defaultWidth center menuwrap">
				<?php wp_nav_menu( array('menu' => 'header-menu')); ?>
			</div>
		</div>

		<?php acf_form_head(); ?>