from subprocess import *
import pymysql
import os

class Program:

	
	def __init__(self, usn, course, assign, file_path, files, main_file):
		self.usn = usn;
		self.course = course;
		self.assign = assign;
		self.file_path = file_path;
		self.main_file = main_file;
		files = files.split(",");
		files.remove(main_file);
		self.files = files;

	def display(self):
		print(self.usn);
		print(self.course);
		print(self.assign);
		print(self.file_path);
		print(self.files);
		print(self.main_file);

	
