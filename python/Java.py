from Program import *
import re
class Java(Program):
	def __init__(self, usn, course, assign, file_path, files, main_file):
		Program.__init__(self, usn, course, assign, file_path, files, main_file);

	def display(self):
		Program.display(self);

	def getFilePath(self):
		return self.file_path;
	
	def compile(self):
		compiled = False;
		output = "";
		try:
			cmd = "javac " + self.main_file;
			cmd = cmd.strip();
			cmd = cmd + " 2>compile_error.txt";
			output = check_output(cmd, shell=True);
			compiled = True;
		except Exception as e:
			compiled = False;
		if( compiled ):
			os.remove("compile_error.txt");
			return "COMPILED";
		else:
			fd = open("compile_error.txt", "r");
			error = "compile_error";
			line = fd.read();
			while line:
				error = error + line;
				line = fd.read();
			os.remove("compile_error.txt");
			return error;

	def execute(self):
		return "";
		conn = pymysql.connect(host="localhost", user="root",passwd="mysql");
		cur = conn.cursor();
		cur.execute("use ate");
		query = "SELECT * FROM test_case WHERE course_code=\'" + self.course + "\' and assign_id=\'" + self.assign + "\'";
		cur.execute(query);
		
		data = cur.fetchall();

		output = "";
		m_file = self.main_file.split(".")[0];

		try:
			for test in data:
				cmd = "java " + m_file + " 1>output.txt 2>runtime_error.txt";
				fin = open("input.txt", "w");
				fin.write(test[3]);
				fin.close();

				fin = open("input.txt", "r");
				out = check_output(cmd, stdin=fin, shell=True);
				fout = open("output.txt", "r");
				ferr = open("runtime_error.txt", "r");

				line = fout.read();
				while line:
					output = output + line;
					line = fout.read();
				line = ferr.read();
				while line:
					output = output + line;
					line = ferr.read();
				output = output + "@#$";
				os.remove("output.txt");
				os.remove("runtime_error.txt");
				os.remove("input.txt");

		except Exception as e:
			print(e);

		print(output);

	def staticAnalysis(self):
		analyzed = False;
		output = "";

		try:
			cmd = "../../../../../pmd-bin-5.2.3/bin/run.sh pmd -d " + self.main_file + " ";
			for f in self.files:
				cmd = cmd + f + " ";
			cmd = cmd + " -f text -R ../../../../../pmd-bin-5.2.3/MyRules.xml  -version 1.7 -language java 1>analysis_error.txt ";
			cmd = cmd.strip();
			output = check_output(cmd, shell=True);
		except Exception as e:
			print("Some error occured.");
			exit(0);
		fd = open("analysis_error.txt", "r");
		error = "analysis_error";
		line = fd.read();
		while line:
			line = re.sub(r'/var/www/html/ate/studentData/.*?/.*?/.*?/.*?/(.*?\.java)', r'\1', line.rstrip())
			error = error + line;
			line = fd.read();
		os.remove("analysis_error.txt");
		return error;