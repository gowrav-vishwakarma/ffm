<script type="text/javascript">
var start = new Date;
var wooYayIntervalId;

wooYayIntervalId = setInterval(function() {
    jQuery(".timer").text((new Date - start) / 1000 + " Seconds Remaining to watch");
    if(((new Date - start) / 1000) >=60){
        clearInterval ( wooYayIntervalId );
        jQuery.ajax({
          url: "index.php?option=com_mlm&task=distributor_cont.doneSurvey&format=raw",
          data : "sid=<?php echo $survey->id?>",
          success: function(response){
              jQuery(".timer").text(response);
          }
        });
    }

}, 1000);

</script>
<div style="height:100px">
    <h3 class="timer"></h3>
</div>
<hr>
<iframe src="<?php echo $survey->Survey;?>" width="100%" height="100%"></iframe>