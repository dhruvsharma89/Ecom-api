<!--------------------------------------------rolling dice------------------------------->
function rollDice()
    {
        var max=6;
        var num=Math.ceil(Math.random()*max);
        return num;
    }

    $(document).ready(function(){
        $("#button1").click(function(){
            $("#demo").html(
            rollDice()
        );
        })
        
    });
<!--------------------------------------------rolling dice------------------------------->

<!--------------------------------------------alternate chances------------------------------->
 var chanceBlue=2;
 var posBlue=0;
 var chanceYellow=1;
 var posYellow=0;
 
 if (chanceBlue > chanceYellow)
     {
         
         chanceYellow= chanceYellow+2;
     }

<!--------------------------------------------alternate chances------------------------------->