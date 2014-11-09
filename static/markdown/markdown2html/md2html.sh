#########################################################################
# File Name: md2thml.sh
# Author: wushuiyong
# mail: wu.shuiyong@qq.com
# Created Time: Wed 05 Mar 2014 09:23:47 AM
#########################################################################
#!/bin/bash

cd `dirname $0`
currentDir=`pwd`
echo $currentDir > /tmp/in.out

tmp="/tmp/md2html.tmp"

gerateHtml() {
	make -f makefile

	mv ../*.html ../../blog/
}

# gerateIndex
gerateIndex() {

	((num=0))
	sufix=0

	indexFile="../index${sufix}.md"
	echo ''> $indexFile
	(rm ../index*.md)
	mdfiles=`find ../ -iname *.md |grep -v -P "index.*.md" | sort -rn`

	for mdfile in $mdfiles
	do
		$((num=$num+1))
		$((sufix=$num/10))
		indexFile="../index${sufix}.md"
		echo $num;
		echo $indexFile;
		# 得到文件名，也是时间 2014-03-03
		htmlFile=`echo $mdfile | sed  "s/..\/\(.*\)\.md/\1/"`
		time="- - -\r\n\r\n$htmlFile"

		# 处理过标题的临时文件
		head -n10 $mdfile | sed "s/<!---title:\(.*\)-->/......\r\n\r\n<br>\r\n\r\n##\[\1\](\/blog\/$htmlFile.html)/g" > $tmp
		
		# 处理过 Hr 的临时文件
		cat $tmp| sed "6s/^.*$/$time/">>$indexFile
	done

}

# 创建首页md
gerateIndex
# 生成所有html
gerateHtml
