#!/bin/bash
#配置数据库
database=moyu_activity
tmp_sql_file='/tmp/tmp_sql.sql'
server_mark='mysql-t890'
server_mark='mysql'
filename=$1

if [ -e "$filename" ]
then
	echo " *****************************     import act_code start  *****************************************************************************************************"
	echo  `date +"%T"`
	echo "import file is: "$filename
	dos2unix ${filename}
	
	if [ -e "$tmp_sql_file" ]
	then
		rm -f ${tmp_sql_file}
	fi
	echo " import  ${filename} now ."
	echo "use ${database};" >> ${tmp_sql_file}
	echo "source ${filename};" >> ${tmp_sql_file}
	#/usr/bin/mysql --default-character-set=utf8 --socket=/data/moyu/${server_mark}/mysql.sock -uroot -p"NoNeed4Pass32768" < ${tmp_sql_file}
	/usr/bin/mysql --default-character-set=utf8 -h127.0.0.1 -usuwin -p"iamsuwin" < ${tmp_sql_file}
	
	rm -f ${filename}
	rm -f ${tmp_sql_file}
	
	echo "-------------import act_code ok."
	echo " *****************************     import act_code end  **************************************************************************************************"
	
else
	echo  "${filename} not  exist."
fi
