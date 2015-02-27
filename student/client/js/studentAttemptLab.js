function getXmlHttpObject()
{
	var xmlhttp;
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	return xmlhttp;		
}



function encodeNameAndValue(sName, sValue)
{
	var sParam = encodeURIComponent(sName);
	sParam += "=";
	sParam += encodeURIComponent(sValue);
	return sParam;
}

function select_lang()
{
	var select = document.getElementById("lang");
	//alert(select.options[select.selectedIndex].value);
}


function set_data(l, w, c, q)
{
	lang = l;
	week = w;
	course = c;
	que = q;
}



function fetch_files()
{
	filetabs = document.getElementById("filetabs");
	tabContent = document.getElementById("tabContent");
	xhr_get_file = getXmlHttpObject();
	xhr_get_file.onreadystatechange = display_files;
	xhr_get_file.open("GET", "/ate/student/server/fetchFilesLab.php?lang=" + lang + "&week=" + week + "&course=" + course + "&que=" + que);
	xhr_get_file.send();
}

var f_id = new Array();
var files = new Array();

function set_w_h()
{
	var f = document.getElementById( "frame_t" + f_id[0]);
	var w = f.style.width;
	var h = f.style.height;
	for( var i = 1; i < f_id.length; i++ )
	{
		var f = document.getElementById( "frame_t" + f_id[i]);
		f.style.width = w;
		f.style.height = h;
	}
}


function myremove(arr, elem)
{
	var temp = new Array();
	for( var i = 0; i < arr.length; i++ )
	{
		if( arr[i] != elem )
		{
			temp.push(arr[i]);
		}
	}
	return temp;
}



function display_files()
{
	if(xhr_get_file.readyState == 4)
	{
		if(xhr_get_file.status == 200 || xhr_get_file.status == 304)
		{
			if( xhr_get_file.responseText == "ERROR" )
			{
				alert("Some ERROR occured, try reloading the page.");
			}
			else if( xhr_get_file.responseText == "NF" )
			{
			}
			else
			{
				var ret = JSON.parse(xhr_get_file.responseText);
				files = ret[0];
				var data = ret[1];
				var flag = true;
				var cmpltable = document.getElementById("comp_files");
				for( var i = 0; i < files.length; i++ )
				{
					var ftab = document.createElement("li");
					var fdiv = document.createElement("div");
					fdiv.setAttribute("class", "tab-pane fade");
					var fanchor = document.createElement("a");
					var temp = files[i].split("/");
					var file = temp[temp.length - 1];
					var id = file.replace(".", "");
					fanchor.href = "#" + id;
					fanchor.setAttribute("data-toggle","tab");
					fanchor.innerHTML = file;
					ftab.appendChild(fanchor);
					ftab.setAttribute("id", "tab" + id);
					filetabs.appendChild(ftab);
					
					fdiv.setAttribute("id", id);
					f_id.push( id );
					var ftext = document.createElement("textarea");
					ftext.setAttribute("class", "form-control");
					ftext.setAttribute("rows", "30");
					ftext.style.resize = "none";
					ftext.setAttribute("id", "t" + id);
					
					ftext.innerHTML = data[files[i]];
					if( flag )
					{
						ftab.setAttribute("class", "active");
						fdiv.setAttribute("class", "tab-pane fade active in");
						flag = false;
					}
					ftab.setAttribute("onclick", "set_w_h();");
					fdiv.appendChild(ftext);
					tabContent.appendChild(fdiv);
					editAreaLoader.init({
						id: "t" + id
						,start_highlight: true
						,allow_toggle: false
						,font_size: "14"
						,language: "en"
						,syntax: lang
						,save_callback: "save_code"
						,toolbar: "search, |,  go_to_line,  |, save, |, select_font"
					});

					// compilation files
					var cmpldiv = document.createElement("div");
					cmpldiv.setAttribute("class", "checkbox");
					cmpldiv.setAttribute("style", "padding-left:3%");
					cmpldiv.setAttribute("id", "cmpldiv" + id);
					var cmpllabel = document.createElement("label");
					var cmplch = document.createElement("input");
					cmplch.setAttribute("type", "checkbox");
					cmplch.setAttribute("checked", "checked");
					cmplch.setAttribute("id", "cmplfile" + id);
					cmplch.setAttribute("value", file);
					cmpllabel.appendChild(cmplch);
					cmpllabel.innerHTML += file;
					cmpldiv.appendChild(cmpllabel);
					cmpltable.appendChild(cmpldiv);
				}
			}
		}
		else
		{
			alert("Error");
		}
	}
}


