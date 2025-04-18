<?php
/*
Template Name: Festivaly 2015
*/
get_header();

?>

<?php
  while ( have_posts() ) : the_post(); 
  $img = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'full' );
?>
<?php if ( ICL_LANGUAGE_CODE == 'pl') { ?>
<section class="sluzby-header" style="background-image: url('<?=$img[0]?>')">  
  <div class="row">      
    <div class="large-12 columns">                
      <div class="main-content">          
          <h1>Festiwalovy sezon <img src="<?=get_template_directory_uri()?>/images/header-kelimek.png" alt="" /> letni <span class="pink">2015</span> w&nbsp;liczbach</h1>
          <h2>To dzięki Wam zwrotne ekokubki Nicknack wykonały świetną robotę!</h2>
      </div>
    </div>    
  </div> 
</section>

<section class="stars">
  <div class="row">
    <div class="large-12 columns">
      <h2><span class="number">40</span> letnich festiwali oraz imprez i ponad&nbsp;<strong>880&nbsp;000+</strong> ludzi<br /> gasiło pragnienie z ekokubków &nbsp; Nicknack.</h2>            
    </div>    
  </div> 
</section>

<section class="festivaly-fakta">
  <div class="row">
    <div class="large-12 columns">
      <h2>NICKNACKowe <img src="<?=get_template_directory_uri()?>/images/fakta-h2.png" alt="" /> FAKTY</h2>
      <p>Dzięki Nicknack nie powstało <span class="pink">2&nbsp;900&nbsp;000</span> <strong>jednorazowych kubków,</strong> które skończyłyby niechybnie na śmietnikach.</u></p>
      <p id="p2">Zgromadzone razem takie "jednorazówki" zapełniłyby powierzchnię <span class="black">64</span> boisk piłkarskich!</p>            
    </div>    
  </div> 
</section>

<section class="festivaly-eko">
  <div class="row">
    <div class="large-12 columns">
      <h2><span class="pink">575&nbsp;000</span></h2>
      <p>Tylko tyle <strong>zwrotnych ekokubków</strong> posłaliśmy w sezonie w teren.</p>
      <p>Z tego <span class="pink">158&nbsp;250</span>  do nas już nie wróciło. Są w Waszych domach jako pamiątki,<br /> z których w dalszym ciągu można się też napić.</p>                  
    </div>    
  </div> 
</section>

<section class="festivaly-nejlepsi">
  <div class="row">
    <div class="large-12 columns">
      <h2> A najlepsze w tym jest to, <span>że umyte ekokubki Nicknack znowu wrócą na festiwale.</span></h2>      
      <img src="<?=get_template_directory_uri()?>/images/pracka.jpg" alt="" />     
      <p>Chcesz je i Ty?</p>
      <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button">Napisz do nas!</a>          
    </div>    
  </div> 
</section> 

<?php } else { ?>

<section class="sluzby-header" style="background-image: url('<?=$img[0]?>')">  
  <div class="row">      
    <div class="large-12 columns">                
      <div class="main-content">          
          <h1>Letní festivalová <img src="<?=get_template_directory_uri()?>/images/header-kelimek.png" alt="" /> sezóna <span class="pink">2015</span> v&nbsp;číslech</h1>
          <h2>Vratné kelímky Nicknack díky vám letos odvedly zatraceně dobrou práci.</h2>
      </div>
    </div>    
  </div> 
</section>

<section class="stars">
  <div class="row">
    <div class="large-12 columns">
      <h2><span class="number">40</span> letních fesťáků a akcí pro&nbsp;<strong>880&nbsp;000+</strong> lidí<br /> hasilo žízeň s&nbsp;Nicknack kelímky.</h2>            
    </div>    
  </div> 
</section>

<section class="festivaly-fakta">
  <div class="row">
    <div class="large-12 columns">
      <h2>Letošní <img src="<?=get_template_directory_uri()?>/images/fakta-h2.png" alt="" /> fakta</h2>
      <p><span class="pink">2&nbsp;900&nbsp;000</span> <strong>jednorázových kelímků</strong> končících na&nbsp;skládkách tím pádem vůbec nemuselo vzniknout.</u></p>
      <p id="p2">Dohromady by zabraly plochu o&nbsp;rozloze <span class="black">64</span> fotbalových hřišť. Hrozná představa.</p>            
    </div>    
  </div> 
</section>

<section class="festivaly-eko">
  <div class="row">
    <div class="large-12 columns">
      <h2><span class="pink">575&nbsp;000</span></h2>
      <p>Jenom tolik <strong>vratných kelímků</strong> jsme letos poslali do&nbsp;terénu a bohatě stačily.</p>
      <p>Z toho <span class="pink">158&nbsp;250</span> se nám zpátky už nevrátilo, <br>máte je doma jako suvenýry.</p>                  
    </div>    
  </div> 
</section>

<section class="festivaly-nejlepsi">
  <div class="row">
    <div class="large-12 columns">
      <h2> A to nejlepší na tom všem je, <span>že Nicknack kelímky umyjeme a valí na fesťák znova!</span></h2>      
      <img src="<?=get_template_directory_uri()?>/images/pracka.jpg" alt="" />     
      <p>Chcete je i vy?</p>
      <a href="<?=get_permalink(icl_object_id(1913, 'page'))?>" class="button">Ozvěte se</a>          
    </div>    
  </div> 
</section>

<?php } ?>


<?php endwhile; // end of the loop. ?>





<?php get_footer(); ?>