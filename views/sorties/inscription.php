<?php
$pageTitle = $this->vars['pageTitle'];
$pageMessage = $this->vars['pageMessage'];
$eventId = $this->vars['eventId'];
include_once ROOT_DIR.'views/header.inc';

?>


    <script>
        function addBox()
        {
            //window.location.replace("sorties/inscription/"+$("#participantsNumber").val());
            var numberP = document.getElementById("participantsNumber").value;

            if(numberP > 6)
            {
                alert("Trop de participants, veuillez inscrire au maximum 5");
                document.getElementById("participantsNumber").value = null;
                for(i = 1; i <= numberP; i++)
                {
                    document.getElementById('blockP'+i).style.display = "none";
                }
            }

            else
            {
                for(i = 1; i <= numberP; i++)
                {
                    document.getElementById('blockP'+i).style.display = "block";
                    document.getElementById('inscriptionBlock').style.display = "block";
                }
            }
        }
		
		
		function sendRequest(){
			$.post($(location).attr('origin') + '/cas/sorties/details.php',{
					participantsNumber : $('#participantsNumber').val(),
					eventId : <?php echo $eventId;?>
				}, 
				function(data){
					window.location.replace('/cas/sorties/details/' + <?php echo $eventId ?>)
				});
		}
		

    </script>
    <form action="<?php echo URL_DIR.'/sorties/details/'.$eventId;?>" method="post">
		<?php
			if($_SESSION['difficulty'] == 'très avancé' || $_SESSION['difficulty'] == 'professionnel'){
				echo('<div class="f-block bred">
							C\'EST DUR!!!
						</div>');
			}

		?>
    	<div class="content" style="display:block">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3"></div>
					<div class="col-md-6 col-sm-6">
						<div class="cwell">
							<!-- Inscription form -->
							<h3 class="title" id="participant"><?php echo $lang['INSCRIPTION_NUMBER_PARTICIPANTS']; ?></h3>
							<input type="number" min="1" max="10" name="numParticipants" style="margin-right:20px">
							<input type="submit"/>
						</div>
						
					</div>
				</div>
			</div>
		</div>
    </form>


<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'views/footer.inc';
?>