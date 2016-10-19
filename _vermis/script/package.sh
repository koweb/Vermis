#!/bin/bash
# $Id: package.sh 1114 2011-01-30 00:46:27Z cepa $

cd ../..

version="1.0"
rev=`svnversion`
date=`date +"%Y%m%d"`
mark="r$rev-$date"
output_dir="vermis-$version-$mark"
rm -rf out/$output_dir/
mkdir -p out/$output_dir/

cp .htaccess out/$output_dir/
cp index.php out/$output_dir/
cp -r _vermis out/$output_dir/

rm -rf out/$output_dir/_vermis/config.php
rm -rf out/$output_dir/_vermis/captcha/*
rm -rf out/$output_dir/_vermis/log/*
rm -rf out/$output_dir/_vermis/upload/*
rm -rf out/$output_dir/_vermis/test/coverage
rm -rf out/$output_dir/_vermis/test/results

sed -e "s/######/$mark/g" _vermis/version.php > out/$output_dir/_vermis/version.php

find out/$output_dir -name ".svn" | xargs rm -rf

cd out

tar zcvf $output_dir.tar.gz $output_dir
tar jcvf $output_dir.tar.bz2 $output_dir
zip -r $output_dir.zip $output_dir

