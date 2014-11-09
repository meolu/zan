#########################################################################
# File Name: gitCommit.sh
# Author: wushuiyong
# mail: wushuiyong@huamanshu.com
# Created Time: Sun 13 Apr 2014 05:07:12 PM
#########################################################################
#!/bin/bash

# 为了兼容ubuntu和centos平台路径问题
cd `dirname $0`
echo `pwd` > /tmp/wushuiyong.log
echo `whoami` >> /tmp/wushuiyong.log
git pull >> /tmp/wushuiyong.log

git add ../../static/images/upload/* ../markdown/*
git commit -m"commit online"
git push origin master
