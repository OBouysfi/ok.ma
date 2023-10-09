<?php
// Jobs Portal 
// Copyright (c) All Rights Reserved, NetArt Media 2003-2015
// Check http://www.netartmedia.net/jobsportal for demos and information
?><?php
if(!defined('IN_SCRIPT')) die("");
$csTable = $this->db->DataTable("employers","WHERE logo<>'' ORDER BY RAND() DESC LIMIT 0,20");
if($this->db->num_rows($csTable) > 0)
{	
?>
<br/>

<style>
#companies-carousel {
    background-color: #fff !important;
}

.slider .slick-prev:before {
    color: #04776e;
}

.slider .slick-next:before {
    color: #04776e;
}

.popular {
    padding-bottom: 4rem;
    padding-top: 4rem;
}

.slider {
    width: 100%;
    display: -webkit-box;
    display: flex;
    outline: hidden;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    flex-direction: row;
    -webkit-box-pack: center;
    justify-content: center;
}

/* Mettez les logos en ligne sur la version mobile */
@media screen and (max-width: 768px) {
    .slider {
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .slider div {
        width: 48%; /* Définissez la largeur pour afficher deux logos par ligne */
        margin-bottom: 1rem;
    }

    .slider img {
        width: 100%;
        height: auto; /* Ajustez la hauteur pour maintenir les proportions */
    }
}

.slider img {
    width: 200px;
    height: 100px;
    outline: hidden;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    padding: 0 20px 0 20px;
}

/* Supprimez le soulignement des liens */
.slider a {
    text-decoration: none;
}

/* Style pour les titres */
.page-header {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 0.7px;
    font-family: monospace;
}

hr {
    /* display: none; */
	color: #04776e;
}
</style>

	
<div id="companies-carousel">
	<div class="container text-center">
		<script src="js/carousel.js"></script>
		<!-- <div class='clearfix'></div> -->
		<div class='center' style = "margin-top:3%; margin-bottom:5%">
			<section class="popular">
				<div class="container">
					<h2 class="page-header text-center" style="font-size: 29px; font-weight: 700; letter-spacing: 0.7px; font-family: monospace;">Les recruteurs qui nous ont fait confiance</h2>
            		<hr />
            		<div class="slider">
        
           	 		<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/mr-bricolage.png" alt="mr-bricolage">      
                		</a>
            		</div>

            		<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/crit.jpg" alt="crit">
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/effic.jpg" alt="effic">        
                		</a>
            		</div>
            		<div>
            			<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/stg.jpg" alt="STG Maroc">
                		</a>
            		</div>

            		<div>
                		<a href="#">
                   	 		<img src="http://www.ok.ma/images/cabinet/manpower.jpg" alt="Manpower">
                		</a>
            		</div>
					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/adecco.jpg" alt="Adecco">
                		</a>
            		</div>
           			</div>
		  		</div>

				  <div class="container">
            		<div class="slider"><div>
				
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/cercle-rh.jpg" alt="Cercle RH">
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/dalaa.jpg" alt="Dalaa">      
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/groupe4.jpg" alt="groupe4">        
                		</a>
            		</div>
            		<div>
            			<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/locamed.jpg" alt="Locamed">
                		</a>
            		</div>

            		<div>
                		<a href="#">
                   	 		<img src="http://www.ok.ma/images/cabinet/chrono-interim.jpg" alt="Chrono Interim">
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/tectra.jpg" alt="Tectra">
                		</a>
            		</div>

           			</div>

					<div class="container">
            		<div class="slider"><div>
				
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/rawaj.jpg" alt="Fondation Rawaj">
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/le-director-financier.jpg" alt="Le director financier">      
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/vhp.jpg" alt="VHP">        
                		</a>
            		</div>

            		<div>
            			<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/macdo.jpg" alt="Macdo">
                		</a>
            		</div>

					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/plus-interim.jpg" alt="Plus Interim">
                		</a>
            		</div>
					   
					<div>
                		<a href="#">
                    		<img src="http://www.ok.ma/images/cabinet/dekra.png" alt="Dekra">
                		</a>
            		</div>
					   

           			</div>


		  		</div>
    		</section>
	</div>	
<div class="clear"></div>	
	
	</div>
</div>

<?php
}
?>