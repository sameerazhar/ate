function encodeNameAndValue(sName, sValue)
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}

function attempt_quiz(course, quiz_id)
{
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var encodedCourse = encodeNameAndValue("course", course);
	window.location = "./studentAttemptQuiz.php?" + encodedCourse + "&" + encodedQuiz_id;
}