function get_file_name(file_id)
{
	var temp = file_id.slice(1, file_id.length);
	var file;
	if( lang == "C" )
	{
		file = temp.slice(0, temp.length - 1);
		if( temp.slice(temp.length - 1, temp.length) == "c" )
		{
			file = file + ".c";
		}
		else
		{
			file = file + ".h";
		}
	}
	else if( lang == "C++" )
	{
		file = temp.slice(0, temp.length - 3) + ".cpp";
		if( temp.slice(temp.length - 3, temp.length) == "cpp" )
		{
			file = file + ".cpp";
		}
		else
		{
			file = file + ".h";
		}
	}
	else if( lang == "Java" )
	{
		file = temp.slice(0, temp.length - 4) + ".java";
	}
	else if( lang == "Python" )
	{
		file = temp.slice(0, temp.length - 2) + ".py";
	}
	return file;
}


function save_code(id, content)
{
	// alert(id.slice(1, id.length));
	xhr_save_file = getXmlHttpObject();
	xhr_save_file.onreadystatechange = save_response;
	xhr_save_file.open("POST", "/ate/student/server/saveFileLab.php", true);
	xhr_save_file.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var file = get_file_name(id);
	// alert(content);
	/*if( content == "" )
	{
		content = "NODATA";
	}*/

	encodedContent = encodeNameAndValue("content", content);
	encodedCourse = encodeNameAndValue("course", course);
	encodedWeek = encodeNameAndValue("week", week);
	encodedQue = encodeNameAndValue("que", que);
	encodedFile = encodeNameAndValue("file", file);


	xhr_save_file.send( encodedCourse + "&" + encodedWeek + "&" + encodedQue + "&" + encodedContent + "&" + encodedFile);
}

function save_response()
{
	if(xhr_save_file.readyState == 4)
	{
		if(xhr_save_file.status == 200 || xhr_save_file.status == 304)
		{
			if( xhr_save_file.responseText == "ERROR" )
			{
				alert("Some error occured, save again");
			}
			/*else if( xhr_save_file.responseText == "open")
			{
				alert("File open error");
			}
			else if( xhr_save_file.responseText == "write" )
			{
				alert("File write error");
			}*/
			else
			{
				alert("File saved successfully");
			}
		}
	}
}





function create_file()
{
	var file_name = prompt("Enter the file name.");
	//alert(file_name);

	if( file_name == null || file_name == "" )
	{
		return;
	}
	xhr_create_file = getXmlHttpObject();
	xhr_create_file.onreadystatechange = create_file_response;
	xhr_create_file.open("GET", "/ate/student/server/createFileLab.php?file=" + file_name + "&course=" + course + "&week=" + week + "&que=" + que + "&lang=" + lang, true);
	xhr_create_file.send();
}

