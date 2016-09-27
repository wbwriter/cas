<?php include_once ROOT_DIR.'views/header.inc'; 
?>

<style>	
	.jumbotron{
		margin-bottom: 0;
		background: none;
		color:aliceblue;
	}
	
	.jumbotron h1, .jumbotron p{
		text-shadow: 1px 1px 2px #000 !important;	
	}
	
	.carousel{
		z-index: -99;
		opacity: 0.8;
	}
	
	.carousel-inner{
		width:100%;
		position: fixed;
	}
	
	.carousel-inner img{
		min-width: 100%;
		margin-top: -20%;
	}
	
</style>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner " role="listbox">
    <div class="item active">
      <img class="img-responsive center-block" src="./img/img1.jpg" alt="Cabane">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img class="img-responsive center-block" src="./img/img2.jpg" alt="Alpinisme">
      <div class="carousel-caption">
      </div>
    </div>
    <div class="item">
      <img class="img-responsive center-block" src="./img/img3.jpg" alt="Peau de Phoque">
      <div class="carousel-caption">
      </div>
    </div>
	  <div class="item">
      <img class="img-responsive center-block" src="./img/img4.jpg" alt="Peau de Phoque">
      <div class="carousel-caption">
      </div>
    </div>
	  <div class="item">
      <img class="img-responsive center-block" src="./img/img5.jpg" alt="Raquettes">
      <div class="carousel-caption">
      </div>
    </div>
	  
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class="jumbotron text-center">
	<h1 class="mytitle">Bienvenue!</h1>
	<p>Club Alpin Suisse, Crans-Montana</p>
</div>


<?php include_once ROOT_DIR.'views/footer.inc'; 
?>