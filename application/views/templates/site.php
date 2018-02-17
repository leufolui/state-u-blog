<!DOCTYPE html>
<html>
<head>
	<title><?=$site_title;?></title>


  <meta property="og:url"           content="<?=isset($link) ? $link : site_url();?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="<?=isset($meta_title) ? $meta_title : 'Bohol Island State University - Bilar'; ?>" />
  <meta property="og:description"   content="<?=isset($description) ? $description : 'Bohol Island State University - Bilar a  premier Science and Technology University for the formation of World class and virtuous human resource for sustainable development in Bohol and the Country.'; ?>" />
  <meta property="og:image"         content="<?=isset($featured_image) ? $featured_image : base_url('public/images/post-img.png'); ?>" />

		<link rel="shortcut icon" href="<?=base_url();?>public/images/logo-only-icon.png"/>
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/bootstrap.min.css">  
        <link rel="stylesheet" type="text/css" href="<?=base_url();?>public/assets/bootstrap/css/font-awesome.css">        
        <link href="<?=base_url('public/assets/css/animate.css');?>" rel="stylesheet">


        <link href="<?=base_url('public/assets/css/site/index.css');?>" rel="stylesheet">
        <?php // add css files
        $this->minify->css(array('animate.css','site/index.css','print.css'));
        echo $this->minify->deploy_css();
        
    ?>

        <!-- CORE PLUGINS -->
        <script src="<?=base_url('public/assets/js/jquery.11.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?=base_url('public/assets/js/notify/dist/notify.js');?>" type="text/javascript"></script>
</head>
<body class="site"  data-spy="scroll" data-target=".navbar" data-offset="50">
<header>
	<div class="header-menu">
	<?php include 'common/site_menu.php'; ?>
	</div>
        <?php $page = $this->input->get('p') ? $this->input->get('p') : 'bilar';
        $sitename = $this->site_m->getSiteName($page);

         ?>
        <div class="container"><?=isset($page) ? '<h3 class="subsite-name">'.$sitename[0]->site_name.'</h3>' : '' ;?></div>
</header>
<div class="site-body">
	<?php echo $body; ?>
</div>

<footer>
	
</footer>
<script type="text/javascript">
	$(document).ready(function(){

/**
 * This object controls the nav bar. Implement the add and remove
 * action over the elements of the nav bar that we want to change.
 *
 * @type {{flagAdd: boolean, elements: string[], add: Function, remove: Function}}
 */
var myNavBar = {

    flagAdd: true,

    elements: [],

    init: function (elements) {
        this.elements = elements;
    },

    add : function() {
        if(this.flagAdd) {
            for(var i=0; i < this.elements.length; i++) {
                document.getElementById(this.elements[i]).className += " fixed-theme";
            }
            this.flagAdd = false;
        }
    },

    remove: function() {
        for(var i=0; i < this.elements.length; i++) {
            document.getElementById(this.elements[i]).className =
                    document.getElementById(this.elements[i]).className.replace( /(?:^|\s)fixed-theme(?!\S)/g , '' );
        }
        this.flagAdd = true;
    }

};

/**
 * Init the object. Pass the object the array of elements
 * that we want to change when the scroll goes down
 */
myNavBar.init(  [
    "header",
    "header-container",
    "brand"
]);

/**
 * Function that manage the direction
 * of the scroll
 */
function offSetManager(){

    var yOffset = 0;
    var currYOffSet = window.pageYOffset;

    if(yOffset < currYOffSet) {
        myNavBar.add();
    }
    else if(currYOffSet == yOffset){
        myNavBar.remove();
    }

}

/**
 * bind to the document scroll detection
 */
window.onscroll = function(e) {
    offSetManager();
}

/**
 * We have to do a first detectation of offset because the page
 * could be load with scroll down set.
 */
offSetManager();
});

/*
	$('#navbar').on('resize', function () {
    $('.pull-right').toggleClass('pull-left', $(window).width() < 768);
});
*/

</script>
</body>
</html>