function encodeNameAndValue(sName, sValue)
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}
function view_results(usn, quiz_id, course)
{
	var encodedUsn = encodeNameAndValue("usn", usn);
	var encodedQuiz_id = encodeNameAndValue("quiz_id", quiz_id);
	var encodedCourse = encodeNameAndValue("course", course);
	window.location = "/ate/faculty/client/facultyViewStudAns.php?" + encodedUsn + "&" + encodedQuiz_id + "&" + encodedCourse;
}