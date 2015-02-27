self.onmessage = function (event)
{
	n = parseInt(event.data);
	var d0=( new Date()).valueOf();
	// repeat myTimer(d0) every 100 ms
   	myVar=setInterval( function(){myTimer(d0,n)}, 500 );
};


function myTimer(d0,totalTime)
{
	// get current time
	var d=( new Date()).valueOf();
	// calculate time difference between now and initial time
	var diff = (totalTime*1000) - (d-d0);
	// calculate number of minutes
	if(diff > 500)
	{
		var minutes = Math.floor(diff/ 1000/ 60);
		// calculate number of seconds
		var seconds = Math.floor(diff/ 1000)-minutes* 60;
		var myVar = null;
		// if number of minutes less than 10, add a leading "0"
   		minutes = minutes.toString();
		if (minutes.length == 1 )
		{
    		minutes = "0" +minutes;
   		}
		// if number of seconds less than 10, add a leading "0"
   		seconds = seconds.toString();
		if (seconds.length == 1 )
		{
			seconds = "0" +seconds;
		}
		// return output to Web Worker
		postMessage(minutes+ ":" +seconds);
	}
	else
	{
		postMessage("timeout");
	}
}