function create_file_response()
{
	if(xhr_create_file.readyState == 4)
	{
		if(xhr_create_file.status == 200 || xhr_create_file.status == 304)
		{
			if( xhr_create_file.responseText === "ERROR")
			{
				alert("Error while creating file.");
			}
			else
			{
				var cmpltable = document.getElementById("comp_files");
				var ftab = document.createElement("li");
				ftab.setAttribute("class", "active");
				var fdiv = document.createElement("div");
				fdiv.setAttribute("class", "tab-pane fade active in");
				var fanchor = document.createElement("a");
	
				var temp = xhr_create_file.responseText.split("/");
				var file = temp[temp.length - 1];
				var id = file.replace(".", "");
				fanchor.href = "#" + id;
				fanchor.setAttribute("data-toggle","tab");
				fanchor.innerHTML = file;
				ftab.appendChild(fanchor);
				ftab.setAttribute("id", "tab" + id);
				filetabs.appendChild(ftab);
				
				fdiv.setAttribute("id", id);

				for( var i = 0; i < f_id.length; i++ )
				{
					var t1 = document.getElementById("tab" + f_id[i]);
					var t2 = document.getElementById(f_id[i]);
					t1.setAttribute("class", "");
					t2.setAttribute("class", "tab-pane fade");
				}
				
				f_id.push( id );
				var ftext = document.createElement("textarea");
				ftext.setAttribute("class", "form-control");
				ftext.setAttribute("rows", "30");
				ftext.style.resize = "none";
				ftext.setAttribute("id", "t" + id);
				ftab.setAttribute("onclick", "set_w_h();");
				
				
				
				fdiv.appendChild(ftext);
				tabContent.appendChild(fdiv);
				files.push(xhr_create_file.responseText);
				editAreaLoader.init({
					id: "t" + id
					,start_highlight: true
					,allow_toggle: false
					,font_size: "14"
					,language: "en"
					,syntax: lang
					,save_callback: "save_code"
					,toolbar: "search, |,  go_to_line,  |, save, |, select_font"
				});


				var cmpldiv = document.createElement("div");
				cmpldiv.setAttribute("class", "checkbox");
				cmpldiv.setAttribute("style", "padding-left:3%");
				cmpldiv.setAttribute("id", "cmpldiv" + id);
				var cmpllabel = document.createElement("label");
				var cmplch = document.createElement("input");
				cmplch.setAttribute("type", "checkbox");
				cmplch.setAttribute("checked", "checked");
				cmplch.setAttribute("id", "cmplfile" + id);
				cmplch.setAttribute("value", file);
				cmpllabel.appendChild(cmplch);
				cmpllabel.innerHTML += file;
				cmpldiv.appendChild(cmpllabel);
				cmpltable.appendChild(cmpldiv);

				
			}
		}
	}
}


function delete_file()
{
	var file_name = prompt("Enter the file name.");

	if( file_name == null || file_name == "" )
	{
		return;
	}
	xhr_delete_file = getXmlHttpObject();
	xhr_delete_file.onreadystatechange = delete_file_response;
	xhr_delete_file.open("GET", "/ate/student/server/deleteFileLab.php?file=" + file_name + "&course=" + course + "&week=" + week + "&que=" + que + "&lang=" + lang, true);
	xhr_delete_file.send();
}


function delete_file_response()
{
	if(xhr_delete_file.readyState == 4)
	{
		if(xhr_delete_file.status == 200 || xhr_delete_file.status == 304)
		{
			if( xhr_delete_file.responseText === "ERROR")
			{
				alert("Error while deleting file.");
			}
			else
			{
				set_w_h();
				var temp = xhr_delete_file.responseText.split("/");
				var cmpltable = document.getElementById("comp_files");
				var file = temp[temp.length - 1];
				var id = file.replace(".", "");
				if( files.length == 1 )
				{
					$("#" + id).remove();
					$("#" + "tab" + id).remove();
					f_id = myremove(f_id, id);
					files = myremove(files, xhr_delete_file.responseText);
					var cmpldiv = document.getElementById("cmpldiv" + id);
					cmpltable.removeChild(cmpldiv);
				}
				else
				{
					var flag = false;
					for( var i = 0; i < f_id.length; i++ )
					{
						var t1 = document.getElementById("tab" + f_id[i]);
						var t2 = document.getElementById(f_id[i]);
						if( f_id[i] == id && t1.getAttribute("class") == "active" )
						{
							flag = true;
						}
					}

					$("#" + id).remove();
					$("#" + "tab" + id).remove();
					f_id = myremove(f_id, id);
					files = myremove(files, xhr_delete_file.responseText);
					var cmpldiv = document.getElementById("cmpldiv" + id);
					cmpltable.removeChild(cmpldiv);

					if( flag )
					{
						var temp = files[0].split("/");
						var file = temp[temp.length - 1];
						var temp_id = file.replace(".", "");
						var ftab = document.getElementById("tab" + temp_id);
						var fdiv = document.getElementById(temp_id);
						ftab.setAttribute("class", "active");
						fdiv.setAttribute("class", "tab-pane fade active in");
					}
				}
				
				
			}
		}
		else
		{
			alert("Some error occured.")
		}
	}
}


