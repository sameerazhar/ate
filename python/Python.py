from Program import *
import re
class Python(Program):
	def __init__(self, usn, course, assign, file_path, files, main_file):
		Program.__init__(self, usn, course, assign, file_path, files, main_file);

	def display(self):
		Program.display(self);

	def getFilePath(self):
		return self.file_path;

	def compile(self):
		return "COMPILED";

	def staticAnalysis(self):
		analyzed = False;
		output = "";

		try:
			cmd = "pychecker " + self.main_file + " ";
			for f in self.files:
				cmd = cmd + f + " ";
			cmd = cmd + " 1>analysis_error.txt";
			cmd = cmd.strip();
			#print(cmd); exit(0);
			output = check_output("pychecker test.py 1>analysis_error.txt", shell=True);
		except Exception as e:
			fd = open("analysis_error.txt", "r");
			error = "";
			line = fd.read();
			while line:
				#line = re.sub(r'/var/www/html/ate/studentData/.*?/.*?/.*?/.*?/(.*?\.py)', r'\1', line.rstrip())
				error = error + line;
				line = fd.read();
			os.remove("analysis_error.txt");
		error = re.sub(r'.*?Warnings\.\.\.(.*)', r'\1', error.strip());
		return error;
		#return "";

	def execute(self):
		return "";
