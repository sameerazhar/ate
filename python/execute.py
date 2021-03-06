import sys

from C import *
from Java import *
from Python import *
from Cpp import *



usn = sys.argv[1];
course = sys.argv[2];
assign = sys.argv[3];
lang = sys.argv[4];
main_file = sys.argv[5];
cmplfiles = sys.argv[6];
conn = pymysql.connect(host="localhost", user="root",passwd="mysql");
cur = conn.cursor();
cur.execute("use ate");
query = "SELECT * FROM program WHERE usn=\'" + usn + "\' and course_code=\'" + course + "\' and assign_id=\'" + assign + "\'";

cur.execute(query);

data = cur.fetchall()[0];

if lang == "C":
	prog = C(data[0], data[2], data[1], data[3], cmplfiles, main_file);
elif lang == "cpp":
	prog = Cpp(data[0], data[2], data[1], data[3], cmplfiles, main_file);
elif lang == "Java":
	prog = Java(data[0], data[2], data[1], data[3], cmplfiles, main_file);
elif lang == "Python":
	prog = Python(data[0], data[2], data[1], data[3], cmplfiles, main_file);


cwd = os.getcwd();
os.chdir("../" + prog.getFilePath());

compiled = prog.compile();
if( compiled == "COMPILED" ):
	analysis = prog.staticAnalysis() + "@#$@@#$@";
	output = analysis + prog.execute();
	print(output);
else:
	print( compiled );
os.chdir(cwd);



cur.close();
conn.close();