function getCmplFiles()
{
	var cmplfiles = "";
	var cmplflag = true;
	for( var i = 0; i < f_id.length; i++ )
	{
		var cmplf = document.getElementById( "cmplfile" + f_id[i]);
		if( cmplf.checked )
		{
			if( cmplflag == true )
			{
				cmplfiles = cmplf.value;
				cmplflag = false;
			}
			else
			{
				cmplfiles = cmplfiles + "," + cmplf.value;
			}
		}
	}
	return cmplfiles;
}




function execute()
{
	var main_file = document.getElementById("main_file").value;
	var cmplfiles = getCmplFiles();

	if( main_file == "" )
	{
		alert("Enter name of the file with main function.");
		return;
	}
	xhr_execute = getXmlHttpObject();
	xhr_execute.onreadystatechange = execute_response;
	xhr_execute.open("GET", "/ate/student/server/executeLab.php?course=" + course + "&week=" + week + "&que=" + que + "&lang=" + lang + "&main_file=" + main_file + "&cmplfiles=" + cmplfiles, true);
	xhr_execute.send();
}

function execute_response()
{
	if(xhr_execute.readyState == 4)
	{
		if(xhr_execute.status == 200 || xhr_execute.status == 304)
		{
			if( xhr_execute.responseText === "ERROR")
			{
				alert("Error while executing code.");
			}
			else
			{
				var res = xhr_execute.responseText;
				var index = res.indexOf("compile_error");
				var output = document.getElementById("output");
				var heading = document.getElementById("heading");
				if( index === 0 )
				{
					heading.style.color = "red";
					heading.innerHTML = "Compiler Error";
					var error = res.substring(13, res.length);
					error = error.replace(/\n/g, "<br>");
					output.innerHTML = "<b>" + error + "</b>";
				}
				else
				{
					heading.style.color = "black";
					heading.innerHTML = "Output";
					var output_list = res.split("@#$");
					var ouput_str = "";
					for( var i = 1; i < output_list.length; i++ )
					{
						ouput_str += "<b>Test Case " + i + ":</b><br>";
						var new_line = output_list[i - 1].replace(/\n/g, "<br>");
						ouput_str += new_line + "<br><br>";
					}
					output.innerHTML = ouput_str;
				}
				
				
				$("#output_window").slideDown("slow");
			}
		}
	}
}


function repeated_code()
{
	var num_tokens = parseInt(document.getElementById("num_tokens").value);
	if( num_tokens < 10 )
	{
		num_tokens = 10;
	}
	xhr_repeated_code = getXmlHttpObject();
	xhr_repeated_code.onreadystatechange = repeated_code_response;
	encodedCourse = encodeNameAndValue("course", course);
	encodedWeek = encodeNameAndValue("week", week);
	encodedQue = encodeNameAndValue("que", que);
	encodedLang = encodeNameAndValue("lang", lang);
	encodedNumTokens = encodeNameAndValue("num_tokens", num_tokens);
	xhr_repeated_code.open("GET", "/ate/student/server/findRepeatedCode.php?" + encodedCourse + "&" + encodedWeek + "&" + encodedQue + "&" + encodedLang + "&" + encodedNumTokens, true);
	xhr_repeated_code.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr_repeated_code.send();
}


function repeated_code_response()
{
	if(xhr_repeated_code.readyState == 4)
	{
		if(xhr_repeated_code.status == 200 || xhr_repeated_code.status == 304)
		{
			if( xhr_repeated_code.responseText === "ERROR")
			{
				alert("Something went wrong, try later.");
			}
			else
			{
				//var cmd = document.getElementById("cmd");
				//cmd.innerHTML = xhr_repeated_code.responseText;
				//alert(xhr_repeated_code.responseText);
				var win = window.open(xhr_repeated_code.responseText, '_blank');
				//win.focus();
				
				if(win.closed)
				{
					alert("Please Disable Pop-up blocker to see the repeated code and try again.");
				}
			}
		}
		else
		{
			alert("Something went wrong, try later.");
		}
	}
}