			window.onload = function()
			{
				admin_btn = document.getElementById("admin_btn");
				stud_btn = document.getElementById("stud_btn");
				fclt_btn = document.getElementById("fclt_btn");
				admin_id = document.getElementById("admin_username");
				admin_pwd = document.getElementById("admin_password");
				faculty_id = document.getElementById("fclt_username");
				faculty_pwd = document.getElementById("fclt_password");
				stud_id = document.getElementById("stud_username");
				stud_pwd = document.getElementById("stud_password");
				admin_msg = document.getElementById("admin_errormsg");
				faculty_msg = document.getElementById("fclt_errormsg");
				stud_msg = document.getElementById("stud_errormsg");
				$('#admin_username').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						admin_login();	
					}
				 
				});
				$('#admin_password').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						admin_login();	
					}
				 
				});
				$('#fclt_username').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						faculty_login();	
					}
				 
				});
				$('#fclt_password').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						faculty_login();	
					}
				 
				});
				$('#stud_username').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						student_login();	
					}
				 
				});
				$('#stud_password').keypress(function(event)
				{
					var keycode = (event.keyCode ? event.keyCode : event.which);
					if(keycode == '13')
					{
						student_login();	
					}
				 
				});
			}

			function getXmlHttpObject()
			{
				var xmlhttp;
				if(window.XMLHttpRequest)
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else
				{
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
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

			function makeRequest()
			{
				var encodedName = encodeNameAndValue("user_id", user_id);
				var encodedPass = encodeNameAndValue("user_pwd", user_pwd);
				var encodedType = encodeNameAndValue("user_type", user_type);	
				xhr=getXmlHttpObject();
				xhr.open("POST","/ate/authentication/login.php",true);
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange=login_result;      
				xhr.send(encodedName + "&" + encodedPass + "&" + encodedType);	
			}

			function login_result()
			{
				if(xhr.readyState == 4)
				{
					if(xhr.status == 200 || xhr.status == 304)
					{
						if( xhr.responseText.trim() == "valid" )
						{
							if(user_type === "admin")
							{
								location.href = "/ate/admin/client/admin.php";
							}
							else if(user_type === "student" )
							{
								location.href = "/ate/student/client/student.php";
							}
							else if(user_type === "faculty")
							{
								location.href = "/ate/faculty/client/faculty.php";
							}
						}
						else
						{
							if(user_type === "admin")
							{
								admin_msg.style.display="block";
								admin_msg.innerHTML="Wrong username or password";
								admin_pwd.value="";
							}
							else if(user_type === "student" )
							{
								stud_msg.style.display="block";
								stud_msg.innerHTML="Wrong username or password";
								stud_pwd.value="";
							}
							else if(user_type === "faculty")
							{
								faculty_msg.style.display="block";
								faculty_msg.innerHTML="Wrong username or password";
								faculty_pwd.value="";
							}
						}
					}
					else
					{
					
						alert("Error");
					}
				}
				
			}

			function admin_login()
			{
				user_type="admin";
				user_id=admin_id.value;
				user_pwd=admin_pwd.value;
				if( user_id == "" || user_pwd == "" )
				{
					admin_msg.style.display="block";
					admin_msg.innerHTML="Fields can't be left empty";
				}
				else
				{
					makeRequest();
				}
			}
			function student_login()
			{
				user_type="student";
				user_id=stud_id.value;
				user_pwd=stud_pwd.value;
				if( user_id == "" || user_pwd == "" )
				{
					stud_msg.style.display="block";
					stud_msg.innerHTML="Fields can't be left empty";
				}
				else
				{
					makeRequest();
				}
				
			}
			function faculty_login()
			{
				user_type="faculty";
				user_id=faculty_id.value;
				user_pwd=faculty_pwd.value;
				if( user_id == "" || user_pwd == "" )
				{
					faculty_msg.style.display="block";
					faculty_msg.innerHTML="Fields can't be left empty";
				}
				else
				{
					makeRequest();
				}
				
			}
			function admin()
			{
				$("#stud_form").slideUp("slow");
				$("#fclt_form").slideUp("slow");
				$("#admin_form").slideToggle("slow");
				admin_btn.onclick = admin_login;
				$("#admin_details").hide();
				$("#admin_username").focus();
				$("#fclt_details").show();
				$("#stud_details").show();
				stud_btn.onclick = student;
				fclt_btn.onclick = faculty;
				admin_msg.style.display="none";
				faculty_msg.style.display="none";
				stud_msg.style.display="none";
				faculty_pwd.value="";
				faculty_id.value="";
				admin_pwd.value="";
				admin_id.value="";
				stud_pwd.value="";
				stud_id.value="";
			}
			function student()
			{
				$("#admin_form").slideUp("slow");
				$("#fclt_form").slideUp("slow");
				$("#stud_form").slideToggle("slow");
				stud_btn.onclick = student_login;
				$("#stud_details").hide();
				$("#stud_username").focus();
				$("#admin_details").show();
				$("#fclt_details").show();
				admin_btn.onclick = admin;
				fclt_btn.onclick = faculty;
				admin_msg.style.display="none";
				faculty_msg.style.display="none";
				stud_msg.style.display="none";
				faculty_pwd.value="";
				faculty_id.value="";
				admin_pwd.value="";
				admin_id.value="";
				stud_pwd.value="";
				stud_id.value="";
			}
			function faculty()
			{
				$("#admin_form").slideUp("slow");
				$("#stud_form").slideUp("slow");
				$("#fclt_form").slideToggle("slow");
				fclt_btn.onclick = faculty_login;
				$("#fclt_details").hide();
				$("#fclt_username").focus();
				$("#admin_details").show();
				$("#stud_details").show();
				admin_btn.onclick = admin;
				stud_btn.onclick = student;
				admin_msg.style.display="none";
				faculty_msg.style.display="none";
				stud_msg.style.display="none";
				faculty_pwd.value="";
				faculty_id.value="";
				admin_pwd.value="";
				admin_id.value="";
				stud_pwd.value="";
				stud_id.value="";
			}
