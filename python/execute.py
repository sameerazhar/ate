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
elif lang == "Cpp":
	print("CPP");
elif lang == "Java":
	prog = Java(data[0], data[2], data[1], data[3], cmplfiles, main_file);
elif lang == "Python":
	print("Python");


cwd = os.getcwd();
os.chdir("/var/www/html" + prog.getFilePath());
compiled = prog.compile();
if( compiled == "COMPILED" ):
	prog.execute();
else:
	print( compiled );
os.chdir(cwd);



cur.close();
conn.close();
