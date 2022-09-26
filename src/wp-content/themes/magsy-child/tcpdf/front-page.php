<?php
/**
 * The Front page
 *
 * @package arteck-design
 */
?>
<?php get_header('home'); ?>

<section class="section home-page">
	
	<div class="container-fluid bg-top home-slider">
        <div class="container">
            <div class="row">
                <!--<div class="col-md-12">-->
                    
                    <span id="home"></span>

                    <?php // Categorie Page d'accueil

                    $args = array(
                        'post_type' => 'produit',
                        'cat' => 40,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'posts_per_page' => -1,
                    );

                    $query = new WP_Query( $args );
                    if ( $query->have_posts() ) {
                    ?>
                        
                        <div class="carousel slide prod" id="carousel-produit" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?php
                                $nslide=0;
                                while ( $query->have_posts() ) : $query->the_post();
                                ?>     
                                    <div class="solo-prod item <?php if($nslide==0) echo 'active'; ?>">
                                        <div class="img-prod">
                                            <?php if(has_post_thumbnail()){
                                                the_post_thumbnail('home-product');
                                            } ?>
                                        </div>
                                        <div class="text-prod">
                                            <h2><?php the_title(); ?></h2>
                                            <p><?php echo get_the_excerpt(); ?></p>
                                            <div class="remontee-prod">
                                                <?php for ($i=1; $i <= 3 ; $i++) { ?>
                                                    <img src="<?php echo get_image('photo_produit_'.$i,1,1,0,NULL, "zc=1&w=110&h=110"); ?>" alt="" height="110" width="110" />
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php  $nslide++;
                                endwhile; ?>
                            </div><!--div class="carousel-inner" role="listbox"-->
                            <div class="btn-prod">
                                <a href="<?php echo get_category_link(40); ?>"><?php _e('Voir notre sélection'); ?></a>
                            </div>

                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <?php
                                /*
                                $nslide=0;
                                while ( $query->have_posts() ) : 
                                    $query->the_post(); ?>   
                                        <li data-target="#carousel-produit" data-slide-to="<?php echo $nslide; ?>" class="<?php if($nslide==0) echo 'active'; ?>"></li>
                                <?php 
                                $nslide++;
                                endwhile;
                                } */
                                ?>
                            </ol>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-produit" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left glyphicon-menu-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-produit" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right glyphicon-menu-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                
                            <div class="clearfix"></div>

                        </div><!--carousel slide prod -->

                    <?php } ?>
                    <div class="clearfix"></div>
                <!--</div>-->
            </div>
        </div>
    </div>
    
    <!-- NOS GAMMES -->
    <div class="home-section home gammes"> 
        <div class="container">
            <div class="row section1">

                <h2 id="nosgammes">Nos gammes</h2>
                <?php get_template_part( 'content', 'slideshow' ); ?>
                <?php get_template_part( 'content', 'responsive-gammes' ); ?>  
                <div class="text-center"> 
                	<a href="<?php echo get_category_link(23); ?>" title="<?php _e("Voir toutes nos gammes"); ?>" class="btn btn-default">
                        <?php _e("Voir toutes nos gammes"); ?>   
                    </a>
                </div>
			</div><!-- row -->
        </div><!-- container -->
    </div>

    <!-- OFFICE CONCEPT EN VIDEO -->
    <div class="home-section home offvid"> 
        <div class="container">
            <h2 id="office-video">OFFICE CONCEPT EN VIDEO</h2>
            <div class="col-sm-6">
                <h2>Office Concept vous présente son activité à travers ses vidéos</h2>
                <?php $latest_post = get_post( array( 'cat' => 35, 'posts_per_page' => 1) ); ?>
                <a href="<?php echo get_permalink( $latest_post->ID ); ?>" title="Page Vidéo" class="video-link">&gt; Accéder aux vidéos</a>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo get_permalink( $latest_post->ID ); ?>" class="player-icon"><img src="<?php echo get_template_directory_uri(); ?>/images/image-video.jpg" class="img-responsive" alt="Arteck Design en vidéo" border="0"  width="500" height="370"/></a>
            </div>
        </div>
    </div>

    <!-- ACTUALITES -->
    <div class="home-section home actu">         
        <div class="container">
            <h2 id="actualites">Actualités</h2>

            <?php get_template_part( 'content', 'slideshowactus' ); ?>
            <?php get_template_part( 'content', 'slideshowactusresponsive' ); ?>
            <div class="text-center"> 
                <a href="<?php echo get_category_link(34); ?>" title="<?php _e("Voir tous nos articles"); ?>" class="btn btn-default">
                    <?php _e("Voir tous nos articles"); ?>
                </a>
            </div>
            
        </div>
    </div>

    <!-- VISITE 360 -->
    <div class="home-section home visite">
        <div class="wrapper">
            <div class="sliding-background"></div>
        </div>

        <div class="container">
            <h2 id="visite">VISITE 360°</h2>
            <?php
            /*$query = new WP_Query(
                array(
                    'post_type' => 'visite',
                    'post_status' => 'publish',
                    'posts_per_page' => 4,
                    'order' => 'DESC',
                    'orderby' => 'date'
                )
            );

            if ( $query->have_posts() ) { ?>
                <div class="global-visite">
                    <?php while ( $query->have_posts() ) {
                        $query->the_post();

                        $link_visite = get('lien_visite');

                        if($link_visite){ ?>
                            <div class="solo-visite">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if(has_post_thumbnail()){ ?>
                                        <div class="hovereffect">
                                            <?php echo the_post_thumbnail(); ?>
                                            <div class="overlay"></div>
                                        </div>
                                        
                                    <?php } ?>
                                        <h3><?php the_title(); ?></h3>
                                        <span> <?php _e('Lire'); ?></span>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } //endwhile ?>
                </div>
                <?php wp_reset_postdata();
            } else {
                
            }*/ ?>

            <div class="text-center"> 
                <a href="<?php echo get_permalink(2382) ?>" title="<?php _e("Voir toutes nos visites"); ?>" class="btn btn-default">
                    <?php _e("Voir toutes nos visites"); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- REMONTEE DE PAGES -->
    <div class="remontee_page">
        <div class="container">
            
            <div class="global-page">
                <img src="<?php echo get_template_directory_uri(); ?>/images/remontee_page.png" alt="remontée de pages" height="236" width="960"/>
                <?php 
                    $query = new WP_Query(
                        array(
                            'post_type' => 'page',
                            'post_status' => 'publish',
                            'posts_per_page' => 3,
                            'meta_key'=>'remontee_remontee_de_page',
                            'meta_value' => 1,
                            'order' => 'DESC',
                            'orderby' => 'date'
                        )
                    );

                    if ( $query->have_posts() ) { ?>
                        <?php while ( $query->have_posts() ) {
                            $query->the_post();
                            $menuorder = get_post_field('menu_order', $post->ID);
                             $remontee = get('remontee_remontee_de_page');
                             
                            if($remontee){ ?>
                                <div class="solo-page">
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php the_title(); ?></h3>
                                        <span>> <?php _e('Lire'); ?></span>
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } //endwhile ?>
                        <?php wp_reset_postdata();
                    } else {
                        
                    }
                ?>
            </div>

        </div>
    </div>


</section>
<div id="valeursajoutees"></div>
<?php get_footer('home'); ?>